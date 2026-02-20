<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PPZahlungen extends Eloquent {

    protected $table = 'PPZahlungen';
    public $timestamps = false;
    protected $primaryKey = 'PPZahlungen_Id';
    protected $fillable = array(
        'PPZahlungen_PPProduktpass_Id',
        'PPZahlungen_LC',
        'PPZahlungen_Nummer',
        'PPZahlungen_BezahltAm',
        'PPZahlungen_Bemerkung',
        'PPZahlungen_LCEroeffnung',
        'PPZahlungen_LCEroeffnungAlternativ',
        'PPZahlungen_Andienung',
        'PPZahlungen_Fälligkeit',
        'PPZahlungen_ZahlungKunde',
        'PPZahlungen_BezahltBemerkung',
        'PPZahlungen_Betrag'
    );

}
