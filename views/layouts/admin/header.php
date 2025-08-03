<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ETİCARETv5-PANEL</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/css/admin-styles.css">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/v/bs5/dt-2.2.1/datatables.min.css" rel="stylesheet">
    <!-- TinyMCE JS -->
    <script src="https://cdn.tiny.cloud/1/mr0zpjbmrda7nkfss1voahfwrxr6b894m86g05vgq998miq3/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
</head>

<body>

<div id="loading">
    <p>Lütfen bekleyiniz...</p>
</div>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/admin" style="line-height: 0.7; margin-top: 10px;">
            ETicaret<span style="font-weight:bold;">V5</span><br>
            <small style="font-size: 0.5em;">Edukey tarafından eğitim amaçlı üretilmiştir.</small>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active text-decoration-none" aria-current="page" href="/admin"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-decoration-none" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cogs"></i> Genel
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item text-decoration-none" href="/admin/settings"><i class="fas fa-cogs"></i> Site Ayarları</a>
                        </li>

                        <li>
                            <a class="dropdown-item text-decoration-none" href="/admin/slider"><i class="fas fa-images"></i> Slider</a>
                        </li>
                        <li>
                            <a class="dropdown-item text-decoration-none" href="/admin/about"><i class="fas fa-building"></i> Kurumsal</a>
                        </li>
                        <li>
                            <a class="dropdown-item text-decoration-none" href="/admin/pages"><i class="fas fa-file-alt"></i> Sayfalar</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-decoration-none" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-shopping-cart"></i> E-Ticaret
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item text-decoration-none" href="/admin/orders"><i class="fas fa-receipt"></i> Siparişler</a>
                        </li>
                        <li>
                            <a class="dropdown-item text-decoration-none" href="/admin/categories"><i class="fas fa-list"></i> Kategoriler</a>
                        </li>

                        <li>
                            <a class="dropdown-item text-decoration-none" href="/admin/products"><i class="fas fa-box"></i> Ürünler</a>
                        </li>

                        <li>
                            <a class="dropdown-item text-decoration-none" href="/admin/deal"><i class="fas fa-tags"></i> Fırsatlar</a>
                        </li>


                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-decoration-none" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-blog"></i> Blog
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item text-decoration-none" href="/admin/blogs"><i class="fas fa-file-alt"></i> Makaleler</a>
                        </li>



                    </ul>
                </li>


            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-decoration-none" href="/" target="_blank">
                        <i class="fas fa-eye"></i> Siteyi Önizle
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-decoration-none" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i> <?php echo $session['user_name']; ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="loginDropdown">
                        <li><a class="dropdown-item text-decoration-none" href="/admin/profile"><i class="fas fa-user"></i> Profilim</a></li>
                        <li><a class="dropdown-item text-decoration-none" href="/logout"><i class="fas fa-sign-out-alt"></i> Çıkış</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Header Finish -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/v/bs5/dt-2.2.1/datatables.min.js"></script>
<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<!-- Admin Script -->
<script src="/js/admin-script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>