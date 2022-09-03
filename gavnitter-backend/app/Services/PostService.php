<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostService
{
    public function __construct(private NotificationService $notificationService) {

    }

    public function getPosts($numberPage, $id = null, $arrayPostId = null): array
    {
        $posts = Post::select("*")
            ->when($id, function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->latest()
            ->when($arrayPostId !== null, function ($query) use ($arrayPostId) {
                $query->whereIn('id', $arrayPostId);
            })
            ->with(['author', 'likes'])
            ->withCount(['comments', 'likes'])
            ->paginate(20, ['*'], 'page', $numberPage)->items();

        array_map(function ($post) {
            $post['selfLike'] = $post->isSelfLike();
        }, $posts);

        return $posts;
    }

    public function createPost($textPost, $user_id): Post
    {
        return Post::create([
            'message' => $textPost,
            'user_id' => (int)$user_id,
        ]);
    }

    public function getPostsWithNewComment($id, $numberPage)
    {
        $notifications = Notification::
            where('user_id', $id)
            ->where('is_close', 0)
            ->where('type', 2)
            ->limit(20)
            ->get();
        $notifications->each->update([
            'is_close' => 1,
        ]);
        $postIds = $notifications->unique('post_id')->pluck('post_id')->toArray();
        return $this->getPosts($numberPage, $id, $postIds);
    }


    public function saveComment($user, $postId, $text) {
        $post = Post::select(['id','user_id', 'message'])
            ->where('id', $postId)
            ->withCount(['comments', 'likes'])
            ->first();
        $comment = Comment::create([
            'post_id' => $postId,
            'user_id' => $user->id,
            'text_comment' => $text,
        ]);
        $this->notificationService->createNotification($user, $post, 'comment', $comment->id);
        $comment['author'] = $comment->author;
        ++$post->comments_count;
        return [
            'comment' => $comment,
            'post' => $post,
        ];
    }

}
