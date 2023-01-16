<?php

namespace SMT\Models;

use Illuminate\Database\Eloquent\Model;

define('DATE_FORMAT_COMMON', config('constants.DATE_FORMAT_COMMON'));
define('DATE_TIME_FORMAT_COMMON', config('constants.DATE_TIME_FORMAT_COMMON'));

class Exception extends Model
{
    protected $table = "exceptions";
    protected $casts = [
        'date' => 'date:'.DATE_FORMAT_COMMON,
        'timestamp' => 'date:'.DATE_TIME_FORMAT_COMMON,
    ];
}
