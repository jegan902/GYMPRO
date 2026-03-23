<?php
/**
 * InvoiceModel
 */
class InvoiceModel extends Model
{
    protected $table = 'invoices';

    public function getAllWithDetails($search = '', $status = '')
    {
        $sql = "SELECT i.*, u.full_name as member_name, p.name as package_name
                FROM {$this->table} i
                JOIN members m ON i.member_id = m.id
                JOIN users u ON m.user_id = u.id
                LEFT JOIN packages p ON i.package_id = p.id
                WHERE 1=1";
        $params = [];

        if (!empty($search)) {
            $sql .= " AND (u.full_name LIKE :search OR i.transaction_id LIKE :search2)";
            $params[':search'] = "%{$search}%";
            $params[':search2'] = "%{$search}%";
        }
        if (!empty($status)) {
            $sql .= " AND i.status = :status";
            $params[':status'] = $status;
        }

        $sql .= " ORDER BY i.created_at DESC";

        $this->db->query($sql);
        foreach ($params as $k => $v) $this->db->bind($k, $v);
        return $this->db->resultSet();
    }

    public function getWithDetails($id)
    {
        $this->db->query("SELECT i.*, u.full_name as member_name, u.email as member_email, u.phone as member_phone,
                          p.name as package_name, p.duration as package_duration
                          FROM {$this->table} i
                          JOIN members m ON i.member_id = m.id
                          JOIN users u ON m.user_id = u.id
                          LEFT JOIN packages p ON i.package_id = p.id
                          WHERE i.id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getTotalRevenue($month = null, $year = null)
    {
        $sql = "SELECT COALESCE(SUM(amount), 0) as total FROM {$this->table} WHERE status = 'paid'";
        if ($month && $year) {
            $sql .= " AND MONTH(payment_date) = :month AND YEAR(payment_date) = :year";
        }
        $this->db->query($sql);
        if ($month && $year) {
            $this->db->bind(':month', $month);
            $this->db->bind(':year', $year);
        }
        return $this->db->single()->total;
    }

    public function getRevenueByMonth($year = null)
    {
        $year = $year ?? date('Y');
        $this->db->query("SELECT MONTH(payment_date) as month, SUM(amount) as total
                          FROM {$this->table}
                          WHERE status = 'paid' AND YEAR(payment_date) = :year
                          GROUP BY MONTH(payment_date)
                          ORDER BY month");
        $this->db->bind(':year', $year);
        return $this->db->resultSet();
    }
}
