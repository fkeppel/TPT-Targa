<?php

class PPLaenderaufteilung extends Eloquent {

    protected $table = 'PPLaenderaufteilung';
    public $timestamps = True;
    protected $primaryKey = 'PPLaenderaufteilung_Id';
    protected $fillable = array(
        'PPLaenderaufteilung_Land',
        'PPLaenderaufteilung_Warehouse',
        'PPLaenderaufteilung_Menge_Kollies',
        'PPLaenderaufteilung_PPProduktpass_Id'
    );

}
