#!/usr/bin/env python3
"""Inventory behavior only; these are not sandbox or inference success tests."""
import contextlib
import importlib.util
import io
import json
from pathlib import Path
import unittest
from unittest.mock import patch

ROOT = Path(__file__).resolve().parents[1]
SPEC = importlib.util.spec_from_file_location('range_infrastructure_preflight', ROOT / 'bin/infrastructure_preflight.py')
preflight = importlib.util.module_from_spec(SPEC)
SPEC.loader.exec_module(preflight)


class InfrastructurePreflightTests(unittest.TestCase):
    def test_absent_tools_report_no_path_presence(self):
        result = preflight.inventory(lambda name: None)
        self.assertFalse(any(item['found_on_path'] for item in result['command_inventory']))

    def test_present_tools_never_enable_unverified_services(self):
        result = preflight.inventory(lambda name: '/operator/local/' + name)
        self.assertTrue(all(item['found_on_path'] for item in result['command_inventory']))
        for service in ('execution', 'evaluation', 'inference'):
            self.assertFalse(result[service]['enabled'])
        self.assertEqual(result['execution']['status'], 'BLOCKED')
        self.assertEqual(result['evaluation']['status'], 'NOT_EVALUATED')
        self.assertEqual(result['inference']['status'], 'UNAVAILABLE')

    def test_lookup_only_receives_known_readonly_names(self):
        names = []
        preflight.inventory(lambda name: names.append(name))
        self.assertEqual(tuple(names), preflight.TOOLS)

    def test_no_private_paths_or_environment_values_emitted(self):
        marker = 'DO_NOT_EMIT_PRIVATE_CREDENTIAL_6ae28c7'
        with patch.dict(preflight.os.environ, {'DB_PASS': marker, 'APP_KEY': marker}):
            result = preflight.inventory(lambda name: marker)
        self.assertNotIn(marker, json.dumps(result))

    def test_all_acceptance_gates_remain_explicit(self):
        result = preflight.inventory(lambda name: None)
        self.assertEqual(len(result['unverified_gates']), 10)
        self.assertIn('No application environment', result['unverified_gates'][2])

    def test_cli_exit_is_disabled_and_emits_parseable_json(self):
        output = io.StringIO()
        with contextlib.redirect_stdout(output):
            self.assertEqual(preflight.main(), 78)
        self.assertFalse(json.loads(output.getvalue())['execution']['enabled'])


if __name__ == '__main__':
    unittest.main(verbosity=2)
