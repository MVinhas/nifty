<main class="container">

    <div class="row g-5">
        <div class="col-md-8">
            <h3 class="pb-4 mb-4 fst-italic border-bottom">
                Latest Articles
            </h3>
            <?php
            if ((array)$data->posts === []) : ?>
                <div class="alert alert-primary mb-4" role="alert">
                    No posts found.
                </div>
            <?php
            else : ?>
                <?php
                foreach ($data->posts as $key => $post) : ?>
                    <article class="blog-post mb-5">
                        <h2 class="blog-post-title mb-1"><?= $post->title ?></h2>
                        <p class="blog-post-meta"><?= $post->date ?> by <a href="#"><?= $post->author ?></a></p>
                        <p class="card-text mb-auto"><?= $post->excerpt; ?></p>
                        <a href="/post/<?= $post->slug ?>">Continue reading</a>
                    </article>
                <?php
                endforeach; ?>
            <?php
            endif; ?>

        </div>
        <?php include __DIR__ . '/../components/sidebar.php'; ?>
    </div>

</main>