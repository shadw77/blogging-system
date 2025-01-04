<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\NewCommentNotification;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\CommentObserver;

#[ObservedBy([CommentObserver::class])]
class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'user_name', 'user_email', 'content', 'approved'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
