<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPHerkunftslaender extends Model
{
    protected $table = 'PPHerkunftslaender';

    protected $primaryKey = 'PPHerkunftslaender_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPHerkunftslaender_Land',
    ];
}
