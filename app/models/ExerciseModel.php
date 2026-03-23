<?php
/**
 * ExerciseModel
 */
class ExerciseModel extends Model
{
    protected $table = 'exercises';

    public function getAllWithMuscle($search = '', $muscleGroupId = 0)
    {
        $sql = "SELECT e.*, mg.name as muscle_group_name, mg.name_vi as muscle_group_vi
                FROM {$this->table} e
                LEFT JOIN muscle_groups mg ON e.muscle_group_id = mg.id
                WHERE 1=1";
        $params = [];
        if (!empty($search)) {
            $sql .= " AND (e.name LIKE :search OR mg.name_vi LIKE :search2 OR mg.name LIKE :search3)";
            $params[':search'] = "%{$search}%";
            $params[':search2'] = "%{$search}%";
            $params[':search3'] = "%{$search}%";
        }
        if ($muscleGroupId > 0) {
            $sql .= " AND e.muscle_group_id = :mgid";
            $params[':mgid'] = $muscleGroupId;
        }
        $sql .= " ORDER BY mg.name, e.name";
        $this->db->query($sql);
        foreach ($params as $k => $v) $this->db->bind($k, $v);
        return $this->db->resultSet();
    }

    public function getByMuscleGroup($muscleGroupId)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE muscle_group_id = :mgid ORDER BY name");
        $this->db->bind(':mgid', $muscleGroupId);
        return $this->db->resultSet();
    }

    public function getMuscleGroups()
    {
        $this->db->query("SELECT * FROM muscle_groups ORDER BY name");
        return $this->db->resultSet();
    }
}
