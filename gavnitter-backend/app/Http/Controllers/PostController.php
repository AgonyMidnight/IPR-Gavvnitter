<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Services\NotificationService;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        protected PostService         $postService,
        protected NotificationService $notificationService)
    {
    }

    public function getLastPosts(Request $request): JsonResponse
    {
        $posts = $this->postService->getPosts($request->numberPage, $request->usersId);
        return response()->json(['posts' => $posts], 200);
    }

    public function createPost(Request $request): JsonResponse
    {
        $post = $this->postService->createPost($request->textPost, auth('api')->id());
        $post['author'] = $post->author;
        return response()->json(['post' => $post], 200);
    }

    public function likePost(Request $request): JsonResponse
    {
        $user = auth('api')->user();
        $post = Post::where('id', $request->post_id)->withCount(['comments', 'likes'])->first();
        $like = $post->likes()->toggle($user->id);
        $isLikeNow = count($like['attached']) > 0;
        $isLikeNow
            ? $this->notificationService->createNotification($user, $post, 'like')
            : $this->notificationService->deleteLike($user, $post);
        return response()->json(['likeStatus' => $isLikeNow]);
    }

    public function getComments(Request $request): JsonResponse
    {
        $post = Post::where('id', $request->post_id)
            ->first();
        $comments = $post->comments;
        foreach ($comments as $comment) {
            $comment['author'] = $comment->author;
        }
        return response()->json([
            'comments' => $comments,
            ]);
    }

    public function saveComment(Request $request)
    {
        $response = $this->postService->saveComment(
            auth('api')->user(),
            $request->post_id,
            $request->text_comment,
        );
        return response()->json([
            'comment' => $response['comment'],
            'post' => $response['post'],
        ]);
    }

    public function deleteComments(Request $request)
    {
        $comment =
            Comment::where('id', $request->id)
                ->where('user_id', auth('api')->id())
                ->first();
        $comment->delete();
    }

    public function getPostsWithNewComment(Request $request): JsonResponse
    {
        $posts = $this->postService->
            getPostsWithNewComment(auth('api')->id(),
            $request->numberPage);
        return response()->json(['posts' => $posts]);
    }

}
