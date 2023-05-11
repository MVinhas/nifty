<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Nifty\Route;

include_once '../config/env_loader.php';
include_once '../config/server.php';

session_start();
if (isset($_SESSION) && $_SESSION['csrf'] === null) {
    $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
}
(new Route())->run();