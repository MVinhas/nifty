<?php

use Nifty\Route;

include_once '../config/env_loader.php';
include_once '../config/server.php';

(new Route)->run();
