<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPProduktpass_Style extends Model
{
    protected $table = 'PPProduktpass_Style';

    protected $primaryKey = 'PPProduktpass_Style_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPProduktpass_Style_Header',
        'PPProduktpass_Style_Value01',
        'PPProduktpass_Style_Value02',
        'PPProduktpass_Style_Value03',
        'PPProduktpass_Style_Value04',
        'PPProduktpass_Style_Value05',
        'PPProduktpass_Style_Value01_Translation',
        'PPProduktpass_Style_Value02_Translation',
        'PPProduktpass_Style_Value03_Translation',
        'PPProduktpass_Style_Value04_Translation',
        'PPProduktpass_Style_Value05_Translation',
        'PPProduktpass_Style_PPProduktpass_Id',
        'PPProduktpass_Style_PPPPFiles_Id',
    ];
}
