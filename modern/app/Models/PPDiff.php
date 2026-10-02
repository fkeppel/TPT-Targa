<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PPDiff extends Model
{
    protected $table = 'PPDiff';

    protected $primaryKey = 'PPDiff_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPDiff_Art',
        'PPDiff_ObjectId',
        'PPDiff_ItemId',
        'PPDiff_Value',
    ];

    public static function getMaxRev($id)
    {
        $row = DB::table('PPDiff')
            ->select(DB::raw('max(PPDiff_Rev) as MaxRev'))
            ->where('PPDiff_ObjectId', '=', $id)
            ->first();

        return $row->MaxRev;

    }
}
