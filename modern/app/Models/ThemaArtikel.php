<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThemaArtikel extends Model
{
    protected $table = 'ThemaArtikel';

    protected $primaryKey = 'ThemaArtikel_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
