<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lagerbewegungsarten extends Model
{
    protected $table = 'Lagerbewegungsarten';

    protected $primaryKey = 'Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
