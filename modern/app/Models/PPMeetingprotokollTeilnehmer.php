<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPMeetingprotokollTeilnehmer extends Model
{
    protected $table = 'PPMeetingprotokollTeilnehmer';

    protected $primaryKey = 'PPMeetingprotokollTeilnehmer_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];
}
