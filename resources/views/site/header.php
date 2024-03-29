<body>
<div class="container">
    <header class="blog-header lh-1 py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-4 pt-1">
                <a class="link-secondary" href="#">Subscribe</a>
            </div>
            <div class="col-4 text-center">
                <a class="blog-header-logo text-dark" href="/"><?= getenv('SITENAME') ?></a>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">
                <a class="link-secondary" href="#" aria-label="Search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
                         stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img"
                         viewBox="0 0 24 24">
                        <title>Search</title>
                        <circle cx="10.5" cy="10.5" r="7.5"></circle>
                        <path d="M21 21l-5.2-5.2"></path>
                    </svg>
                </a>
                <?php
                if ($_SESSION !== null && array_key_exists('user', $_SESSION) && is_string($_SESSION['user']->username)) : ?>
                    <span class="d-block">Welcome, <?= $_SESSION['user']->username; ?></span>
                    &nbsp;
                    <a href="/backoffice/admin" role="button">Admin</a>
                <?php
                else : ?>
                    <a class="btn btn-sm btn-outline-secondary " href="/site/login">Sign up</a>
                <?php
                endif; ?>
            </div>
        </div>
    </header>

    <div class="nav-scroller py-1 mb-2">
        <nav class="nav d-flex justify-content-between">
            <?php
            foreach ($data->categories as $category) : ?>
                <a class="p-2 link-secondary" href="/category/<?= $category->slug ?>"><?= $category->name ?></a>
            <?php
            endforeach; ?>
        </nav>
    </div>
</div>