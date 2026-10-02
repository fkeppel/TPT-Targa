<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPProduktpass_KLLink extends Model
{
    protected $table = 'PPProduktpass_KLLink';

    protected $primaryKey = 'PPProduktpass_KLLink_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
