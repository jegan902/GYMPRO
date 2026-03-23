<?php
/**
 * FitnessController
 * BMI / BMR / TDEE Calculator
 */
class FitnessController extends Controller
{
    public function __construct()
    {
        Middleware::requireAuth();
    }

    /**
     * GET /fitness - BMI/BMR/TDEE Calculator page
     */
    public function index()
    {
        $this->view('fitness/calculator', [
            'title' => 'BMI / BMR / TDEE',
        ]);
    }

    /**
     * POST /fitness/calculate - Calculate and optionally save
     */
    public function calculate()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('fitness');
        $this->validateCSRF();

        $gender   = $_POST['gender'] ?? 'male';
        $age      = intval($_POST['age'] ?? 0);
        $height   = floatval($_POST['height'] ?? 0);
        $weight   = floatval($_POST['weight'] ?? 0);
        $activity = floatval($_POST['activity'] ?? 1.2);
        $goal     = $_POST['goal'] ?? 'maintain';

        if ($height <= 0 || $weight <= 0 || $age <= 0) {
            Session::flash('error', 'Vui lòng nhập đầy đủ thông tin.', 'danger');
            $this->redirect('fitness');
        }

        // BMI
        $h = $height / 100;
        $bmi = round($weight / ($h * $h), 1);

        // BMR (Mifflin-St Jeor)
        if ($gender === 'male') {
            $bmr = round(10 * $weight + 6.25 * $height - 5 * $age + 5);
        } else {
            $bmr = round(10 * $weight + 6.25 * $height - 5 * $age - 161);
        }

        // TDEE
        $tdee = round($bmr * $activity);

        // Goal-based calories
        switch ($goal) {
            case 'lose':    $targetCal = round($tdee * 0.8); break;
            case 'gain':    $targetCal = round($tdee * 1.15); break;
            default:        $targetCal = $tdee;
        }

        // Macros (P/C/F ratio based on goal)
        switch ($goal) {
            case 'lose':
                $protein = round(($targetCal * 0.35) / 4);
                $carbs   = round(($targetCal * 0.40) / 4);
                $fat     = round(($targetCal * 0.25) / 9);
                break;
            case 'gain':
                $protein = round(($targetCal * 0.30) / 4);
                $carbs   = round(($targetCal * 0.50) / 4);
                $fat     = round(($targetCal * 0.20) / 9);
                break;
            default:
                $protein = round(($targetCal * 0.30) / 4);
                $carbs   = round(($targetCal * 0.45) / 4);
                $fat     = round(($targetCal * 0.25) / 9);
        }

        // Save to body_metrics if member
        if (Session::userRole() === 'member') {
            $memberModel = $this->model('MemberModel');
            $member = $memberModel->getByUserId(Session::userId());
            if ($member) {
                $db = Database::getInstance();
                $db->query("INSERT INTO body_metrics (member_id, weight, bmi, measured_date) VALUES (:mid, :w, :bmi, CURDATE())
                            ON DUPLICATE KEY UPDATE weight=:w2, bmi=:bmi2");
                $db->bind(':mid', $member->id);
                $db->bind(':w', $weight);
                $db->bind(':bmi', $bmi);
                $db->bind(':w2', $weight);
                $db->bind(':bmi2', $bmi);
                $db->execute();

                // Update member record
                $memberModel->update($member->id, ['height' => $height, 'weight' => $weight, 'bmi' => $bmi]);
            }
        }

        $this->view('fitness/result', [
            'title'     => 'Kết quả BMI / BMR / TDEE',
            'bmi'       => $bmi,
            'bmr'       => $bmr,
            'tdee'      => $tdee,
            'targetCal' => $targetCal,
            'protein'   => $protein,
            'carbs'     => $carbs,
            'fat'       => $fat,
            'gender'    => $gender,
            'age'       => $age,
            'height'    => $height,
            'weight'    => $weight,
            'activity'  => $activity,
            'goal'      => $goal,
        ]);
    }
}
