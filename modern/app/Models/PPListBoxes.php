<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPListBoxes extends Model
{
    protected $table = 'PPListBoxes';

    protected $primaryKey = 'PPListBoxes_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPListBoxes_Type',
        'PPListBoxes_Ident',
        'PPListBoxes_Value',
    ];
}
