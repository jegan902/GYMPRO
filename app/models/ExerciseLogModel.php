<?php
/**
 * ExerciseLogModel
 */
class ExerciseLogModel extends Model
{
    protected $table = 'exercise_logs';

    public function getByMember($memberId, $limit = 30)
    {
        $this->db->query("SELECT el.*, e.name as exercise_name, mg.name_vi as muscle_group
                          FROM {$this->table} el
                          JOIN exercises e ON el.exercise_id = e.id
                          LEFT JOIN muscle_groups mg ON e.muscle_group_id = mg.id
                          WHERE el.member_id = :mid
                          ORDER BY el.log_date DESC, el.created_at DESC
                          LIMIT {$limit}");
        $this->db->bind(':mid', $memberId);
        return $this->db->resultSet();
    }

    public function getGroupedByDate($memberId, $limit = 10)
    {
        $logs = $this->getByMember($memberId, 100);
        $grouped = [];
        foreach ($logs as $log) {
            $date = $log->log_date;
            $grouped[$date][] = $log;
        }
        return array_slice($grouped, 0, $limit, true);
    }

    public function getProgressData($memberId, $exerciseId, $limit = 12)
    {
        $this->db->query("SELECT log_date, MAX(weight) as max_weight, MAX(reps) as max_reps
                          FROM {$this->table}
                          WHERE member_id = :mid AND exercise_id = :eid
                          GROUP BY log_date
                          ORDER BY log_date ASC
                          LIMIT {$limit}");
        $this->db->bind(':mid', $memberId);
        $this->db->bind(':eid', $exerciseId);
        return $this->db->resultSet();
    }
}
