<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPProduktpassIntern extends Model
{
    protected $table = 'PPProduktpass_Intern';

    protected $primaryKey = 'PPProduktpass_Intern_Id';

    public $incrementing = false;

    protected $keyType = 'int';

    public $timestamps = true;
}
