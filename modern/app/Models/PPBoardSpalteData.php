<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPBoardSpalteData extends Model
{
    protected $table = 'PPBoardSpalteData';

    protected $primaryKey = 'PPBoardSpalte_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
