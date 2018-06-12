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
        'biography'
    ];

    public function getBiographyAttribute() {
        $bio = Biography::where('user_id', $this->id)->get();
        return $bio[0]->description;
    }

    public function role() {
        return $this->belongsTo(UserRole::class);
    }
}
