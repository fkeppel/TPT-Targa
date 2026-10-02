<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPLsv extends Model
{
    protected $table = 'PPLsv';

    protected $primaryKey = 'PPLsv_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
