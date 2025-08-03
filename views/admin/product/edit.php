<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Ürün Düzenle</h1>
                <a href="/admin/products" class="btn btn-outline-secondary">Geri Dön</a>
            </div>
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php elseif (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/admin/products/update/<?= htmlspecialchars($product['id']) ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="standard_image" class="form-label">Standart Resim</label>
                    <input type="file" class="form-control" id="standard_image" name="standard_image">
                    <input type="hidden" name="current_standard_image" value="<?= htmlspecialchars($product['standard_image']) ?>">
                    <img src="<?= htmlspecialchars($product['standard_image']) ?>" alt="Product Image" class="img-fluid mt-2" style="width: 100px;">
                </div>
                <div class="mb-3">
                    <label for="hover_image" class="form-label">Hover Resim</label>
                    <input type="file" class="form-control" id="hover_image" name="hover_image">
                    <input type="hidden" name="current_hover_image" value="<?= htmlspecialchars($product['hover_image']) ?>">
                    <img src="<?= htmlspecialchars($product['hover_image']) ?>" alt="Product Image" class="img-fluid mt-2" style="width: 100px;">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Ürün İsmi</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="short_description" class="form-label">Kısa Açıklama</label>
                    <textarea class="form-control" id="short_description" name="short_description" rows="3"><?= htmlspecialchars($product['short_description']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category['id']) ?>" <?= $product['category_id'] == $category['id'] ? 'selected' : '' ?>><?= htmlspecialchars($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="stock_quantity" class="form-label">Stok Miktarı</label>
                    <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="<?= htmlspecialchars($product['stock_quantity']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="delivery_date" class="form-label">Teslimat Süresi (Gün)</label>
                    <input type="number" class="form-control" id="delivery_date" name="delivery_date" value="<?= htmlspecialchars($product['delivery_date']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="long_description" class="form-label">Uzun Açıklama</label>
                    <textarea class="form-control" id="long_description" name="long_description" rows="5"><?= htmlspecialchars($product['long_description']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="featured" class="form-label">Öne Çıkan</label>
                    <select class="form-control" id="featured" name="featured" required>
                        <option value="none" <?= $product['featured'] == 'none' ? 'selected' : '' ?>>Yok</option>
                        <option value="featured" <?= $product['featured'] == 'featured' ? 'selected' : '' ?>>Öne Çıkan</option>
                        <option value="bestseller" <?= $product['featured'] == 'bestseller' ? 'selected' : '' ?>>Çok Satan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tag" class="form-label">Etiket</label>
                    <select class="form-control" id="tag" name="tag" required>
                        <option value="new" <?= $product['tag'] == 'new' ? 'selected' : '' ?>>Yeni</option>
                        <option value="campaign" <?= $product['tag'] == 'campaign' ? 'selected' : '' ?>>Kampanya</option>
                        <option value="discount" <?= $product['tag'] == 'discount' ? 'selected' : '' ?>>İndirim</option>
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
        selector: '#long_description',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
        setup: function(editor) {
            editor.on('change', function() {
                editor.save();
            });
        }
    });
</script>