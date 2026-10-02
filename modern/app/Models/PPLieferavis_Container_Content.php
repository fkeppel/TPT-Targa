<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPLieferavis_Container_Content extends Model
{
    protected $table = 'PPLieferavis_Container_Content';

    protected $primaryKey = 'PPLieferavis_Container_Content_Id';

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
