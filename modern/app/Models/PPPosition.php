<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Legacy model whose backing table is not present in the supplied schema.
 */
class PPPosition extends Model
{
    protected $table = 'PPPosition';

    protected $primaryKey = 'PositionIdent';

    public $timestamps = false;
}
