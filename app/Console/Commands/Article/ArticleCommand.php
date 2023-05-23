<?php declare(strict_types=1);

namespace ArticlesApp\Console\Commands\Article;

use ArticlesApp\Exceptions\ResourceNotFoundException;
use ArticlesApp\Models\Article;
use ArticlesApp\Services\Article\IndexArticleService;
use ArticlesApp\Services\Article\Show\ShowArticleService;
use ArticlesApp\Services\Article\Show\ShowArticleServiceRequest;

class ArticleCommand
{
    private IndexArticleService $indexArticleService;
    private ShowArticleService $showArticleService;

    public function __construct()
    {
        $this->indexArticleService = new IndexArticleService();
        $this->showArticleService = new ShowArticleService();
    }

    public function execute(ArticleCommandRequest $request): void
    {
        if (empty($request->getArticleIds())) {
            $this->index();
        } else {
            foreach ($request->getArticleIds() as $id) {
                if (!in_array($id, range(1, 100))) {
                    throw new ResourceNotFoundException('Invalid ID');
                } else {
                    $this->show((int) $id);
                }
            }
        }
    }

    private function index(): void
    {
        $articleResponse = $this->indexArticleService->execute();

        foreach ($articleResponse as $article) {
            /** @var Article $article */
            (new ArticleCommandResponse($article))->getArticleContent();
        }
    }

    private function show(int $id): void
    {
        $articleResponse = $this->showArticleService->execute(new ShowArticleServiceRequest($id));

        $article = new ArticleCommandResponse($articleResponse->getArticle(), $articleResponse->getComments());
        $article->getArticleContent();
        $article->getCommentsContent();
    }
}