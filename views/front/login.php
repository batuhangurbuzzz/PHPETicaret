<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <ul class="nav nav-tabs justify-content-center mb-3" id="loginTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="login-tab" href="/login" role="tab" aria-controls="login" aria-selected="true">
                                Giriş yap
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="register-tab" href="/register" role="tab" aria-controls="register" aria-selected="false">
                                Üye ol
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="loginTabContent">
                        <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                            <form method="POST" action="/login/submit">
                                <div class="mb-3">
                                    <input type="email" class="form-control" name="email" placeholder="E-posta adresi" value="course@emrahyuksel.com.tr" required>
                                </div>
                                <div class="mb-3 position-relative">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Şifre" value="111111" required>
                                    <i class="fas fa-eye position-absolute" id="togglePassword" style="top: 12px; right: 15px; cursor: pointer;"></i>
                                </div>
                                <?php if (isset($error)): ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                <?php endif; ?>
                                <div class="mb-3 text-end">
                                    <a href="#" class="text-decoration-none text-secondary">Şifremi unuttum</a>
                                </div>
                                <button type="submit" class="btn btn-secondary w-100">Giriş yap</button>
                            </form>
                            <div class="separator">veya</div>
                            <button class="btn btn-outline-secondary w-100 mb-2" type="button" onclick="showApiKeyAlert()">Cep Telefonu ile Giriş Yap</button>
                            <button class="btn btn-outline-secondary w-100" type="button" onclick="showApiKeyAlert()">Mail ile Giriş Yap</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showApiKeyAlert() {
        alert("API KEY'ler girilmemiş. Lütfen sistem yöneticinizle iletişime geçin.");
    }

    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
</script>