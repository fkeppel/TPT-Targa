<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class XMLConverterMitVersion extends Model
{
    protected $table = 'XMLConverterMitVersion';

    protected $primaryKey = 'XMLConverter_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
