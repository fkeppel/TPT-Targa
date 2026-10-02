<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kalkulationskurs extends Model
{
    protected $table = 'Kalkulationskurs';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;
}
