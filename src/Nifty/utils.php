<?php

function slugify(string $text, string $divider = '-'): string
{
    if ($text === '') {
        return 'n-' . time() + rand(0, 1000) . '-a';
    }

    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    return strtolower($text);
}

function arrayKeysToQueryFields(array|null $array): string
{
    $keys = [];
    foreach ($array as $key => $value) {
        $keys[] = "$key = :" . $key;
    }
    return implode(',', $keys);
}

function arrayValuesToQueryParams(array|null $array): array
{
    $values = [];
    foreach ($array as $key => $value) {
        $values[':' . $key] = $value;
    }
    return $values;
}

function _postSanitized(): array
{
    return array_map('htmlspecialchars', $_POST);
}

function log_to_file(string $what, string $file): bool
{
    $fileFullPath = $_SERVER['DOCUMENT_ROOT'] . '/../logs/' . $file;
    if (str_starts_with(php_sapi_name(), 'cli')) {
        $fileFullPath = '../logs/' . $file;
    }

    if (valid_file($fileFullPath) && getenv('ENVIRONMENT') === 'dev') {
        return error_log($what, 3, $fileFullPath);
    }
    return false;
}

function log_header(): void
{
    $path = $_SERVER['DOCUMENT_ROOT'] . '../logs/';
    if (str_starts_with(php_sapi_name(), 'cli')) {
        $path = '../logs/';
    }
    if (!is_dir($path)) {
        mkdir($path);
    }
    $files = array_filter(scandir($path), fn($item) => !is_dir($path . $item));
    foreach ($files as $file) {
        file_put_contents($path . $file, "===" . date('Y-m-d H:i:s') . "===\n", FILE_APPEND);
    }
}

function d(mixed $data): void
{
    echo "<pre><code>";
    echo var_dump($data);
    echo "</code></pre>";
}

function dd(mixed $data, bool $return = false)
{
    if ($return) {
        log_to_file(print_r($data, true), '.dd');
        return true;
    }
    d($data);
    die();
}

/*
 * Check if log file exists.
 * If not, creates one
 * If it exists, but it was not created today, it's emptied
 * For now, we don't want to keep old logs
 */
function valid_file(string $fileFullPath): bool
{
    if (!file_exists($fileFullPath)) {
        return touch($fileFullPath);
    } else {
        if (date('Y-m-d') > date('Y-m-d', filemtime($fileFullPath))) {
            if (!unlink($fileFullPath)) {
                return false;
            }
            return touch($fileFullPath);
        }
    }
    return true;
}