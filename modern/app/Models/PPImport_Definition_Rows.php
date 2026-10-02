<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPImport_Definition_Rows extends Model
{
    protected $table = 'PPImport_Definition_Rows';

    protected $primaryKey = 'PPImport_Definition_Rows_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
