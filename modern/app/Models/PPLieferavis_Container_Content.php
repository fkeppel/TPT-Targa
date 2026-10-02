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
}
