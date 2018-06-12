<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Biography extends Model
{
    protected $fillable = [
        'user_id', 'description'
    ];

    protected $hidden = [
        'id', 'user_id', 'created_at', 'updated_at'
    ];

	public function user() {
        return $this->belongsTo(User::class);
    }
}
