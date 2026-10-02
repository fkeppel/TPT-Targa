<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPAdressen extends Model
{
    protected $table = 'PPAdressen';

    protected $primaryKey = 'Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'Art',
        'Firma1',
        'Firma2',
        'Ansprechpartner',
        'Adresse1',
        'Adresse2',
        'Matchcode',
        'PLZ',
        'Ort',
        'Postfach',
        'Land',
        'Telefon',
        'Fax',
        'email',
        'web',
        'delcredere',
        'EORI',
        'Steuernummer',
        'USt_Id',
        'PPAdressen_LidlId',
        'PPAdressen_Abgangshafen',
        'PPAdressen_Mobil',
        'PPAdressen_Agent',
        'PPAdressen_LT',
        'PPAdressen_ZertStep',
        'PPAdressen_ZertStepValid',
        'PPAdressen_ZertBSCI',
        'PPAdressen_ZertBSCIValid',
    ];
}
