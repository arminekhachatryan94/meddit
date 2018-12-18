<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'post_id', 'comment_id', 'user_id', 'body'
    ];

	public function user(){
		return $this->belongsTo(User::class);
    }
    
    public function comments() {
    	return $this->hasMany(Comment::class)->oldest();
    }
}
