<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Database view model. No inferred relationships are defined.
 */
class PPBoardSpalte extends Model
{
    protected $table = 'PPBoardSpalte';

    protected $primaryKey = 'PPBoardSpalte_Id';

    public $incrementing = false;

    public $timestamps = false;

    protected $guarded = [];
}
