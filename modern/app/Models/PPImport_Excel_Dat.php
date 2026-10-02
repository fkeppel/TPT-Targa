<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPImport_Excel_Dat extends Model
{
    protected $table = 'PPImport_Excel_Data';

    protected $primaryKey = 'PPImport_Excel_Data_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
