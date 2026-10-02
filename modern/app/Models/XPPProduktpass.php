<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class XPPProduktpass extends Model
{
    protected $table = 'XPPProduktpass';

    protected $primaryKey = 'PPProduktpass_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
