<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPTermineMusterung extends Model
{
    protected $table = 'PPTermineMusterung';

    protected $primaryKey = 'PPTermineMusterung_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
