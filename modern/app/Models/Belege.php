<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Belege extends Model
{
    protected $table = 'belege';

    protected $primaryKey = 'Belege_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
