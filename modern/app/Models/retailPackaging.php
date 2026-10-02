<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class retailPackaging extends Model
{
    protected $table = 'retailPackaging';

    protected $primaryKey = 'retailPackaging_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
