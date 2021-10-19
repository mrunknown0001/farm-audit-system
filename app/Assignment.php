<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }


    public function location()
    {
    	return $this->belongsTo('App\Location');
    }


    public function sub_location()
    {
    	return $this->belongsTo('App\SubLocation');
    }
}
