<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikeltexte extends Model
{
    protected $table = 'artikeltexte';

    protected $primaryKey = 'Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
