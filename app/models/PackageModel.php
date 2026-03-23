<?php
/**
 * PackageModel
 */
class PackageModel extends Model
{
    protected $table = 'packages';

    public function getActive()
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY price ASC");
        return $this->db->resultSet();
    }

    public function assignToMember($memberId, $packageId, $startDate = null)
    {
        $pkg = $this->findById($packageId);
        if (!$pkg) return false;

        $start = $startDate ?? date('Y-m-d');
        $end = date('Y-m-d', strtotime($start . ' + ' . $pkg->duration . ' days'));

        $this->db->query("INSERT INTO member_packages (member_id, package_id, start_date, end_date, status, payment_status)
                          VALUES (:mid, :pid, :start, :end, 'active', 'paid')");
        $this->db->bind(':mid', $memberId);
        $this->db->bind(':pid', $packageId);
        $this->db->bind(':start', $start);
        $this->db->bind(':end', $end);
        return $this->db->execute();
    }

    public function getMemberPackages($memberId)
    {
        $this->db->query("SELECT mp.*, p.name as package_name, p.duration, p.price
                          FROM member_packages mp
                          JOIN packages p ON mp.package_id = p.id
                          WHERE mp.member_id = :mid ORDER BY mp.created_at DESC");
        $this->db->bind(':mid', $memberId);
        return $this->db->resultSet();
    }

    public function getAllMemberPackages()
    {
        $this->db->query("SELECT mp.*, p.name as package_name, p.price, u.full_name as member_name
                          FROM member_packages mp
                          JOIN packages p ON mp.package_id = p.id
                          JOIN members m ON mp.member_id = m.id
                          JOIN users u ON m.user_id = u.id
                          ORDER BY mp.created_at DESC");
        return $this->db->resultSet();
    }

    public function expirePackages()
    {
        $this->db->query("UPDATE member_packages SET status = 'expired' WHERE status = 'active' AND end_date < CURDATE()");
        return $this->db->execute();
    }
}
