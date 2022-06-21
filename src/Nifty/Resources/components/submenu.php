<div class="collapse" tabindex="0">
    <ul class="navbar-nav">
        <?php foreach ($data->menu ?? (object)[] as $item) : ?>
            <li class="nav-item">
                <a class="nav-link" href="/<?= $item->title; ?>">
                    <?= $item->title ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>