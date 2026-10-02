<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPImport_Definitions extends Model
{
    protected $table = 'PPImport_Definitions';

    protected $primaryKey = 'PPImport_Definition_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
