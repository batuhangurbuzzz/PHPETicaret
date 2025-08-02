<?php

namespace App\Models;

use App\Core\Database;

/**
 * SearchModel sınıfı, ürün arama işlemlerini gerçekleştirmek için kullanılır.
 */
class SearchModel
{
    /**
     * @var \PDO Veritabanı bağlantı nesnesi
     */
    private $db;

    /**
     * SearchModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Ürünleri verilen sorguya göre arar.
     *
     * @param string $query Arama sorgusu
     * @return array Arama sonuçları
     */
    public function searchProducts($query)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE name LIKE ? OR short_description LIKE ? OR tag LIKE ?");
        $searchQuery = '%' . $query . '%';
        $stmt->execute([$searchQuery, $searchQuery, $searchQuery]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}