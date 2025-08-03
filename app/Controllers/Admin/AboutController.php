<?php

namespace App\Controllers\Admin;

use App\Core\BaseController;
use App\Models\AboutModel;

class AboutController extends BaseController
{
    private $aboutModel;

    public function __construct()
    {
        parent::__construct(); // Üst sınıfın constructor'ını çağır
        $this->aboutModel = new AboutModel();
    }

    public function edit()
    {
        $about = $this->aboutModel->getAbout();
        $this->renderAdmin('admin/about/edit', ['about' => $about]);
    }

    public function update()
    {
        $data = [
            'vision' => $_POST['vision'],
            'mission' => $_POST['mission'],
            'biography' => $_POST['biography']
        ];

        if (!empty($_FILES['image1']['name'])) {
            $data['image1'] = $this->uploadImage('image1');
            $this->deleteOldImage('image1');
        } else {
            $data['image1'] = $_POST['current_image1'];
        }

        if (!empty($_FILES['image2']['name'])) {
            $data['image2'] = $this->uploadImage('image2');
            $this->deleteOldImage('image2');
        } else {
            $data['image2'] = $_POST['current_image2'];
        }

        if ($this->aboutModel->updateAbout($data)) {
            header('Location: /admin/about');
            exit;
        } else {
            $this->renderAdmin('admin/about/edit', ['error' => 'Hakkımızda bilgileri güncellenemedi.', 'about' => $data]);
        }
    }

    private function uploadImage($imageField)
    {
        $targetDir = __DIR__ . '/../../../public/uploads/about/';
        $fileName = uniqid() . '_' . basename($_FILES[$imageField]['name']);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES[$imageField]['tmp_name'], $targetFilePath)) {
            return '/uploads/about/' . $fileName;
        }

        return null;
    }

    private function deleteOldImage($imageField)
    {
        $oldImage = $_POST['current_' . $imageField];
        if ($oldImage && file_exists(__DIR__ . '/../../../public' . $oldImage)) {
            unlink(__DIR__ . '/../../../public' . $oldImage);
        }
    }
}