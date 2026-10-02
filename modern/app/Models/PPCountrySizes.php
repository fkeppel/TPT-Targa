<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPCountrySizes extends Model
{
    protected $table = 'PPCountrySizes';

    protected $primaryKey = 'PPCountrySizes_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
