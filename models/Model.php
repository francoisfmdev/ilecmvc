<?php

namespace Models;

use PDO;

class Model
{
    protected PDO $db;
    protected string $table; // Le nom de la table associée au modèle

    public function __construct(PDO $db, string $table)
    {
        $this->db = $db;
        $this->table = $table;
    }

    /**
     * Récupérer une ligne par son ID.
     *
     * @param int $id
     * @return array|null
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Récupérer toutes les lignes.
     *
     * @return array
     */
    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Insérer une nouvelle ligne.
     *
     * @param array $data
     * @return int|null L'ID de la nouvelle ligne ou null en cas d'échec.
     */
    public function create(array $data): ?int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);

        if ($stmt->execute($data)) {
            return (int)$this->db->lastInsertId();
        }

        return null;
    }

    /**
     * Mettre à jour une ligne par son ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $setPart = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));
        $data['id'] = $id;

        $sql = "UPDATE {$this->table} SET $setPart WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }

    /**
     * Supprimer une ligne par son ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
