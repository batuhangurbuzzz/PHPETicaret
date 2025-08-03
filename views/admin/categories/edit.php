<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Kategori Düzenle</h1>
        <a href="/admin/categories" class="btn btn-outline-secondary">Geri Dön</a>
    </div>
    <div class="row justify-content-center">
        <main class="col-md-8 mb-4" style="max-width: 800px;">

            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/admin/categories/update/<?= htmlspecialchars($category['id']) ?>" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">İsim</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($category['name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="icon" class="form-label">İkon</label>
                    <input type="text" id="icon" name="icon" class="form-control" value="<?= htmlspecialchars($category['icon']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Açıklama</label>
                    <textarea id="description" name="description" class="form-control" required><?= htmlspecialchars($category['description']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Durum</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="1" <?= $category['status'] == 1 ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= $category['status'] == 0 ? 'selected' : '' ?>>Pasif</option>
                    </select>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-secondary">Güncelle</button>
                </div>
            </form>
        </main>
    </div>
</div>