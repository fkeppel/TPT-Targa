<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artike extends Model
{
    protected $table = 'artikelstamm';

    protected $primaryKey = 'artikelstamm_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
