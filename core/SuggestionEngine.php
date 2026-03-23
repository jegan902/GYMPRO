<?php
/**
 * AI Rule-Based Suggestion Engine
 * Gợi ý thông minh dựa trên BMI, mục tiêu, lịch sử tập
 */
class SuggestionEngine
{
    /**
     * Generate suggestions based on member data
     */
    public static function generate($memberData)
    {
        $suggestions = [];
        $bmi = floatval($memberData['bmi'] ?? 0);
        $goal = $memberData['goal'] ?? 'maintain';
        $workoutsPerWeek = intval($memberData['workouts_per_week'] ?? 0);
        $bodyFat = floatval($memberData['body_fat'] ?? 0);

        // ── BMI-based suggestions ──
        if ($bmi > 0) {
            if ($bmi < 18.5) {
                $suggestions[] = [
                    'type' => 'warning',
                    'icon' => 'bi-exclamation-triangle',
                    'title' => 'Thiếu cân',
                    'message' => 'BMI của bạn dưới 18.5. Nên tăng lượng calo nạp vào và tập trung vào bài tập tăng cơ (compound movements).',
                    'actions' => ['Tăng 300-500 kcal/ngày so với TDEE', 'Tập Compound: Squat, Deadlift, Bench Press', 'Protein ≥ 1.6g/kg cân nặng', 'Tập 3-4 buổi/tuần, nghỉ 48h giữa các nhóm cơ'],
                ];
            } elseif ($bmi >= 25 && $bmi < 30) {
                $suggestions[] = [
                    'type' => 'info',
                    'icon' => 'bi-info-circle',
                    'title' => 'Thừa cân nhẹ',
                    'message' => 'BMI trong vùng thừa cân. Kết hợp cardio và strength training để giảm mỡ hiệu quả.',
                    'actions' => ['Giảm 300-500 kcal/ngày so với TDEE', 'Cardio 20-30 phút sau tập tạ', 'HIIT 2-3 lần/tuần', 'Giảm carbs, tăng protein và rau xanh'],
                ];
            } elseif ($bmi >= 30) {
                $suggestions[] = [
                    'type' => 'danger',
                    'icon' => 'bi-exclamation-circle',
                    'title' => 'Béo phì',
                    'message' => 'BMI ≥ 30 cần giảm cân cấp thiết. Ưu tiên cardio nhẹ và kiểm soát chế độ ăn.',
                    'actions' => ['Tham khảo ý kiến bác sĩ trước', 'Đi bộ nhanh/xe đạp 30-45 phút/ngày', 'Giảm 500-700 kcal/ngày', 'Tránh đồ chiên, nước ngọt, đồ ăn nhanh', 'Uống đủ 2-3 lít nước/ngày'],
                ];
            } else {
                $suggestions[] = [
                    'type' => 'success',
                    'icon' => 'bi-check-circle',
                    'title' => 'Cân nặng bình thường',
                    'message' => 'BMI trong vùng khỏe mạnh. Duy trì chế độ tập và ăn hiện tại.',
                    'actions' => ['Duy trì tập 3-5 buổi/tuần', 'Protein 1.2-1.5g/kg', 'Tăng volume bài tập dần dần'],
                ];
            }
        }

        // ── Goal-based suggestions ──
        switch ($goal) {
            case 'lose_fat':
                $suggestions[] = [
                    'type' => 'primary',
                    'icon' => 'bi-fire',
                    'title' => 'Kế hoạch giảm mỡ',
                    'message' => 'Để giảm mỡ hiệu quả, kết hợp thâm hụt calo với tập luyện.',
                    'actions' => ['Thâm hụt 400-600 kcal/ngày', 'Strength training 4x/tuần', 'Cardio LISS 3x/tuần (30-45 phút)', 'Protein ≥ 2g/kg để giữ cơ', 'Ngủ 7-8 tiếng/đêm'],
                ];
                break;
            case 'build_muscle':
                $suggestions[] = [
                    'type' => 'primary',
                    'icon' => 'bi-lightning',
                    'title' => 'Kế hoạch tăng cơ',
                    'message' => 'Tăng cơ cần thặng dư calo kết hợp progressive overload.',
                    'actions' => ['Thặng dư 300-500 kcal/ngày', 'Tập 4-5 buổi/tuần, split theo nhóm cơ', 'Progressive overload: tăng tạ/rep mỗi tuần', 'Protein 1.6-2.2g/kg', 'Creatine 5g/ngày (tùy chọn)'],
                ];
                break;
            case 'gain_weight':
                $suggestions[] = [
                    'type' => 'primary',
                    'icon' => 'bi-arrow-up-circle',
                    'title' => 'Kế hoạch tăng cân',
                    'message' => 'Tăng cân lành mạnh bằng cách ăn nhiều hơn và tập compound.',
                    'actions' => ['Thặng dư 500-700 kcal/ngày', 'Ăn 5-6 bữa/ngày', 'Ưu tiên: cơm, khoai, bơ, sữa, hạt', 'Tập compound với tạ nặng, reps 6-10', 'Hạn chế cardio, nghỉ ngơi đủ'],
                ];
                break;
        }

        // ── Workout frequency suggestions ──
        if ($workoutsPerWeek > 0 && $workoutsPerWeek < 3) {
            $suggestions[] = [
                'type' => 'warning',
                'icon' => 'bi-calendar-x',
                'title' => 'Tần suất tập thấp',
                'message' => "Bạn chỉ tập {$workoutsPerWeek} buổi/tuần gần đây. Nên tập ít nhất 3 buổi để đạt hiệu quả.",
                'actions' => ['Đặt lịch tập cố định', 'Chọn giáo án phù hợp thời gian', 'Tập Full Body nếu ít thời gian'],
            ];
        }

        return $suggestions;
    }

    /**
     * Get workout recommendation based on data
     */
    public static function getWorkoutRecommendation($bmi, $goal)
    {
        if ($bmi >= 30) {
            return ['style' => 'Cardio + Light Resistance', 'days' => 5, 'focus' => 'Đi bộ nhanh, xe đạp, bơi lội + tạ nhẹ'];
        } elseif ($bmi >= 25) {
            return ['style' => 'HIIT + Strength', 'days' => 4, 'focus' => 'HIIT 2x + Strength 2x/tuần'];
        } elseif ($bmi < 18.5) {
            return ['style' => 'Compound Heavy', 'days' => 3, 'focus' => 'Squat, Deadlift, Bench, OHP – tạ nặng, reps 5-8'];
        }

        switch ($goal) {
            case 'lose_fat': return ['style' => 'Push/Pull/Legs + Cardio', 'days' => 5, 'focus' => 'PPL split + LISS cardio'];
            case 'build_muscle': return ['style' => 'Bro Split', 'days' => 5, 'focus' => 'Ngực, Lưng, Vai, Tay, Chân'];
            case 'gain_weight': return ['style' => 'Upper/Lower', 'days' => 4, 'focus' => 'Upper/Lower split, compound movements'];
            default: return ['style' => 'Full Body', 'days' => 3, 'focus' => 'Full body 3x/tuần'];
        }
    }
}
