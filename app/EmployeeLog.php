<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeLog extends Model
{
    public function employee()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
