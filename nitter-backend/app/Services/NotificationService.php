<?php

namespace App\Services;

use App\Events\NotificationPost;
use App\Models\Notification;

class NotificationService
{
    private function getTextNotification($userLogin, $typeNotification): string
    {
        return
            $userLogin
            . ' '
            . ($typeNotification == Notification::LIKE_NOTIFICATION ? 'liked' : 'commented')
            . ' your post';
    }

    public function createNotification($user, $post, $notificationType, $commentId = null)
    {
        if ($user->id != $post->user_id) {
            $type = Notification::getTypeNotification($notificationType);
            $notification = Notification::create([
                'user_id' => $post->user_id,
                'post_id' => $post->id,
                'user_by' => $user->id,
                'type' => $type,
                'text' => $this->getTextNotification($user->login, $type),
                'comment_id' => $commentId,
            ]);
            event(new NotificationPost($notification));
        }
    }

    public function deleteLike($user, $post)
    {
        if ($user->id != $post->user_id) {
            $notification = Notification::
                where([
                    'post_id' => $post->id,
                    'user_id' => $post->user_id,
                    'user_by' => $user->id,
                ])
                ->first();
            event(new NotificationPost($notification, 'delete'));
            $notification->delete();
        }
    }

    public function deleteComment($commentId)
    {
        $notification = Notification::
            where('comment_id', $commentId)
            ->first();
        if ($notification) {
            event(new NotificationPost($notification, 'delete'));
            $notification->delete();
        }
    }

    public function getNotifications($userId, $type, $full)
    {
        $notifications = Notification::
            where('user_id', $userId)
            ->when(!($full === 'true' && $type === 'like'), function ($query) {
                $query->where('is_close', 0);
            })
            ->where('type', Notification::getTypeNotification($type))
            ->when($full === 'true', function ($query) {
                $query->with(['author', 'post', 'comment']);
            })
            ->get();
        if ($full === 'true') {
            $notifications->each->update([
                'is_close' => 1,
            ]);
        }
        return $notifications;
    }
}
