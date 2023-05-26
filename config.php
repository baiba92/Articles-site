<?php declare(strict_types=1);

use ArticlesApp\Repositories\Article\ArticleRepository;
use ArticlesApp\Repositories\Article\PdoArticleRepository;
use ArticlesApp\Repositories\Author\AuthorRepository;
use ArticlesApp\Repositories\Author\JsonPlaceholderAuthorRepository;
use ArticlesApp\Repositories\Comment\CommentRepository;
use ArticlesApp\Repositories\Comment\JsonPlaceholderCommentRepository;

return [
    ArticleRepository::class => DI\create(PdoArticleRepository::class),
    AuthorRepository::class => DI\create(JsonPlaceholderAuthorRepository::class),
    CommentRepository::class => DI\create(JsonPlaceholderCommentRepository::class)
];