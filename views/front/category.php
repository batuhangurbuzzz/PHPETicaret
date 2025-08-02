<div class="container my-2">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Kategori'ye ait ürünler listeleniyor...</h1>
        <i class="fas fa-user-edit fa-2x"></i>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($products)): ?>
                <div class="row">
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="position-relative">
                                    <span class="badge bg-secondary badge-label"><?php echo htmlspecialchars($product['tag'] ?? ''); ?></span>
                                    <span class="badge bg-secondary badge-featured">Öne Çıkan</span>
                                    <span class="badge bg-secondary badge-best-seller"><?php echo htmlspecialchars($product['category_name'] ?? ''); ?></span>
                                    <img src="<?php echo htmlspecialchars($product['standard_image'] ?? ''); ?>" class="card-img-top img-300x300" alt="<?php echo htmlspecialchars($product['name'] ?? ''); ?>">
                                    <img src="<?php echo htmlspecialchars($product['hover_image'] ?? ''); ?>" class="card-img-top hover-img img-300x300" alt="<?php echo htmlspecialchars($product['name'] ?? ''); ?> Hover">
                                    <i class="fas fa-heart favorite-icon" onclick="addToFavorites()"></i>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['name'] ?? ''); ?></h5>
                                    <p class="card-text short-description"><?php echo htmlspecialchars($product['short_description'] ?? ''); ?></p>
                                    <div class="d-flex justify-content-between">
                                        <a href="/product/<?php echo htmlspecialchars($product['slug']); ?>" class="btn btn-secondary">Detaylar</a>
                                        <form action="/cart/add" method="post">
                                            <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-dark"><i class="fas fa-cart-plus"></i> Sepete Ekle</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-center">Ürün bulunamadı.</p>
            <?php endif; ?>
        </div>
    </div>
</div>