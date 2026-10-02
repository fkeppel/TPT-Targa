<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InquiryRechenmenge extends Model
{
    protected $table = 'Inquiry_Rechenmenge';

    protected $primaryKey = 'ID';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;
}
