<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPLieferavis_BOL extends Model
{
    protected $table = 'PPLieferavis_BOL';

    protected $primaryKey = 'PPLieferavis_BOL_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPLieferavis_BOL_Id',
        'PPLieferavis_BOL_BOLNr',
        'PPLieferavis_BOL_Brutto',
        'PPLieferavis_BOL_Netto',
    ];
}
