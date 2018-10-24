<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Comment;
use App\User;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'title', 'body'
    ];

    public function comments() {
    	return $this->hasMany(Comment::class)->oldest();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
