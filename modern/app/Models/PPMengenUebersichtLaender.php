<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPMengenUebersichtLaender extends Model
{
    protected $table = 'PPMengenUebersichtLaender';

    protected $primaryKey = 'PPMengenUebersichtLaender_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
