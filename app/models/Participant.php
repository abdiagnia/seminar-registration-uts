<?php

class Participant
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function all(): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM participants ORDER BY id DESC'
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM participants WHERE id = :id'
        );

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO participants (code, name, email, institution, category)
            VALUES (:code, :name, :email, :institution, :category)'
        );

        return $stmt->execute($data);
    }

    public function update(int $id, array $data): bool
    {
        $data['id'] = $id;

        $stmt = $this->db->prepare(
            'UPDATE participants
            SET code = :code,
                name = :name,
                email = :email,
                institution = :institution,
                category = :category
            WHERE id = :id'
        );

        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            'DELETE FROM participants WHERE id = :id'
        );

        return $stmt->execute(['id' => $id]);
    }
}
