<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPBoardSpalteSAVE extends Model
{
    protected $table = 'PPBoardSpalte_SAVE';

    protected $primaryKey = 'PPBoardSpalte_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
