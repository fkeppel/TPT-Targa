<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPShipment extends Model
{
    protected $table = 'PPShipment';

    protected $primaryKey = 'PPShipment_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
