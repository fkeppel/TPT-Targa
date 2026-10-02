<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AusmusterungStamm extends Model
{
    protected $table = 'AusmusterungStamm';

    protected $primaryKey = 'AusmusterungStamm_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
