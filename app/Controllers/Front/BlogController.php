<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\BlogModel;

class BlogController extends BaseController
{
    /**
     * @var BlogModel $blogModel Blog model örneği
     */
    private $blogModel;

    /**
     * BlogController yapıcı metodu.
     * BlogModel örneğini başlatır ve üst sınıfın yapıcı metodunu çağırır.
     */
    public function __construct()
    {
        parent::__construct();
        $this->blogModel = new BlogModel();
    }

    /**
     * Blog makalelerinin listesini görüntüler.
     *
     * @return void
     */
    public function index()
    {
        // BlogModel kullanarak tüm blog makalelerini al
        $posts = $this->blogModel->getAllPostsForFront();

        // Verileri view'a gönder
        $this->render('front/blog/index', [
            'posts' => $posts // Blog makaleleri
        ]);
    }

    /**
     * Belirtilen blog makalesini görüntüler.
     *
     * @param string $slug Blog makalesinin slug'ı
     * @return void
     */
    public function detail($slug)
    {
        // BlogModel kullanarak tek bir blog makalesini al
        $post = $this->blogModel->getPostBySlugForFront($slug);

        // Verileri view'a gönder
        $this->render('front/blog/detail', [
            'post' => $post // Blog makalesi
        ]);
    }
}