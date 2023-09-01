<main class="container">
    <div class="p-4 p-md-5 mb-4 rounded text-bg-dark">
        <div class="col-md-6 px-0">
            <h1 class="display-4 fst-italic"><?= $data->main_post->title ?? 'There is no main posts' ?></h1>
            <p class="lead my-3"><?= mb_strimwidth($data->main_post->excerpt ?? 'So there is no excerpt to show', 0, 180, '...'); ?></p>
            <?php if (property_exists($data->main_post, 'slug')) : ?>
                <p class="lead mb-0"><a href="/post/<?= $data->main_post->slug ?>" class="text-white fw-bold">Continue
                    reading...</a></p><?php endif; ?>
        </div>
    </div>

    <div class="row mb-2">
        <?php
        foreach ($data->other_featured_posts as $post) : ?>
            <div class="col-md-6 mb-3 d-flex align-items-stretch">
                <div class="card h-100">
                    <div class="row">
                        <div class="col-md-4 d-flex">
                            <svg class="bd-placeholder-img rounded-start" xmlns="http://www.w3.org/2000/svg" role="img"
                                 aria-label="Placeholder" focusable="false"><title>Placeholder</title>
                                <rect width="100%" height="100%" fill="#20c997"></rect>
                            </svg>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body d-flex flex-column">
                                <strong class="d-inline-block mb-2 text-primary"><?= $post->category_name ?></strong>
                                <h5 class="card-title"><?= $post->title ?></h5>
                                <div class="mb-1 text-muted"><?= $post->date ?></div>
                                <p class="card-text mb-4"><?= mb_strimwidth($post->excerpt, 0, 90, '...'); ?></p>
                                <a href="/post/<?= $post->slug ?>" class="btn btn-primary mt-auto align-self-start">Continue
                                    reading</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        endforeach; ?>
    </div>

    <div class="row g-5">
        <div class="col-md-8">
            <h3 class="pb-4 mb-4 fst-italic border-bottom">
                Latest Articles
            </h3>
            <?php
            if ((array)$data->normal_posts === []) : ?>
                <div class="alert alert-primary mb-4" role="alert">
                    No posts found.
                </div>
            <?php
            else : ?>
                <?php
                foreach ($data->normal_posts as $key => $post) : ?>
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

            <nav class="blog-pagination" aria-label="Pagination">
                <a class="btn rounded-pill
                    <?php
                if ((array)$data->normal_posts === []) {
                    echo ' btn-outline-secondary disabled';
                } else {
                    echo ' btn-outline-primary';
                }
                ?>
                    " href="/?page=<?= $data->next_page ?>">Older</a>
                <a class="btn rounded-pill
                <?php
                if (!array_key_exists('page', $_GET)) {
                    echo ' btn-outline-secondary disabled';
                } else {
                    echo ' btn-outline-primary';
                }
                ?>
                " href="
                <?php
                if (!array_key_exists('page', $_GET) || (int)$_GET['page'] === 1 || (int)$_GET['page'] === 0 || empty((array)$data->normal_posts)) {
                    echo '/#';
                } else {
                    echo "/?page=" . $data->previous_page;
                }
                ?>
                ">
                    Newer
                </a>
            </nav>

        </div>

        <?php include __DIR__ . '/../components/sidebar.php'; ?>
    </div>

</main>