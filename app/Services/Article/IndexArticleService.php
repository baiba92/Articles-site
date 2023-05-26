<?php declare(strict_types=1);

namespace ArticlesApp\Services\Article;

use ArticlesApp\Models\Article;
use ArticlesApp\Repositories\Article\ArticleRepository;
use ArticlesApp\Repositories\Author\AuthorRepository;

class IndexArticleService
{
    private ArticleRepository $articleRepository;
    private AuthorRepository $authorRepository;

    public function __construct
    (
        ArticleRepository $articleRepository,
        AuthorRepository $authorRepository
    )
    {
        $this->articleRepository = $articleRepository;
        $this->authorRepository = $authorRepository;
    }

    public function execute(): array
    {
        $articles = $this->articleRepository->fetchAllArticles();

        foreach ($articles as $article) {
            /** @var Article $article */
            $author = $this->authorRepository->fetchSingleAuthor($article->authorId());
            $article->setAuthor($author);
        }

        return $articles;
    }
}