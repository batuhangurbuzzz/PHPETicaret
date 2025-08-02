<div class="container my-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3"><?php echo $post['title']; ?></h1>
        <i class="fas fa-blog fa-2x"></i>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <img src="<?php echo $post['thumbnail_url']; ?>" class="img-fluid mb-4 mx-auto d-block" alt="<?php echo $post['title']; ?>">
            <p class="text-muted text-center">Yayınlanma Tarihi: <?php echo date('d M Y', strtotime($post['published_at'])); ?></p>
            <div class="content bg-light p-4 rounded">
                <?php echo $post['content']; ?>
            </div>
        </div>
    </div>
</div>