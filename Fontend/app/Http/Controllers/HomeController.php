<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class HomeController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    /**
     * Hiển thị trang chủ với dữ liệu lấy từ CMS (Branches, Managers/Staff, Packages)
     */
    public function index()
    {
        $articles = [
            [
                'id' => 1,
                'title' => 'Khai Trương Chi Nhánh GymPro Premium Quận 7',
                'summary' => 'GymPro chính thức khai trương chi nhánh mới tại Quận 7 với trang thiết bị Technogym chuẩn Olympic và ưu đãi 30% gói tập.',
                'image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=800',
                'category' => 'Sự kiện',
                'date' => '12/06/2026',
            ],
            [
                'id' => 2,
                'title' => 'Chế Độ Dinh Dưỡng Kết Hảo Cho Người Mới',
                'summary' => 'Làm thế nào để xây dựng chế độ ăn uống giảm mỡ tăng cơ chính xác nhất phù hợp với thể trạng cá nhân.',
                'image' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?q=80&w=800',
                'category' => 'Dinh dưỡng',
                'date' => '08/06/2026',
            ],
            [
                'id' => 3,
                'title' => '5 Bài Tập Compound Tốt Nhất Để Phát Triển Sức Mạnh Toàn Diện',
                'summary' => 'Hướng dẫn từ đội ngũ Huấn luyện viên cá nhân (PT) của GymPro về Squat, Bench Press, Deadlift và cách tránh chấn thương.',
                'image' => 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=800',
                'category' => 'Tập luyện',
                'date' => '03/06/2026',
            ]
        ];

        try {
            // Lấy danh sách chi nhánh
            $branchRes = $this->api->get('/v1/Branches');
            $branches = $branchRes->successful() ? $branchRes->json() : [];
            \Log::info('Home Branches Raw: ' . json_encode($branches));

            // Lấy danh sách nhân sự
            $managerRes = $this->api->get('/v1/Managers');
            $staff = $managerRes->successful() ? $managerRes->json() : [];
            \Log::info('Home Staff Raw: ' . json_encode($staff));

            // Lấy danh sách các gói tập công khai
            $packageRes = $this->api->get('/Packages', ['activeOnly' => 'true']);
            $packages = $packageRes->successful() ? $packageRes->json() : [];
            \Log::info('Home Packages Raw: ' . json_encode($packages));

            return view('home', compact('branches', 'staff', 'packages', 'articles'));
        } catch (\Exception $e) {
            \Log::error('Home Page Data Fetch Error: ' . $e->getMessage());
            return view('home', [
                'branches' => [],
                'staff' => [],
                'packages' => [],
                'articles' => $articles
            ]);
        }
    }

    /**
     * Hiển thị trang giới thiệu chi tiết (About Us Page)
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Hiển thị trang tin tức & sự kiện (News & Events Page)
     */
    public function news()
    {
        $articles = [
            [
                'id' => 1,
                'title' => 'Khai Trương Chi Nhánh GymPro Premium Quận 7',
                'summary' => 'GymPro chính thức khai trương chi nhánh mới tại Quận 7 với trang thiết bị Technogym chuẩn Olympic và ưu đãi 30% gói tập.',
                'image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=800',
                'category' => 'Sự kiện',
                'date' => '12/06/2026',
            ],
            [
                'id' => 2,
                'title' => 'Chế Độ Dinh Dưỡng Kết Hợp BMI/BMR Hoàn Hảo Cho Người Mới',
                'summary' => 'Làm thế nào để sử dụng chỉ số BMR từ AI Health Tool của GymPro để lên thực đơn ăn uống giảm mỡ tăng cơ chính xác nhất.',
                'image' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?q=80&w=800',
                'category' => 'Dinh dưỡng',
                'date' => '08/06/2026',
            ],
            [
                'id' => 3,
                'title' => '5 Bài Tập Compound Tốt Nhất Để Phát Triển Sức Mạnh Toàn Diện',
                'summary' => 'Hướng dẫn từ đội ngũ Huấn luyện viên cá nhân (PT) của GymPro về Squat, Bench Press, Deadlift và cách tránh chấn thương.',
                'image' => 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=800',
                'category' => 'Tập luyện',
                'date' => '03/06/2026',
            ],
            [
                'id' => 4,
                'title' => 'GymPro Powerlifting Championship 2026 Chính Thức Khởi Tranh',
                'summary' => 'Giải đấu sức mạnh lớn nhất năm của hệ thống GymPro quy tụ hơn 200 vận động viên tranh tài tại cơ sở Quận 1.',
                'image' => 'https://images.unsplash.com/photo-1517963879433-6ad2b056d712?q=80&w=800',
                'category' => 'Sự kiện',
                'date' => '28/05/2026',
            ]
        ];
        return view('news', compact('articles'));
    }

    /**
     * Hiển thị trang liên hệ (Contact Page)
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Thay đổi ngôn ngữ hiển thị (vi / en)
     */
    public function changeLanguage($locale)
    {
        if (in_array($locale, ['vi', 'en'])) {
            session()->put('locale', $locale);
        }
        return redirect()->back();
    }
}
