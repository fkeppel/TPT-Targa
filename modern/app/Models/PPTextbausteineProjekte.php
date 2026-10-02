<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPTextbausteineProjekte extends Model
{
    protected $table = 'PPTextbausteineProjekte';

    protected $primaryKey = 'PPTextbausteineProjekte_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
