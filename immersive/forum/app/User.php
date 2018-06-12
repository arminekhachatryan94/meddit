<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'description'
    ];

    public function getDescriptionAttribute() {
        $bio = Description::where('user_id', $this->id)->get();
        return $bio[0]->description;
    }

    public function biography() {
    	return $this->hasOne(Description::class);
    }

    public function role() {
        return $this->belongsTo(UserRole::class);
    }
}
