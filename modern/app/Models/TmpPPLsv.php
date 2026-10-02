<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TmpPPLsv extends Model
{
    protected $table = 'tmpPPLsv';

    protected $primaryKey = 'xPPLsv_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
