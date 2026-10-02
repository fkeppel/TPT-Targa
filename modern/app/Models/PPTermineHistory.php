<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPTermineHistory extends Model
{
    protected $table = 'PPTermineHistory';

    protected $primaryKey = 'PPTermineHistory_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
