<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    protected $table = 'Files';

    protected $primaryKey = 'Files_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
