import os
import re

base_dir = 'ML Workbench'
subpages = [
    'ExperimentRuns.php',
    'ModelArtifacts.php',
    'MetricTelemetry.php',
    'RangeEvaluation.php',
    'TensorInspector.php',
    'HyperparameterMatrix.php'
]

# 1. Patch NotebookWorkbench.php insert
nb_file = os.path.join(base_dir, 'NotebookWorkbench.php')
with open(nb_file, 'r', encoding='utf-8') as f:
    c = f.read()

pattern = re.compile(
    r'(\$nbId = \$db->insert\(\s*"INSERT INTO notebooks.*?\);\s*\$notebook = \$db->fetchOne\(.*?\);\s*// Seed initial cells\s*\$db->insert\(.*?;\s*\$db->insert\(.*?;)',
    re.DOTALL
)

replacement = """$nbId = $db->insert('notebooks', [
            'code' => $nbCode,
            'title' => 'telemetry_pipeline_v1.ipynb',
            'student_id' => $currentUser['id'],
            'ticket_id' => $ticketId,
            'version' => 1,
            'status' => 'ACTIVE',
            'kernel_state' => 'IDLE'
        ]);
        $notebook = $db->fetchOne("SELECT * FROM notebooks WHERE id = :id", ['id' => $nbId]);

        // Seed initial cells using structured inserts
        $db->insert('notebook_cells', [
            'notebook_id' => $nbId,
            'cell_order' => 1,
            'cell_type' => 'markdown',
            'source' => "# VOSTOKPRIBOR Telemetry Range\\nPipeline candidate notebook.",
            'output_text' => ''
        ]);
        $db->insert('notebook_cells', [
            'notebook_id' => $nbId,
            'cell_order' => 2,
            'cell_type' => 'code',
            'source' => "import os, sys\\nprint(f'Python {sys.version.split()[0]} online in range environment.')\\nsum_val = sum(range(10))\\nprint(f'Computed sum: {sum_val}')",
            'output_text' => 'Python runtime available.'
        ]);"""

new_c = pattern.sub(replacement, c)
if new_c != c:
    with open(nb_file, 'w', encoding='utf-8') as f:
        f.write(new_c)
    print('NotebookWorkbench.php inserts patched successfully.')
else:
    print('Pattern did not match in NotebookWorkbench.php')

# 2. Patch the 6 subpages
sub_pattern = re.compile(
    r'(\s*if \(!\$notebook\) \{.*?// Seed initial cells\s*\$db->insert\(.*?\);\s*\$db->insert\(.*?\);\s*\}\s*)',
    re.DOTALL
)

for page in subpages:
    filepath = os.path.join(base_dir, page)
    if not os.path.exists(filepath):
        continue
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
    new_content = sub_pattern.sub('\n', content)
    if new_content != content:
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f'{page} patched: auto-creation removed.')
    else:
        print(f'Pattern did not match in {page}')
