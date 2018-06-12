<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
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
        'biography', 'role'
    ];

    public function getBiographyAttribute() {
        $bio = Biography::where('user_id', $this->id)->get();
        return $bio[0]->description;
    }

    public function getRoleAttribute() {
        $role = UserRole::where('user_id', $this->id)->get();
        return $role[0]->role;
    }

}
