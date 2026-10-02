<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPProduktpass_Qualitaet extends Model
{
    protected $table = 'PPProduktpass_Qualitaet';

    protected $primaryKey = 'PPProduktpass_Qualitaet_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPProduktpass_Qualitaet_Header',
        'PPProduktpass_Qualitaet_Row',
        'PPProduktpass_Qualitaet_PPProduktpass_Id',
        'PPProduktpass_Qualitaet_Value01',
        'PPProduktpass_Qualitaet_Value02',
        'PPProduktpass_Qualitaet_Value03',
        'PPProduktpass_Qualitaet_Value04',
        'PPProduktpass_Qualitaet_Value05',
        'PPProduktpass_Qualitaet_Value06',
        'PPProduktpass_Qualitaet_Value07',
        'PPProduktpass_Qualitaet_Value08',
        'PPProduktpass_Qualitaet_Value09',
        'PPProduktpass_Qualitaet_Value10',
        'PPProduktpass_Qualitaet_Value11',
        'PPProduktpass_Qualitaet_Value12',
        'PPProduktpass_Qualitaet_Value13',
        'PPProduktpass_Qualitaet_Value14',
        'PPProduktpass_Qualitaet_Value15',

    ];
}
