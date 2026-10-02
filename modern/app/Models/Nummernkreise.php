<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nummernkreise extends Model
{
    protected $table = 'Nummernkreise';

    protected $primaryKey = 'Nummernkreise_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
