<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KostenContainer extends Model
{
    protected $table = 'KostenContainer';

    protected $primaryKey = 'KostenContainer_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
