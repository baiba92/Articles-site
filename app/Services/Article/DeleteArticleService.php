<?php declare(strict_types=1);

namespace ArticlesApp\Services\Article;

use ArticlesApp\Repositories\Article\PdoArticleRepository;

class DeleteArticleService
{
    private PdoArticleRepository $pdoArticleRepository;

    public function __construct(PdoArticleRepository $pdoArticleRepository)
    {
        $this->pdoArticleRepository = $pdoArticleRepository;
    }

    public function execute(int $id): void
    {
        $this->pdoArticleRepository->delete($id);
    }
}