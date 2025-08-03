<?php

// App\Models ad alanını kullan
namespace App\Models;

// Gerekli sınıfı içe aktar
use App\Core\Database;

// OrderModel sınıfını tanımla
class OrderModel
{
    // Veritabanı bağlantısı
    private $db;

    // Yapıcı metot
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Kullanıcı ID'sine göre siparişleri alır.
     *
     * @param int $userId Kullanıcı ID'si
     * @return array
     */
    public function getOrdersByUserId($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    /**
     * Sipariş ID'sine göre siparişi alır.
     *
     * @param int $orderId Sipariş ID'si
     * @return array|false
     */
    public function getOrderById($orderId)
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = :order_id");
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetch();
    }

    /**
     * Sipariş ID'sine göre sipariş öğelerini alır.
     *
     * @param int $orderId Sipariş ID'si
     * @return array
     */
    public function getOrderItemsByOrderId($orderId)
    {
        $stmt = $this->db->prepare("
            SELECT oi.*, p.name as product_name 
            FROM order_items oi 
            JOIN products p ON oi.product_id = p.id 
            WHERE oi.order_id = :order_id
        ");
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll();
    }

    /**
     * Yeni bir sipariş oluşturur.
     *
     * @param array $data Sipariş verileri
     * @return int
     */
    public function createOrder($data)
    {
        $stmt = $this->db->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (:user_id, :total_price, :status)");
        $stmt->execute([
            'user_id' => $data['user_id'],
            'total_price' => $data['total_price'],
            'status' => $data['status'] ?? 'pending'
        ]);
        return $this->db->lastInsertId();
    }

    /**
     * Yeni bir sipariş öğesi oluşturur.
     *
     * @param array $data Sipariş öğesi verileri
     * @return void
     */
    public function createOrderItem($data)
    {
        $stmt = $this->db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
        $stmt->execute([
            'order_id' => $data['order_id'],
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'],
            'price' => $data['price']
        ]);
    }

    /**
     * Yeni bir sipariş ödemesi oluşturur.
     *
     * @param array $data Sipariş ödeme verileri
     * @return void
     */
    public function createOrderPayment($data)
    {
        $stmt = $this->db->prepare("INSERT INTO order_payments (order_id, payment_status, payment_method, transaction_id, payment_total) VALUES (:order_id, :payment_status, :payment_method, :transaction_id, :payment_total)");
        $stmt->execute([
            'order_id' => $data['order_id'],
            'payment_status' => $data['payment_status'],
            'payment_method' => $data['payment_method'],
            'transaction_id' => $data['transaction_id'],
            'payment_total' => $data['payment_total']
        ]);
    }

    /**
     * Yeni bir sipariş adresi oluşturur.
     *
     * @param array $data Sipariş adres verileri
     * @return void
     */
    public function createOrderAddress($data)
    {
        $stmt = $this->db->prepare("INSERT INTO order_addresses (order_id, address_type, full_name, phone, city, district, neighborhood, address) VALUES (:order_id, :address_type, :full_name, :phone, :city, :district, :neighborhood, :address)");
        $stmt->execute([
            'order_id' => $data['order_id'],
            'address_type' => $data['address_type'],
            'full_name' => $data['full_name'],
            'phone' => $data['phone'],
            'city' => $data['city'],
            'district' => $data['district'],
            'neighborhood' => $data['neighborhood'],
            'address' => $data['address']
        ]);
    }

    /**
     * Kullanıcı ID'sine göre kullanıcıyı alır.
     *
     * @param int $userId Kullanıcı ID'si
     * @return array|false
     */
    public function getUserById($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch();
    }

    /**
     * Kullanıcı ID'sine göre sepet öğelerini alır.
     *
     * @param int $userId Kullanıcı ID'si
     * @return array
     */
    public function getCartItems($userId)
    {
        $stmt = $this->db->prepare("
            SELECT ci.product_id, p.name, p.price, ci.quantity, c.category 
            FROM cart_items ci 
            JOIN products p ON ci.product_id = p.id 
            JOIN categories c ON p.category_id = c.id 
            WHERE ci.user_id = :user_id
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    /**
     * Kullanıcı ID'sine göre sepeti temizler.
     *
     * @param int $userId Kullanıcı ID'si
     * @return void
     */
    public function clearCart($userId)
    {
        $stmt = $this->db->prepare("DELETE FROM cart_items WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
    }

    /**
     * Sipariş ID'sine göre sipariş adresini alır.
     *
     * @param int $orderId Sipariş ID'si
     * @return array|false
     */
    public function getOrderAddressByOrderId($orderId)
    {
        $stmt = $this->db->prepare("SELECT * FROM order_addresses WHERE order_id = :order_id AND address_type = 'shipping'");
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetch();
    }

    /**
     * Tüm siparişleri alır (admin için).
     *
     * @return array
     */
    public function getAllOrders()
    {
        $stmt = $this->db->query("SELECT * FROM orders ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /**
     * Sipariş durumunu günceller.
     *
     * @param int $orderId Sipariş ID'si
     * @param string $status Yeni durum
     * @return void
     */
    public function updateOrderStatus($orderId, $status)
    {
        $stmt = $this->db->prepare("UPDATE orders SET status = :status WHERE id = :order_id");
        $stmt->execute([
            'status' => $status,
            'order_id' => $orderId
        ]);
    }
}