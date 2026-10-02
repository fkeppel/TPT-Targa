<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPTempQualitaet extends Model
{
    protected $table = 'PPTempQualitaet';

    protected $primaryKey = 'PPTempQualitaet_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
