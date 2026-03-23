<?php
/**
 * NotificationModel
 */
class NotificationModel extends Model
{
    protected $table = 'notifications';

    public function getByUser($userId, $limit = 20)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE user_id = :uid ORDER BY created_at DESC LIMIT {$limit}");
        $this->db->bind(':uid', $userId);
        return $this->db->resultSet();
    }

    public function getUnreadCount($userId)
    {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE user_id = :uid AND is_read = 0");
        $this->db->bind(':uid', $userId);
        return $this->db->single()->total;
    }

    public function markRead($id)
    {
        $this->db->query("UPDATE {$this->table} SET is_read = 1 WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function markAllRead($userId)
    {
        $this->db->query("UPDATE {$this->table} SET is_read = 1 WHERE user_id = :uid AND is_read = 0");
        $this->db->bind(':uid', $userId);
        return $this->db->execute();
    }

    public function createForAllMembers($title, $message, $type = 'system')
    {
        $this->db->query("SELECT id FROM users WHERE role = 'member' AND is_active = 1");
        $users = $this->db->resultSet();
        foreach ($users as $u) {
            $this->create(['user_id' => $u->id, 'title' => $title, 'message' => $message, 'type' => $type]);
        }
    }
}
