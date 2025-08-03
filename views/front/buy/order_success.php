<div class="container mt-20 mb-5">
    <div style="margin-top:120px !important; margin-bottom:170px !important" class="d-flex flex-column align-items-center mt-20 mb-5">
        <i class="fas fa-check-circle fa-5x text-success mb-3"></i>
        <h1 class="display-4 text-center">Ödeme Başarılı!</h1>
        <p class="lead text-center">Siparişiniz başarıyla tamamlandı.</p>
        <p class="text-center">Sipariş Numaranız: <strong><?= htmlspecialchars($conversationId) ?></strong></p>
        <div class="d-flex justify-content-center mt-3">
            <a href="/" class="btn btn-secondary me-2">Alışverişe Devam Et</a>
            <a href="/order" class="btn btn-secondary">Siparişlerim</a>
        </div>
    </div>
</div>