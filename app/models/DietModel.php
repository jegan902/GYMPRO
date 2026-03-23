<?php
/**
 * DietModel
 */
class DietModel extends Model
{
    protected $table = 'diet_plans';

    public function getAllWithMeals()
    {
        $plans = $this->findAll();
        foreach ($plans as $plan) {
            $this->db->query("SELECT * FROM meals WHERE diet_plan_id = :pid ORDER BY sort_order");
            $this->db->bind(':pid', $plan->id);
            $plan->meals = $this->db->resultSet();
        }
        return $plans;
    }

    public function getWithMeals($planId)
    {
        $plan = $this->findById($planId);
        if (!$plan) return null;

        $this->db->query("SELECT * FROM meals WHERE diet_plan_id = :pid ORDER BY sort_order");
        $this->db->bind(':pid', $planId);
        $plan->meals = $this->db->resultSet();

        return $plan;
    }

    public function getActivePlans()
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY name");
        return $this->db->resultSet();
    }

    public function addMeal($data)
    {
        $this->db->query("INSERT INTO meals (diet_plan_id, meal_name, food_items, calories, protein, carbs, fat, sort_order) VALUES (:pid, :name, :food, :cal, :pro, :carbs, :fat, :ord)");
        $this->db->bind(':pid', $data['diet_plan_id']);
        $this->db->bind(':name', $data['meal_name']);
        $this->db->bind(':food', $data['food_items']);
        $this->db->bind(':cal', $data['calories']);
        $this->db->bind(':pro', $data['protein']);
        $this->db->bind(':carbs', $data['carbs']);
        $this->db->bind(':fat', $data['fat']);
        $this->db->bind(':ord', $data['sort_order']);
        return $this->db->execute();
    }

    public function deleteMeals($planId)
    {
        $this->db->query("DELETE FROM meals WHERE diet_plan_id = :pid");
        $this->db->bind(':pid', $planId);
        return $this->db->execute();
    }

    public function assignToMember($memberId, $planId)
    {
        $this->db->query("INSERT INTO member_diet_plans (member_id, diet_plan_id, assigned_date, status) VALUES (:mid, :pid, CURDATE(), 'active')");
        $this->db->bind(':mid', $memberId);
        $this->db->bind(':pid', $planId);
        return $this->db->execute();
    }
}
