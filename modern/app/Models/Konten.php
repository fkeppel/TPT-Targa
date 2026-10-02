<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    protected $table = 'konten';

    protected $primaryKey = 'Konten_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
