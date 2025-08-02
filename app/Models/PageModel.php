<?php

namespace App\Models;

use App\Core\Database;

/**
 * PageModel sınıfı, sayfalarla ilgili veritabanı işlemlerini yönetir.
 */
class PageModel
{
    /**
     * @var Database Veritabanı bağlantı nesnesi
     */
    private $db;

    /**
     * PageModel constructor.
     * Database sınıfının tekil örneğini alır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Tüm sayfaları getirir.
     *
     * @return array Sayfaların listesi
     */
    public function getAllPages()
    {
        $query = "SELECT * FROM pages";
        return $this->db->query($query)->fetchAll();
    }

    /**
     * Belirli bir ID'ye sahip sayfayı getirir.
     *
     * @param int $id Sayfa ID'si
     * @return array Sayfa bilgileri
     */
    public function getPageById($id)
    {
        $query = "SELECT * FROM pages WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Belirli bir slug'a sahip sayfayı getirir.
     *
     * @param string $slug Sayfa slug'ı
     * @return array Sayfa bilgileri
     */
    public function getPageBySlug($slug)
    {
        $query = "SELECT * FROM pages WHERE slug = :slug";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch();
    }

    /**
     * Yeni bir sayfa oluşturur.
     *
     * @param array $data Sayfa verileri
     * @return bool İşlem sonucu
     */
    public function createPage($data)
    {
        $query = "INSERT INTO pages (title, slug, content, status) VALUES (:title, :slug, :content, :status)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

    /**
     * Belirli bir ID'ye sahip sayfayı günceller.
     *
     * @param int $id Sayfa ID'si
     * @param array $data Güncellenmiş sayfa verileri
     * @return bool İşlem sonucu
     */
    public function updatePage($id, $data)
    {
        $data['id'] = $id;
        $query = "UPDATE pages SET title = :title, slug = :slug, content = :content, status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

    /**
     * Belirli bir ID'ye sahip sayfayı siler.
     *
     * @param int $id Sayfa ID'si
     * @return bool İşlem sonucu
     */
    public function deletePage($id)
    {
        $query = "DELETE FROM pages WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}