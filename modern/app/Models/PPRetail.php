<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPRetail extends Model
{
    protected $table = 'PPRetail';

    protected $primaryKey = 'PPRetail_Id';

    public $incrementing = false;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPRetail_Code',
        'PPRetail_CustMemoText1',
        'PPRetail_CustMemoText3',
        'PPRetail_Name'];
}
