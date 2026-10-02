<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPStati extends Model
{
    protected $table = 'PPStati';

    protected $primaryKey = 'PPStati_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPStati_Status',
        'PPStati_Color',
        'PPStati_Background',
    ];
}
