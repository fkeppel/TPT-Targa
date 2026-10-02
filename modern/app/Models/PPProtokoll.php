<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPProtokoll extends Model
{
    protected $table = 'PPProtokoll';

    protected $primaryKey = 'PPProtokoll_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
