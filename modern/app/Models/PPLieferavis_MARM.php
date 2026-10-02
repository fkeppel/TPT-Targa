<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPLieferavis_MARM extends Model
{
    protected $table = 'PPLieferavis_MARM';

    protected $primaryKey = 'PPLieferavis_MARM_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPLieferavis_MARM_SATNR',
        'PPLieferavis_MARM_Laenge',
        'PPLieferavis_MARM_Breite',
        'PPLieferavis_MARM_Hoehe',
        'PPLieferavis_MARM_Brutto',
        'PPLieferavis_MARM_Netto',
    ];
}
