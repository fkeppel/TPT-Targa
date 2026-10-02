<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPImport_Exce extends Model
{
    protected $table = 'PPImport_Excel';

    protected $primaryKey = 'PPImort__Excel_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
