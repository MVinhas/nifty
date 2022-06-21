<body>
    <nav class="mainNav">
        <a class="brand" href="#">
            <span class="sitename"><?= getenv('SITENAME'); ?></span>
            <?php if ($data->user->logged_in ?? false) : ?> 
            <span class="sitelogo">
                <img class="img-profile" src="/assets/avatar.svg" alt="My Profile Picture">
            </span>
            <?php endif; ?>
        </a>
        <button class="toggler" type="button">
            <span class="toggler-icon"></span>
        </button>
        <?php include_once 'app/Nifty/Resources/components/submenu.php'; ?>
    </nav>