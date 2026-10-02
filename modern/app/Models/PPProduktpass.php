<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Database view model. No inferred relationships are defined.
 */
class PPProduktpass extends Model
{
    protected $table = 'PPProduktpass';

    protected $primaryKey = 'PPProduktpass_Id';

    public $incrementing = false;

    public $timestamps = false;

    protected $guarded = [];
}
