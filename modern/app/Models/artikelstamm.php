<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class artikelstamm extends Model
{
    protected $table = 'artikelstamm';

    protected $primaryKey = 'artikelstamm_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
