<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPXML_OSMengen extends Model
{
    protected $table = 'PPXML_OSMengen';

    protected $primaryKey = 'PPXML_OSMengen_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPXML_OSMengen_lsv',
        'PPXML_OSMengen_styleNo',
        'PPXML_OSMengen_productName',
        'PPXML_OSMengen_sizeName'.
        'PPXML_OSMengen_country',
        'PPXML_OSMengen_value',
        'PPXML_OSMengen_PPProduktpass_Id',
    ];
}
