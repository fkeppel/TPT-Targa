<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPDevisenTerminKaeufe extends Model
{
    protected $table = 'PPDevisenTerminKaeufe';

    protected $primaryKey = 'PPDevisenTerminKaeufe_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPDevisenTerminKaeufe_Referenz',
        'PPDevisenTerminKaeufe_Termin',
        'PPDevisenTerminKaeufe_Betrag',
        'PPDevisenTerminKaeufe_Kurs',
        'PPDevisenTerminKaeufe_Bank',
        'PPDevisenTerminKaeufe_Status',
    ];
}
