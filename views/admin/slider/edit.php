<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Slider Düzenle</h1>
        <a href="/admin/slider" class="btn btn-outline-secondary">Geri Dön</a>
    </div>
    <div class="row justify-content-center">
        <main class="col-md-8 mb-4" style="max-width: 800px;">

            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/admin/slider/update/<?= htmlspecialchars($slider['id']) ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="image_url" class="form-label">Slider Görseli</label>
                    <input type="file" id="image_url" name="image_url" class="form-control">
                    <img src="<?= htmlspecialchars($slider['image_url']) ?>" alt="Slider Image" class="img-fluid mt-2" style="max-width: 200px;">
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($slider['title']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Açıklama</label>
                    <textarea id="description" name="description" class="form-control" required><?= htmlspecialchars($slider['description']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="link_url" class="form-label">URL</label>
                    <input type="url" id="link_url" name="link_url" class="form-control" value="<?= htmlspecialchars($slider['link_url']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Durum</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="1" <?= $slider['status'] == 1 ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= $slider['status'] == 0 ? 'selected' : '' ?>>Pasif</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="sort_order" class="form-label">Sıra</label>
                    <input type="number" id="sort_order" name="sort_order" class="form-control" value="<?= htmlspecialchars($slider['sort_order']) ?>" required>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-secondary">Güncelle</button>
                </div>
            </form>
        </main>
    </div>
</div>