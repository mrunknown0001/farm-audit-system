<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFarm extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }


    public function farm()
    {
    	return $this->belongsTo('App\Farm');
    }
}
