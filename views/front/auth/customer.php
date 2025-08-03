<div class="container my-2">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Müşteri Dashboard</h1>
        <i class="fas fa-user-edit fa-2x"></i>
    </div>
    <div class="row">
        <?php include 'sidebar.php'; ?>
        <div class="col-md-8">
            <div class="form-container mx-auto" style="max-width: 500px;">
                <h4 class="mb-3">Şifre Güncelleme</h4>
                <p class="mb-4">Şifrenizi güncellemek için aşağıdaki formu doldurun.</p>
                <?php if (isset($success)): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <form action="/auth/updatePasswordFront" method="POST">
                    <div class="form-group mb-3">
                        <label for="current_password">Mevcut Şifre</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="new_password">Yeni Şifre</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="confirm_password">Yeni Şifre (Tekrar)</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-secondary">Şifre Güncelle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>