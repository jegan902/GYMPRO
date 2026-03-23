<?php
/**
 * Base Model Class
 * Provides common database operations via PDO
 */
class Model
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findAll($orderBy = 'id DESC')
    {
        $this->db->query("SELECT * FROM {$this->table} ORDER BY {$orderBy}");
        return $this->db->resultSet();
    }

    public function findById($id)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function create($data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $this->db->query("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})");

        foreach ($data as $key => $value) {
            $this->db->bind(':' . $key, $value);
        }

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function update($id, $data)
    {
        $setParts = [];
        foreach ($data as $key => $value) {
            $setParts[] = "{$key} = :{$key}";
        }
        $setString = implode(', ', $setParts);

        $this->db->query("UPDATE {$this->table} SET {$setString} WHERE id = :id");

        foreach ($data as $key => $value) {
            $this->db->bind(':' . $key, $value);
        }
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function count($condition = '1=1')
    {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE {$condition}");
        $result = $this->db->single();
        return $result->total;
    }
}
