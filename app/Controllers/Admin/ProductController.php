<?php

namespace App\Controllers\Admin;

use App\Models\ProductModel;
use App\Core\BaseController;

class ProductController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $products = $this->productModel->getAllProducts();

        if (empty($products)) {
            $products = [];
        }

        $this->renderAdmin(
            'admin/product/index',
            ['products' => $products]
        );
    }

    public function create()
    {
        $categories = $this->productModel->getAllCategories();
        $this->renderAdmin('admin/product/create', ['categories' => $categories]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $slug = $this->generateSlug($_POST['name']);

            $data = [
                'name' => $_POST['name'],
                'slug' => $slug,
                'short_description' => $_POST['short_description'],
                'featured' => $_POST['featured'], // Enum değerine göre al
                'tag' => $_POST['tag'],
                'standard_image' => $this->uploadImage('standard_image'),
                'hover_image' => $this->uploadImage('hover_image'),
                'stock_quantity' => $_POST['stock_quantity'],
                'delivery_date' => $_POST['delivery_date'], // Gün olarak al
                'long_description' => $_POST['long_description'],
                'category_id' => $_POST['category_id']
            ];

            $result = $this->productModel->createProduct($data);

            if ($result) {
                $this->renderAdmin('admin/product/create', ['success' => 'Ürün başarıyla oluşturuldu.']);
            } else {
                $this->renderAdmin('admin/product/create', ['error' => 'Ürün oluşturulurken bir hata oluştu.']);
            }
        }
    }

    public function edit($id)
    {
        $product = $this->productModel->getProductById($id);
        $categories = $this->productModel->getAllCategories();

        $this->renderAdmin(
            'admin/product/edit',
            ['product' => $product, 'categories' => $categories]
        );
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $slug = $this->generateSlug($_POST['name']);

            $data = [
                'name' => $_POST['name'],
                'slug' => $slug,
                'short_description' => $_POST['short_description'],
                'featured' => $_POST['featured'], // Enum değerine göre al
                'tag' => $_POST['tag'],
                'standard_image' => $this->uploadImage('standard_image') ?: $_POST['current_standard_image'],
                'hover_image' => $this->uploadImage('hover_image') ?: $_POST['current_hover_image'],
                'stock_quantity' => $_POST['stock_quantity'],
                'delivery_date' => $_POST['delivery_date'], // Gün olarak al
                'long_description' => $_POST['long_description'],
                'category_id' => $_POST['category_id']
            ];

            $result = $this->productModel->updateProduct($id, $data);

            if ($result) {
                $this->renderAdmin('admin/product/edit', ['product' => $this->productModel->getProductById($id), 'success' => 'Ürün başarıyla güncellendi.']);
            } else {
                $this->renderAdmin('admin/product/edit', ['product' => $this->productModel->getProductById($id), 'error' => 'Ürün güncellenirken bir hata oluştu.']);
            }
        }
    }

    public function delete($id)
    {
        $product = $this->productModel->getProductById($id);

        if ($product) {
            if ($product['standard_image']) {
                $standardImagePath = __DIR__ . '/../../../public' . $product['standard_image'];
                if (file_exists($standardImagePath)) {
                    unlink($standardImagePath);
                }
            }

            if ($product['hover_image']) {
                $hoverImagePath = __DIR__ . '/../../../public' . $product['hover_image'];
                if (file_exists($hoverImagePath)) {
                    unlink($hoverImagePath);
                }
            }
        }

        $this->productModel->deleteProduct($id);

        header('Location: /admin/products');
    }

    private function uploadImage($inputName)
    {
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../../public/uploads/products/';
            $fileExtension = pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION);
            $randomFileName = uniqid() . '.' . $fileExtension;
            $uploadFile = $uploadDir . $randomFileName;
            move_uploaded_file($_FILES[$inputName]['tmp_name'], $uploadFile);
            return '/uploads/products/' . $randomFileName;
        }
        return null;
    }

    private function generateSlug($name)
    {
        $turkish = ['ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'];
        $english = ['i', 'g', 'u', 's', 'o', 'c', 'I', 'G', 'U', 'S', 'O', 'C'];
        $name = str_replace($turkish, $english, $name);
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    }

    public function gallery($productId)
    {
        $product = $this->productModel->getProductById($productId);
        $galleryImages = $this->productModel->getProductGalleryImages($productId);
        $this->renderAdmin('admin/product/gallery', [
            'product_id' => $productId,
            'product_name' => $product['name'],
            'gallery_images' => array_slice($galleryImages, 0, 5) // Maksimum 5 görsel
        ]);
    }

    public function addGalleryImage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'];
            $imagePath = $this->uploadGalleryImage('gallery_image', $productId);

            if ($imagePath) {
                $this->productModel->addGalleryImage($productId, $imagePath);
            }

            header("Location: /admin/products/gallery/$productId");
        }
    }

    public function deleteGalleryImage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'];
            $imagePath = $_POST['image_path'];

            if ($this->productModel->deleteGalleryImage($productId, $imagePath)) {
                $fullImagePath = __DIR__ . '/../../../public' . $imagePath;
                if (file_exists($fullImagePath)) {
                    unlink($fullImagePath);
                }
            }

            header("Location: /admin/products/gallery/$productId");
        }
    }

    private function uploadGalleryImage($inputName, $productId)
    {
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../../public/uploads/products/' . $productId . '/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileExtension = pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION);
            $randomFileName = uniqid() . '.' . $fileExtension;
            $uploadFile = $uploadDir . $randomFileName;
            move_uploaded_file($_FILES[$inputName]['tmp_name'], $uploadFile);
            return '/uploads/products/' . $productId . '/' . $randomFileName;
        }
        return null;
    }
}