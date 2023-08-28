<main class="container">
    <div class="p-4 p-md-5 mb-4 rounded text-bg-dark">
        <div class="col-md-6 px-0">
            <h1 class="display-4 fst-italic"><?= $data->main_post->title ?? 'There is no main posts' ?></h1>
            <p class="lead my-3"><?= mb_strimwidth($data->main_post->excerpt ?? 'So there is no excerpt to show', 0, 180, '...'); ?></p>
            <?php if (isset($data->main_post->slug)) : ?>
                <p class="lead mb-0"><a href="/post/index/<?= $data->main_post->slug ?>" class="text-white fw-bold">Continue
                    reading...</a></p><?php endif; ?>
        </div>
    </div>

    <div class="row mb-2">
        <?php
        foreach ($data->other_featured_posts as $post) : ?>
            <div class="col-md-6">
                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <strong class="d-inline-block mb-2 text-primary"><?= $post->category_name ?></strong>
                        <h3 class="mb-0"><?= $post->title ?></h3>
                        <div class="mb-1 text-muted"><?= $post->date ?></div>
                        <p class="card-text mb-auto"><?= mb_strimwidth($post->excerpt, 0, 90, '...'); ?></p>
                        <a href="/post/index/<?= $post->slug ?>">Continue reading</a>
                    </div>
                    <div class="col-auto d-none d-lg-block p-4">
                        <img src="https://via.placeholder.com/200x250.png"/></text>
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
                        <a href="/post/index/<?= $post->slug ?>">Continue reading</a>
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
                if (!isset($_GET['page'])) {
                    echo ' btn-outline-secondary disabled';
                } else {
                    echo ' btn-outline-primary';
                }
                ?>
                " href="
                <?php
                if (
                    !isset($_GET['page'])
                    ||
                    (int)$_GET['page'] === 1
                    ||
                    (int)$_GET['page'] === 0
                    ||
                    empty((array)$data->normal_posts)
                ) {
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

        <div class="col-md-4">
            <div class="position-sticky" style="top: 2rem;">
                <div class="p-4 mb-3 bg-light rounded">
                    <h4 class="fst-italic">About</h4>
                    <p class="mb-0"><?= $data->about->content ?? 'No "About" content to show' ?></p>
                </div>

                <div class="p-4">
                    <h4 class="fst-italic">Archives</h4>
                    <ol class="list-unstyled mb-0">
                        <?php
                        foreach ($data->archive as $date) : ?>
                            <li>
                                <a href="/posts/<?= $date->year . '/' . $date->month ?>"><?= $date->date ?></a><?= ' (' . $date->total . ')' ?>
                            </li>
                        <?php
                        endforeach; ?>
                    </ol>
                </div>

                <div class="p-4">
                    <h4 class="fst-italic">Social Networks</h4>
                    <ol class="list-unstyled">
                        <?php
                        foreach ($data->social_networks as $social) : ?>
                            <li><a href="<?= $social->url; ?>"><?= $social->name; ?></a></li>
                        <?php
                        endforeach; ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>

</main>