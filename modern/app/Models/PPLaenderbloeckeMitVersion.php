<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPLaenderbloeckeMitVersion extends Model
{
    protected $table = 'PPLaenderbloeckeMitVersion';

    protected $primaryKey = 'PPLaenderbloecke_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
