<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zkd extends Model
{
    protected $table = 'zkd';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
