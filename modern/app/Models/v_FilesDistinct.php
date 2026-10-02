<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Database view model. No inferred relationships are defined.
 */
class v_FilesDistinct extends Model
{
    protected $table = 'v_FilesDistinct';

    protected $primaryKey = 'PPPPFiles_Id';

    public $incrementing = false;

    public $timestamps = false;

    protected $guarded = [];
}
