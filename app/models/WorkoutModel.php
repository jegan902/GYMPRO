<?php
/**
 * WorkoutModel
 */
class WorkoutModel extends Model
{
    protected $table = 'workout_plans';

    public function getAllPlans()
    {
        $this->db->query("SELECT wp.* FROM {$this->table} wp ORDER BY wp.created_at DESC");
        return $this->db->resultSet();
    }

    public function getWithSessions($planId)
    {
        $plan = $this->findById($planId);
        if (!$plan) return null;

        // Get sessions for this plan
        $this->db->query("SELECT * FROM workout_sessions WHERE workout_plan_id = :pid ORDER BY day_number");
        $this->db->bind(':pid', $planId);
        $plan->sessions = $this->db->resultSet();

        // Get exercises for each session
        foreach ($plan->sessions as $session) {
            $this->db->query("SELECT wse.*, e.name as exercise_name, e.description as exercise_desc,
                              mg.name_vi as muscle_group
                              FROM workout_session_exercises wse
                              JOIN exercises e ON wse.exercise_id = e.id
                              LEFT JOIN muscle_groups mg ON e.muscle_group_id = mg.id
                              WHERE wse.workout_session_id = :sid
                              ORDER BY wse.sort_order");
            $this->db->bind(':sid', $session->id);
            $session->exercises = $this->db->resultSet();
        }

        return $plan;
    }

    public function createSession($data)
    {
        $this->db->query("INSERT INTO workout_sessions (workout_plan_id, day_number, session_name, focus_area) VALUES (:pid, :day, :name, :focus)");
        $this->db->bind(':pid', $data['workout_plan_id']);
        $this->db->bind(':day', $data['day_number']);
        $this->db->bind(':name', $data['session_name']);
        $this->db->bind(':focus', $data['focus_area'] ?? '');
        $this->db->execute();
        return $this->db->lastInsertId();
    }

    public function addExerciseToSession($data)
    {
        $this->db->query("INSERT INTO workout_session_exercises (workout_session_id, exercise_id, sets, reps, rest_seconds, sort_order) VALUES (:sid, :eid, :sets, :reps, :rest, :ord)");
        $this->db->bind(':sid', $data['workout_session_id']);
        $this->db->bind(':eid', $data['exercise_id']);
        $this->db->bind(':sets', $data['sets']);
        $this->db->bind(':reps', $data['reps']);
        $this->db->bind(':rest', $data['rest_seconds']);
        $this->db->bind(':ord', $data['sort_order']);
        return $this->db->execute();
    }

    public function getMemberPlans($memberId)
    {
        $this->db->query("SELECT mwp.*, wp.name as plan_name, wp.level, wp.goal
                          FROM member_workout_plans mwp
                          JOIN workout_plans wp ON mwp.workout_plan_id = wp.id
                          WHERE mwp.member_id = :mid
                          ORDER BY mwp.assigned_date DESC");
        $this->db->bind(':mid', $memberId);
        return $this->db->resultSet();
    }

    public function assignToMember($memberId, $planId)
    {
        $this->db->query("INSERT INTO member_workout_plans (member_id, workout_plan_id, assigned_date, status) VALUES (:mid, :pid, CURDATE(), 'active')");
        $this->db->bind(':mid', $memberId);
        $this->db->bind(':pid', $planId);
        return $this->db->execute();
    }
}
