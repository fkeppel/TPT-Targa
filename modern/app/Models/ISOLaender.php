<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ISOLaender extends Model
{
    protected $table = 'ISOLaender';

    protected $primaryKey = 'ISOLaender_ISO2';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;
}
