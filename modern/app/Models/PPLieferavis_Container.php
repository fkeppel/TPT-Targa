<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPLieferavis_Container extends Model
{
    protected $table = 'PPLieferavis_Container';

    protected $primaryKey = 'PPLieferavis_Container_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPLieferavis_Container_PPLieferavis_Id',
        'PPLieferavis_Container_ContainerId',
        'PPLieferavis_Container_Art',
        'PPLieferavis_Container_PalCon',
        'PPLieferavis_Container_BOLNr',
        'PPLieferavis_Container_PPLieferavis_BOL_Id',
    ];
}
