<div class="container">
    <div class="row">
        <main class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 py-0 px-3">Sipariş Yönetimi</h1>
            </div>
            <div class="container my-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="orderTable" class="table table-bordered table-hover">
                            <thead class="table-light">
                            <tr>
                                <th class="text-center align-middle" style="width: 5%;">#</th>
                                <th class="text-center align-middle" style="width: 15%;">Kullanıcı</th>
                                <th class="text-center align-middle" style="width: 15%;">Toplam Fiyat</th>
                                <th class="text-center align-middle" style="width: 15%;">Durum</th>
                                <th class="text-center align-middle" style="width: 15%;">Tarih</th>
                                <th class="text-center align-middle" style="width: 10%;">Detay</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $index = 0;
                            foreach ($orders as $order):
                                $index++;
                                ?>
                                <tr>
                                    <td class="text-center align-middle"><?= $index ?></td>
                                    <td class="text-center align-middle"><?= htmlspecialchars($order['user_name']) ?></td>
                                    <td class="text-center align-middle"><?= htmlspecialchars($order['total_price']) ?> TL</td>
                                    <td class="text-center align-middle">
                                            <span class="badge bg-<?= $order['status'] === 'paid' ? 'success' : ($order['status'] === 'shipped' ? 'info' : ($order['status'] === 'cancelled' ? 'danger' : 'warning')) ?>">
                                                <?= $order['status'] === 'pending' ? 'Siparişiniz Hazırlanıyor' : ($order['status'] === 'paid' ? 'Ödeme Alındı' : ($order['status'] === 'shipped' ? 'Kargolandı' : 'İptal Edildi')) ?>
                                            </span>
                                    </td>
                                    <td class="text-center align-middle"><?= htmlspecialchars($order['created_at']) ?></td>
                                    <td class="text-center align-middle">
                                        <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#orderDetailModal" data-order-id="<?= htmlspecialchars($order['id']) ?>">Detay</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
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
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                Sipariş Durumunu Güncelle
                            </div>
                            <div class="card-body">
                                <label for="orderStatusSelect">Sipariş Durumunu Güncelle:</label>
                                <select id="orderStatusSelect" class="form-select">
                                    <option value="pending">Siparişiniz Hazırlanıyor</option>
                                    <option value="paid">Ödeme Alındı</option>
                                    <option value="shipped">Kargolandı</option>
                                    <option value="cancelled">İptal Edildi</option>
                                </select>
                                <button id="updateOrderStatusBtn" class="btn btn-primary mt-2">Güncelle</button>
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

            fetch('/admin/orders/detail/' + orderId)
                .then(response => response.json())
                .then(data => {
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
                    switch (data.order.status) {
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

                    var orderStatusSelect = document.getElementById('orderStatusSelect');
                    orderStatusSelect.value = data.order.status;

                    var updateOrderStatusBtn = document.getElementById('updateOrderStatusBtn');
                    updateOrderStatusBtn.onclick = function() {
                        var newStatus = orderStatusSelect.value;
                        fetch('/admin/orders/updateStatus/' + orderId, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                status: newStatus
                            })
                        })
                            .then(response => response.json())
                            .then(result => {
                                if (result.success) {
                                    alert('Sipariş durumu başarıyla güncellendi.');
                                    orderDetailModal.querySelector('.btn-close').click();
                                    location.reload();
                                } else {
                                    alert('Sipariş durumu güncellenirken bir hata oluştu.');
                                }
                            });
                    };
                });
        });

        $('#orderTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/tr.json"
            },
            "ordering": true,
            "columnDefs": [{
                "orderable": false,
                "targets": [0, 3]
            }]
        });
    });
</script>