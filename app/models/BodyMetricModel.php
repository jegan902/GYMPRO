<?php
/**
 * BodyMetricModel
 */
class BodyMetricModel extends Model
{
    protected $table = 'body_metrics';

    public function getByMember($memberId, $limit = 20)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE member_id = :mid ORDER BY measured_date DESC LIMIT {$limit}");
        $this->db->bind(':mid', $memberId);
        return $this->db->resultSet();
    }

    public function getLatest($memberId)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE member_id = :mid ORDER BY measured_date DESC LIMIT 1");
        $this->db->bind(':mid', $memberId);
        return $this->db->single();
    }

    public function getChartData($memberId, $field = 'weight', $limit = 12)
    {
        $this->db->query("SELECT measured_date, {$field} as value FROM {$this->table} WHERE member_id = :mid AND {$field} IS NOT NULL ORDER BY measured_date ASC LIMIT {$limit}");
        $this->db->bind(':mid', $memberId);
        return $this->db->resultSet();
    }

    public function getAllRecent($limit = 20)
    {
        $this->db->query("SELECT bm.*, u.full_name
                          FROM {$this->table} bm
                          JOIN members m ON bm.member_id = m.id
                          JOIN users u ON m.user_id = u.id
                          ORDER BY bm.measured_date DESC
                          LIMIT {$limit}");
        return $this->db->resultSet();
    }
}
