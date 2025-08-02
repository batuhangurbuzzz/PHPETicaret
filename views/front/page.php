<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="display-6"><?= htmlspecialchars($page['title']) ?></h1>
        <i class="fas fa-file-alt fa-3x text-secondary"></i>
    </div>
    <hr>

    <div class="row mt-4">
        <div class="col-md-12">
            <p><?= $page['content']; ?></p>
        </div>
    </div>
</div>