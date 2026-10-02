<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Protokoll extends Model
{
    protected $table = 'protokoll';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
