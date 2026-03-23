<?php
/**
 * EquipmentModel
 */
class EquipmentModel extends Model
{
    protected $table = 'equipments';

    public function getAllFiltered($search = '', $status = '')
    {
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        $params = [];
        if (!empty($search)) {
            $sql .= " AND (name LIKE :s OR category LIKE :s2)";
            $params[':s'] = "%{$search}%";
            $params[':s2'] = "%{$search}%";
        }
        if (!empty($status)) {
            $sql .= " AND status = :st";
            $params[':st'] = $status;
        }
        $sql .= " ORDER BY name ASC";
        $this->db->query($sql);
        foreach ($params as $k => $v) $this->db->bind($k, $v);
        return $this->db->resultSet();
    }

    public function countByStatus($status)
    {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE status = :s");
        $this->db->bind(':s', $status);
        return $this->db->single()->total;
    }

    public function getNeedingMaintenance()
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE next_maintenance_date <= CURDATE() AND status = 'active' ORDER BY next_maintenance_date");
        return $this->db->resultSet();
    }
}
