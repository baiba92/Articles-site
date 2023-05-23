<?php declare(strict_types=1);

namespace ArticlesApp\Console\Commands\Article;

class ArticleCommandRequest
{
    private ?array $articleIds;

    public function __construct(array $articleIds)
    {
        $this->articleIds = $articleIds;
    }

    public function getArticleIds(): array
    {
        return $this->articleIds;
    }
}