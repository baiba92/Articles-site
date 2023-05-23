<?php declare(strict_types=1);

namespace ArticlesApp\Services\Article;

use ArticlesApp\Models\Article;
use ArticlesApp\Models\Author;
use ArticlesApp\Repositories\Article\ArticleRepository;
use ArticlesApp\Repositories\Article\JsonPlaceholderArticleRepository;
use ArticlesApp\Repositories\Author\AuthorRepository;
use ArticlesApp\Repositories\Author\JsonPlaceholderAuthorRepository;

class IndexArticleService
{
    private ArticleRepository $articleRepository;
    private AuthorRepository $authorRepository;

    public function __construct()
    {
        $this->articleRepository = new JsonPlaceholderArticleRepository();
        $this->authorRepository = new JsonPlaceholderAuthorRepository();

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