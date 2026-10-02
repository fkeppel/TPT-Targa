<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translations extends Model
{
    protected $table = 'Translations';

    protected $primaryKey = 'Translations_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
