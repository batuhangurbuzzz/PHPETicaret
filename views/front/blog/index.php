<div class="container my-2">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Blog Makaleleri</h1>
        <i class="fas fa-blog fa-2x"></i>
    </div>
    <div class="row">
        <?php foreach ($posts as $post): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?php echo $post['thumbnail_url']; ?>" class="card-img-tops" alt="<?php echo $post['title']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $post['title']; ?></h5>
                        <p class="card-text"><?php echo substr($post['content'], 0, 100); ?>...</p>
                        <a href="/blog/<?php echo $post['slug']; ?>" class="btn btn-secondary">Devamını Oku</a>
                    </div>
                    <div class="card-footer text-muted">
                        Yayınlanma Tarihi: <?php echo date('d M Y', strtotime($post['published_at'])); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>