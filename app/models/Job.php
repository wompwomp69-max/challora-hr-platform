<?php
class Job {
    private PDO $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function all(): array {
        $stmt = $this->db->query('
            SELECT j.*, u.name AS created_by_name
            FROM jobs j
            LEFT JOIN users u ON u.id = j.created_by
            ORDER BY j.created_at DESC
        ');
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array {
        $stmt = $this->db->prepare('
            SELECT j.*, u.name AS created_by_name
            FROM jobs j
            LEFT JOIN users u ON u.id = j.created_by
            WHERE j.id = ?
        ');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findByCreator(int $createdBy): array {
        $stmt = $this->db->prepare('SELECT * FROM jobs WHERE created_by = ? ORDER BY created_at DESC');
        $stmt->execute([$createdBy]);
        return $stmt->fetchAll();
    }

    public function create(array $data): int {
        $stmt = $this->db->prepare('
            INSERT INTO jobs (title, description, location, salary_range, created_by)
            VALUES (?, ?, ?, ?, ?)
        ');
        $stmt->execute([
            $data['title'],
            $data['description'],
            $data['location'] ?? null,
            $data['salary_range'] ?? null,
            $data['created_by'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare('
            UPDATE jobs SET title = ?, description = ?, location = ?, salary_range = ?
            WHERE id = ?
        ');
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['location'] ?? null,
            $data['salary_range'] ?? null,
            $id,
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM jobs WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function isCreatedBy(int $jobId, int $userId): bool {
        $stmt = $this->db->prepare('SELECT 1 FROM jobs WHERE id = ? AND created_by = ?');
        $stmt->execute([$jobId, $userId]);
        return (bool) $stmt->fetch();
    }
}
