<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Belegnummern extends Model
{
    protected $table = 'belegnummern';

    protected $primaryKey = 'belegnummern_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
