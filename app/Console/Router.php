<?php  declare(strict_types=1);

namespace ArticlesApp\Console;

use ArticlesApp\Console\Commands\Article\ArticleCommandRequest;
use ArticlesApp\Console\Commands\Article\ArticleCommands;
use ArticlesApp\Console\Commands\Author\AuthorCommandRequest;
use ArticlesApp\Console\Commands\Author\AuthorCommands;

class Router
{
    public static function response(string $resource, $ids = null): void
    {
        switch ($resource) {
            case 'articles':
                $articleCommand = new ArticleCommands();
                if ($ids == null) {
                    $articleCommand->index();
                } else {
                    foreach ($ids as $id) {
                        if (!in_array($id, range(1, 100))) {
                            echo 'Invalid ID';
                        } else {
                            $articleCommand->show(new ArticleCommandRequest((int)$id));
                        }
                    }
                }
                break;
            case 'authors':
                $authorCommand = new AuthorCommands();
                if ($ids == null) {
                    $authorCommand->index();
                } else {
                    foreach ($ids as $id) {
                        if (!in_array($id, range(1, 10))) {
                            echo 'Invalid ID';
                        } else {
                            $authorCommand->show(new AuthorCommandRequest((int)$id));
                        }
                    }
                }
                break;
            default:
                echo 'Invalid resource/command provided';
        }
    }
}