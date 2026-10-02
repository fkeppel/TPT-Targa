<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPBatchtermine extends Model
{
    protected $table = 'PPBatchtermine';

    protected $primaryKey = 'PPBatchtermine_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
