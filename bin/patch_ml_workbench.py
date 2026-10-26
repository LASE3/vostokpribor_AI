# Patch ML Workbench files: structured inserts, remove spurious auto-creation, truthful telemetry

import os

base_dir = 'ML Workbench'
subpages = [
    'ExperimentRuns.php',
    'ModelArtifacts.php',
    'MetricTelemetry.php',
    'RangeEvaluation.php',
    'TensorInspector.php',
    'HyperparameterMatrix.php'
]

# 1. Patch NotebookWorkbench.php
nb_path = os.path.join(base_dir, 'NotebookWorkbench.php')
with open(nb_path, 'r', encoding='utf-8') as f:
    nb_content = f.read()

# Replace raw insert with structured insert
old_nb_insert = """        $nbId = $db->insert(
            "INSERT INTO notebooks (code, title, student_id, ticket_id, version, status, kernel_state, created_at, updated_at)
             VALUES (:code, 'telemetry_pipeline_v1.ipynb', :sid, :tid, 1, 'ACTIVE', 'IDLE', NOW(), NOW())",
            [
                'code' => $nbCode,
                'sid' => $currentUser['id'],
                'tid' => $ticketId
            ]
        );
        $notebook = $db->fetchOne("SELECT * FROM notebooks WHERE id = :id", ['id' => $nbId]);

        // Seed initial cells
        $db->insert("INSERT INTO notebook_cells (notebook_id, cell_order, cell_type, source, output_text, updated_at) VALUES (:nid, 1, 'markdown', '# VOSTOKPRIBOR Telemetry Range\\nPipeline candidate notebook.', '', NOW())", ['nid' => $nbId]);
        $db->insert("INSERT INTO notebook_cells (notebook_id, cell_order, cell_type, source, output_text, updated_at) VALUES (:nid, 2, 'code', 'import os, sys\\nprint(f\\"Python {sys.version.split()[0]} online in range sandbox.\\")\\nsum_val = sum(range(10))\\nprint(f\\"Computed sum: {sum_val}\\")', 'Loaded Python runtime in sandbox.', NOW())", ['nid' => $nbId]);"""

new_nb_insert = """        $nbId = $db->insert('notebooks', [
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
            'source' => "# VOSTOKPRIBOR Telemetry Range\nPipeline candidate notebook.",
            'output_text' => ''
        ]);
        $db->insert('notebook_cells', [
            'notebook_id' => $nbId,
            'cell_order' => 2,
            'cell_type' => 'code',
            'source' => "import os, sys\nprint(f'Python {sys.version.split()[0]} online in range environment.')\nsum_val = sum(range(10))\nprint(f'Computed sum: {sum_val}')",
            'output_text' => 'Python runtime available.'
        ]);"""

if old_nb_insert in nb_content:
    nb_content = nb_content.replace(old_nb_insert, new_nb_insert)
    print("NotebookWorkbench.php inserts patched to structured calls.")
else:
    print("Warning: old_nb_insert not matched directly in NotebookWorkbench.php")

# Truthful telemetry in NotebookWorkbench.php
nb_content = nb_content.replace(
    '<span>Python 3.10.12 (GPU A100-SXM4-40GB: Idle 14% RAM)</span>',
    '<span>Local Python 3 (Container Sandbox: Not Installed)</span>'
)
nb_content = nb_content.replace(
    '<span class="text-on-surface font-semibold">RAM: 4.8 / 32 GB</span><span class="mx-1 text-outline-variant">|</span><span class="text-on-surface font-semibold">Disk: 18.2 / 100 GB</span>',
    '<span class="text-on-surface font-semibold">Memory: Host Process</span><span class="mx-1 text-outline-variant">|</span><span class="text-on-surface font-semibold">Storage: Local Range</span>'
)
nb_content = nb_content.replace(
    '<span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Kernel Connected</span>',
    '<span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Kernel: Host Mode</span>'
)

with open(nb_path, 'w', encoding='utf-8') as f:
    f.write(nb_content)
print("NotebookWorkbench.php updated.")

# 2. Patch 6 Sub-pages (remove spurious auto-creation on GET)
for page in subpages:
    filepath = os.path.join(base_dir, page)
    if not os.path.exists(filepath):
        continue
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # Replace the auto-creation block
    target_block = """if ($isStudent) {
    $notebook = $db->fetchOne("SELECT * FROM notebooks WHERE student_id = :sid ORDER BY updated_at DESC LIMIT 1", ['sid' => $currentUser['id']]);
    if (!$notebook) {
        // Create initial notebook
        $nbCode = 'NB-' . strtoupper(bin2hex(random_bytes(3)));
        $assignedTicket = $db->fetchOne("SELECT ticket_id FROM ticket_assignments WHERE student_id = :sid LIMIT 1", ['sid' => $currentUser['id']]);
        $ticketId = $assignedTicket ? $assignedTicket['ticket_id'] : null;
        $nbId = $db->insert(
            "INSERT INTO notebooks (code, title, student_id, ticket_id, version, status, kernel_state, created_at, updated_at)
             VALUES (:code, 'telemetry_pipeline_v1.ipynb', :sid, :tid, 1, 'ACTIVE', 'IDLE', NOW(), NOW())",
            [
                'code' => $nbCode,
                'sid' => $currentUser['id'],
                'tid' => $ticketId
            ]
        );
        $notebook = $db->fetchOne("SELECT * FROM notebooks WHERE id = :id", ['id' => $nbId]);

        // Seed initial cells
        $db->insert("INSERT INTO notebook_cells (notebook_id, cell_order, cell_type, source, output_text, updated_at) VALUES (:nid, 1, 'markdown', '# VOSTOKPRIBOR Telemetry Range\\nPipeline candidate notebook.', '', NOW())", ['nid' => $nbId]);
        $db->insert("INSERT INTO notebook_cells (notebook_id, cell_order, cell_type, source, output_text, updated_at) VALUES (:nid, 2, 'code', 'import os, sys\\nprint(f\\"Python {sys.version.split()[0]} online in range sandbox.\\")\\nsum_val = sum(range(10))\\nprint(f\\"Computed sum: {sum_val}\\")', 'Loaded Python runtime in sandbox.', NOW())", ['nid' => $nbId]);
    }
} else {
    $notebook = $db->fetchOne("SELECT * FROM notebooks ORDER BY updated_at DESC LIMIT 1");
}"""

    replacement_block = """if ($isStudent) {
    $notebook = $db->fetchOne("SELECT * FROM notebooks WHERE student_id = :sid ORDER BY updated_at DESC LIMIT 1", ['sid' => $currentUser['id']]);
} else {
    $notebook = $db->fetchOne("SELECT * FROM notebooks ORDER BY updated_at DESC LIMIT 1");
}"""

    if target_block in content:
        content = content.replace(target_block, replacement_block)
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"{page} successfully updated (spurious auto-creation removed).")
    else:
        # Check CRLF
        target_block_crlf = target_block.replace('\n', '\r\n')
        replacement_block_crlf = replacement_block.replace('\n', '\r\n')
        if target_block_crlf in content:
            content = content.replace(target_block_crlf, replacement_block_crlf)
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(content)
            print(f"{page} successfully updated (CRLF matched).")
        else:
            print(f"Target block not found in {page}")
