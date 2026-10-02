<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPImport_Definition_Fields extends Model
{
    protected $table = 'PPImport_Definition_Fields';

    protected $primaryKey = 'PPImport_Definition_Fields_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
