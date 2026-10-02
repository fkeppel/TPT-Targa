<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPPerioden extends Model
{
    protected $table = 'PPPerioden';

    protected $primaryKey = 'PPPerioden_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
