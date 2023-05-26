<?php declare(strict_types=1);

namespace ArticlesApp\Services\Author;

use ArticlesApp\Repositories\Author\AuthorRepository;

class IndexAuthorService
{
    private AuthorRepository $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function execute(): array
    {
        return $this->authorRepository->fetchAuthors();
    }
}