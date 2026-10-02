<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Belegepositionen extends Model
{
    protected $table = 'belegepositionen';

    protected $primaryKey = 'belegepositionen_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
