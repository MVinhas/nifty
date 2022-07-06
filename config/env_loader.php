<?php

use Nifty\Env;

require_once __DIR__."/../vendor/autoload.php";
(new Env(__DIR__ . '/../config/.env'))->load();
