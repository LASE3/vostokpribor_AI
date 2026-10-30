-- Preserve explicit fractional instructor grades accepted by the existing review form.
ALTER TABLE submissions MODIFY COLUMN total_score DECIMAL(5,2) NULL;
