<div class="col-md-3">
    <div class="card d-none d-md-block">
        <div class="card-header">
            <h4 class="mb-0">Menü</h4>
        </div>
        <div class="list-group list-group-flush">
            <a href="/customer" class="list-group-item list-group-item-action <?php echo $currentUrl == '/customer' ? 'bg-secondary text-white' : ''; ?>">Profilim</a>
            <a href="/order" class="list-group-item list-group-item-action <?php echo $currentUrl == '/order' ? 'bg-secondary text-white' : ''; ?>">Siparişlerim</a>
            <a href="/logout" class="list-group-item list-group-item-action <?php echo $currentUrl == '/logout' ? 'bg-secondary text-white' : ''; ?>">Çıkış Yap</a>
        </div>
    </div>
    <div class="d-block d-md-none my-3">
        <select class="form-select" onchange="location = this.value;">
            <option value="/customer" <?php echo $currentUrl == '/customer' ? 'selected' : ''; ?>>Profilim</option>
            <option value="/order" <?php echo $currentUrl == '/order' ? 'selected' : ''; ?>>Siparişlerim</option>
            <option value="/logout" <?php echo $currentUrl == '/logout' ? 'selected' : ''; ?>>Çıkış Yap</option>
        </select>
    </div>
</div>