<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tPPProduktpass extends Model
{
    protected $table = 'tPPProduktpass';

    protected $primaryKey = 'PPProduktpass_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
