<?php
class NewsController extends Controller {
    private $newsModel;

    public function __construct() {
        $this->newsModel = $this->model("NewsModel");
    }

    public function index() {
        $news_list = $this->newsModel->getAll();
        $trending = $this->newsModel->getTrending(4);
        
        $this->view("news/index", [
            "title" => "Trung tâm Tin tức GYMPRO",
            "news_list" => $news_list,
            "trending_news" => $trending,
            "category_counts" => $this->newsModel->getCategoryCounts(),
            "no_layout" => true
        ]);
    }

    public function category($slug) {
        $categories = $this->getCategoryMapping();
        $category_name = array_search($slug, $categories);
        
        if (!$category_name) {
            $category_name = str_replace("-", " ", ucfirst($slug));
        }

        $news_list = $this->newsModel->getByCategory($category_name);
        $recent_news = $this->newsModel->getAll(5);

        $this->view("news/category", [
            "title" => "Chuyên mục: " . $category_name,
            "category" => $category_name,
            "current_slug" => $slug,
            "news_list" => $news_list,
            "recent_news" => $recent_news,
            "category_counts" => $this->newsModel->getCategoryCounts(),
            "no_layout" => true
        ]);
    }

    private function getCategoryMapping() {
        return [
            "Dinh dưỡng" => "dinh-duong",
            "Tập luyện" => "tap-luyen",
            "Kỳ tích GYMPRO" => "success-stories",
            "Lối sống lành mạnh" => "phong-cach-song"
        ];
    }

    public function search() {
        $query = isset($_GET["q"]) ? trim($_GET["q"]) : "";
        $results = $this->newsModel->search($query);
        $recent_posts = $this->newsModel->getAll(4);

        $this->view("news/search", [
            "title" => "Kết quả tìm kiếm: " . $query,
            "query" => $query,
            "results" => $results,
            "recent_posts" => $recent_posts,
            "category_counts" => $this->newsModel->getCategoryCounts(),
            "no_layout" => true
        ]);
    }

    public function trending() {
        $news_list = $this->newsModel->getTrending(10);
        $this->view("news/index", [
            "title" => "Tin tức Xu hướng",
            "news_list" => $news_list,
            "is_trending" => true,
            "no_layout" => true
        ]);
    }

    public function detail($id) {
        $article = $this->newsModel->getBySlug($id);
        if (!$article) {
            $article = $this->newsModel->getById($id);
        }

        if (!$article) {
            $this->redirect("news");
            return;
        }
        
        $recent_news = $this->newsModel->getAll(5);

        $this->view("news/detail", [
            "title" => $article->title,
            "article" => $article,
            "recent_news" => $recent_news,
            "related_news" => array_slice($recent_news, 0, 3),
            "category_counts" => $this->newsModel->getCategoryCounts(),
            "no_layout" => true
        ]);
    }

    public function admin_index() {
        Middleware::requireRole(["admin", "staff"]);
        $news = $this->newsModel->getAll();
        $this->view("news/admin_index", [
            "title" => "Quản lý Tin tức",
            "news" => $news
        ]);
    }

    public function create() {
        Middleware::requireRole(["admin", "staff"]);
        $this->view("news/admin_create", [
            "title" => "Thêm bài viết mới"
        ]);
    }

    public function store() {
        Middleware::requireRole(["admin", "staff"]);
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = [
                "title" => $this->sanitize($_POST["title"]),
                "slug" => $this->sanitize($_POST["slug"]),
                "category" => $_POST["category"],
                "author" => Session::get("user_name"),
                "image" => $this->sanitize($_POST["image"]),
                "summary" => $this->sanitize($_POST["summary"]),
                "content" => $_POST["content"], 
                "is_trending" => isset($_POST["is_trending"]) ? 1 : 0,
                "is_featured" => isset($_POST["is_featured"]) ? 1 : 0
            ];

            if ($this->newsModel->create($data)) {
                Session::flash("news_msg", "Đã thêm bài viết thành công!", "success");
                $this->redirect("news/admin_index");
            }
        }
    }

    public function edit($id) {
        Middleware::requireRole(["admin", "staff"]);
        $article = $this->newsModel->getById($id);

        $this->view("news/admin_edit", [
            "title" => "Chỉnh sửa bài viết",
            "article" => $article
        ]);
    }

    public function update($id) {
        Middleware::requireRole(["admin", "staff"]);
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = [
                "title" => $this->sanitize($_POST["title"]),
                "slug" => $this->sanitize($_POST["slug"]),
                "category" => $_POST["category"],
                "author" => $this->sanitize($_POST["author"]),
                "image" => $this->sanitize($_POST["image"]),
                "summary" => $this->sanitize($_POST["summary"]),
                "content" => $_POST["content"],
                "is_trending" => isset($_POST["is_trending"]) ? 1 : 0,
                "is_featured" => isset($_POST["is_featured"]) ? 1 : 0
            ];

            if ($this->newsModel->update($id, $data)) {
                Session::flash("news_msg", "Cập nhật bài viết thành công!", "success");
                $this->redirect("news/admin_index");
            }
        }
    }

    public function delete($id) {
        Middleware::requireRole(["admin", "staff"]);
        if ($this->newsModel->delete($id)) {
            Session::flash("news_msg", "Đã xóa bài viết.", "info");
        }
        $this->redirect("news/admin_index");
    }
}
