<?php declare(strict_types=1);

namespace ArticlesApp\Repositories\Article;

use ArticlesApp\Models\Article;
use ArticlesApp\Models\Author;
use GuzzleHttp\Client;
use Medoo\Medoo;

class PdoArticleRepository implements ArticleRepository
{
    private Medoo $database;
    private Client $client;

    public function __construct()
    {
        $this->database = new Medoo([
            'type' => $_ENV['DATABASE_TYPE'],
            'host' => $_ENV['HOST'],
            'database' => $_ENV['SCHEMA_NAME'],
            'username' => $_ENV['USERNAME'],
            'password' => $_ENV['PASSWORD']
        ]);

        $this->createTable();
        $this->client = new Client(['verify' => false]);
        $this->fillTable();
    }

    public function fetchAllArticles(): array
    {
        $articles = $this->database->select("articles", [
            'id',
            'author_id',
            'title',
            'content'
        ]);

        return $this->createCollection($articles);
    }

    public function fetchArticlesByAuthorId(int $authorId): array
    {
        $articles = $this->database->select("articles", [
            "id",
            'author_id',
            'title',
            'content'
        ], [
            "author_id" => $authorId
        ]);

        return $this->createCollection($articles);
    }

    public function fetchSingleArticle(int $id): ?Article
    {
        $article = $this->database->select("articles", [
            "id",
            'author_id',
            'title',
            'content'
        ], [
            "id" => $id
        ]);

        return $this->createArticle($article[0]);
    }

    public function update(int $id, string $title, string $content): void
    {
        $this->database->update("articles", [
            "title" => $title,
            'content' => $content
        ], [
            'id' => $id
        ]);
    }

    public function delete(int $id): void
    {
        $this->database->delete("articles", [
            "AND" => [
                "id" => $id
            ]
        ]);
    }

    public function create(string $title, string $content): void
    {
        $authorId = ($this->database->max("articles", "author_id")) + 1;
        $articleId = ($this->database->max("articles", "id")) + 1;

        $article = new Article($articleId, $authorId, $title, $content);

        $this->database->insert("articles", [
            "author_id" => $article->authorId(),
            "title" => $article->title(),
            "content" => $article->content()
        ]);
    }

    private function fillTable()
    {
        $count = $this->database->count("articles", "*");
        if ($count == 0) {
            $response = $this->client->get("https://jsonplaceholder.typicode.com/posts");
            $responseJson = $response->getBody()->getContents();
            $articles = json_decode($responseJson);

            foreach ($articles as $article) {
                $this->database->insert("articles", [
                    "author_id" => $article->userId,
                    "title" => $article->title,
                    "content" => $article->body
                ]);
            }
        }
    }

    private function createTable()
    {
        $this->database->create("articles", [
                "id" => [
                    "INT",
                    "NOT NULL",
                    "AUTO_INCREMENT",
                    "PRIMARY KEY"
                ],
                "author_id" => [
                    "INT",
                    "NOT NULL"
                ],
                "title" => [
                    "VARCHAR(255)"
                ],
                "content" => [
                    "TEXT"
                ]
            ]
        );
    }

    private function createCollection(array $articles): array
    {
        $collection = [];
        foreach ($articles as $article) {
            $collection[] = $this->createArticle($article);
        }
        return $collection;
    }

    private function createArticle(array $articleContent): Article
    {
        return new Article(
            (int) $articleContent['id'],
            (int) $articleContent['author_id'],
            $articleContent['title'],
            $articleContent['content']
        );
    }
}