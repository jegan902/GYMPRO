<?php
class AboutController extends Controller {
    public function index() {
        // Dummy data for trainers in the About page
        $trainers = [
            1 => [
                'name' => 'Trần Anh Tuấn',
                'role' => 'Chuyên gia Lên Cơ vóc',
                'quote' => '"Không có đường tắt, chỉ có kỷ luật và mồ hôi. Tôi sẽ giúp bạn biến mồ hôi thành kết quả nhìn thấy được."',
                'image' => 'https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?q=80&w=1470&auto=format&fit=crop'
            ],
            2 => [
                'name' => 'Nguyễn Thị Linh',
                'role' => 'HLV Yoga & Giảm Mỡ',
                'quote' => '"Một tinh thần minh mẫn trong một cơ thể khỏe mạnh. Cùng tôi xây dựng vóc dáng mơ ước của bạn."',
                'image' => 'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?q=80&w=1470&auto=format&fit=crop'
            ],
            3 => [
                'name' => 'Hoàng Gia Bảo',
                'role' => 'Chuyên gia Phục hồi',
                'quote' => '"Tập luyện an toàn và thông minh mới là mấu chốt để duy trì cơ thể khỏe mạnh dài lâu."',
                'image' => 'https://images.unsplash.com/photo-1548690312-e3b507d8c110?q=80&w=1470&auto=format&fit=crop'
            ]
        ];

        $this->view('about/index', [
            'title' => 'Giới thiệu về GYMPRO',
            'trainers' => $trainers,
            'no_layout' => true
        ]);
    }
}
