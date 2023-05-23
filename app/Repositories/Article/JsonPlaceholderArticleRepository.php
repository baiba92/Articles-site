<?php declare(strict_types=1);

namespace ArticlesApp\Repositories\Article;

use ArticlesApp\Cache;
use ArticlesApp\Models\Article;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;

class JsonPlaceholderArticleRepository implements ArticleRepository
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(['verify' => false]);
    }

    public function fetchAllArticles(): array
    {
        try {
            if (!Cache::has('articles')) {
                $response = $this->client->get("https://jsonplaceholder.typicode.com/posts");
                $responseJson = $response->getBody()->getContents();
                Cache::save('articles', $responseJson);
            } else {
                $responseJson = Cache::get('articles');
            }

            $articlesContent = json_decode($responseJson);
            return $this->createArticlesCollection($articlesContent);

        } catch (GuzzleException $exception) {
            return [];
        }
    }

    public function fetchArticlesByAuthorId(int $authorId): array
    {
        try {
            if (!Cache::has('articles_author_' . $authorId)) {
                $response = $this->client->get("https://jsonplaceholder.typicode.com/users/$authorId/posts");
                $responseJson = $response->getBody()->getContents();
                Cache::save('articles_author_' . $authorId, $responseJson);
            } else {
                $responseJson = Cache::get('articles_author_' . $authorId);
            }

            $articlesContent = json_decode($responseJson);
            return $this->createArticlesCollection($articlesContent);

        } catch (GuzzleException $exception) {
            return [];
        }
    }

    public function fetchSingleArticle(int $id): ?Article
    {
        try {
            if (!Cache::has('article_' . $id)) {
                $response = $this->client->get("https://jsonplaceholder.typicode.com/posts/$id");
                $responseJson = $response->getBody()->getContents();
                Cache::save('article_' . $id, $responseJson);
            } else {
                $responseJson = Cache::get('article_' . $id);
            }

            $articleContent = json_decode($responseJson);
            return $this->createArticle($articleContent);

        } catch (GuzzleException $exception) {
            return null;
        }
    }

    private function createArticlesCollection(array $articles): array
    {
        $collection = [];
        foreach ($articles as $article) {
            $collection[] = $this->createArticle($article);
        }
        return $collection;
    }

    private function createArticle(stdClass $articleContent): Article
    {
        return new Article(
            $articleContent->id,
            $articleContent->userId,
            $articleContent->title,
            $articleContent->body
        );
    }
}