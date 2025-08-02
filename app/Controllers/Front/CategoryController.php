<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    /**
     * @var CategoryModel $categoryModel Kategori modeli örneği
     */
    private $categoryModel;

    /**
     * CategoryController constructor.
     * Üst sınıfın yapıcı metodunu çağırır ve CategoryModel örneğini oluşturur.
     */
    public function __construct()
    {
        parent::__construct(); // Üst sınıfın yapıcı metodunu çağır
        $this->categoryModel = new CategoryModel(); // CategoryModel örne��ini oluştur
    }

    /**
     * Belirtilen kategoriye ait ürünleri gösterir.
     *
     * @param string $categorySlug Kategori slug'ı
     */
    public function show($categorySlug)
    {
        // CategoryModel'i kullanarak ürünleri al
        $products = $this->categoryModel->getProductsByCategorySlug($categorySlug);

        // Verileri view'a gönder
        $this->render('front/category', [
            'products' => $products // Ürün verileri
        ]);
    }
}