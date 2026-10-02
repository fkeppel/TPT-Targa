<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPKategorien extends Model
{
    protected $table = 'PPKategorien';

    protected $primaryKey = 'PPKategorien_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
