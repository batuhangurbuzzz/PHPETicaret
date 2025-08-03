<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Blog Yazısını Düzenle</h1>
        <a href="/admin/blogs" class="btn btn-outline-secondary">Geri Dön</a>
    </div>
    <div class="row justify-content-center">
        <main class="col-md-8 mb-4" style="max-width: 800px;">

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/admin/blogs/update/<?= htmlspecialchars($post['id']) ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="thumbnail_url" class="form-label">Kapak Resmi</label>
                    <input type="file" id="thumbnail_url" name="thumbnail_url" class="form-control">
                    <img src="<?= htmlspecialchars($post['thumbnail_url']) ?>" alt="Blog Thumbnail" class="img-fluid mt-2" style="max-width: 200px;">
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($post['title']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">İçerik</label>
                    <textarea id="content" name="content" class="form-control" required><?= htmlspecialchars($post['content']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="published_at" class="form-label">Yayınlanma Tarihi</label>
                    <input type="datetime-local" id="published_at" name="published_at" class="form-control" value="<?= htmlspecialchars($post['published_at']) ?>" required>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-secondary">Güncelle</button>
                </div>
            </form>
        </main>
    </div>
</div>