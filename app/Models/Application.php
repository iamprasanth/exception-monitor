<?php

namespace SMT\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = "applications";

    public function getServerDetails()
	{
		return $this->hasOne('SMT\Models\ServerDetail', 'application_id', 'id')
                    ->select(array('application_id', 'host', 'username', 'password', 'port', 'path'));
    }
}
