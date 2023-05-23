<?php declare(strict_types=1);

namespace ArticlesApp\Console\Commands\Author;

class AuthorCommandRequest
{
    private ?array $authorIds;

    public function __construct(array $authorIds)
    {
        $this->authorIds = $authorIds;
    }

    public function getAuthorIds(): array
    {
        return $this->authorIds;
    }
}