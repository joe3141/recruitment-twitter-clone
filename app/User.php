<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'avatar', 'provider', 'provider_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function followers()
    {
        return $this->belongsToMany('App\User', 'followers', 'user_id', 'follower_id')
            ->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany('App\User', 'followers', 'follower_id', 'user_id')
            ->withTimestamps();
    }

    public function tweets()
    {
        return $this->hasMany('App\Tweet');
    }

    public function doesFollow($user_id)
    {
       return $this->following()->where('user_id', '=', $user_id)->first() ? true : false;
    }

    public function likes()
    {
        return $this->belongsToMany('App\Tweet', 'likes', 'user_id', 'tweet_id')->withTimestamps();
    }

    public function mentions()
    {
        return $this->hasMany('App\Mention');
    }
}
