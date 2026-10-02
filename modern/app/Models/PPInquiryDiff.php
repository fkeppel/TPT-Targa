<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPInquiryDiff extends Model
{
    protected $table = 'PPInquiryDiff';

    protected $primaryKey = 'PPInquiryDiff_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'PPInquiryDiff_PPProduktpass_Id',
        'PPInquiryDiff_Header',
        'PPInquiryDiff_Row',
        'PPInquiryDiff_Version',
        'PPInquiryDiff_Value_1',
        'PPInquiryDiff_Value_2',
        'PPInquiryDiff_Value_3',
        'PPInquiryDiff_Value_4',
        'PPInquiryDiff_Value_5',
        'PPInquiryDiff_Value_6',
        'PPInquiryDiff_Value_7',
        'PPInquiryDiff_Value_8',
        'PPInquiryDiff_Value_9',
        'PPInquiryDiff_Value_10',
    ];
}
