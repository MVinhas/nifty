<?php

use Nifty\Exceptions\SiteException;
use Nifty\Env;

require_once __DIR__."/../vendor/autoload.php";
try {
    (new Env(__DIR__ . '/../config/.env'))->load();
} catch (Exception $e) {
    throw SiteException::EnvNotFound();
}