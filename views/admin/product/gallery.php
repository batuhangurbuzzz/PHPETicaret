<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Ürün Galerisi</h1>
                <a href="/admin/products" class="btn btn-outline-secondary">Geri Dön</a>
            </div>
            <form action="/admin/products/gallery/add" method="post" enctype="multipart/form-data">
                <h4>Ürün Adı: <?= htmlspecialchars($product_name ?? '') ?></h4>
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product_id) ?>">
                <div class="mb-3">
                    <label for="gallery_image" class="form-label">Galeri Resmi</label>
                    <input type="file" class="form-control" id="gallery_image" name="gallery_image" required>
                </div>
                <div class="d-flex justify-content-end mt-4 mb-5">
                    <button type="submit" class="btn btn-secondary">Ekle</button>
                </div>
            </form>
            <div class="row">
                <?php if (empty($gallery_images)): ?>
                    <div class="col-md-12">
                        <div class="alert alert-secondary text-center">Bu ürün için galeri resmi bulunmamaktadır.</div>
                    </div>
                <?php else: ?>
                    <?php foreach ($gallery_images as $image): ?>
                        <div class="col-md-3">
                            <div class="card mb-3">
                                <img src="<?= htmlspecialchars($image['image_path']) ?>" class="card-img-top" alt="...">
                                <div class="card-body text-center">
                                    <form action="/admin/products/gallery/delete" method="post">
                                        <input type="hidden" name="image_path" value="<?= htmlspecialchars($image['image_path']) ?>">
                                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product_id) ?>">
                                        <button type="submit" class="btn btn-secondary btn-sm">Sil</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>