<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPHaefen extends Model
{
    protected $table = 'PPHaefen';

    protected $primaryKey = 'PPHaefen_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPHaefen_Nr',
        'PPHaefen_Name',
    ];
}
