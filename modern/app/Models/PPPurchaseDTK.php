<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPPurchaseDTK extends Model
{
    protected $table = 'PPPurchaseDTK';

    protected $primaryKey = 'PPPurchaseDTK_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPPurchaseDTK_PPProduktpass_id',
        'PPPurchaseDTK_PPDevisenTerminKauf_Id',
        'PPPurchaseDTK_Betrag',
    ];
}
