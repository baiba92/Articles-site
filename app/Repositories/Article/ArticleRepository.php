<?php declare(strict_types=1);

namespace ArticlesApp\Repositories\Article;

use ArticlesApp\Models\Article;

interface ArticleRepository
{
    public function fetchAllArticles(): array;
    public function fetchArticlesByAuthorId(int $authorId): array;
    public function fetchSingleArticle(int $id): ?Article;
}