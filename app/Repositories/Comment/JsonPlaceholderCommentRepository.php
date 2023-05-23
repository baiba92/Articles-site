<?php declare(strict_types=1);

namespace ArticlesApp\Repositories\Comment;

use ArticlesApp\Cache;
use ArticlesApp\Models\Comment;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;

class JsonPlaceholderCommentRepository implements CommentRepository
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(['verify' => false]);
    }

    public function fetchCommentsByArticleId(int $articleId): array
    {
        try {
            if (!Cache::has('article_comments_' . $articleId)) {
                $response = $this->client->get("https://jsonplaceholder.typicode.com/posts/$articleId/comments");
                $responseJson = $response->getBody()->getContents();
                Cache::save('article_comments_' . $articleId, $responseJson);
            } else {
                $responseJson = Cache::get('article_comments_' . $articleId);
            }

            $commentsContent = json_decode($responseJson);
            return $this->createCommentsCollection($commentsContent);

        } catch (GuzzleException $exception) {
            return [];
        }
    }

    private function createCommentsCollection(array $comments): array
    {
        $collection = [];
        foreach ($comments as $comment) {
            $collection[] = $this->createComment($comment);
        }
        return $collection;
    }

    private function createComment(stdClass $commentContent): Comment
    {
        return new Comment(
            $commentContent->postId,
            $commentContent->id,
            $commentContent->name,
            $commentContent->email,
            $commentContent->body
        );
    }
}