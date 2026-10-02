<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'PPMitarbeiter_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
