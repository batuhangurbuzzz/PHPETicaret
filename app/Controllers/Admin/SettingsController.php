<?php

namespace App\Controllers\Admin;

use App\Models\SettingsModel;
use App\Core\BaseController;


class SettingsController extends BaseController
{
    public function index()
    {

        $settingsModel = new SettingsModel();
        $this->settings = $settingsModel->getAllSettings();

        // Verileri view'a gönder
        $this->renderAdmin(
            'admin/settings/index',
            ['settings' => $this->settings]
        );
    }

    public function updateSetting()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $key = $_POST['key'];
            $value = $_POST['value'];

            $settingsModel = new SettingsModel();
            $result = $settingsModel->updateSetting($key, $value);

            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Ayar başarıyla güncellendi.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Ayar güncellenirken bir hata oluştu.']);
            }
        }
    }
}