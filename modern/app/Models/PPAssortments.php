<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPAssortments extends Model
{
    protected $table = 'PPAssortments';

    protected $primaryKey = 'PPAssortments_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
