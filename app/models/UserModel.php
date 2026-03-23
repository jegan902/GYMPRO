<?php
/**
 * UserModel
 * Handles user-related database operations
 */
class UserModel extends Model
{
    protected $table = 'users';

    public function findByEmail($email)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE email = :email");
        $this->db->bind(':email', $email);
        return $this->db->single();
    }

    public function register($data)
    {
        return $this->create([
            'full_name' => $data['full_name'],
            'email'     => $data['email'],
            'password'  => password_hash($data['password'], PASSWORD_DEFAULT),
            'phone'     => $data['phone'] ?? null,
            'role'      => $data['role'] ?? 'user',
        ]);
    }

    public function updateLastLogin($id)
    {
        $this->db->query("UPDATE {$this->table} SET last_login = NOW() WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function emailExists($email)
    {
        $user = $this->findByEmail($email);
        return $user ? true : false;
    }

    public function countByRole($role)
    {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE role = :role");
        $this->db->bind(':role', $role);
        $result = $this->db->single();
        return $result->total;
    }

}
