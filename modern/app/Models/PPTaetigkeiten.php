<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPTaetigkeiten extends Model
{
    protected $table = 'PPTaetigkeiten';

    protected $primaryKey = 'PPTaetigkeiten_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
