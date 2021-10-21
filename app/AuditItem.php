<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditItem extends Model
{
    public function checklists()
    {
    	return $this->hasMany('App\AuditItemChecklist');
    }
}
