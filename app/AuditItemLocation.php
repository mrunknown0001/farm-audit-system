<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditItemLocation extends Model
{
    public function audit_item()
    {
    	return $this->belongsTo('App\AuditItem');
    }


    public function location()
    {
    	return $this->belongsTo('App\Location');
    }
}
