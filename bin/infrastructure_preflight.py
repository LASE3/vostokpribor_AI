#!/usr/bin/env python3
"""Read-only inventory, not an isolation attestation or a service enabler.

Exit 78 is intentional: this application has no reviewed runner/evaluator/serving
adapter. No detected executable is launched, installed, started or configured.
"""
import json
import os
import platform
import shutil
from datetime import datetime, timezone

TOOLS = ('docker', 'podman', 'kubectl', 'nerdctl', 'wsl', 'python')
REQUIRED_GATES = (
    'Operator-approved isolation platform and patched runtime',
    'Per-student filesystem and process separation',
    'No application environment, database credentials or control socket in a workload',
    'Deny-by-default network and private artifact authorization',
    'Enforced CPU, memory, process, wall-time, output and storage limits',
    'Independent restricted service identity and authenticated job channel',
    'Atomic claim, cancellation acknowledgement, crash recovery and cleanup',
    'Adversarial isolation tests and measured service health',
    'Trusted evaluation provenance bound to model, dataset and evaluator versions',
    'Verified inference provider with authenticated ownership, health and rollback',
)


def inventory(lookup=None):
    lookup = lookup or shutil.which
    return {
        'schema_version': 1,
        'observed_utc': datetime.now(timezone.utc).isoformat(),
        'platform': {'system': platform.system(), 'release': platform.release(), 'logical_processors': os.cpu_count()},
        'command_inventory': [{'name': tool, 'found_on_path': lookup(tool) is not None} for tool in TOOLS],
        'execution': {'status': 'BLOCKED', 'enabled': False, 'reason': 'No reviewed isolated runner adapter is deployed.'},
        'evaluation': {'status': 'NOT_EVALUATED', 'enabled': False, 'reason': 'No trusted isolated evaluator and measurement provenance are deployed.'},
        'inference': {'status': 'UNAVAILABLE', 'enabled': False, 'reason': 'No verified live inference provider is integrated.'},
        'unverified_gates': list(REQUIRED_GATES),
        'limitations': [
            'Found on PATH does not prove installation, daemon health, resource limits or isolation.',
            'This tool executes no external command and changes no settings, services, database or private files.',
            'No environment values, credentials, machine hostname or source contents are emitted.',
            'A future adapter needs independent security acceptance; an environment flag cannot enable these services.',
        ],
    }


def main():
    print(json.dumps(inventory(), indent=2))
    return 78


if __name__ == '__main__':
    raise SystemExit(main())
