<?php

namespace App\Controllers\Admin;

use App\Core\BaseController;
use App\Models\DashboardModel;

class DashboardController extends BaseController
{
    private $dashboardModel;

    public function __construct()
    {
        parent::__construct();
        $this->dashboardModel = new DashboardModel();
    }

    public function index()
    {
        $data = [
            'customerCount' => $this->dashboardModel->getCustomerCount(),
            'orderCount' => $this->dashboardModel->getOrderCount(),
            'orderStatusCounts' => $this->dashboardModel->getOrderStatusCounts(),
            'todayOrderCount' => $this->dashboardModel->getTodayOrderCount(),
            'totalOrderCount' => $this->dashboardModel->getTotalOrderCount(),
            'cancelledOrderCount' => $this->dashboardModel->getCancelledOrderCount(),
            'pendingOrderCount' => $this->dashboardModel->getPendingOrderCount(),
            'completedOrderCount' => $this->dashboardModel->getCompletedOrderCount()
        ];

        $this->renderAdmin('admin/dashboard', $data);
    }
}