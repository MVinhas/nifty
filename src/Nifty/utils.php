<?php

function slugify(string $text, string $divider = '-'): string
{
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
    $text = strtolower($text);

    if ($text === '') {
        return 'n-a';
    }

    return $text;
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
    if (getenv('ENVIRONMENT') === 'dev') {
        return error_log($what, 3, $fileFullPath);
    }
    return false;
}

function log_header(): void
{
    $path = $_SERVER['DOCUMENT_ROOT'] . '/../logs/';
    $files = array_filter(scandir($path), fn($item) => !is_dir($path . $item));
    foreach ($files as $file) {
        file_put_contents($path . $file, "===" . date('Y-m-d H:i:s') . "===\n", FILE_APPEND);
    }
}

function d(mixed $data): void
{
    echo "<pre>";
    echo var_dump($data);
    echo "</pre>";
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