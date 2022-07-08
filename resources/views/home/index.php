<main>
<?php foreach ($data->posts as $key => $post) :?>
    <div class="px-4 py-5 my-5 text-center">
        <h1 class="display-5 fw-bold"><?= $post->title ?></h1>
        <div class="col-sm-4 mx-auto mb-4 text-muted">
            Published on <?= $post->date ?>
        </div>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4"><?= $post->excerpt ?></p>
        </div>
    </div>
    <?php if ($key !== $data->last_key) :?>
    <hr>
    <?php endif; ?>
    <?php endforeach; ?>
</main>