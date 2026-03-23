<?php
/**
 * AttendanceModel
 */
class AttendanceModel extends Model
{
    protected $table = 'attendance';

    public function checkIn($memberId, $method = 'manual')
    {
        // Check if already checked in today without checkout
        $existing = $this->getActiveCheckIn($memberId);
        if ($existing) return false;

        $this->db->query("INSERT INTO {$this->table} (member_id, check_in_time, method) VALUES (:mid, NOW(), :method)");
        $this->db->bind(':mid', $memberId);
        $this->db->bind(':method', $method);
        return $this->db->execute();
    }

    public function checkOut($memberId)
    {
        $active = $this->getActiveCheckIn($memberId);
        if (!$active) return false;

        $this->db->query("UPDATE {$this->table} SET check_out_time = NOW() WHERE id = :id");
        $this->db->bind(':id', $active->id);
        return $this->db->execute();
    }

    public function getActiveCheckIn($memberId)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE member_id = :mid AND DATE(check_in_time) = CURDATE() AND check_out_time IS NULL ORDER BY check_in_time DESC LIMIT 1");
        $this->db->bind(':mid', $memberId);
        return $this->db->single();
    }

    public function getTodayAttendance()
    {
        $this->db->query("SELECT a.*, m.id as member_id, u.full_name, u.avatar, u.phone
                          FROM {$this->table} a
                          JOIN members m ON a.member_id = m.id
                          JOIN users u ON m.user_id = u.id
                          WHERE DATE(a.check_in_time) = CURDATE()
                          ORDER BY a.check_in_time DESC");
        return $this->db->resultSet();
    }

    public function getHistory($memberId = null, $dateFrom = null, $dateTo = null, $limit = 50)
    {
        $sql = "SELECT a.*, u.full_name, u.avatar
                FROM {$this->table} a
                JOIN members m ON a.member_id = m.id
                JOIN users u ON m.user_id = u.id
                WHERE 1=1";
        $params = [];

        if ($memberId) {
            $sql .= " AND a.member_id = :mid";
            $params[':mid'] = $memberId;
        }
        if ($dateFrom) {
            $sql .= " AND DATE(a.check_in_time) >= :dfrom";
            $params[':dfrom'] = $dateFrom;
        }
        if ($dateTo) {
            $sql .= " AND DATE(a.check_in_time) <= :dto";
            $params[':dto'] = $dateTo;
        }

        $sql .= " ORDER BY a.check_in_time DESC LIMIT {$limit}";

        $this->db->query($sql);
        foreach ($params as $k => $v) $this->db->bind($k, $v);
        return $this->db->resultSet();
    }

    public function countToday()
    {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE DATE(check_in_time) = CURDATE()");
        return $this->db->single()->total;
    }

    public function currentlyInGym()
    {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE DATE(check_in_time) = CURDATE() AND check_out_time IS NULL");
        return $this->db->single()->total;
    }

    public function getWeeklyStats()
    {
        $this->db->query("SELECT DATE(check_in_time) as date, COUNT(*) as total
                          FROM {$this->table}
                          WHERE check_in_time >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                          GROUP BY DATE(check_in_time)
                          ORDER BY date");
        return $this->db->resultSet();
    }
}
