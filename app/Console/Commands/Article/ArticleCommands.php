<?php declare(strict_types=1);

namespace ArticlesApp\Console\Commands\Article;

use ArticlesApp\Models\Article;
use ArticlesApp\Services\Article\IndexArticleService;
use ArticlesApp\Services\Article\Show\ShowArticleService;
use ArticlesApp\Services\Article\Show\ShowArticleServiceRequest;

class ArticleCommands
{
    public function index(): void
    {
        $service = new IndexArticleService();
        $articles = $service->execute();

        foreach ($articles as $article) {
            /** @var Article $article */
            (new ArticleCommandResponse($article))->getArticleContent();
        }
    }

    public function show(ArticleCommandRequest $request): void
    {
        $service = new ShowArticleService();
        $response = $service->execute(new ShowArticleServiceRequest($request->getArticleId()));

        $article = new ArticleCommandResponse($response->getArticle(), $response->getComments());
        $article->getArticleContent();
        echo 'Comments:' . PHP_EOL;
        $article->getCommentsContent();
        echo PHP_EOL;
    }
}