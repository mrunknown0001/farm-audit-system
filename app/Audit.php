<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    public function images()
    {
    	return $this->hasMany('App\AuditImage');
    }

    public function location()
    {
    	return $this->belongsTo('App\Location');
    }

    public function sub_location()
    {
    	return $this->belongsTo('App\Sublocation');
    }

    public function audit_item()
    {
    	return $this->belongsTo('App\AuditItem');
    }
}
