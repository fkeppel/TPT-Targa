<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPMitarbeiter extends Model
{
    protected $table = 'PPMitarbeiter';

    protected $primaryKey = 'PPMitarbeiter_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];

    public function scopeAktiv($query)
    {
        return $query->where('PPMitarbeiter_Status', '>=', 1);
    }

    public function scopeTaetigkeit($query, $part)
    {
        if ($part === '') {
            return $query;
        }

        return $query->where(
            'PPMitarbeiter_Taetigkeit',
            'LIKE',
            '%'.$part.'%'
        );
    }
}
