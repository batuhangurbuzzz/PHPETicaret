<?php

namespace App\Controllers\Admin;

use App\Core\BaseController;
use App\Models\DealModel;

class DealController extends BaseController
{
    private $dealModel;

    public function __construct()
    {
        parent::__construct(); // Üst sınıfın constructor'ını çağır
        $this->dealModel = new DealModel();
    }

    public function index()
    {
        $deals = $this->dealModel->getAllDeals();
        $this->renderAdmin('admin/deal/index', ['deals' => $deals]);
    }

    public function create()
    {
        $this->renderAdmin('admin/deal/create');
    }

    public function store()
    {
        $data = [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'status' => $_POST['status']
        ];

        if ($this->dealModel->createDeal($data)) {
            header('Location: /admin/deal');
            exit;
        } else {
            $this->renderAdmin('admin/deal/create', ['error' => 'Kampanya oluşturulamadı.']);
        }
    }

    public function edit($id)
    {
        $deal = $this->dealModel->getDealById($id);
        $this->renderAdmin('admin/deal/edit', ['deal' => $deal]);
    }

    public function update($id)
    {
        $data = [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'status' => $_POST['status']
        ];

        if ($this->dealModel->updateDeal($id, $data)) {
            header('Location: /admin/deal');
            exit;
        } else {
            $this->renderAdmin('admin/deal/edit', ['error' => 'Kampanya güncellenemedi.', 'deal' => $data]);
        }
    }

    public function delete($id)
    {
        if ($this->dealModel->deleteDeal($id)) {
            header('Location: /admin/deal');
            exit;
        } else {
            $this->renderAdmin('admin/deal/index', ['error' => 'Kampanya silinemedi.']);
        }
    }
}