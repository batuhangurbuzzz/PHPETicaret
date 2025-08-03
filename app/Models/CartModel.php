<?php

namespace App\Models;

use App\Core\Database;

/**
 * CartModel sınıfı, sepet işlemlerini yönetir.
 */
class CartModel
{
    /**
     * @var \PDO Veritabanı bağlantısı
     */
    private $db;

    /**
     * CartModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = self::getDbInstance();
    }

    /**
     * Veritabanı bağlantısını tekil hale getirir.
     *
     * @return \PDO
     */
    private static function getDbInstance()
    {
        return Database::getInstance();
    }

    /**
     * Sepete ürün ekler veya miktarını günceller.
     *
     * @param int $userId Kullanıcı ID'si
     * @param int $productId Ürün ID'si
     * @param int $quantity Ürün miktarı
     * @return bool
     */
    public function addToCart($userId, $productId, $quantity = 1)
    {
        // Mevcut ürün miktarını kontrol et
        $stmt = $this->db->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        $existingItem = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($existingItem) {
            // Mevcut ürün miktarını güncelle
            $newQuantity = $existingItem['quantity'] + $quantity;
            $stmt = $this->db->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
            return $stmt->execute([$newQuantity, $userId, $productId]);
        } else {
            // Yeni ürün ekle
            $stmt = $this->db->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
            return $stmt->execute([$userId, $productId, $quantity]);
        }
    }

    /**
     * Sepetten ürün siler.
     *
     * @param int $userId Kullanıcı ID'si
     * @param int $productId Ürün ID'si
     * @return bool
     */
    public function removeFromCart($userId, $productId)
    {
        $stmt = $this->db->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
        return $stmt->execute([$userId, $productId]);
    }

    /**
     * Kullanıcı ID'ye göre sepet öğelerini getirir.
     *
     * @param int $userId Kullanıcı ID'si
     * @return array
     */
    public function getCartItemsByUserId($userId)
    {
        $stmt = $this->db->prepare("
            SELECT p.name, p.price, c.quantity, c.product_id
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Sepetteki ürün miktarını arttırır.
     *
     * @param int $userId Kullanıcı ID'si
     * @param int $productId Ürün ID'si
     * @return bool
     */
    public function increaseQuantity($userId, $productId)
    {
        $stmt = $this->db->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
        return $stmt->execute([$userId, $productId]);
    }

    /**
     * Sepetteki ürün miktarını azaltır.
     *
     * @param int $userId Kullanıcı ID'si
     * @param int $productId Ürün ID'si
     * @return bool
     */
    public function decreaseQuantity($userId, $productId)
    {
        $stmt = $this->db->prepare("UPDATE cart SET quantity = quantity - 1 WHERE user_id = ? AND product_id = ? AND quantity > 1");
        return $stmt->execute([$userId, $productId]);
    }

    /**
     * Kullanıcı ID'ye göre sepetteki ürün sayısını getirir.
     *
     * @param int $userId Kullanıcı ID'si
     * @return int
     */
    public function getCartItemCountByUserId($userId)
    {
        $stmt = $this->db->prepare("SELECT SUM(quantity) as item_count FROM cart WHERE user_id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['item_count'] ?? 0;
    }
}