<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Database view model. No inferred relationships are defined.
 */
class PPLaenderbloecke extends Model
{
    protected $table = 'PPLaenderbloecke';

    protected $primaryKey = 'PPLaenderbloecke_Id';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'PPLaenderbloecke_Land',
        'PPLaenderbloecke_Block',
        'PPLaenderbloecke_Hafen1',
        'PPLaenderbloecke_Hafen2',
    ];
}
