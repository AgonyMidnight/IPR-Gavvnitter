<?php

namespace App\Models;

use App\Models\Scopes\LastedScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments_posts';
    protected $fillable = [
        'id',
        'text_comment',
        'user_id',
        'post_id',
        'crated_at',
        'updated_at',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new LastedScope());
    }

    public function author(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
