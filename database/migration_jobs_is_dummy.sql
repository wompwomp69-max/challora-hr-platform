-- Add marker for dummy job records
USE challora_recruitment;

ALTER TABLE jobs
ADD COLUMN is_dummy TINYINT(1) NOT NULL DEFAULT 0;

CREATE INDEX idx_jobs_is_dummy ON jobs(is_dummy);
