<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPLsvORG extends Model
{
    protected $table = 'PPLsvORG';

    protected $primaryKey = 'PPLsv_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
