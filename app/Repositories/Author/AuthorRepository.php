<?php declare(strict_types=1);

namespace ArticlesApp\Repositories\Author;

use ArticlesApp\Models\Author;

interface AuthorRepository
{
    public function fetchAuthors(): array;
    public function fetchSingleAuthor(int $id): ?Author;
}