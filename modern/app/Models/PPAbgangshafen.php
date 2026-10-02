<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPAbgangshafen extends Model
{
    protected $table = 'PPAbgangshafen';

    protected $primaryKey = 'PPAbgangshafen_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPAbgangshafen_Hafen',
    ];
}
