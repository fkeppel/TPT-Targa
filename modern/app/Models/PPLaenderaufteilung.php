<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPLaenderaufteilung extends Model
{
    protected $table = 'PPLaenderaufteilung';

    protected $primaryKey = 'PPLaenderaufteilung_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPLaenderaufteilung_Land',
        'PPLaenderaufteilung_Warehouse',
        'PPLaenderaufteilung_Menge_Kollies',
        'PPLaenderaufteilung_PPProduktpass_Id',
    ];
}
