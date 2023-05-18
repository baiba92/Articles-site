<?php declare(strict_types=1);

namespace ArticlesApp\Console\Commands\Article;

class ArticleCommandRequest
{
    private int $articleId;

    public function __construct(int $articleId)
    {
        $this->articleId = $articleId;
    }

    public function getArticleId(): int
    {
        return $this->articleId;
    }
}