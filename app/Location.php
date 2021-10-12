<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function sub_locations()
    {
    	return $this->hasMany('App\SubLocation');
    }
}
