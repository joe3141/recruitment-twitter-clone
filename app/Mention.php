<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mention extends Model
{
    protected $guarded = [];

    public function tweet()
    {
    	return $this->belongsTo('App\Tweet');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
