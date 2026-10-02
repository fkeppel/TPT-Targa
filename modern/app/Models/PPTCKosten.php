<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPTCKosten extends Model
{
    protected $table = 'PPTCKosten';

    protected $primaryKey = 'PPTCKosten_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
