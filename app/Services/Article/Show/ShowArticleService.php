<?php declare(strict_types=1);

namespace ArticlesApp\Services\Article\Show;

use ArticlesApp\Exceptions\ResourceNotFoundException;
use ArticlesApp\Repositories\Article\ArticleRepository;
use ArticlesApp\Repositories\Author\AuthorRepository;
use ArticlesApp\Repositories\Comment\CommentRepository;

class ShowArticleService
{
    private ArticleRepository $articleRepository;
    private AuthorRepository $authorRepository;
    private CommentRepository $commentRepository;

    public function __construct
    (
        ArticleRepository $articleRepository,
        AuthorRepository $authorRepository,
        CommentRepository $commentRepository
    )
    {
        $this->articleRepository = $articleRepository;
        $this->authorRepository = $authorRepository;
        $this->commentRepository = $commentRepository;
    }

    public function execute(ShowArticleServiceRequest $request): ShowArticleServiceResponse
    {
        $article = $this->articleRepository->fetchSingleArticle($request->getArticleId());

        if ($article == null) {
            throw new ResourceNotFoundException('Article by id ' . $request->getArticleId() . ' not found');
        }

        $author = $this->authorRepository->fetchSingleAuthor($article->authorId());

        // IF UNCOMMENTED, ERROR WHEN TRYING TO OPEN NEWLY ADDED ARTICLES, BECAUSE AUTHOR IS NOT FROM API
        //if ($author == null) {
        //    throw new ResourceNotFoundException('Author by id ' . $article->authorId() . ' not found');
        //}

        $article->setAuthor($author);

        $comments = $this->commentRepository->fetchCommentsByArticleId($article->id());

        return new ShowArticleServiceResponse($article, $comments);
    }
}