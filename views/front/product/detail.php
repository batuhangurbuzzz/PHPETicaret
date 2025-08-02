<div class="container mt-5">
    <div class="row">
        <div class="col-md-5">
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?php echo $product['standard_image']; ?>" class="d-block w-100" alt="Ürün Resmi 1">
                    </div>
                    <div class="carousel-item">
                        <img src="<?php echo $product['hover_image']; ?>" class="d-block w-100" alt="Ürün Resmi 2">
                    </div>
                    <?php foreach ($galleryImages as $index => $image): ?>
                        <div class="carousel-item">
                            <img src="<?php echo $image['image_path']; ?>" class="d-block w-100" alt="Ürün Resmi <?php echo $index + 3; ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Önceki</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Sonraki</span>
                </button>
            </div>
            <div class="mt-3">
                <div class="d-flex justify-content-center">
                    <img src="<?php echo $product['standard_image']; ?>" class="img-thumbnail me-1" alt="Ürün Resmi 1" data-bs-target="#productCarousel" data-bs-slide-to="0" style="width: 100px; height: 100px;">
                    <img src="<?php echo $product['hover_image']; ?>" class="img-thumbnail me-1" alt="Ürün Resmi 2" data-bs-target="#productCarousel" data-bs-slide-to="1" style="width: 100px; height: 100px;">
                    <?php foreach ($galleryImages as $index => $image): ?>
                        <img src="<?php echo $image['image_path']; ?>" class="img-thumbnail me-1" alt="Ürün Resmi <?php echo $index + 3; ?>" data-bs-target="#productCarousel" data-bs-slide-to="<?php echo $index + 2; ?>" style="width: 100px; height: 100px;">
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <?php
            $product = $data['product'];
            $galleryImages = $data['galleryImages'];
            $settings = $data['settings'];
            $cargo = isset($settings['cargo']) ? json_decode($settings['cargo'], true) : [];
            $campaign_01 = isset($settings['campaign_01']) ? json_decode($settings['campaign_01'], true) : [];
            $campaign_02 = isset($settings['campaign_02']) ? json_decode($settings['campaign_02'], true) : [];
            $formatter = new \IntlDateFormatter('tr_TR', \IntlDateFormatter::FULL, \IntlDateFormatter::NONE);
            $formatter->setPattern('d MMMM EEEE');
            $deliveryDate = $formatter->format(strtotime('+' . $product['delivery_date'] . ' days'));
            ?>
            <h1><?php echo $product['name']; ?></h1>
            <p><?php echo $product['short_description']; ?></p>
            <p>Fiyat: <?php echo $product['price']; ?> TL</p>

            <p>
                4.5
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <span class="text-muted">(13 değerlendirme)</span>
            </p>
            <p class="text-secondary">
                <i class="fas fa-check-circle"></i> Stok Durumu: : <?php echo $product['stock_quantity'] > 0 ? 'Mevcut' : 'Tükendi'; ?>
            </p>
            </p>
            <form action="/cart/add" method="post">
                <div class="mb-3" style="max-width: 120px;">
                    <label for="productQuantity" class="form-label">Adet Seçimi</label>
                    <div class="input-group">
                        <button class="btn btn-outline-secondary" type="button" id="button-decrement">-</button>
                        <input type="text" class="form-control text-center" id="productQuantity" name="quantity" value="1" min="1" readonly>
                        <button class="btn btn-outline-secondary" type="button" id="button-increment">+</button>
                    </div>
                </div>
                <input type="hidden" name="user_id" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>"> <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <button type="submit" class="btn btn-secondary me-2"><i class="fas fa-shopping-cart"></i> Sepete Ekle</button>
                <button type="button" class="btn btn-outline-secondary"><i class="fas fa-heart"></i> Favorilere Ekle</button>
            </form>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Teslimat Seçenekleri</h5>
                    <p class="card-text"><i class="fas fa-shipping-fast"></i> Tahmini <?php echo $deliveryDate; ?> günü kargoda</p>
                    <p class="card-text"><?php echo isset($cargo['delivery_text']) ? $cargo['delivery_text'] : 'Standart Teslimat'; ?></p>
                    <img src="<?php echo isset($cargo['carrier_logo']) ? $cargo['carrier_logo'] : 'https://place-hold.it/100x50?text=Kargo+Firma'; ?>" alt="Kargo Firması Logosu" class="rounded">
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <h5>Kampanyalar</h5>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo isset($campaign_01['campaign_name']) ? $campaign_01['campaign_name'] : ''; ?></h5>
                    <p class="card-text"><?php echo isset($campaign_01['description']) ? $campaign_01['description'] : ''; ?></p>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo isset($campaign_02['campaign_name']) ? $campaign_02['campaign_name'] : ''; ?></h5>
                    <p class="card-text"><?php echo isset($campaign_02['description']) ? $campaign_02['description'] : ''; ?></p>
                </div>
            </div>
            <div class="card mb-3">
                <img src="https://place-hold.it/300x150?text=Kampanya+Görseli" class="card-img-top" alt="Kampanya Görseli">
            </div>
        </div>
    </div>

    <div class="mt-5 mb-5">
        <ul class="nav nav-tabs" id="productTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Açıklama</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Yorumlar</button>
            </li>
        </ul>
        <div class="tab-content" id="productTabContent">
            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                <h2>Ürün Açıklaması</h2>
                <p><?php echo $product['long_description']; ?></p>
            </div>
            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                <h2>Ürün Yorumları</h2>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Kullanıcı 1</h5>
                        <p class="card-text">Bu ürünü çok beğendim, gerçekten kaliteli ve kullanışlı.</p>
                        <p class="card-text">
                            <small class="text-muted">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </small>
                        </p>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Kullanıcı 2</h5>
                        <p class="card-text">Fiyatına göre oldukça iyi bir ürün, tavsiye ederim.</p>
                        <p class="card-text">
                            <small class="text-muted">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </small>
                        </p>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Kullanıcı 3</h5>
                        <p class="card-text">Ürün beklentilerimi karşıladı, hızlı kargo için teşekkürler.</p>
                        <p class="card-text">
                            <small class="text-muted">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="far fa-star"></i>
                            </small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('button-decrement').addEventListener('click', function() {
        var quantityInput = document.getElementById('productQuantity');
        var currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });

    document.getElementById('button-increment').addEventListener('click', function() {
        var quantityInput = document.getElementById('productQuantity');
        quantityInput.value = parseInt(quantityInput.value) + 1;
    });
</script>