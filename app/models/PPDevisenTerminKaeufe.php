<?php

class PPDevisenTerminKaeufe extends Eloquent {

    protected $table = 'PPDevisenTerminKaeufe';
    public $timestamps = true;
    protected $primaryKey = 'PPDevisenTerminKaeufe_Id';
    protected $fillable = array(
        'PPDevisenTerminKaeufe_Referenz',
        'PPDevisenTerminKaeufe_AngelegtAm',
        'PPDevisenTerminKaeufe_Termin',
        'PPDevisenTerminKaeufe_Betrag',
        'PPDevisenTerminKaeufe_Kurs',
        'PPDevisenTerminKaeufe_Bank',
        'PPDevisenTerminKaeufe_Status'
    );

}
