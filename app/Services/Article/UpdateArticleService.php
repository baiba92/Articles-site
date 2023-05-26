<?php declare(strict_types=1);

namespace ArticlesApp\Services\Article;

use ArticlesApp\Repositories\Article\PdoArticleRepository;

class UpdateArticleService
{
    private PdoArticleRepository $pdoArticleRepository;
    public function __construct(PdoArticleRepository $pdoArticleRepository)
    {
        $this->pdoArticleRepository = $pdoArticleRepository;
    }

    public function execute(int $id, string $title, string $content): void
    {
        $this->pdoArticleRepository->update($id, $title, $content);
    }
}