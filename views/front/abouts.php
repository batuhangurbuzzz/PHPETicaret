<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="display-6">Kurumsal</h1>
        <i class="fas fa-building fa-3x text-secondary"></i>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Vizyonumuz</h2>
                    <p class="card-text"><?= $about['vision']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Misyonumuz</h2>
                    <p class="card-text"><?= $about['mission']; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <h2>Firmamızın Özgeçmişi</h2>
            <p><?= $about['biography']; ?></p>
            <div class="clearfix">
                <img src="<?= $about['image1']; ?>" class="col-md-4 float-md-end mb-3 ms-md-3 img-fluid rounded" alt="Firmamız">
                <p><?= $about['biography']; ?></p>
            </div>
            <div class="clearfix">
                <img src="<?= $about['image2']; ?>" class="col-md-4 float-md-start mb-3 me-md-3 img-fluid rounded" alt="Ekibimiz">
                <p><?= $about['biography']; ?></p>
            </div>
        </div>
    </div>
</div>