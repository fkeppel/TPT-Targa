<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPXMLNodes extends Model
{
    protected $table = 'PPXMLNodes';

    protected $primaryKey = 'PPXMLNodes_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
