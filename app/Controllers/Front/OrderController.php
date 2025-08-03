<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\OrderModel;

class OrderController extends BaseController
{
    /**
     * @var OrderModel $orderModel Order model örneği
     */
    private $orderModel;

    /**
     * OrderController constructor.
     * Üst sınıfın yapıcı metodunu çağırır ve OrderModel örneğini oluşturur.
     */
    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new OrderModel();
    }

    /**
     * Kullanıcının siparişlerini listeler.
     * Eğer kullanıcı giriş yapmamışsa login sayfasına yönlendirir.
     */
    public function index()
    {
        // BaseController'dan miras alınan userId değişkenini kullan
        $userId = $this->userId;
        if ($userId) {
            $currentUrl = $_SERVER['REQUEST_URI'];
            $orders = $this->orderModel->getOrdersByUserId($userId);
            $this->render('front/auth/order', [
                'orders' => $orders,
                'currentUrl' => $currentUrl
            ]);
        } else {
            header('Location: /login');
        }
    }

    /**
     * Belirtilen siparişin detaylarını JSON formatında döner.
     * Eğer kullanıcı giriş yapmamışsa login sayfasına yönlendirir.
     *
     * @param int $orderId Sipariş ID'si
     */
    public function detail($orderId)
    {
        // BaseController'dan miras alınan userId değişkenini kullan
        $userId = $this->userId;
        if ($userId) {
            $order = $this->orderModel->getOrderById($orderId);
            $orderItems = $this->orderModel->getOrderItemsByOrderId($orderId);
            $orderAddress = $this->orderModel->getOrderAddressByOrderId($orderId);
            header('Content-Type: application/json');
            echo json_encode(['status' => $order['status'], 'items' => $orderItems, 'address' => $orderAddress]);
        } else {
            header('Location: /login');
        }
    }
}