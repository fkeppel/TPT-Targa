<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoadJeProduzent extends Model
{
    protected $table = 'LoadJeProduzent';

    protected $primaryKey = 'ID';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;
}
