<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditItem extends Model
{
	public function auditname()
	{
		return $this->belongsTo('App\AuditItemCategory', 'audit_item_category_id');
	}

    public function checklists()
    {
    	return $this->hasMany('App\AuditItemChecklist', 'audit_item_id');
    }


    public function locations()
    {
    	return $this->hasMany('App\AuditItemLocation', 'audit_item_id');
    }
}
