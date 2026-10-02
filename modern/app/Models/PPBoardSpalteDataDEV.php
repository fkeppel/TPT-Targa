<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPBoardSpalteDataDEV extends Model
{
    protected $table = 'PPBoardSpalteData_DEV';

    protected $primaryKey = 'PPBoardSpalte_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
