<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPDictionary extends Model
{
    protected $table = 'PPDictionary';

    protected $primaryKey = 'PPDictionary_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPDictionary_Language', 'PPDictionary_Eintrag', 'PPDictionary_Uebersetzung',
    ];
}
