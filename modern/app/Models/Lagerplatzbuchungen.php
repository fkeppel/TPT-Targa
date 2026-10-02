<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lagerplatzbuchungen extends Model
{
    protected $table = 'Lagerplatzbuchungen';

    protected $primaryKey = 'Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
