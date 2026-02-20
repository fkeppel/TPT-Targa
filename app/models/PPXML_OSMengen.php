<?php

class PPXML_OSMengen extends Eloquent {

    protected $table = 'PPXML_OSMengen';
    public $timestamps = false;
    protected $primaryKey = 'PPXML_OSMengen_Id';
    protected $fillable = array(
        'PPXML_OSMengen_lsv',
        'PPXML_OSMengen_styleNo',
        'PPXML_OSMengen_productName',
        'PPXML_OSMengen_sizeName' .
        'PPXML_OSMengen_country',
        'PPXML_OSMengen_value',
        'PPXML_OSMengen_PPProduktpass_Id'
    );

}
