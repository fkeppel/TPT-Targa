<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Steuersatz extends Model
{
    protected $table = 'Steuersatz';

    protected $primaryKey = 'Steuersatz_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
