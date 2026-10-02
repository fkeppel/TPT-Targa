<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Database view model. No inferred relationships are defined.
 */
class v_Assortment extends Model
{
    protected $table = 'v_Assortment';

    protected $primaryKey = 'PPAssortments_Id';

    public $incrementing = false;

    public $timestamps = false;

    protected $guarded = [];
}
