<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPOrderWeights extends Model
{
    protected $table = 'PPOrderWeights';

    protected $primaryKey = 'PPOrderWeights_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
