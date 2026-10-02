<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Database view model. No inferred relationships are defined.
 */
class PPMusterung extends Model
{
    protected $table = 'PPMusterung';

    protected $primaryKey = 'PPProduktpass_Id';

    public $incrementing = false;

    public $timestamps = false;

    protected $guarded = [
    ];
}
