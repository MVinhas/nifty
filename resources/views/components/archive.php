<div class="p-4">
    <h4 class="fst-italic">Archives</h4>
    <ol class="list-unstyled mb-0">
        <?php
        foreach ($data->archive as $date) : ?>
            <li>
                <a href="/post/<?= $date->year . '/' . $date->month ?>"><?= $date->date ?></a><?= ' (' . $date->total . ')' ?>
            </li>
        <?php
        endforeach; ?>
    </ol>
</div>