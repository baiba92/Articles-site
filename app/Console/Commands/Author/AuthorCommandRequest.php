<?php declare(strict_types=1);

namespace ArticlesApp\Console\Commands\Author;

class AuthorCommandRequest
{
    private int $authorId;

    public function __construct(int $authorId)
    {
        $this->authorId = $authorId;
    }

    public function getArticleId(): int
    {
        return $this->authorId;
    }
}