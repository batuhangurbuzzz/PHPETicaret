<div class="container my-2">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Müşteri Dashboard</h1>
        <i class="fas fa-user-edit fa-2x"></i>
    </div>
    <div class="row">
        <?php include 'sidebar.php'; ?>
        <div class="col-md-8">
            <h2>Siparişlerim</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Sipariş ID</th>
                    <th>Toplam Fiyat</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                    <th>Detay</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['id']) ?></td>
                        <td><?= htmlspecialchars($order['total_price']) ?> TL</td>
                        <td>
                                <span class="badge bg-<?= $order['status'] === 'paid' ? 'success' : ($order['status'] === 'shipped' ? 'info' : ($order['status'] === 'cancelled' ? 'danger' : 'warning')) ?>">
                                    <?= $order['status'] === 'pending' ? 'Siparişiniz Hazırlanıyor' : ($order['status'] === 'paid' ? 'Ödeme Alındı' : ($order['status'] === 'shipped' ? 'Kargolandı' : 'İptal Edildi')) ?>
                                </span>
                        </td>
                        <td><?= htmlspecialchars($order['created_at']) ?></td>
                        <td>
                            <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#orderDetailModal" data-order-id="<?= htmlspecialchars($order['id']) ?>">Detay</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Sipariş Detay Modal -->
<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailModalLabel">Sipariş Detayı</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Ürün ID</th>
                        <th>Ürün İsmi</th>
                        <th>Adet</th>
                        <th>Fiyat</th>
                    </tr>
                    </thead>
                    <tbody id="orderItemsBody">
                    <!-- Sipariş detayları burada yüklenecek -->
                    </tbody>
                </table>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                Teslimat Adresi
                            </div>
                            <div class="card-body" id="deliveryAddress">
                                <!-- Teslimat adresi burada yüklenecek -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                Bilgilendirme
                            </div>
                            <div class="card-body" id="orderStatusInfo">
                                <!-- Sipariş durumu bilgisi burada yüklenecek -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var orderDetailModal = document.getElementById('orderDetailModal');
        orderDetailModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var orderId = button.getAttribute('data-order-id');

            fetch('/order/detail/' + orderId)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Success:', data);
                    var orderItemsBody = document.getElementById('orderItemsBody');
                    orderItemsBody.innerHTML = '';

                    data.items.forEach(function(item) {
                        var row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.product_id}</td>
                            <td>${item.product_name}</td>
                            <td>${item.quantity}</td>
                            <td>${item.price} TL</td>
                        `;
                        orderItemsBody.appendChild(row);
                    });

                    var deliveryAddress = document.getElementById('deliveryAddress');
                    deliveryAddress.innerHTML = `
                        <p><strong>Ad Soyad:</strong> ${data.address.full_name}</p>
                        <p><strong>Telefon:</strong> ${data.address.phone}</p>
                        <p><strong>Adres:</strong> ${data.address.address}, ${data.address.neighborhood}, ${data.address.district}, ${data.address.city}</p>
                    `;

                    var orderStatusInfo = document.getElementById('orderStatusInfo');
                    var statusMessage = '';
                    switch (data.status) {
                        case 'pending':
                            statusMessage = 'Siparişiniz hazırlanıyor. En kısa sürede işleme alınacaktır.';
                            break;
                        case 'paid':
                            statusMessage = 'Ödeme alındı. Siparişiniz işleme alındı.';
                            break;
                        case 'shipped':
                            statusMessage = 'Siparişiniz kargolandı. Kargo takip numaranız ile siparişinizi takip edebilirsiniz.';
                            break;
                        case 'cancelled':
                            statusMessage = 'Siparişiniz iptal edildi. Daha fazla bilgi için bizimle iletişime geçin.';
                            break;
                        default:
                            statusMessage = 'Sipariş durumu bilinmiyor. Lütfen destek ekibimizle iletişime geçin.';
                    }
                    orderStatusInfo.innerHTML = `<p>${statusMessage}</p>`;
                })
                .catch(error => {
                    console.error('Error fetching order details:', error);
                });
        });
    });
</script>