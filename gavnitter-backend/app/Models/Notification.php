<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Notification extends Model
{
    use HasFactory;

    const LIKE_NOTIFICATION = 1;
    const COMMENT_NOTIFICATION = 2;

    protected $table = 'notifications';

    protected $fillable = [
        'id',
        'user_id',
        'post_id',
        'user_by',
        'type',
        'text',
        'is_close',
        'comment_id',
    ];

    public static function getTypeNotification($type): int
    {
        return match ($type) {
            'like' => self::LIKE_NOTIFICATION,
            'comment' => self::COMMENT_NOTIFICATION,
        };
    }

    public function comment(): HasOne
    {
        return $this->hasOne(Comment::class, 'id', 'comment_id' );
    }

    public function post(): HasOne
    {
        return $this->hasOne(Post::class, 'id', 'post_id' );
    }

    public function author() :HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_by');
    }
}
