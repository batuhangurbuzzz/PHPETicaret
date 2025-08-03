<?php

namespace App\Controllers\Admin;

use App\Models\OrderModel;
use App\Core\BaseController;

// OrderController sınıfını tanımla
class OrderController extends BaseController
{
    private $orderModel;

    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new OrderModel();
    }

    /**
     * Tüm siparişleri listele.
     */
    public function index()
    {
        $orders = $this->orderModel->getAllOrders();

        foreach ($orders as &$order) {
            $user = $this->orderModel->getUserById($order['user_id']);
            $order['user_name'] = $user['name'];
        }

        if (empty($orders)) {
            $orders = [];
        }

        $this->renderAdmin(
            'admin/order/index',
            ['orders' => $orders]
        );
    }

    /**
     * Sipariş detaylarını al.
     *
     * @param int $orderId Sipariş ID'si
     * @return void
     */
    public function detail($orderId)
    {
        $order = $this->orderModel->getOrderById($orderId);
        $items = $this->orderModel->getOrderItemsByOrderId($orderId);
        $address = $this->orderModel->getOrderAddressByOrderId($orderId);

        echo json_encode([
            'order' => $order,
            'items' => $items,
            'address' => $address
        ]);
    }

    /**
     * Sipariş durumunu güncelle.
     *
     * @param int $orderId Sipariş ID'si
     * @return void
     */
    public function updateStatus($orderId)
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $newStatus = $input['status'] ?? null;

        if ($newStatus) {
            $this->orderModel->updateOrderStatus($orderId, $newStatus);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Geçersiz durum']);
        }
    }
}