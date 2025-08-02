<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\ProductModel;

class ProductController extends BaseController
{
    /**
     * @var ProductModel $productModel Ürün modeli örneği
     */
    private $productModel;

    /**
     * ProductController constructor.
     * Üst sınıfın yapıcı metodunu çağırır ve ProductModel örneğini oluşturur.
     */
    public function __construct()
    {
        parent::__construct();
        $this->productModel = new ProductModel();
    }

    /**
     * Ürün detaylarını görüntüler.
     *
     * @param string $slug Ürünün slug değeri
     */
    public function detail($slug)
    {
        // ProductModel'i kullanarak tek bir ürünü al
        $product = $this->productModel->getProductBySlugForFront($slug);

        // Ürüne ait galeri resimlerini al
        $galleryImages = $this->productModel->getProductGalleryImages($product['id']);

        // Verileri view'a gönder
        $this->render('front/product/detail', [
            'product' => $product, // Ürün verisi
            'galleryImages' => $galleryImages // Galeri resimleri
        ]);
    }
}