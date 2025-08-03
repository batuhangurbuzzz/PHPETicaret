<?php

namespace App\Controllers\Admin;

use App\Core\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    private $categoryModel;

    public function __construct()
    {
        parent::__construct(); // Üst sınıfın constructor'ını çağır
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $categories = $this->categoryModel->getAllCategories();
        $this->renderAdmin('admin/categories/index', ['categories' => $categories]);
    }

    public function create()
    {
        $this->renderAdmin('admin/categories/create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'icon' => $_POST['icon'],
                'description' => $_POST['description'],
                'status' => $_POST['status']
            ];

            $result = $this->categoryModel->createCategory($data);

            if ($result) {
                $this->renderAdmin('admin/categories/create', ['success' => 'Kategori başarıyla oluşturuldu.']);
            } else {
                $this->renderAdmin('admin/categories/create', ['error' => 'Kategori oluşturulamadı.']);
            }
        }
    }

    public function edit($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        $this->renderAdmin('admin/categories/edit', ['category' => $category]);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'icon' => $_POST['icon'],
                'description' => $_POST['description'],
                'status' => $_POST['status']
            ];

            $result = $this->categoryModel->updateCategory($id, $data);

            $category = $this->categoryModel->getCategoryById($id);

            if ($result) {
                $this->renderAdmin('admin/categories/edit', ['category' => $category, 'success' => 'Kategori başarıyla güncellendi.']);
            } else {
                $this->renderAdmin('admin/categories/edit', ['category' => $category, 'error' => 'Kategori güncellenemedi.']);
            }
        }
    }

    public function delete($id)
    {
        $result = $this->categoryModel->deleteCategory($id);

        if ($result) {
            header('Location: /admin/categories');
        } else {
            $categories = $this->categoryModel->getAllCategories();
            $this->renderAdmin('admin/categories/index', ['categories' => $categories, 'error' => 'Kategori silinemedi.']);
        }
    }
}