<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPTermine extends Model
{
    protected $table = 'PPTermine';

    protected $primaryKey = 'PPTermine_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [

        'PPTermine_PPProduktpass_Id',
        'PPTermine_DatumStart',
        'PPTermine_DatumEnde',
        'PPTermine_Header',
        'PPTermine_Art',
        'PPTermine_Typ',
        'PPTermine_MAAnlage',
        'PPTermine_MAZustaendigkeit',
        'PPTermine_Status',
        'PPTermine_Bemerkungen',
        'created_at',
        'updated_at',
        'PPTermine_PPBoardSpalte_Id',
        'PPTermine_History',

    ];
}
