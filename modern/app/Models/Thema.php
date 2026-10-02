<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thema extends Model
{
    protected $table = 'Thema';

    protected $primaryKey = 'Thema_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
