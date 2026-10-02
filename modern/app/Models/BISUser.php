<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BISUser extends Model
{
    protected $table = 'BISUser';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'BISUser_Name',
        'BISUser_Vorname',
        'password',
        'BISUser_email',
        'username',
    ];
}
