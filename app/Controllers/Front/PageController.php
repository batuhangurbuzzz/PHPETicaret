<?php

namespace App\Controllers\Front;

use App\Models\PageModel;
use App\Core\BaseController;

class PageController extends BaseController
{
    /**
     * @var PageModel $pageModel Page model örneği
     */
    private $pageModel;

    /**
     * PageController constructor.
     * Üst sınıfın yapıcı metodunu çağırır ve PageModel örneğini oluşturur.
     */
    public function __construct()
    {
        // Üst sınıfın yapıcı metodunu çağır
        parent::__construct();

        // PageModel örneğini oluştur
        $this->pageModel = new PageModel();
    }

    /**
     * Belirtilen slug'a göre sayfa gösterimini sağlar.
     *
     * @param string $slug Sayfa slug değeri
     */
    public function show($slug)
    {
        // Slug'a göre sayfa bilgilerini al
        $page = $this->pageModel->getPageBySlug($slug);

        // Sayfa bulunduysa sayfa görünümünü render et
        if ($page) {
            $this->render('front/page', ['page' => $page]);
        } else {
            // Sayfa bulunamadıysa 404 hata sayfasını render et
            $this->render('errors/404');
        }
    }
}