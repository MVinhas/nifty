<?php

require_once __DIR__."/../vendor/autoload.php";

use Nifty\Route;

include_once '../config/env_loader.php';
include_once '../config/server.php';

session_start();
(new Route())->run();