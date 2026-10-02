<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPCalculation extends Model
{
    protected $table = 'PPCalculation';

    protected $primaryKey = 'PPCalculation_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
