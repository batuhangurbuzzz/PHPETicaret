<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Hakkımızda Bilgilerini Düzenle</h1>
        <a href="/admin/settings" class="btn btn-outline-secondary">Geri Dön</a>
    </div>
    <div class="row justify-content-center">
        <main class="col-md-8 mb-4" style="max-width: 800px;">

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/admin/about/update" method="POST" enctype="multipart/form-data">
                <!-- Mevcut resimleri gizli alanlar olarak ekleyin -->
                <input type="hidden" name="current_image1" value="<?= htmlspecialchars($about['image1']) ?>">
                <input type="hidden" name="current_image2" value="<?= htmlspecialchars($about['image2']) ?>">
                <div class="mb-3">
                    <label for="vision" class="form-label">Vizyon</label>
                    <textarea id="vision" name="vision" class="form-control" required><?= htmlspecialchars($about['vision']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="mission" class="form-label">Misyon</label>
                    <textarea id="mission" name="mission" class="form-control" required><?= htmlspecialchars($about['mission']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="biography" class="form-label">Biyografi</label>
                    <textarea id="biography" name="biography" class="form-control tinymce" required><?= htmlspecialchars($about['biography']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="image1" class="form-label">Resim 1</label>
                    <input type="file" id="image1" name="image1" class="form-control">
                    <img src="<?= htmlspecialchars($about['image1']) ?>" alt="About Image 1" class="img-fluid mt-2" style="max-width: 200px;">
                </div>
                <div class="mb-3">
                    <label for="image2" class="form-label">Resim 2</label>
                    <input type="file" id="image2" name="image2" class="form-control">
                    <img src="<?= htmlspecialchars($about['image2']) ?>" alt="About Image 2" class="img-fluid mt-2" style="max-width: 200px;">
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-secondary">Güncelle</button>
                </div>
            </form>
        </main>
    </div>
</div>
<script>
    tinymce.init({
        selector: 'textarea.tinymce',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
    });
</script>