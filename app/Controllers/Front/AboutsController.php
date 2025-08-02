<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\AboutModel;

/**
 * AboutsController sınıfı, hakkında sayfası ile ilgili işlemleri yönetir.
 */
class AboutsController extends BaseController
{
    /**
     * @var AboutModel $aboutModel Hakkında bilgilerini yöneten model
     */
    protected $aboutModel;

    /**
     * AboutsController constructor.
     * AboutModel örneğini oluşturur ve BaseController'ın yapıcı metodunu çağırır.
     */
    public function __construct()
    {
        parent::__construct();
        $this->aboutModel = new AboutModel();
    }

    /**
     * Hakkında sayfasını görüntüler.
     */
    public function index()
    {
        // AboutModel'i kullanarak verileri al
        $about = $this->aboutModel->getAbout();

        // Verileri view'a gönder
        $this->render('front/abouts', [
            'about' => $about
        ]);
    }
}