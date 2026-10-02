<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPLog extends Model
{
    protected $table = 'PPLog';

    protected $primaryKey = 'PPLog_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
