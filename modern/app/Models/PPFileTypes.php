<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPFileTypes extends Model
{
    protected $table = 'PPFileTypes';

    protected $primaryKey = 'PPFileTypes_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
