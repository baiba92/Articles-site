<?php declare(strict_types=1);

namespace ArticlesApp\Console\Commands\Author;

use ArticlesApp\Models\Author;
use ArticlesApp\Services\Author\IndexAuthorService;
use ArticlesApp\Services\Author\Show\ShowAuthorService;
use ArticlesApp\Services\Author\Show\ShowAuthorServiceRequest;

class AuthorCommands
{
    public function index(): void
    {
        $service = new IndexAuthorService;
        $authors = $service->execute();

        foreach ($authors as $author) {
            /** @var Author $author */
            (new AuthorCommandResponse($author))->getAuthorContent();
        }
    }

    public function show(AuthorCommandRequest $request): void
    {
        $service = new ShowAuthorService();
        $response = $service->execute(new ShowAuthorServiceRequest($request->getArticleId()));

        $author = new AuthorCommandResponse($response->getAuthor(), $response->getArticles());
        $author->getAuthorContent();
        echo 'Articles:' . PHP_EOL;
        $author->getArticlesContent();
        echo PHP_EOL;
    }
}