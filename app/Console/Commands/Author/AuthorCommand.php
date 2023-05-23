<?php declare(strict_types=1);

namespace ArticlesApp\Console\Commands\Author;

use ArticlesApp\Exceptions\ResourceNotFoundException;
use ArticlesApp\Models\Author;
use ArticlesApp\Services\Author\IndexAuthorService;
use ArticlesApp\Services\Author\Show\ShowAuthorService;
use ArticlesApp\Services\Author\Show\ShowAuthorServiceRequest;

class AuthorCommand
{
    private IndexAuthorService $indexAuthorService;
    private ShowAuthorService $showAuthorService;

    public function __construct()
    {
        $this->indexAuthorService = new IndexAuthorService();
        $this->showAuthorService = new ShowAuthorService();
    }

    public function execute(AuthorCommandRequest $request): void
    {
        if (empty($request->getAuthorIds())) {
            $this->index();
        } else {
            foreach ($request->getAuthorIds() as $id) {
                if (!in_array($id, range(1, 10))) {
                    throw new ResourceNotFoundException('Invalid ID');
                } else {
                    $this->show((int) $id);
                }
            }
        }
    }

    private function index(): void
    {
        $authors = $this->indexAuthorService->execute();

        foreach ($authors as $author) {
            /** @var Author $author */
            (new AuthorCommandResponse($author))->getAuthorContent();
        }
    }

    private function show(int $id): void
    {
        $response = $this->showAuthorService->execute(new ShowAuthorServiceRequest($id));

        $author = new AuthorCommandResponse($response->getAuthor(), $response->getArticles());
        $author->getAuthorContent();
        $author->getArticlesContent();
    }
}