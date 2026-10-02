<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPTermineAnhaenge extends Model
{
    protected $table = 'PPTermineAnhaenge';

    protected $primaryKey = 'PPTermineAnhaenge_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
