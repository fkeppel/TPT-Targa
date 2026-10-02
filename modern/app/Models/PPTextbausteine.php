<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPTextbausteine extends Model
{
    protected $table = 'PPTextbausteine';

    protected $primaryKey = 'PPTextbausteine_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPTextbausteine_Art',
        'PPTextbausteine_Text',
    ];
}
