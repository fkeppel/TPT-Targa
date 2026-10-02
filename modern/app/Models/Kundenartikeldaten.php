<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kundenartikeldaten extends Model
{
    protected $table = 'kundenartikeldaten';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
