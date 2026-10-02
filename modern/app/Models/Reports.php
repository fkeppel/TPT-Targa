<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    protected $table = 'Reports';

    protected $primaryKey = 'Reports_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $guarded = [];

    public static function getreports($use)
    {

        $reps = Reports::where('Reports_Id', '>', 0)->where('Reports_Use'.$use, 1)->get();

        return $reps;
    }
}
