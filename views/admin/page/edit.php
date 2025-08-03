<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Sayfa Düzenle</h1>
                <a href="/admin/pages" class="btn btn-outline-secondary">Geri Dön</a>
            </div>
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php elseif (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/admin/pages/update/<?= htmlspecialchars($page['id']) ?>" method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($page['title']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">İçerik</label>
                    <textarea class="form-control" id="content" name="content" rows="5"><?= htmlspecialchars($page['content']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Durum</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="draft" <?= $page['status'] == 'draft' ? 'selected' : '' ?>>Taslak</option>
                        <option value="published" <?= $page['status'] == 'published' ? 'selected' : '' ?>>Yayınlandı</option>
                    </select>
                </div>
                <div class="d-flex justify-content-end mt-4 mb-5">
                    <button type="submit" class="btn btn-secondary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    tinymce.init({
        selector: '#content',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
        setup: function(editor) {
            editor.on('change', function() {
                editor.save();
            });
        }
    });
</script>