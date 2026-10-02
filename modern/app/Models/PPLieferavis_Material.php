<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPLieferavis_Material extends Model
{
    protected $table = 'PPLieferavis_Material';

    protected $primaryKey = 'PPLieferavis_Material_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPLieferavis_Material_PPLieferavis_Id',
        'PPLieferavis_Material_Materialnummer',
        'PPLieferavis_Material_Menge',
        'PPLieferavis_Material_OrderNr',
        'PPLieferavis_Material_OrderPosNr',
        'PPLiefveravis_Material_OrderGTIN',
        'PPLiefveravis_Material_AvisPosNr',

    ];
}
