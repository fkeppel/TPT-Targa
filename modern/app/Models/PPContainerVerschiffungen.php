<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPContainerVerschiffungen extends Model
{
    protected $table = 'PPContainerVerschiffungen';

    protected $primaryKey = 'PPContainerVerschiffungen_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
