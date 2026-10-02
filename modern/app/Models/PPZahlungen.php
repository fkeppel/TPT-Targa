<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPZahlungen extends Model
{
    protected $table = 'PPZahlungen';

    protected $primaryKey = 'PPZahlungen_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPZahlungen_PPProduktpass_Id',
        'PPZahlungen_LC',
        'PPZahlungen_Nummer',
        'PPZahlungen_BezahltAm',
        'PPZahlungen_Bemerkung',
        'PPZahlungen_LCEroeffnung',
        'PPZahlungen_LCEroeffnungAlternativ',
        'PPZahlungen_Andienung',
        'PPZahlungen_ZahlungKunde',
        'PPZahlungen_BezahltBemerkung',
        'PPZahlungen_Betrag',
    ];
}
