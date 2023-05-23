<?php  declare(strict_types=1);

namespace ArticlesApp\Console;

use ArticlesApp\Console\Commands\Article\ArticleCommand;
use ArticlesApp\Console\Commands\Article\ArticleCommandRequest;
use ArticlesApp\Console\Commands\Author\AuthorCommandRequest;
use ArticlesApp\Console\Commands\Author\AuthorCommand;
use ArticlesApp\Exceptions\ResourceNotFoundException;

class Console
{
    public static function response(string $resource, $ids = null): void
    {
        switch ($resource) {
            case 'articles':
                $articleCommand = new ArticleCommand();
                $request = new ArticleCommandRequest($ids);
                $articleCommand->execute($request);
                break;
            case 'authors':
                $authorCommand = new AuthorCommand();
                $request = new AuthorCommandRequest($ids);
                $authorCommand->execute($request);
                break;
            default:
                throw new ResourceNotFoundException('Invalid resource/command provided');
        }
    }

    public static function instruction(): void
    {
        echo 'Commands to get information:' . PHP_EOL;
        echo '  php console.php articles  --> to get all articles' . PHP_EOL;
        echo '  php console.php articles 1 3  --> to get articles by article id 1 and 3 (1-100 possible ids)' . PHP_EOL;
        echo '  php console.php authors  --> to get all authors' . PHP_EOL;
        echo '  php console.php articles 1 3  --> to get authors by author id 1 and 3 (1-10 possible ids)' . PHP_EOL;
    }
}