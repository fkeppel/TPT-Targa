<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPTerms extends Model
{
    protected $table = 'PPTerms';

    protected $primaryKey = 'PPTerms_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPTerms_MC',
        'PPTerms_Text',
        'PPTerms_Art',
    ];
}
