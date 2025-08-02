<div class="container my-2">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Bize Ulaşın</h1>
        <i class="fas fa-envelope fa-2x"></i>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h3>İletişim Formu</h3>
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
            <form action="contact/submit-contact" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Adınız</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-posta</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Mesajınız</label>
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-secondary">Gönder</button>
            </form>
        </div>
        <div class="col-md-6">
            <h3>İletişim Bilgileri</h3>
            <p><i class="fas fa-map-marker-alt"></i> <?php echo $settings['contact_address']; ?></p>
            <p><i class="fas fa-phone"></i> Telefon: <?php echo $settings['contact_phone']; ?></p>
            <p><i class="fas fa-envelope"></i> E-posta: <?php echo $settings['contact_email']; ?></p>
            <h3>Harita</h3>
            <iframe src="https://www.google.com/maps/embed?..." width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
    </div>
</div>