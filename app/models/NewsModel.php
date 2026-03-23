<?php
/**
 * NewsModel
 * Handles all database operations for news articles
 */
class NewsModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Get all news articles
     */
    public function getAll($limit = null) {
        $sql = "SELECT * FROM news ORDER BY created_at DESC";
        if ($limit) {
            $sql .= " LIMIT :limit";
        }
        $this->db->query($sql);
        if ($limit) {
            $this->db->bind(':limit', $limit);
        }
        return $this->db->resultSet();
    }

    /**
     * Get news by slug
     */
    public function getBySlug($slug) {
        $this->db->query("SELECT * FROM news WHERE slug = :slug");
        $this->db->bind(':slug', $slug);
        return $this->db->single();
    }

    /**
     * Get news by ID
     */
    public function getById($id) {
        $this->db->query("SELECT * FROM news WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Get news by category
     */
    public function getByCategory($category_name) {
        $this->db->query("SELECT * FROM news WHERE category = :category ORDER BY created_at DESC");
        $this->db->bind(':category', $category_name);
        return $this->db->resultSet();
    }

    /**
     * Search news
     */
    public function search($query) {
        $this->db->query("SELECT * FROM news WHERE title LIKE :q1 OR summary LIKE :q2 OR content LIKE :q3 ORDER BY created_at DESC");
        $q = "%$query%";
        $this->db->bind(':q1', $q);
        $this->db->bind(':q2', $q);
        $this->db->bind(':q3', $q);
        return $this->db->resultSet();
    }

    /**
     * Get trending news
     */
    public function getTrending($limit = 4) {
        $this->db->query("SELECT * FROM news WHERE is_trending = 1 ORDER BY created_at DESC LIMIT :limit");
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    /**
     * Get featured news
     */
    public function getFeatured() {
        $this->db->query("SELECT * FROM news WHERE is_featured = 1 LIMIT 1");
        return $this->db->single();
    }

    /**
     * Create new article
     */
    public function create($data) {
        $this->db->query("INSERT INTO news (title, slug, category, author, image, summary, content, is_trending, is_featured) 
                          VALUES (:title, :slug, :category, :author, :image, :summary, :content, :is_trending, :is_featured)");
        
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':slug', $data['slug']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':author', $data['author']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':summary', $data['summary']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':is_trending', $data['is_trending'] ?? 0);
        $this->db->bind(':is_featured', $data['is_featured'] ?? 0);

        return $this->db->execute();
    }

    /**
     * Update article
     */
    public function update($id, $data) {
        $this->db->query("UPDATE news SET title = :title, slug = :slug, category = :category, author = :author, 
                          image = :image, summary = :summary, content = :content, is_trending = :is_trending, 
                          is_featured = :is_featured WHERE id = :id");
        
        $this->db->bind(':id', $id);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':slug', $data['slug']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':author', $data['author']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':summary', $data['summary']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':is_trending', $data['is_trending'] ?? 0);
        $this->db->bind(':is_featured', $data['is_featured'] ?? 0);

        return $this->db->execute();
    }

    /**
     * Delete article
     */
    public function delete($id) {
        $this->db->query("DELETE FROM news WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    /**
     * Helper to expose DB query (use with caution)
     */
    public function query($sql) {
        $this->db->query($sql);
    }

    /**
     * Helper to expose DB bind
     */
    public function bind($param, $value, $type = null) {
        $this->db->bind($param, $value, $type);
    }

    /**
     * Helper to expose DB single
     */
    public function single() {
        return $this->db->single();
    }

    /**
     * Get count of articles per category
     */
    public function getCategoryCounts() {
        $this->db->query("SELECT category, COUNT(*) as count FROM news GROUP BY category");
        return $this->db->resultSet();
    }
}
