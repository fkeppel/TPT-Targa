<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoeglicheLieferanten extends Model
{
    protected $table = 'MoeglicheLieferanten';

    protected $primaryKey = 'UUID';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;
}
