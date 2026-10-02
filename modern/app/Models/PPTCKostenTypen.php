<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPTCKostenTypen extends Model
{
    protected $table = 'PPTCKostenTypen';

    protected $primaryKey = 'PPTCKostenTypen_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
