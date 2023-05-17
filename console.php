<?php declare(strict_types=1);

use ArticlesApp\Services\Article\IndexArticleService;

require_once __DIR__ . '/vendor/autoload.php';

$resource = $argv[1] ?? null;
$id = $argv[2] ?? null;

switch ($resource) {
    case 'articles':

        if ($id != null) {
            // show service
        } else {
            // index service
        }

        break;
    case 'authors':

        if ($id != null) {
            // show service
        } else {
            // index service
        }

        break;
    default:
        echo 'Invalid resource/command provided';
        break;
}