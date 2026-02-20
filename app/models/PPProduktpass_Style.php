<?php

class PPProduktpass_Style extends Eloquent {

    protected $table      = 'PPProduktpass_Style';
    public $timestamps    = false;
    protected $primaryKey = 'PPProduktpass_Style_Id';
    protected $fillable = array(
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
        'PPProduktpass_Style_PPPPFiles_Id'
    );

}
