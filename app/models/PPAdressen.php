<?php

class PPAdressen extends Eloquent {

    protected $table = 'PPAdressen';
    public $timestamps = True;
    protected $primaryKey = 'Id';
    protected $fillable = array(
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
        'PPAdressen_ZertBSCIValid'
    );

}
