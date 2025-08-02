<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\SliderModel;
use App\Models\DealModel;
use App\Models\ProductModel;

class HomeController extends BaseController
{
    /**
     * @var SliderModel $sliderModel Slider model örneği
     * @var DealModel $dealModel Kampanya model örneği
     * @var ProductModel $productModel Ürün model örneği
     */
    private $sliderModel;
    private $dealModel;
    private $productModel;

    /**
     * HomeController constructor.
     * Model örneklerini oluşturur ve üst sınıfın yapıcı metodunu çağırır.
     */
    public function __construct()
    {
        parent::__construct();

        // SliderModel örneğini oluştur
        $this->sliderModel = new SliderModel();

        // DealModel örneğini oluştur
        $this->dealModel = new DealModel();

        // ProductModel örneğini oluştur
        $this->productModel = new ProductModel();
    }

    /**
     * Anasayfa verilerini alır ve view'a gönderir.
     */
    public function index()
    {
        // SliderModel'i kullanarak aktif slider verilerini al
        $sliders = $this->sliderModel->getActiveSliders();

        // DealModel'i kullanarak aktif kampanyaları al
        $deals = $this->dealModel->getActiveDeals();

        // ProductModel'i kullanarak öne çıkan ürünleri al
        $products = $this->productModel->getFeaturedProducts();
        $totalProductCount = $this->productModel->getTotalProductCount();

        // Verileri view'a gönder
        $this->render('front/home', [
            'sliders' => $sliders, // Slider verileri
            'deals' => $deals,     // Kampanya verileri
            'products' => $products, // Ürün verileri
            'totalProductCount' => $totalProductCount // Toplam ürün sayısı
        ]);
    }
}