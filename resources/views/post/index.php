<main class="container">
    <div class="row g-5">
        <div class="col-md-8">
            <article class="blog-post mb-5">
                <h2 class="blog-post-title mb-1"><?= $data->title ?></h2>
                <p class="blog-post-meta"><?= $data->date ?> by <a href="#"><?= $data->author ?></a></p>
                <p class="card-text mb-auto"><?= $data->content; ?></p>
            </article>
        </div>
        <?php include __DIR__ . '/../components/sidebar.php'; ?>
    </div>
</main>