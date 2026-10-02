<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cpcincoterms extends Model
{
    protected $table = 'cpcincoterms';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
