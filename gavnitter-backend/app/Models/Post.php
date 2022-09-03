<?php

namespace App\Models;

use App\Models\Scopes\LastedScope;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use phpDocumentor\Reflection\Types\Boolean;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $fillable = [
        'id',
        'message',
        'user_id',
        'created_at',
        'updated_at',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new LastedScope());
    }

    public function scopeCountsReactions($query)
    {
        return $query->withCount(['comments', 'likes']);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'posts_likes');
    }

    public function isSelfLike(): bool
    {
        return (bool)count($this->likes->where('id', auth('api')->id())) > 0;
    }

    public function author() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
