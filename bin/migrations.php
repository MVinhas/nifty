<?php

include_once '../config/env_loader.php';
$args = [];
if ($argc > 0) {
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
(new \Nifty\Migrations())->migrate($args);
