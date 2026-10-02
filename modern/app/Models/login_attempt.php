<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class login_attempt extends Model
{
    protected $table = 'login_attempt';

    protected $primaryKey = 'login_attempt_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
