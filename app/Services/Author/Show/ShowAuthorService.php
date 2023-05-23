<?php  declare(strict_types=1);

namespace ArticlesApp\Services\Author\Show;

use ArticlesApp\Exceptions\ResourceNotFoundException;
use ArticlesApp\Models\Article;
use ArticlesApp\Repositories\Article\ArticleRepository;
use ArticlesApp\Repositories\Article\JsonPlaceholderArticleRepository;
use ArticlesApp\Repositories\Author\AuthorRepository;
use ArticlesApp\Repositories\Author\JsonPlaceholderAuthorRepository;

class ShowAuthorService
{
    private AuthorRepository $authorRepository;
    private ArticleRepository $articleRepository;

    public function __construct()
    {
        $this->authorRepository = new JsonPlaceholderAuthorRepository();
        $this->articleRepository = new JsonPlaceholderArticleRepository();
    }

    public function execute(ShowAuthorServiceRequest $request): ShowAuthorServiceResponse
    {
        $author = $this->authorRepository->fetchSingleAuthor($request->getAuthorId());

        if ($author == null) {
            throw new ResourceNotFoundException('Author by id ' . $request->getAuthorId() . ' not found');
        }

        $articles = $this->articleRepository->fetchArticlesByAuthorId($author->id());

        foreach ($articles as $article) {
            /** @var Article $article */
            $articleAuthor = $this->authorRepository->fetchSingleAuthor($author->id());
            $article->setAuthor($articleAuthor);
        }

        return new ShowAuthorServiceResponse($author, $articles);
    }
}