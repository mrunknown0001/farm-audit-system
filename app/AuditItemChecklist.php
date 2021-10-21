<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditItemChecklist extends Model
{
    public function audititem()
    {
    	return $this->belongsTo('App\AuditItem');
    }
}
