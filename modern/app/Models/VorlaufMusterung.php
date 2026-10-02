<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VorlaufMusterung extends Model
{
    protected $table = 'Vorlauf_Musterung';

    protected $primaryKey = 'ID';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;
}
