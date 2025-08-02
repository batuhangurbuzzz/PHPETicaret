<?php

namespace App\Models;

use App\Core\Database;

/**
 * DealModel sınıfı, kampanya verilerini yönetmek için kullanılır.
 */
class DealModel
{
    /**
     * @var \PDO Veritabanı bağlantısı
     */
    private $db;

    /**
     * DealModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Tüm aktif kampanyaları alır.
     *
     * @return array
     */
    public function getActiveDeals()
    {
        // deals tablosundan aktif kampanyaları al
        $stmt = $this->db->query("
            SELECT * 
            FROM deals 
            WHERE status = 1 
              AND start_date <= NOW() 
              AND end_date >= NOW() 
            ORDER BY start_date ASC
        ");

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Belirli bir kampanyayı ID ile alır.
     *
     * @param int $id Kampanya ID'si
     * @return array|false
     */
    public function getDealById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM deals WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Yeni bir kampanya oluşturur.
     *
     * @param array $data Kampanya verileri
     * @return bool
     */
    public function createDeal($data)
    {
        $stmt = $this->db->prepare("INSERT INTO deals (title, content, start_date, end_date, status) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$data['title'], $data['content'], $data['start_date'], $data['end_date'], $data['status']]);
    }

    /**
     * Mevcut bir kampanyayı günceller.
     *
     * @param int $id Kampanya ID'si
     * @param array $data Kampanya verileri
     * @return bool
     */
    public function updateDeal($id, $data)
    {
        $query = "UPDATE deals SET title = ?, content = ?, start_date = ?, end_date = ?, status = ? WHERE id = ?";
        $params = [$data['title'], $data['content'], $data['start_date'], $data['end_date'], $data['status'], $id];

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    /**
     * Belirli bir kampanyayı siler.
     *
     * @param int $id Kampanya ID'si
     * @return bool
     */
    public function deleteDeal($id)
    {
        $stmt = $this->db->prepare("DELETE FROM deals WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Tüm kampanyaları alır.
     *
     * @return array
     */
    public function getAllDeals()
    {
        $stmt = $this->db->query("SELECT * FROM deals ORDER BY start_date ASC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}