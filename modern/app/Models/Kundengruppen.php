<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kundengruppen extends Model
{
    protected $table = 'Kundengruppen';

    protected $primaryKey = 'Kundengruppen_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
