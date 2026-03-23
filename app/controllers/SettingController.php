<?php
/**
 * SettingController
 */
class SettingController extends Controller
{
    private $settingModel;

    public function __construct()
    {
        Middleware::requireAuth();
        Middleware::requireRole('admin');
        $this->settingModel = $this->model('SettingModel');
    }

    public function index()
    {
        $settings = $this->settingModel->getAll();
        $grouped = [];
        foreach ($settings as $s) {
            $grouped[$s->setting_key] = $s;
        }

        $this->view('settings/index', [
            'title'    => 'Cấu hình hệ thống',
            'settings' => $grouped,
        ]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('setting');
        $this->validateCSRF();

        $keys = ['gym_name', 'address', 'hotline', 'default_activity_level', 'calorie_formula_type',
                 'macro_ratio_bulk', 'macro_ratio_cut', 'max_checkin_per_day', 'peak_hour_range'];

        foreach ($keys as $key) {
            if (isset($_POST[$key])) {
                $this->settingModel->set($key, $this->sanitize($_POST[$key]));
            }
        }

        Session::flash('success', 'Lưu cấu hình thành công!', 'success');
        $this->redirect('setting');
    }
}
