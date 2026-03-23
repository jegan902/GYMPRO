<?php
/**
 * SettingModel
 */
class SettingModel extends Model
{
    protected $table = 'settings';

    public function getAll()
    {
        $this->db->query("SELECT * FROM {$this->table} ORDER BY setting_key");
        return $this->db->resultSet();
    }

    public function get($key)
    {
        $this->db->query("SELECT setting_value FROM {$this->table} WHERE setting_key = :k");
        $this->db->bind(':k', $key);
        $row = $this->db->single();
        return $row ? $row->setting_value : null;
    }

    public function set($key, $value)
    {
        $this->db->query("UPDATE {$this->table} SET setting_value = :v WHERE setting_key = :k");
        $this->db->bind(':v', $value);
        $this->db->bind(':k', $key);
        return $this->db->execute();
    }
}
