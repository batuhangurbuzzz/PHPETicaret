<div class="container mt-3 mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="display-6">Sepetim</h1>
        <i class="fas fa-credit-card fa-3x text-secondary"></i>
    </div>
    <hr>
    <div class="d-flex justify-content-end mb-2">
        <span id="shipping-badge" class="badge bg-secondary"></span>
    </div>
    <table class="table table-bordered cart-table">
        <thead>
        <tr>
            <th>Ürün</th>
            <th>Adet</th>
            <th>Fiyat</th>
            <th>Toplam</th>
            <th>İşlem</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($cartItems)): ?>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>
                        <form action="/cart/decreaseQuantity" method="post" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($item['product_id']); ?>">
                            <button type="submit" class="btn btn-sm btn-outline-secondary">-</button>
                        </form>
                        <span class="mx-2"><?php echo htmlspecialchars($item['quantity']); ?></span>
                        <form action="/cart/increaseQuantity" method="post" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($item['product_id']); ?>">
                            <button type="submit" class="btn btn-sm btn-outline-secondary">+</button>
                        </form>
                    </td>
                    <td><?php echo htmlspecialchars($item['price']); ?> TL</td>
                    <td class="total-price"><?php echo htmlspecialchars($item['price'] * $item['quantity']); ?> TL</td>
                    <td>
                        <form action="/cart/remove" method="post">
                            <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($item['product_id']); ?>">
                            <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">Sepetinizde ürün bulunmamaktadır.</td>
            </tr>
        <?php endif; ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3" class="text-end fw-bold">Genel Toplam</td>
            <td id="grand-total">
                <?php
                $total = 0;
                foreach ($cartItems as $item) {
                    $total += $item['price'] * $item['quantity'];
                }
                echo $total . ' TL';
                ?>
            </td>
            <td></td>
        </tr>
        </tfoot>
    </table>
    <div class="row justify-content-end mb-3">

    </div>
    <div class="d-flex justify-content-end">
        <a href="/" class="btn btn-secondary me-2">Alışverişe Devam Et</a>
        <a href="#" id="complete-purchase" class="btn btn-secondary">Alışverişi Tamamla</a>
    </div>
</div>

<script>
    document.getElementById('complete-purchase').addEventListener('click', function(event) {
        var cartItems = <?php echo json_encode($cartItems); ?>;
        if (cartItems.length === 0) {
            event.preventDefault();
            alert('Sepetiniz Boş');
        } else {
            window.location.href = '/buy';
        }
    });
</script>