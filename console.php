<?php declare(strict_types=1);

use ArticlesApp\Console\Console;

require_once __DIR__ . '/vendor/autoload.php';

if (count($argv) > 1) {
    $resource = $argv[1] ?? null;
    $ids = array_slice($argv, 2) ?? null;

    Console::response($resource, $ids);
} else {
    Console::instruction();
}

