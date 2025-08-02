<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\SearchModel;

class SearchController extends BaseController
{
    /**
     * @var SearchModel $searchModel Arama işlemleri için kullanılan model
     */
    private $searchModel;

    /**
     * SearchController constructor.
     * Üst sınıfın yapıcı metodunu çağırır ve SearchModel örneğini oluşturur.
     */
    public function __construct()
    {
        parent::__construct();
        $this->searchModel = new SearchModel();
    }

    /**
     * Arama sayfasını görüntüler.
     *
     * @return void
     */
    public function index()
    {
        // Kullanıcının arama sorgusunu alır, eğer sorgu yoksa boş string kullanır.
        $query = $_GET['query'] ?? '';

        // Arama modelini kullanarak ürünleri arar.
        $products = $this->searchModel->searchProducts($query);

        // Arama sonuçlarını ve sorguyu arayüze gönderir.
        $this->render('front/search', [
            'products' => $products,
            'query' => $query
        ]);
    }
}