<?php

namespace App\Models;

use App\Core\Database;

class BlogModel
{
    /**
     * @var \PDO Veritabanı bağlantısı
     */
    private $db;

    /**
     * BlogModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Tüm blog gönderilerini alır.
     *
     * @return array Blog gönderileri
     */
    public function getAllPosts()
    {
        $stmt = $this->db->query("SELECT * FROM BlogPosts ORDER BY published_at DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Belirli bir ID'ye sahip blog gönderisini alır.
     *
     * @param int $id Blog gönderisi ID'si
     * @return array Blog gönderisi
     */
    public function getPostById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM BlogPosts WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Yeni bir blog gönderisi oluşturur.
     *
     * @param array $data Blog gönderisi verileri
     * @return bool İşlem sonucu
     */
    public function createPost($data)
    {
        $stmt = $this->db->prepare("INSERT INTO BlogPosts (title, slug, content, thumbnail_url, published_at) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$data['title'], $data['slug'], $data['content'], $data['thumbnail_url'], $data['published_at']]);
    }

    /**
     * Belirli bir ID'ye sahip blog gönderisini günceller.
     *
     * @param int $id Blog gönderisi ID'si
     * @param array $data Blog gönderisi verileri
     * @return bool İşlem sonucu
     */
    public function updatePost($id, $data)
    {
        $query = "UPDATE BlogPosts SET title = ?, slug = ?, content = ?, published_at = ?";
        $params = [$data['title'], $data['slug'], $data['content'], $data['published_at']];

        if (isset($data['thumbnail_url'])) {
            $query .= ", thumbnail_url = ?";
            $params[] = $data['thumbnail_url'];
        }

        $query .= " WHERE id = ?";
        $params[] = $id;

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    /**
     * Belirli bir ID'ye sahip blog gönderisini siler.
     *
     * @param int $id Blog gönderisi ID'si
     * @return bool İşlem sonucu
     */
    public function deletePost($id)
    {
        $stmt = $this->db->prepare("DELETE FROM BlogPosts WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Ön yüz için tüm blog gönderilerini alır.
     *
     * @return array Blog gönderileri
     */
    public function getAllPostsForFront()
    {
        $stmt = $this->db->prepare("SELECT title, slug, content, thumbnail_url, published_at FROM BlogPosts ORDER BY published_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Ön yüz için belirli bir slug'a sahip blog gönderisini alır.
     *
     * @param string $slug Blog gönderisi slug'ı
     * @return array Blog gönderisi
     */
    public function getPostBySlugForFront($slug)
    {
        $stmt = $this->db->prepare("SELECT title, slug, content, thumbnail_url, published_at FROM BlogPosts WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Verilen isimden bir slug oluşturur.
     *
     * @param string $name İsim
     * @return string Slug
     */
    private function generateSlug($name)
    {
        $turkish = ['ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'];
        $english = ['i', 'g', 'u', 's', 'o', 'c', 'I', 'G', 'U', 'S', 'O', 'C'];
        $name = str_replace($turkish, $english, $name);
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    }
}