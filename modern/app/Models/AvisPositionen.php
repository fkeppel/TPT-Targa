<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvisPositionen extends Model
{
    protected $table = 'AvisPositionen';

    protected $primaryKey = 'AvisPositionen_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
