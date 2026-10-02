<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreisblattFracht extends Model
{
    protected $table = 'PreisblattFracht';

    protected $primaryKey = 'ID';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;
}
