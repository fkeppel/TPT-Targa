<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kostenarten extends Model
{
    protected $table = 'Kostenarten';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
