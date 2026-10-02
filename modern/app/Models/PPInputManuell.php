<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPInputManuell extends Model
{
    protected $table = 'PPInputManuell';

    protected $primaryKey = 'PPInputManuell_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
