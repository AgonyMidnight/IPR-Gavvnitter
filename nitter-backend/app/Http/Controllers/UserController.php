<?php

namespace App\Http\Controllers;


use App\Models\Notification;
use App\Models\User;
use App\Services\NotificationService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserService         $userService,
        protected NotificationService $notificationService,
    )
    {

    }

    public function updateProfile(Request $request): JsonResponse
    {
        $user = auth('api')->user();
        $this->userService->updateProfile($request->get('user'), $user);
        return response()->json([
            'userData' => $user,
        ], 200);
    }

    public function updateAvatar(Request $request): JsonResponse
    {
        $user = auth('api')->user();
        $user->update([
            'avatar' => request()->file('avatar')->store("avatars", "public"),
        ]);
        return response()->json([
            'userData' => $user->avatar,
        ], 200);
    }

    public function getProfile(Request $request): JsonResponse
    {
        return response()->json([
            'userData' => User::select(['id', 'name', 'login', 'gender', 'avatar'])
                    ->where('id', $request->id)
                    ->first(),
        ], 200);
    }

    public function getNotifications(Request $request): JsonResponse
    {
        $notifications = $this->notificationService
            ->getNotifications(auth('api')->id(), $request->type, $request->full);
        return response()->json([
            'notifications' => $notifications,
        ], 200);
    }

    public function deleteNotification(Request $request)
    {
        $notification = Notification::find($request->id);
        if (auth('api')->id() === $notification->user_id) {
            $notification->update([
                'is_close' => true,
            ]);
        }
    }
}
