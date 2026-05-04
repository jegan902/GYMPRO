<?php
/**
 * MemberModel
 * Handles member-related database operations
 */
require_once APP_ROOT . '/app/models/UserModel.php';

class MemberModel extends Model
{
    protected $table = 'members';

    /**
     * Get all members with user info
     */
    public function getAllWithUser($search = '', $status = '')
    {
        $sql = "SELECT m.*, u.full_name, u.email, u.phone, u.avatar, u.is_active as user_active
                FROM {$this->table} m
                JOIN users u ON m.user_id = u.id
                WHERE 1=1";
        $params = [];

        if (!empty($search)) {
            $sql .= " AND (u.full_name LIKE :search OR u.email LIKE :search2 OR u.phone LIKE :search3)";
            $params[':search'] = "%{$search}%";
            $params[':search2'] = "%{$search}%";
            $params[':search3'] = "%{$search}%";
        }

        if (!empty($status)) {
            $sql .= " AND m.status = :status";
            $params[':status'] = $status;
        }

        $sql .= " ORDER BY m.created_at DESC";

        $this->db->query($sql);
        foreach ($params as $key => $val) {
            $this->db->bind($key, $val);
        }
        return $this->db->resultSet();
    }

    /**
     * Get member by User ID
     */
    public function findByUserId($userId)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE user_id = :uid");
        $this->db->bind(':uid', $userId);
        return $this->db->single();
    }

    /**
     * Get single member with user info
     */
    public function getWithUser($id)
    {
        $this->db->query("SELECT m.*, u.full_name, u.email, u.phone, u.avatar, u.role, u.is_active as user_active
                          FROM {$this->table} m
                          JOIN users u ON m.user_id = u.id
                          WHERE m.id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Get member by user_id
     */
    public function getByUserId($userId)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE user_id = :user_id");
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }

    /**
     * Create member with user account
     */
    public function createWithUser($userData, $memberData)
    {
        // Admin creates a member, set role to member explicitly
        $userData['role'] = 'member';

        // Create user first
        $userModel = new UserModel();
        $userId = $userModel->register($userData);

        if (!$userId) return false;

        // Create member
        $memberData['user_id'] = $userId;
        if (!empty($memberData['height']) && !empty($memberData['weight'])) {
            $h = $memberData['height'] / 100;
            $memberData['bmi'] = round($memberData['weight'] / ($h * $h), 2);
        }

        return $this->create($memberData);
    }

    /**
     * Update member and user info
     */
    public function updateWithUser($memberId, $userData, $memberData)
    {
        $member = $this->findById($memberId);
        if (!$member) return false;

        // Recalculate BMI
        if (!empty($memberData['height']) && !empty($memberData['weight'])) {
            $h = $memberData['height'] / 100;
            $memberData['bmi'] = round($memberData['weight'] / ($h * $h), 2);
        }

        // Update user
        $userModel = new UserModel();
        $userModel->update($member->user_id, $userData);

        // Update member
        return $this->update($memberId, $memberData);
    }

    /**
     * Get active package for member
     */
    public function getActivePackage($memberId)
    {
        $this->db->query("SELECT mp.*, p.name as package_name, p.duration, p.price, p.features
                          FROM member_packages mp
                          JOIN packages p ON mp.package_id = p.id
                          WHERE mp.member_id = :member_id AND mp.status = 'active'
                          ORDER BY mp.end_date DESC LIMIT 1");
        $this->db->bind(':member_id', $memberId);
        return $this->db->single();
    }

    /**
     * Check if a member has an active package with PT features
     */
    public function hasPTPackage($userId)
    {
        $member = $this->getByUserId($userId);
        if (!$member) return false;

        $package = $this->getActivePackage($member->id);
        if (!$package || empty($package->features)) return false;

        return stripos($package->features, 'PT') !== false;
    }

    /**
     * Count by status
     */
    public function countByStatus($status)
    {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE status = :status");
        $this->db->bind(':status', $status);
        return $this->db->single()->total;
    }
}
