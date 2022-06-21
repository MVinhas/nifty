<?php

include_once 'env_loader.php';
$args = [];
if (isset($argc)) {
    for ($i = 0; $i < $argc; $i++) {
        if ($argv[$i] === '--populate') {
            $args[] = 'populate';
        } elseif ($argv[$i] === '--clean-tables') {
            $args[] = 'cleanTables';
        } elseif ($argv[$i] === '--drop-tables') {
            $args[] = 'dropTables';
        }
    }
}
\Nifty\Migrations::migrate($args);