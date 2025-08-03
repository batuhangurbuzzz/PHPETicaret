<?php

namespace App\Controllers\Admin;

use App\Models\PageModel;
use App\Core\BaseController;

class PageController extends BaseController
{
    private $pageModel;

    public function __construct()
    {
        parent::__construct();
        $this->pageModel = new PageModel();
    }

    public function index()
    {
        $pages = $this->pageModel->getAllPages();
        $this->renderAdmin('admin/page/index', ['pages' => $pages]);
    }

    public function create()
    {
        $this->renderAdmin('admin/page/create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $slug = $this->generateSlug($_POST['title']);

            $data = [
                'title' => $_POST['title'],
                'slug' => $slug,
                'content' => $_POST['content'],
                'status' => $_POST['status']
            ];

            $result = $this->pageModel->createPage($data);

            if ($result) {
                $this->renderAdmin('admin/page/create', ['success' => 'Sayfa başarıyla oluşturuldu.']);
            } else {
                $this->renderAdmin('admin/page/create', ['error' => 'Sayfa oluşturulurken bir hata oluştu.']);
            }
        }
    }

    public function edit($id)
    {
        $page = $this->pageModel->getPageById($id);
        $this->renderAdmin('admin/page/edit', ['page' => $page]);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $slug = $this->generateSlug($_POST['title']);

            $data = [
                'title' => $_POST['title'],
                'slug' => $slug,
                'content' => $_POST['content'],
                'status' => $_POST['status']
            ];

            $result = $this->pageModel->updatePage($id, $data);

            if ($result) {
                $this->renderAdmin('admin/page/edit', ['page' => $this->pageModel->getPageById($id), 'success' => 'Sayfa başarıyla güncellendi.']);
            } else {
                $this->renderAdmin('admin/page/edit', ['page' => $this->pageModel->getPageById($id), 'error' => 'Sayfa güncellenirken bir hata oluştu.']);
            }
        }
    }

    public function delete($id)
    {
        $this->pageModel->deletePage($id);
        header('Location: /admin/pages');
    }

    private function generateSlug($title)
    {
        $turkish = ['ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'];
        $english = ['i', 'g', 'u', 's', 'o', 'c', 'I', 'G', 'U', 'S', 'O', 'C'];
        $title = str_replace($turkish, $english, $title);
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    }
}