<?php

class PPXML_Mengen extends Eloquent {

    protected $table = 'PPXML_Mengen';
    public $timestamps = false;
    protected $primaryKey = 'PPXML_Mengen_Id';
    protected $fillable = array(
        'PPXML_Mengen_lsv',
        'PPXML_Mengen_styleNo',
        'PPXML_Mengen_productName',
        'PPXML_Mengen_sizeName',
        'PPXML_Mengen_sizeCode',
        'PPXML_Mengen_country',
        'PPXML_Mengen_value',
        'PPXML_Mengen_PPProduktpass_Id'
    );

}
