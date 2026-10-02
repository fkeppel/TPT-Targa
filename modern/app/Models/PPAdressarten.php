<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPAdressarten extends Model
{
    protected $table = 'PPAdressarten';

    protected $primaryKey = 'PPAdressarten_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPAdressarten_Art',
        'PPAdressarten_Bezeichnung',
    ];
}
