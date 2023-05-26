<?php declare(strict_types=1);

use ArticlesApp\Controllers\ArticleController;
use ArticlesApp\Controllers\AuthorController;

return [
    ['GET', '/', [ArticleController::class, 'home']],
    ['GET', '/articles', [ArticleController::class, 'index']],
    ['GET', '/article/{id:\d+}', [ArticleController::class, 'show']],
    ['GET', '/article/edit', [ArticleController::class, 'editForm']],
    ['GET', '/articles/create', [ArticleController::class, 'createForm']],
    ['POST', '/article/{id:\d+}', [ArticleController::class, 'edit']],
    ['POST', '/article/create', [ArticleController::class, 'create']],
    ['POST', '/articles', [ArticleController::class, 'delete']],
    ['GET', '/authors', [AuthorController::class, 'index']],
    ['GET', '/author/{id:\d+}', [AuthorController::class, 'show']]
];
