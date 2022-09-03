<?php

use App\Http\Controllers\Authorization\AuthorizationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('user')->group(function () {
    Route::post('/create', [AuthorizationController::class, 'registration']);
    Route::post('/login', [AuthorizationController::class, 'loginUser']);
    Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'submitForgetPasswordForm']);
});


Route::middleware('auth:api')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/logout', [AuthorizationController::class, 'logout']);
        Route::post('/posts', [PostController::class, 'getPostsWithNewComment']);
        Route::get('/info', [UserController::class, 'getProfile']);
        Route::post('/profile/update', [UserController::class, 'updateProfile']);
        Route::post('/profile/avatar', [UserController::class, 'updateAvatar']);
        Route::get('/notification', [UserController::class, 'getNotifications']);
        Route::delete('/notification', [UserController::class, 'deleteNotification']);
    });
    Route::prefix('posts')->group(function () {
        Route::get('/', [PostController::class, 'getLastPosts']);
        Route::post('/create', [PostController::class, 'createPost']);
        Route::get('/comment', [PostController::class, 'getComments']);
        Route::post('/comment', [PostController::class, 'saveComment']);
        Route::delete('/comment', [PostController::class, 'deleteComments']);
        Route::put('/like', [PostController::class, 'likePost']);
    });
});



