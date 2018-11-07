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
        'name', 'email', 'password', 'phone', 'confirmed', 'nickname', 'public_name', 'pic_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFirstNameAttribute()
    {
        $parts = explode(" ", trim($this->name));
        if(count($parts) > 1){
            $lastname = array_pop($parts);
            $firstname = implode(" ", $parts);
        }else{
            $firstname = $parts[0];
        }
        return $firstname;
    }

    public function getProfileNameAttribute()
    {
        if($this->public_name == 0){
            return $this->first_name;
        }else{
            return $this->nickname;
        }
    }

    public function getProfilePicAttribute()
    {
        if($this->pic_path != null){
            return url($this->pic_path);
        }else{
            return url('profiles/blank-photo.PNG');
        }
    }
}
