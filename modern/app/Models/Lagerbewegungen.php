<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lagerbewegungen extends Model
{
    protected $table = 'lagerbewegungen';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
