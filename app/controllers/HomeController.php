<?php
/**
 * HomeController
 * Public landing page
 */
class HomeController extends Controller
{
    public function index()
    {
        // Mock data for trainers (Sync with TrainerController)
        $trainers = [
            1 => [
                'name' => 'Trần Anh Tuấn',
                'role' => 'Chuyên gia Lên Cơ vóc',
                'image' => 'https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?q=80&w=1470&auto=format&fit=crop',
                'quote' => '"Sự khác biệt giữa mục tiêu và giấc mơ chính là thời hạn hoàn thành."'
            ],
            2 => [
                'name' => 'Nguyễn Thị Linh',
                'role' => 'HLV Yoga & Định hình form dáng',
                'image' => 'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?q=80&w=1470&auto=format&fit=crop',
                'quote' => '"Sự kiên nhẫn trong luyện tập là chìa khóa tháo gỡ mọi giới hạn."'
            ],
            3 => [
                'name' => 'Hoàng Gia Bảo',
                'role' => 'Chuyên gia Phục hồi',
                'image' => 'https://images.unsplash.com/photo-1548690312-e3b507d8c110?q=80&w=1470&auto=format&fit=crop',
                'quote' => '"Tốc độ sẽ vô nghĩa nếu bạn hướng sai đích đi."'
            ]
        ];

        // Mock data for news (Sync with NewsController)
        $news = [
            1 => [
                'title' => 'Thực đơn Eat Clean 7 ngày cho người mới bắt đầu',
                'category' => 'Dinh Dưỡng',
                'image' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?q=80&w=1453&auto=format&fit=crop'
            ],
            2 => [
                'title' => 'Cách hít thở chuẩn khi đẩy ngực Bench Press',
                'category' => 'Tập Luyện',
                'image' => 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=1470&auto=format&fit=crop'
            ],
            3 => [
                'title' => 'Tầm quan trọng của giấc ngủ trong việc tạo cơ',
                'category' => 'Phong cách sống',
                'image' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?q=80&w=1470&auto=format&fit=crop'
            ]
        ];

        // Mock data for testimonials
        $testimonials = [
            [
                'name' => 'Nguyễn Anh Duy',
                'role' => 'Thành viên Platinum',
                'content' => 'Hệ thống trợ lý AI thực sự đã thay đổi cách tôi tập luyện. Việc theo dõi dinh dưỡng chưa bao giờ dễ dàng và chuyên nghiệp đến thế.',
                'avatar' => 'https://i.pravatar.cc/150?u=duy'
            ],
            [
                'name' => 'Lê Minh Tâm',
                'role' => 'Thành viên Gold',
                'content' => 'Không gian tập luyện tuyệt vời, sạch sẽ và hiện đại. Đội ngũ HLV ở đây cực kỳ tận tâm và chuyên môn cao.',
                'avatar' => 'https://i.pravatar.cc/150?u=tam'
            ],
            [
                'name' => 'Phạm Hoàng My',
                'role' => 'Thành viên mới',
                'content' => 'Tôi đã giảm được 5kg sau 2 tháng nhờ giáo án tập luyện cá nhân hóa của GymPro. Cảm ơn đội ngũ rất nhiều!',
                'avatar' => 'https://i.pravatar.cc/150?u=my'
            ]
        ];

        // Mock data for FAQs
        $faqs = [
            [
                'question' => 'Tôi có được tập thử trước khi đăng ký không?',
                'answer' => 'Tất nhiên! GymPro tặng bạn 01 buổi tập trải nghiệm miễn phí với đầy đủ tiện ích và sự hướng dẫn của HLV.'
            ],
            [
                'question' => 'Gói tập đã bao gồm phí thuê tủ đồ chưa?',
                'answer' => 'Có, tất cả các gói tập tại GymPro đều đã bao gồm phí sử dụng tủ đồ cá nhân trong ngày và phòng xông hơi.'
            ],
            [
                'question' => 'Tôi có thể bảo lưu gói tập khi đi công tác không?',
                'answer' => 'Được nhé. Tùy theo loại gói tập bạn đăng ký, GymPro hỗ trợ bảo lưu từ 15 đến 60 ngày mỗi năm.'
            ]
        ];

        $this->view('home/index', [
            'title'     => 'Chào mừng đến với ' . APP_NAME,
            'no_layout' => true,
            'is_home'   => true,
            'trainers'  => $trainers,
            'news'      => $news,
            'testimonials' => $testimonials,
            'faqs'      => $faqs
        ]);
    }
}
