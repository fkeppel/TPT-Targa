<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Belegarten extends Model
{
    protected $table = 'belegarten';

    protected $primaryKey = 'Belegarten_Id';

    public $incrementing = false;

    protected $keyType = 'int';

    public $timestamps = true;
}
