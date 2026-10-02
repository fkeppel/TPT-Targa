<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rechnungsprufung extends Model
{
    protected $table = 'Rechnungsprüfung';

    protected $primaryKey = 'Nummer_Id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $guarded = [];
}
