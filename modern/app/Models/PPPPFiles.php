<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPPPFiles extends Model
{
    protected $table = 'PPPPFiles';

    protected $primaryKey = 'PPPPFiles_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPPPFiles_PPProduktpass_Id',
        'PPPPFiles_Type',
        'PPPPFiles_Date',
        'PPPPFiles_Description',
        'PPPPFiles_SubKat',
        'PPPPFiles_Pfad',
    ];
}
