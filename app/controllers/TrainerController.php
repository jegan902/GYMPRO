<?php
class TrainerController {
    public function index() {
        require_once APP_ROOT . '/app/views/home/index.php'; // For now, redirect to home
    }

    public function detail($id) {
        $trainers_db = [
            1 => [
                'name' => 'Trần Anh Tuấn',
                'role' => 'Chuyên gia Lên Cơ vóc',
                'title' => 'Personal Trainer Cấp Cao',
                'image' => 'https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?q=80&w=1470&auto=format&fit=crop',
                'experience' => '8 năm',
                'certifications' => ['NASM-CPT', 'CrossFit Level 2', 'NCEP Dinh dưỡng Thể thao'],
                'specialties' => ['Tăng Cơ - Giảm Mỡ', 'Huấn luyện Sức mạnh cường độ cao (Powerlifting)', 'Thiết kế chế độ ăn kiêng cá nhân hóa'],
                'philosophy' => 'Không có đường tắt, chỉ có kỷ luật và mồ hôi. Tôi tin rằng mỗi người đều sở hữu một phiên bản mạnh mẽ hơn đang chờ được đánh thức. Nhiệm vụ của tôi là cung cấp cho bạn tấm bản đồ chính xác, động lực đi kèm sự nghiêm khắc để bạn khai phá tiềm năng đó. Hãy để mồ hôi trên sàn tập thành kết quả nhìn thấy được trên cơ thể.',
                'quote' => '"Sự khác biệt giữa mục tiêu và giấc mơ chính là thời hạn hoàn thành."'
            ],
            2 => [
                'name' => 'Nguyễn Thị Linh',
                'role' => 'HLV Yoga & Định hình form dáng',
                'title' => 'Master Trainer / Yoga Instructor',
                'image' => 'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?q=80&w=1470&auto=format&fit=crop',
                'experience' => '6 năm',
                'certifications' => ['Yoga Alliance RYT 500', 'Pilates Mat Instructor', 'Bằng Cử nhân Giáo dục Thể chất'],
                'specialties' => ['Yoga (Vinyasa & Hatha)', 'Khắc phục gù lưng, võng lưng an toàn', 'Giảm mỡ toàn thân và linh hoạt cơ khớp'],
                'philosophy' => 'Một tinh thần minh mẫn chỉ tồn tại trong một cơ thể khỏe mạnh. Đối với tôi, việc tập luyện không chỉ nhằm mục đích sở hữu vòng eo thon gọn hay cơ mông săn chắc, mà quan trọng hơn là học cách cảm nhận, lắng nghe và yêu thương cơ thể mình từ bên trong. Mỗi động tác phải có sự liên kết chặt chẽ với nhịp thở.',
                'quote' => '"Sự kiên nhẫn trong luyện tập là chìa khóa tháo gỡ mọi giới hạn của thể chất."'
            ],
            3 => [
                'name' => 'Hoàng Gia Bảo',
                'role' => 'Chuyên gia Phục hồi & Y học thể thao',
                'title' => 'Chuyên Viên Phục Hồi Chấn Thương',
                'image' => 'https://images.unsplash.com/photo-1548690312-e3b507d8c110?q=80&w=1470&auto=format&fit=crop',
                'experience' => '10 năm',
                'certifications' => ['ISSA Biomechanics', 'Chứng chỉ Vật lý trị liệu Thể thao Quốc gia', 'ACSM Exercise is Medicine'],
                'specialties' => ['Phục hồi sau chấn thương thể thao', 'Tăng cường giới hạn vận động an toàn cho người trung niên', 'Điều chỉnh tư thế cột sống (Postural Rectification)'],
                'philosophy' => 'Tập luyện an toàn và di chuyển thông minh chính là điểm cốt lõi để duy trì cơ thể khỏe mạnh trong suốt cuộc đời. Chúng ta không cố nâng mức tạ bằng cách phá hỏng cột sống hay các khớp nối. Cần phải thiết lập một hệ cơ lõi (Core) vững chắc và giải quyết triệt để các tổn thương tìm ẩn trước khi nghĩ đến những bài tập với khối lượng tạ nặng nề.',
                'quote' => '"Tốc độ sẽ vô nghĩa nếu bạn hướng sai đích đi."'
            ]
        ];

        // Fallback safety
        $trainer = isset($trainers_db[$id]) ? $trainers_db[$id] : $trainers_db[1];

        require_once APP_ROOT . '/app/views/trainers/detail.php';
    }
}
