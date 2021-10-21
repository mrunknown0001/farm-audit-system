<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditImage extends Model
{
	public function audit()
	{
		return $this->belongsTo('App\Audit');
	}
}
