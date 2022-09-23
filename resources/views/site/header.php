<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/"><?= getenv('SITENAME') ?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <?php foreach ($data->menu as $menu) :?>
                        <?php if (!$menu->dropdown) :?>
                        <li class="nav-item">
                            <a class="nav-link" href="/<?= $menu->name ?>"><?= $menu->name ?></a>
                        </li>
                        <?php endif; ?>

                        <?php if ($menu->dropdown) :?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="/<?= $menu->name ?>" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Dropdown
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php if ($menu->new_section) :?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <?php endif; ?>
                                <li><a class="dropdown-item" href="/<?= $menu->name ?>"><?= $menu->name ?></a></li>

                            </ul>
                        </li>
                        <?php endif; ?>
                        <?php if ($menu->disabled) :?>
                        <li class="nav-item">
                            <a class="nav-link disabled"><?= $menu->name ?></a>
                        </li>
                        <?php endif; ?>

                        <?php endforeach; ?>
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>