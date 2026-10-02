<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPTranslateGUI extends Model
{
    protected $table = 'PPTranslateGUI';

    protected $primaryKey = 'PPTranslateGUI_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
