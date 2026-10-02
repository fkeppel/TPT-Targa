<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PP8WMuster extends Model
{
    protected $table = 'PP8WMuster';

    protected $primaryKey = 'PP8WMuster_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PP8WMuster_Id',
        'PP8WMuster_Empfaenger',
        'PP8WMuster_Remark',
        'PP8WMuster_Art',
    ];
}
