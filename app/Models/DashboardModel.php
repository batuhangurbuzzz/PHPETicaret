<?php

namespace App\Models;

use App\Core\Database;

/**
 * DashboardModel sınıfı, veritabanından çeşitli istatistiksel verileri almak için kullanılır.
 */
class DashboardModel
{
    /**
     * @var \PDO Veritabanı bağlantı nesnesi
     */
    private $db;

    /**
     * DashboardModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Toplam müşteri sayısını döner.
     *
     * @return int Müşteri sayısı
     */
    public function getCustomerCount()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM users");
        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }

    /**
     * Toplam sipariş sayısını döner.
     *
     * @return int Sipariş sayısı
     */
    public function getOrderCount()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM orders");
        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }

    /**
     * Sipariş durumlarına göre sipariş sayılarını döner.
     *
     * @return array Sipariş durumlarına göre sayılar
     */
    public function getOrderStatusCounts()
    {
        $stmt = $this->db->query("SELECT status, COUNT(*) as count FROM orders GROUP BY status");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Bugün oluşturulan siparişlerin sayısını döner.
     *
     * @return int Bugünkü sipariş sayısı
     */
    public function getTodayOrderCount()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM orders WHERE DATE(created_at) = CURDATE()");
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }

    /**
     * Toplam sipariş sayısını döner.
     *
     * @return int Toplam sipariş sayısı
     */
    public function getTotalOrderCount()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM orders");
        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }

    /**
     * İptal edilen siparişlerin sayısını döner.
     *
     * @return int İptal edilen sipariş sayısı
     */
    public function getCancelledOrderCount()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM orders WHERE status = 'cancelled'");
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }

    /**
     * Bekleyen siparişlerin sayısını döner.
     *
     * @return int Bekleyen sipariş sayısı
     */
    public function getPendingOrderCount()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM orders WHERE status NOT IN ('cancelled', 'shipped')");
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }

    /**
     * Tamamlanan siparişlerin sayısını döner.
     *
     * @return int Tamamlanan sipariş sayısı
     */
    public function getCompletedOrderCount()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM orders WHERE status = 'shipped'");
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }
}