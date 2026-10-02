<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Legacy model whose backing table is not present in the supplied schema.
 */
class PPRelatedItems extends Model
{
    protected $table = 'PPRelatedItems';

    protected $primaryKey = 'PPRelatedItems_Id';

    public $timestamps = true;

    protected $guarded = [];
}
