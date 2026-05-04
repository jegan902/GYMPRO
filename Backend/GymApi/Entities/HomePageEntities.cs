using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace GymApi.Entities
{
    [Table("home_page_hero")]
    public class HomePageHero
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [MaxLength(200)]
        [Column("title")]
        public string Title { get; set; } = "Khai Phá Tiềm Năng Của Bạn";

        [Column("subtitle")]
        public string? Subtitle { get; set; } = "GymPro kết hợp trí tuệ nhân tạo và quản lý vận hành tối ưu.";

        [MaxLength(50)]
        [Column("button_text")]
        public string ButtonText { get; set; } = "Bắt đầu ngay";

        [Column("image_url")]
        public string? ImageUrl { get; set; }

        [MaxLength(20)]
        [Column("background_color")]
        public string BackgroundColor { get; set; } = "#FF5E00";

        [Column("updated_at")]
        public DateTime UpdatedAt { get; set; } = DateTime.Now;
    }

    [Table("home_features")]
    public class HomeFeature
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [MaxLength(50)]
        [Column("icon")]
        public string Icon { get; set; } = "bi-lightning";

        [Required]
        [MaxLength(100)]
        [Column("title")]
        public string Title { get; set; } = string.Empty;

        [Column("description")]
        public string? Description { get; set; }

        [Column("display_order")]
        public int DisplayOrder { get; set; } = 0;

        [Column("created_at")]
        public DateTime CreatedAt { get; set; } = DateTime.Now;
    }
}
