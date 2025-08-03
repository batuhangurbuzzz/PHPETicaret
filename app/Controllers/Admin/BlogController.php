<?php

namespace App\Controllers\Admin;

use App\Core\BaseController;
use App\Models\BlogModel;

class BlogController extends BaseController
{
    private $blogModel;

    public function __construct()
    {
        parent::__construct(); // Üst sınıfın constructor'ını çağır
        $this->blogModel = new BlogModel();
    }

    public function index()
    {
        $posts = $this->blogModel->getAllPosts();
        $this->renderAdmin('admin/blogs/index', ['posts' => $posts]);
    }

    public function create()
    {
        $this->renderAdmin('admin/blogs/create');
    }

    public function store()
    {
        $data = [
            'title' => $_POST['title'],
            'slug' => $this->generateSlug($_POST['title']),
            'content' => $_POST['content'],
            'thumbnail_url' => $this->uploadImage(),
            'published_at' => $_POST['published_at']
        ];

        if ($this->blogModel->createPost($data)) {
            header('Location: /admin/blogs');
            exit;
        } else {
            $this->renderAdmin('admin/blogs/create', ['error' => 'Blog yazısı oluşturulamadı.']);
        }
    }

    public function edit($id)
    {
        $post = $this->blogModel->getPostById($id);
        $this->renderAdmin('admin/blogs/edit', ['post' => $post]);
    }

    public function update($id)
    {
        $data = [
            'title' => $_POST['title'],
            'slug' => $this->generateSlug($_POST['title']),
            'content' => $_POST['content'],
            'published_at' => $_POST['published_at']
        ];

        if (!empty($_FILES['thumbnail_url']['name'])) {
            $data['thumbnail_url'] = $this->uploadImage();
        }

        if ($this->blogModel->updatePost($id, $data)) {
            header('Location: /admin/blogs');
            exit;
        } else {
            $this->renderAdmin('admin/blogs/edit', ['error' => 'Blog yazısı güncellenemedi.', 'post' => $data]);
        }
    }

    public function delete($id)
    {
        $post = $this->blogModel->getPostById($id);
        if ($this->blogModel->deletePost($id)) {
            if ($post['thumbnail_url']) {
                unlink(__DIR__ . '/../../../public/uploads/blogs/' . basename($post['thumbnail_url']));
            }
            header('Location: /admin/blogs');
            exit;
        } else {
            $this->renderAdmin('admin/blogs/index', ['error' => 'Blog yazısı silinemedi.']);
        }
    }

    private function generateSlug($title)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    }

    private function uploadImage()
    {
        $targetDir = __DIR__ . '/../../../public/uploads/blogs/';
        $fileName = uniqid() . '_' . basename($_FILES['thumbnail_url']['name']);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['thumbnail_url']['tmp_name'], $targetFilePath)) {
            return '/uploads/blogs/' . $fileName;
        }

        return null;
    }
}