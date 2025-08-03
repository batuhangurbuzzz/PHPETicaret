<?php

namespace App\Controllers\Front;

use App\Core\BaseController;

class CustomerController extends BaseController
{
    /**
     * Müşteri ana sayfasını görüntüler.
     *
     * @return void
     */
    public function index()
    {
        // Mevcut URL'yi alır
        $currentUrl = $_SERVER['REQUEST_URI'];

        // Görünümü render eder ve verileri gönderir
        $this->render('front/auth/customer', ['currentUrl' => $currentUrl]);
    }
}