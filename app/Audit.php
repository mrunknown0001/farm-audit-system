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
    	return $this->belongsTo('App\SubLocation');
    }

    public function audit_item()
    {
    	return $this->belongsTo('App\AuditItem');
    }

    public function review()
    {
        return $this->hasOne('App\AuditReview');
    }


    public function reviewer()
    {
        return $this->belongsTo('App\User', 'field3');
    }

    public function auditor()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
