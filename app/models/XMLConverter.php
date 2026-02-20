<?php

class XMLConverter extends Eloquent {

    protected $table = 'XMLConverter';
    public $timestamps = false;
    protected $primaryKey = 'XMLConverter_Id';
    protected $fillable = ['XMLConverter_DBTable',
        'XMLConverter_DBColumn',
        'XMLConverter_XMLNode'];

}
