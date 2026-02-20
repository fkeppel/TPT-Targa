<?php

class PPLC extends Eloquent {

    protected $primaryKey = 'PPLC_Id';
    protected $table = 'PPLC';
    public $timestamps = false;
    protected $fillable = [
        'PPLC_PPProduktpass_Id',
        'PPLC_Applicant',
        'PPLC_Beneficiary',
        'PPLC_AdvisingBank',
        'PPLC_AdvisingBankLand',
        'PPLC_FormOfDocumentaryCredit',
        'PPLC_ApplicableRules',
        'PPLC_DateAndPlaceOfExpiry',
        'PPLC_AvailableWith',
        'PPLC_PartitialShipment',
        'PPLC_TransShipment',
        'PPLC_ForTransportationTo',
        'PPLC_Overshipment',
        'PPLC_OtherSpec',
        'PPLC_DocumentsRequired',
        'PPLC_AdditionalConditions',
        'PPLC_Charges',
        'PPLC_Deduction',
        'PPLC_TextPort',
        'PPLC_Amount',
        'PPLC_TOP',
        'PPLC_POL',
        'PPLC_LDOS',
        'PPLC_DOTG',
        'PPLC_PeriodeForPrensentation',
        'PPLC_ConfirmationInstructions',
        'PPLC_IPAN',
        'PPLC_FinalDate'
    ];

}
