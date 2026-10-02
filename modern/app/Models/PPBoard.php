<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPBoard extends Model
{
    protected $table = 'PPBoard';

    protected $primaryKey = 'PPBoard_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPBoard_Bezeichnung',
    ];
}
