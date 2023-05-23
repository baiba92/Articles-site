<?php declare(strict_types=1);

namespace ArticlesApp\Repositories\Comment;

interface CommentRepository
{
    public function fetchCommentsByArticleId(int $articleId): array;
}