<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EAN_Nummern extends Model
{
    protected $table = 'EAN_Nummern';

    protected $primaryKey = 'EAN_Nummern_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'EAN_Nummern_EAN',
        'EAN_Nummern_IAN',
        'EAN_Nummern_Status',
        'EAN_Nummern_MA',
        'EAN_Nummern_LetzteAenderung',
    ];
}
