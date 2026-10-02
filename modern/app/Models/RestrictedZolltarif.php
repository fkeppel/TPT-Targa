<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestrictedZolltarif extends Model
{
    protected $table = 'RestrictedZolltarif';

    protected $primaryKey = 'RestrictedZolltarif_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
