<?php  declare(strict_types=1);

namespace ArticlesApp\Services\Author\Show;

use ArticlesApp\Exceptions\ResourceNotFoundException;
use ArticlesApp\Models\Article;
use ArticlesApp\Repositories\Article\ArticleRepository;

use ArticlesApp\Repositories\Author\AuthorRepository;


class ShowAuthorService
{
    private AuthorRepository $authorRepository;
    private ArticleRepository $articleRepository;

    public function __construct
    (
        AuthorRepository $authorRepository,
        ArticleRepository $articleRepository
    )
    {
        $this->authorRepository = $authorRepository;
        $this->articleRepository = $articleRepository;
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