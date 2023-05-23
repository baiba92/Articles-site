<?php declare(strict_types=1);

namespace ArticlesApp\Services\Article\Show;

use ArticlesApp\Exceptions\ResourceNotFoundException;
use ArticlesApp\Repositories\Article\ArticleRepository;
use ArticlesApp\Repositories\Article\JsonPlaceholderArticleRepository;
use ArticlesApp\Repositories\Author\AuthorRepository;
use ArticlesApp\Repositories\Author\JsonPlaceholderAuthorRepository;
use ArticlesApp\Repositories\Comment\CommentRepository;
use ArticlesApp\Repositories\Comment\JsonPlaceholderCommentRepository;

class ShowArticleService
{
    private ArticleRepository $articleRepository;
    private AuthorRepository $authorRepository;
    private CommentRepository $commentRepository;

    public function __construct()
    {
        $this->articleRepository = new JsonPlaceholderArticleRepository();
        $this->authorRepository = new JsonPlaceholderAuthorRepository();
        $this->commentRepository = new JsonPlaceholderCommentRepository();
    }

    public function execute(ShowArticleServiceRequest $request): ShowArticleServiceResponse
    {
        $article = $this->articleRepository->fetchSingleArticle($request->getArticleId());

        if ($article == null) {
            throw new ResourceNotFoundException('Article by id ' . $request->getArticleId() . ' not found');
        }

        $author = $this->authorRepository->fetchSingleAuthor($article->authorId());

        if ($author == null) {
            throw new ResourceNotFoundException('Author by id ' . $article->authorId() . ' not found');
        }

        $article->setAuthor($author);

        $comments = $this->commentRepository->fetchCommentsByArticleId($article->id());

        return new ShowArticleServiceResponse($article, $comments);
    }
}