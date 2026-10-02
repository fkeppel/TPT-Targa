<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPThema extends Model
{
    protected $table = 'PPThema';

    protected $primaryKey = 'PPThema_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
