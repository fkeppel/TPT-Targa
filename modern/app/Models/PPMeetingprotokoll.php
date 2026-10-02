<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPMeetingprotokoll extends Model
{
    protected $table = 'PPMeetingprotokoll';

    protected $primaryKey = 'PPMeetingprotokoll_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
