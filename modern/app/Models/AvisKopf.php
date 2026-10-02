<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvisKopf extends Model
{
    protected $table = 'AvisKopf';

    protected $primaryKey = 'AvisKopf_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
