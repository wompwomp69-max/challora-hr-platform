
USE challora_recruitment;


ALTER TABLE applications ADD COLUMN cv_path VARCHAR(255) DEFAULT NULL;


UPDATE applications SET status = 'pending' WHERE status IN ('applied', 'reviewed');
ALTER TABLE applications MODIFY COLUMN status ENUM('pending', 'accepted', 'rejected') NOT NULL DEFAULT 'pending';
