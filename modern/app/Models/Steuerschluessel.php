<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Steuerschluessel extends Model
{
    protected $table = 'Steuerschluessel';

    protected $primaryKey = 'Steuerschluessel_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
