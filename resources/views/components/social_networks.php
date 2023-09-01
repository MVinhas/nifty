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