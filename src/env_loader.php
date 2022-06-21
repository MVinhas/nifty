<?php

use Nifty\Exceptions\SiteException;

require_once __DIR__."/../vendor/autoload.php";
try {
    (new \Nifty\Env(__DIR__ . '/../.env'))->load();
} catch (Exception $e) {
    throw SiteException::EnvNotFound();
}