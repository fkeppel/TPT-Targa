<?php

class PPInquiryDiff extends Eloquent {

    protected $table = 'PPInquiryDiff';
    public $timestamps = false;
    protected $primaryKey = 'PPInquiryDiff_Id';
    protected $fillable = array(
        'PPInquiryDiff_PPProduktpass_Id',
        'PPInquiryDiff_Header',
        'PPInquiryDiff_Row',
        'PPInquiryDiff_Version',
        'PPInquiryDiff_Value_1', 'PPInquiryDiff_Value_2', 'PPInquiryDiff_Value_3', 'PPInquiryDiff_Value_4', 'PPInquiryDiff_Value_5', 'PPInquiryDiff_Value_6', 'PPInquiryDiff_Value_7', 'PPInquiryDiff_Value_8', 'PPInquiryDiff_Value_9', 'PPInquiryDiff_Value_10'
    );

}
