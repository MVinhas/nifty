<main class="container">
    <div class="p-4 p-md-5 mb-4 rounded text-bg-dark">
        <div class="col-md-6 px-0">
            <h1 class="display-4 fst-italic"><?= $data->main_post->{0}->title ?></h1>
            <p class="lead my-3"><?= mb_strimwidth($data->main_post->{0}->excerpt, 0, 180, '...'); ?></p>
            <p class="lead mb-0"><a href="/<?= $data->main_post->{0}->slug ?>" class="text-white fw-bold">Continue reading...</a></p>
        </div>
    </div>

    <div class="row mb-2">
        <?php foreach ($data->other_featured_posts as $post) : ?>
        <div class="col-md-6">
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col p-4 d-flex flex-column position-static">
                    <strong class="d-inline-block mb-2 text-primary"><?= $post->category_name ?></strong>
                    <h3 class="mb-0"><?= $post->title ?></h3>
                    <div class="mb-1 text-muted"><?= $post->date ?></div>
                    <p class="card-text mb-auto"><?= mb_strimwidth($post->excerpt, 0, 90, '...'); ?></p>
                    <a href="/<?= $post->slug ?>" class="stretched-link">Continue reading</a>
                </div>
                <div class="col-auto d-none d-lg-block">
                    <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
                    </svg>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="row g-5">
        <div class="col-md-8">
            <h3 class="pb-4 mb-4 fst-italic border-bottom">
                From the Firehose
            </h3>
            <?php foreach ($data->normal_posts as $key => $post) : ?>

            <article class="blog-post mb-5">
                <h2 class="blog-post-title mb-1"><?= $post->title ?></h2>
                <p class="blog-post-meta"><?= $post->date ?> by <a href="#"><?= $post->author ?></a></p>
                <p class="card-text mb-auto"><?= mb_strimwidth($post->excerpt, 0, 90, '...'); ?></p>
                <a href="/<?= $post->slug ?>" class="stretched-link">Continue reading</a>
            </article>
            <?php endforeach; ?>

            <nav class="blog-pagination" aria-label="Pagination">
                <a class="btn btn-outline-primary rounded-pill" href="#">Older</a>
                <a class="btn btn-outline-secondary rounded-pill disabled">Newer</a>
            </nav>

        </div>

        <div class="col-md-4">
            <div class="position-sticky" style="top: 2rem;">
                <div class="p-4 mb-3 bg-light rounded">
                    <h4 class="fst-italic">About</h4>
                    <p class="mb-0"><?= $data->about->content ?></p>
                </div>

                <div class="p-4">
                    <h4 class="fst-italic">Archives</h4>
                    <ol class="list-unstyled mb-0">
                        <li><a href="#">March 2021</a></li>
                        <li><a href="#">February 2021</a></li>
                        <li><a href="#">January 2021</a></li>
                        <li><a href="#">December 2020</a></li>
                        <li><a href="#">November 2020</a></li>
                        <li><a href="#">October 2020</a></li>
                        <li><a href="#">September 2020</a></li>
                        <li><a href="#">August 2020</a></li>
                        <li><a href="#">July 2020</a></li>
                        <li><a href="#">June 2020</a></li>
                        <li><a href="#">May 2020</a></li>
                        <li><a href="#">April 2020</a></li>
                    </ol>
                </div>

                <div class="p-4">
                    <h4 class="fst-italic">Social Networks</h4>
                    <ol class="list-unstyled">
                        <?php foreach ($data->social_networks as $social) :?>
                            <li><a href="<?= $social->url; ?>"><?= $social->name; ?></a></li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>

</main>