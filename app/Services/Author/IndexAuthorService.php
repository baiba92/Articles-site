<?php declare(strict_types=1);

namespace ArticlesApp\Services\Author;

use ArticlesApp\Repositories\Author\AuthorRepository;
use ArticlesApp\Repositories\Author\JsonPlaceholderAuthorRepository;

class IndexAuthorService
{
    private AuthorRepository $authorRepository;

    public function __construct()
    {
        $this->authorRepository = new JsonPlaceholderAuthorRepository();
    }

    public function execute(): array
    {
        return $this->authorRepository->fetchAuthors();
    }
}