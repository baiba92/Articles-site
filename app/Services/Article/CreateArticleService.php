<?php declare(strict_types=1);

namespace ArticlesApp\Services\Article;

use ArticlesApp\Repositories\Article\PdoArticleRepository;

class CreateArticleService
{
    private PdoArticleRepository $pdoArticleRepository;
    public function __construct(PdoArticleRepository $pdoArticleRepository)
    {
        $this->pdoArticleRepository = $pdoArticleRepository;
    }

    public function execute(string $title, string $content): void
    {
        $this->pdoArticleRepository->create($title, $content);
    }
}