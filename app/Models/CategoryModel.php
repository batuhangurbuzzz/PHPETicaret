<?php

namespace App\Models;

use App\Core\Database;

/**
 * CategoryModel sınıfı, kategori veritabanı işlemlerini yönetir.
 */
class CategoryModel
{
    /**
     * @var \PDO Veritabanı bağlantısı
     */
    private $db;

    /**
     * CategoryModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Aktif kategorileri alır.
     *
     * @return array Kategoriler dizisi
     */
    public function getActiveCategories()
    {
        // categories tablosundan aktif kategorileri al
        $stmt = $this->db->query("SELECT * FROM categories WHERE status = 1 ORDER BY id ASC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Tüm kategorileri alır.
     *
     * @return array Kategoriler dizisi
     */
    public function getAllCategories()
    {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY id ASC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Belirli bir kategori ID'sine göre kategori bilgilerini alır.
     *
     * @param int $id Kategori ID'si
     * @return array Kategori bilgileri
     */
    public function getCategoryById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Yeni bir kategori oluşturur.
     *
     * @param array $data Kategori verileri
     * @return bool İşlem sonucu
     */
    public function createCategory($data)
    {
        $slug = $this->generateSlug($data['name']);
        $stmt = $this->db->prepare("INSERT INTO categories (name, icon, description, status, slug) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$data['name'], $data['icon'], $data['description'], $data['status'], $slug]);
    }

    /**
     * Belirli bir kategori ID'sine göre kategori bilgilerini günceller.
     *
     * @param int $id Kategori ID'si
     * @param array $data Kategori verileri
     * @return bool İşlem sonucu
     */
    public function updateCategory($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE categories SET name = ?, icon = ?, description = ?, status = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['icon'], $data['description'], $data['status'], $id]);
    }

    /**
     * Belirli bir kategori ID'sine göre kategoriyi siler.
     *
     * @param int $id Kategori ID'si
     * @return bool İşlem sonucu
     */
    public function deleteCategory($id)
    {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Kategori ismine göre slug oluşturur.
     *
     * @param string $name Kategori ismi
     * @return string Slug
     */
    private function generateSlug($name)
    {
        $turkish = ['ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'];
        $english = ['i', 'g', 'u', 's', 'o', 'c', 'I', 'G', 'U', 'S', 'O', 'C'];
        $name = str_replace($turkish, $english, $name);
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    }

    /**
     * Kategori slug'ına göre ürünleri alır.
     *
     * @param string $categorySlug Kategori slug'ı
     * @return array Ürünler dizisi
     */
    public function getProductsByCategorySlug($categorySlug)
    {
        $stmt = $this->db->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE c.slug = ?");
        $stmt->execute([$categorySlug]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}