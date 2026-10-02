<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPLieferavis extends Model
{
    protected $table = 'PPLieferavis';

    protected $primaryKey = 'PPLieferavis_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPLieferavis_ETD',
        'PPLieferavis_ETA',
        'PPLieferavis_POL',
        'PPLieferavis_POD',
        'PPLieferavis_SupplierId',
        'PPLieferavis_FrachtfuehrerId',
        'PPLieferavis_SpediteurId',
        'PPLieferavis_SeaAir',
        'PPLieferavis_AvisNr',
        'PPLieferavis_Incoterm',
        'PPLieferavis_Incoterm2',
        'PPLieferavis_Abgangsland',
        'PPLieferavis_Remark',
    ];
}
