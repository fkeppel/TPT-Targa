<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adres extends Model
{
    protected $table = 'adressen';

    protected $primaryKey = 'Adressen_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
