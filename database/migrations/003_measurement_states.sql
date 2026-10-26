-- Measurement state must distinguish absent trusted evidence from a failed quality test.
ALTER TABLE validation_runs MODIFY COLUMN status ENUM('PENDING','RUNNING','PASSED','FAILED','NOT_EVALUATED','INCOMPLETE') NOT NULL DEFAULT 'PENDING';
ALTER TABLE experiment_runs MODIFY COLUMN status ENUM('RUNNING','COMPLETED','FAILED','RECORDED') NOT NULL DEFAULT 'RECORDED';
