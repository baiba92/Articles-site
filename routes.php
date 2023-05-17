<?php declare(strict_types=1);

use ArticlesApp\Controllers\ArticleController;
use ArticlesApp\Controllers\AuthorController;

return [
    ['GET', '/', [ArticleController::class, 'home']],
    ['GET', '/articles', [ArticleController::class, 'index']],
    ['GET', '/article', [ArticleController::class, 'show']],
    ['GET', '/authors', [AuthorController::class, 'index']],
    ['GET', '/author', [AuthorController::class, 'show']]
];
