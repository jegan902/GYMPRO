-- ── News Articles ──
CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    category VARCHAR(100) NOT NULL,
    author VARCHAR(100) NOT NULL,
    image VARCHAR(255) NOT NULL,
    summary TEXT NOT NULL,
    content LONGTEXT NOT NULL,
    is_trending TINYINT(1) DEFAULT 0,
    is_featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Seed Data (from current mock)
INSERT INTO news (title, slug, category, author, image, summary, content, is_trending, is_featured) VALUES
('Thực đơn Eat Clean 7 ngày cho người mới bắt đầu', 'eat-clean-7-ngay', 'Dinh dưỡng', 'Admin GymPro', 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?q=80&w=1453&auto=format&fit=crop', 'Khám phá lộ trình ăn uống lành mạnh giúp thanh lọc cơ thể và hỗ trợ giảm cân hiệu quả chỉ trong một tuần.', 'Nội dung chi tiết về thực đơn Eat Clean...', 1, 1),
('Cách hít thở chuẩn khi đẩy ngực Bench Press', 'hit-tho-bench-press', 'Tập luyện', 'HLV Nam Trần', 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=1470&auto=format&fit=crop', 'Hít thở sai cách không chỉ làm giảm hiệu suất mà còn tiềm ẩn nguy cơ chấn thương nghiêm trọng khi tập tạ nặng.', 'Hướng dẫn chi tiết cách hít thở...', 1, 0),
('Tầm quan trọng của giấc ngủ trong việc tạo cơ', 'giac-ngu-va-co-bap', 'Phong cách sống', 'Admin GymPro', 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?q=80&w=1470&auto=format&fit=crop', 'Cơ bắp không phát triển trong lúc bạn tập, chúng phát triển khi bạn ngủ. Hãy tìm hiểu lý do tại sao.', 'Phân tích về giấc ngủ...', 1, 0),
('Top 5 bài tập Cardio đốt mỡ hiệu quả nhất 2024', 'cardio-dot-mo-2024', 'Tập luyện', 'HLV Linh Nguyễn', 'https://images.unsplash.com/photo-1538805060514-97d9cc17730c?q=80&w=1374&auto=format&fit=crop', 'Bạn không có nhiều thời gian? 20 phút với các bài tập này sẽ giúp bạn đốt cháy calo cả ngày dài.', 'Danh sách 5 bài tập cardio...', 1, 0),
('Bí quyết giữ vững động lực tập luyện mùa đông', 'dong-luc-tap-mua-dong', 'Phong cách sống', 'HLV Bảo Hoàng', 'https://images.unsplash.com/photo-1526506118085-60ce8714f8c5?q=80&w=1374&auto=format&fit=crop', 'Trời lạnh dễ khiến chúng ta lười biếng. Đây là cách các vận động viên chuyên nghiệp vượt qua sự trì trệ.', 'Các mẹo giữ động lực...', 0, 0),
('Hành trình giảm 20kg của hội viên Minh Tâm', 'hanh-trinh-minh-tam', 'Kỳ tích GYMPRO', 'Admin GymPro', 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=1470&auto=format&fit=crop', 'Câu chuyện đầy cảm hứng về sự nỗ lực không ngừng nghỉ và những thay đổi kinh ngạc sau 6 tháng.', 'Phỏng vấn chi tiết Minh Tâm...', 0, 0);
