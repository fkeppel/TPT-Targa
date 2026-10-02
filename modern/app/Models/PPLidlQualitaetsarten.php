<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPLidlQualitaetsarten extends Model
{
    protected $table = 'PPLidlQualitaetsarten';

    protected $primaryKey = 'PPLidlQualitaetsarten_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
