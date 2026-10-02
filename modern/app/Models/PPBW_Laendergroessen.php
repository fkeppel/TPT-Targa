<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPBW_Laendergroessen extends Model
{
    protected $table = 'PPBW_Laendergroessen';

    protected $primaryKey = 'PPBW_Laendergroessen_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPBW_Laendergroessen_Id', 'PPBW_Laendergroessen_Land',
        'PPBW_Laendergroessen_Groesse', 'PPBW_Laendergroessen_Bett_Laenge',
        'PPBW_Laendergroessen_Bett_Breite', 'PPBW_Laendergroessen_Anz_Kissen',
        'PPBW_Laendergroessen_Kissen_Laenge', 'PPBW_Laendergroessen_Kissen_Breite',
    ];
}
