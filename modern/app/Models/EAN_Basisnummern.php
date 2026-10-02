<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EAN_Basisnummern extends Model
{
    protected $table = 'EAN_Basisnummern';

    protected $primaryKey = 'EAN_Basisnummern_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'EAN_Basisnummern_Kd',
        'EAN_Basisnummern_Nummer',
        'EAN_Basisnummern_Max',
    ];
}
