<?php

namespace App\Controllers\Admin;

use App\Models\SliderModel;
use App\Core\BaseController;

class SliderController extends BaseController
{
    private $sliderModel;

    public function __construct()
    {
        parent::__construct(); // Üst sınıfın constructor'ını çağır
        $this->sliderModel = new SliderModel();
    }

    public function index()
    {
        $sliders = $this->sliderModel->getAllSliders();

        $this->renderAdmin(
            'admin/slider/index',
            ['sliders' => $sliders]
        );
    }

    public function create()
    {
        $this->renderAdmin('admin/slider/create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'image_url' => $this->uploadImage(),
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'link_url' => $_POST['link_url'],
                'status' => $_POST['status'],
                'sort_order' => $_POST['sort_order']
            ];

            $result = $this->sliderModel->createSlider($data);

            if ($result) {
                $this->renderAdmin('admin/slider/create', ['success' => 'Slider başarıyla oluşturuldu.']);
            } else {
                $this->renderAdmin('admin/slider/create', ['error' => 'Slider oluşturulurken bir hata oluştu.']);
            }
        }
    }

    public function edit($id)
    {
        $slider = $this->sliderModel->getSliderById($id);

        $this->renderAdmin(
            'admin/slider/edit',
            ['slider' => $slider]
        );
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'link_url' => $_POST['link_url'],
                'status' => $_POST['status'],
                'sort_order' => $_POST['sort_order']
            ];

            $imageUrl = $this->uploadImage();
            if ($imageUrl) {
                $data['image_url'] = $imageUrl;
            }

            $result = $this->sliderModel->updateSlider($id, $data);

            $slider = $this->sliderModel->getSliderById($id);

            if ($result) {
                $this->renderAdmin('admin/slider/edit', ['slider' => $slider, 'success' => 'Slider başarıyla güncellendi.']);
            } else {
                $this->renderAdmin('admin/slider/edit', ['slider' => $slider, 'error' => 'Slider güncellenirken bir hata oluştu.']);
            }
        }
    }

    public function delete($id)
    {
        $slider = $this->sliderModel->getSliderById($id);

        if ($slider && $slider['image_url']) {
            $imagePath = __DIR__ . '/../../../public' . $slider['image_url'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $this->sliderModel->deleteSlider($id);

        header('Location: /admin/slider');
    }

    private function uploadImage()
    {
        if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../../public/uploads/sliders/';
            $fileExtension = pathinfo($_FILES['image_url']['name'], PATHINFO_EXTENSION);
            $randomFileName = uniqid() . '.' . $fileExtension;
            $uploadFile = $uploadDir . $randomFileName;
            move_uploaded_file($_FILES['image_url']['tmp_name'], $uploadFile);
            return '/uploads/sliders/' . $randomFileName;
        }
        return null;
    }
}