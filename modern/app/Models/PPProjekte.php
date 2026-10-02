<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPProjekte extends Model
{
    protected $table = 'PPProjekte';

    protected $primaryKey = 'PPProjekte_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPProjekte_Bezeichnung',
        'PPProjekte_AnlageDatum',
        'PPProjekte_Verantwortlich',
    ];
}
