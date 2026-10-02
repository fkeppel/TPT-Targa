<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPUserSettings extends Model
{
    protected $table = 'PPUserSettings';

    protected $primaryKey = 'PPUserSettings_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPUserSettings_Setting',
        'PPUserSettings_Type',
        'PPUserSettings_Value',
        'PPUserSettings_User',
        'PPUserSettings_UserId',
    ];
}
