<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPXML_Mengen extends Model
{
    protected $table = 'PPXML_Mengen';

    protected $primaryKey = 'PPXML_Mengen_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPXML_Mengen_lsv',
        'PPXML_Mengen_styleNo',
        'PPXML_Mengen_productName',
        'PPXML_Mengen_sizeName',
        'PPXML_Mengen_sizeCode',
        'PPXML_Mengen_country',
        'PPXML_Mengen_value',
        'PPXML_Mengen_PPProduktpass_Id',
    ];
}
