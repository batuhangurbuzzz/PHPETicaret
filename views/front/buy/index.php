<div class="container mt-3 mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="display-4">Ödeme İşlemleri</h1>
        <i class="fas fa-credit-card fa-3x text-secondary"></i>
    </div>
    <hr>
    <?php if (isset($success)): ?>
        <div class="alert alert-success" role="alert">
            <?= $success ?>
        </div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= $error ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    <span>Adres <?= $userAddress ? 'Güncelle' : 'Ekle' ?></span>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <form action="/buy/submit" method="POST">
                            <div class="mb-3">
                                <label for="invoiceType" class="form-label">Fatura Türü</label>
                                <select class="form-select" id="invoiceType" name="invoiceType" required>
                                    <option value="individual" <?= $userAddress && $userAddress['invoice_type'] === 'individual' ? 'selected' : '' ?>>Bireysel</option>
                                    <option value="corporate" <?= $userAddress && $userAddress['invoice_type'] === 'corporate' ? 'selected' : '' ?>>Kurumsal</option>
                                </select>
                            </div>
                            <div class="mb-3" id="taxNumberField">
                                <label for="taxNumber" class="form-label" id="taxNumberLabel"><?= $userAddress && $userAddress['invoice_type'] === 'corporate' ? 'Vergi Numarası' : 'TC Kimlik Numarası' ?></label>
                                <input type="text" class="form-control" id="taxNumber" name="taxNumber" value="<?= $userAddress['tax_number'] ?? '' ?>">
                            </div>
                            <div class="mb-3 <?= $userAddress && $userAddress['invoice_type'] === 'corporate' ? '' : 'd-none' ?>" id="taxOfficeField">
                                <label for="taxOffice" class="form-label">Vergi Dairesi</label>
                                <input type="text" class="form-control" id="taxOffice" name="taxOffice" value="<?= $userAddress['tax_office'] ?? '' ?>">
                            </div>
                            <div class="mb-3 <?= $userAddress && $userAddress['invoice_type'] === 'corporate' ? '' : 'd-none' ?>" id="companyNameField">
                                <label for="companyName" class="form-label">Firma İsmi</label>
                                <input type="text" class="form-control" id="companyName" name="companyName" value="<?= $userAddress['company_name'] ?? '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Ad Soyad</label>
                                <input type="text" class="form-control" id="fullName" name="fullName" value="<?= $userAddress['full_name'] ?? '' ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Telefon</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?= $userAddress['phone'] ?? '' ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">İl</label>
                                <input type="text" class="form-control" id="city" name="city" value="<?= $userAddress['city'] ?? '' ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="district" class="form-label">İlçe</label>
                                <input type="text" class="form-control" id="district" name="district" value="<?= $userAddress['district'] ?? '' ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="neighborhood" class="form-label">Mahalle</label>
                                <input type="text" class="form-control" id="neighborhood" name="neighborhood" value="<?= $userAddress['neighborhood'] ?? '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Adres</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required><?= $userAddress['address'] ?? '' ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-secondary"><?= $userAddress ? 'Güncelle' : 'Kaydet' ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    <span>Ödeme</span>
                </div>
                <div class="card-body">
                    <div class="alert alert-secondary" role="alert">
                        Test alışverişi yapmak için aşağıdaki kart bilgilerini kullanabilirsiniz:<br>
                        Kart Numarası: <span id="cardNumber">5890040000000016</span> <button class="btn btn-sm btn-outline-secondary btn-sm" onclick="copyCardNumber()">Kopyala</button><br>
                        Son Kullanma Tarihi: 01/30<br>
                        CVC: 111<br>
                        Ad Soyad alanı için kendi ad ve soyadınızı kullanabilirsiniz.
                    </div>
                    <?php if ($userAddress): ?>
                        <div id="iyzipay-checkout-form" class="responsive">
                            <?= is_array($paymentForm) ? $paymentForm['error'] : $paymentForm ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning" role="alert">
                            Ödeme işlemine geçmek için lütfen adres bilginizi ekleyin.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('invoiceType').addEventListener('change', function(e) {
        var invoiceType = e.target.value;
        var taxNumberField = document.getElementById('taxNumberField');
        var taxNumberLabel = document.getElementById('taxNumberLabel');
        var taxOfficeField = document.getElementById('taxOfficeField');
        var companyNameField = document.getElementById('companyNameField');

        if (invoiceType === 'individual') {
            taxNumberLabel.textContent = 'TC Kimlik Numarası';
            taxNumberField.classList.remove('d-none');
            taxOfficeField.classList.add('d-none');
            companyNameField.classList.add('d-none');
        } else if (invoiceType === 'corporate') {
            taxNumberLabel.textContent = 'Vergi Numarası';
            taxNumberField.classList.remove('d-none');
            taxOfficeField.classList.remove('d-none');
            companyNameField.classList.remove('d-none');
        }
    });

    // Sayfa yüklendiğinde invoiceType'a göre alanları ayarla
    document.addEventListener('DOMContentLoaded', function() {
        var invoiceType = document.getElementById('invoiceType').value;
        var taxNumberLabel = document.getElementById('taxNumberLabel');
        var taxNumberField = document.getElementById('taxNumberField');
        var taxOfficeField = document.getElementById('taxOfficeField');
        var companyNameField = document.getElementById('companyNameField');

        if (invoiceType === 'individual') {
            taxNumberLabel.textContent = 'TC Kimlik Numarası';
            taxNumberField.classList.remove('d-none');
            taxOfficeField.classList.add('d-none');
            companyNameField.classList.add('d-none');
        } else if (invoiceType === 'corporate') {
            taxNumberLabel.textContent = 'Vergi Numarası';
            taxNumberField.classList.remove('d-none');
            taxOfficeField.classList.remove('d-none');
            companyNameField.classList.remove('d-none');
        }

    });

    function copyCardNumber() {
        var cardNumber = document.getElementById('cardNumber').textContent;
        navigator.clipboard.writeText(cardNumber).then(function() {
            alert('Kart numarası kopyalandı: ' + cardNumber);
        }, function(err) {
            console.error('Kart numarası kopyalanamadı: ', err);
        });
    }
</script>