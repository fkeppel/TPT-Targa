<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPTermineChanges extends Model
{
    protected $table = 'PPTermineChanges';

    protected $primaryKey = 'PPTermineChanges_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [
    ];
}
