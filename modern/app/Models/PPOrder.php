<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPOrder extends Model
{
    protected $table = 'PPOrder';

    protected $primaryKey = 'PPOrder_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
