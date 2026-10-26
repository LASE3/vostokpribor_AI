#!/usr/bin/env python3
"""
VOSTOKPRIBOR AI Engineering Range
Isolated Python Execution Worker
"""

import os
import sys
import time
import json
import shutil
import argparse
import subprocess
from datetime import datetime
from pathlib import Path


class PythonExecutionWorker:
    def __init__(self, base_dir: Path):
        self.base_dir = base_dir
        self.storage_dir = base_dir / "storage" / "private"
        self.sandbox_base = self.storage_dir / "sandboxes"
        self.datasets_dir = self.storage_dir / "datasets"
        self.bridge_script = base_dir / "bin" / "worker_bridge.php"
        self.sandbox_base.mkdir(parents=True, exist_ok=True)
        self.php_bin = self._resolve_php_bin()

    def _resolve_php_bin(self) -> str:
        candidates = [
            r"C:\xampp\php\php.exe",
            "php"
        ]
        for c in candidates:
            if os.path.isabs(c) and os.path.exists(c):
                return c
            if shutil.which(c):
                return c
        return "php"

    def _call_bridge(self, action: str, *args, input_data: str = None) -> dict:
        cmd = [self.php_bin, str(self.bridge_script), action] + list(args)
        proc = subprocess.run(
            cmd,
            cwd=str(self.base_dir),
            capture_output=True,
            text=True,
            input=input_data,
            encoding="utf-8"
        )
        if proc.returncode != 0:
            print(f"Bridge error ({action}): {proc.stderr}")
            return {}
        try:
            return json.loads(proc.stdout.strip())
        except json.JSONDecodeError:
            print(f"Bridge non-JSON output: {proc.stdout}")
            return {}

    def fetch_queued_job(self, specific_uuid=None) -> dict | None:
        if specific_uuid:
            res = self._call_bridge("fetch-job", specific_uuid)
        else:
            res = self._call_bridge("fetch-next")
        if res.get("found") and res.get("job"):
            return res["job"]
        return None

    def execute_job(self, job: dict):
        job_id = int(job["id"])
        job_uuid = job["job_uuid"]
        code = job["code_to_execute"]
        cell_id = job.get("cell_id")
        student_id = job["student_id"]

        print(f"[{datetime.now().strftime('%Y-%m-%d %H:%M:%S')}] Executing {job_uuid} (Student #{student_id})...")

        # 1. Prepare Sandbox Directory
        sandbox_path = self.sandbox_base / job_uuid
        sandbox_path.mkdir(parents=True, exist_ok=True)
        data_link_dir = sandbox_path / "data"
        data_link_dir.mkdir(exist_ok=True)

        # 2. Link student's assigned datasets
        assigned_ds = self._call_bridge("list-datasets", str(student_id))
        if isinstance(assigned_ds, list):
            for ds in assigned_ds:
                src_file = self.datasets_dir / ds["file_path"]
                if src_file.exists():
                    target_name = f"{ds['code'].lower()}.{ds['format']}"
                    shutil.copy2(src_file, data_link_dir / target_name)

        script_file = sandbox_path / "workload.py"
        with open(script_file, "w", encoding="utf-8") as f:
            f.write(code)

        # 3. Sanitized Environment (NO secrets, NO db credentials)
        clean_env = {
            "PATH": os.environ.get("PATH", ""),
            "SYSTEMROOT": os.environ.get("SYSTEMROOT", "C:\\Windows"),
            "PYTHONUNBUFFERED": "1",
            "PYTHONIOENCODING": "utf-8",
            "MPLBACKEND": "Agg"
        }

        # 4. Run Isolated Subprocess
        timeout_sec = 30
        start_time = time.time()
        stdout_txt = ""
        stderr_txt = ""
        exit_code = 0
        status = "COMPLETED"

        try:
            proc = subprocess.run(
                [sys.executable, str(script_file)],
                cwd=str(sandbox_path),
                env=clean_env,
                capture_output=True,
                text=True,
                timeout=timeout_sec,
                encoding="utf-8",
                errors="replace"
            )
            stdout_txt = proc.stdout
            stderr_txt = proc.stderr
            exit_code = proc.returncode
            if exit_code != 0:
                status = "FAILED"
        except subprocess.TimeoutExpired:
            status = "TIMEOUT"
            stderr_txt = f"Execution timed out: job exceeded maximum safety limit of {timeout_sec}s."
            exit_code = 124
        except Exception as e:
            status = "FAILED"
            stderr_txt = f"Sandbox execution failure: {str(e)}"
            exit_code = 1

        elapsed_ms = int((time.time() - start_time) * 1000)

        # Enforce maximum safety output limits (512KB)
        MAX_OUTPUT = 512 * 1024
        if len(stdout_txt) > MAX_OUTPUT:
            stdout_txt = stdout_txt[:MAX_OUTPUT] + "\n[OUTPUT TRUNCATED - EXCEEDED 512KB SAFETY LIMIT]"
        if len(stderr_txt) > MAX_OUTPUT:
            stderr_txt = stderr_txt[:MAX_OUTPUT] + "\n[STDERR TRUNCATED - EXCEEDED 512KB SAFETY LIMIT]"

        # Check for generated plot images
        plot_path = None
        for img_name in ["plot.png", "figure.png", "chart.png", "output.png"]:
            candidate = sandbox_path / img_name
            if candidate.exists():
                plot_path = f"sandboxes/{job_uuid}/{img_name}"
                break

        # 5. Send results back to database via bridge
        payload = {
            "job_id": job_id,
            "status": status,
            "stdout": stdout_txt,
            "stderr": stderr_txt,
            "exit_code": exit_code,
            "elapsed_ms": elapsed_ms,
            "cell_id": cell_id,
            "plot_path": plot_path
        }

        self._call_bridge("complete-job", input_data=json.dumps(payload))
        print(f"[{datetime.now().strftime('%Y-%m-%d %H:%M:%S')}] Job {job_uuid} {status} in {elapsed_ms}ms (exit code: {exit_code})")

    def run_once(self, specific_uuid=None) -> bool:
        job = self.fetch_queued_job(specific_uuid)
        if job:
            self.execute_job(job)
            return True
        return False

    def run_daemon(self, poll_interval=2):
        print("=== VOSTOKPRIBOR AI Python Execution Sandbox Worker Online ===")
        print(f"Base Directory: {self.base_dir}")
        print(f"Poll Interval:  {poll_interval}s\n")
        while True:
            try:
                processed = self.run_once()
                if not processed:
                    time.sleep(poll_interval)
            except KeyboardInterrupt:
                print("\nWorker safely terminated.")
                break
            except Exception as e:
                print(f"Worker cycle warning: {e}")
                time.sleep(poll_interval)


if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="VOSTOKPRIBOR AI Python Execution Worker")
    parser.add_argument("--daemon", action="store_true", help="Run background polling daemon")
    parser.add_argument("--once", action="store_true", help="Execute single queued job and exit")
    parser.add_argument("--job", type=str, help="Execute specific job UUID")
    args = parser.parse_args()

    base_path = Path(__file__).resolve().parent.parent
    worker = PythonExecutionWorker(base_path)

    if args.job:
        worker.run_once(specific_uuid=args.job)
    elif args.daemon:
        worker.run_daemon()
    else:
        # Default to checking once
        did_work = worker.run_once()
        if not did_work:
            print("No QUEUED execution jobs in database.")
