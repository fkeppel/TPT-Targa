<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPAssortmentStyles extends Model
{
    protected $table = 'PPAssortmentStyles';

    protected $primaryKey = 'PPAssortmentStyles_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
