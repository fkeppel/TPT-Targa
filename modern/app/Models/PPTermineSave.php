<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPTermineSave extends Model
{
    protected $table = 'PPTermineSave';

    protected $primaryKey = 'PPTermine_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
