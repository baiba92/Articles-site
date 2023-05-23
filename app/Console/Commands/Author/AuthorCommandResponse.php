<?php declare(strict_types=1);

namespace ArticlesApp\Console\Commands\Author;

use ArticlesApp\Models\Article;
use ArticlesApp\Models\Author;

class AuthorCommandResponse
{
    private Author $author;
    private array $articles;

    public function __construct(Author $author, array $articles = [])
    {
        $this->author = $author;
        $this->articles = $articles;
    }

    public function getAuthorContent(): void
    {
        echo '---------------------' . PHP_EOL;
        echo "[{$this->author->id()}]" . PHP_EOL;
        echo "Name: {$this->author->name()}" . PHP_EOL;
        echo "Username: {$this->author->userName()}" . PHP_EOL;
        echo "Website: {$this->author->website()}" . PHP_EOL;
        echo "E-mail: {$this->author->eMail()}" . PHP_EOL;
        echo "Hometown: {$this->author->homeTown()}" . PHP_EOL;
        echo "Employed at: {$this->author->workingPlace()}" . PHP_EOL;
        echo PHP_EOL;
    }

    public function getArticlesContent(): void
    {
        echo 'Articles:' . PHP_EOL;
        foreach ($this->articles as $article) {
            /** @var Article $article */
            echo "[id: {$article->id()}]" . PHP_EOL;
            echo '---' . strtoupper($article->title()) . '---' . PHP_EOL;
            echo $article->content() . PHP_EOL;
            echo PHP_EOL;
        }
    }
}