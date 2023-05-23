<?php declare(strict_types=1);

namespace ArticlesApp\Console\Commands\Article;

use ArticlesApp\Models\Article;
use ArticlesApp\Models\Comment;

class ArticleCommandResponse
{
    private Article $article;
    private array $comments;

    public function __construct(Article $article, array $comments = [])
    {
        $this->article = $article;
        $this->comments = $comments;
    }

    public function getArticleContent(): void
    {
        echo '---------------------' . PHP_EOL;
        echo "[id: {$this->article->id()}]" . PHP_EOL;
        echo "Published by: {$this->article->author()->name()}" . PHP_EOL;
        echo '---' . strtoupper($this->article->title()) . '---' . PHP_EOL;
        echo $this->article->content() . PHP_EOL;
        echo PHP_EOL;
    }

    public function getCommentsContent(): void
    {
        echo 'Comments:' . PHP_EOL;
        foreach ($this->comments as $comment) {
            /** @var Comment $comment */
            echo strtoupper($comment->title()) . " ({$comment->eMail()})" . PHP_EOL;
            echo $comment->content() . PHP_EOL;
            echo PHP_EOL;
        }
    }
}