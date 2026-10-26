#!/usr/bin/env python3
"""Student execution is disabled until an independent isolated runner is verified.

The former host subprocess implementation was not isolation and has been removed.
A future runner requires its own restricted credentials, filesystem/network policy,
CPU/memory/process limits, authenticated result channel and cancellation guarantees.
"""
import sys

def main():
    print("Execution unavailable: no verified isolated runner is deployed.", file=sys.stderr)
    return 78

if __name__ == "__main__":
    raise SystemExit(main())
