<?php declare(strict_types=1);

namespace ArticlesApp\Controllers;

use ArticlesApp\Core\View;
use ArticlesApp\Exceptions\ResourceNotFoundException;
use ArticlesApp\Services\Author\IndexAuthorService;
use ArticlesApp\Services\Author\Show\ShowAuthorService;
use ArticlesApp\Services\Author\Show\ShowAuthorServiceRequest;

class AuthorController
{
    private IndexAuthorService $indexAuthorService;
    private ShowAuthorService $showAuthorService;

    public function __construct
    (
        IndexAuthorService $indexAuthorService,
        ShowAuthorService $showAuthorService
    )
    {
        $this->indexAuthorService = $indexAuthorService;
        $this->showAuthorService = $showAuthorService;
    }


    public function index(): View
    {
        $authors = $this->indexAuthorService->execute();

        return new View('authors', [
            'authors' => $authors
        ]);
    }

    public function show(): View
    {
        try {
            $authorId = (int)$_GET['authorId'];
            $response = $this->showAuthorService->execute(new ShowAuthorServiceRequest($authorId));

            return new View('singleAuthor', [
                'author' => $response->getAuthor(),
                'articles' => $response->getArticles()
            ]);
        } catch (ResourceNotFoundException $exception) {
            //return new View ('notFound', []);
        }
    }
}