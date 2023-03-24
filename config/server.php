<?php

require_once '../src/Nifty/utils.php';
if (getenv('ENVIRONMENT') === 'dev') {
    ini_set("display_errors", "On");
    ini_set("error_prepend_string", "<div class='debug'>");
    ini_set("error_append_string", "</div>");
    error_reporting(E_ALL);
    log_header();
}