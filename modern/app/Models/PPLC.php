<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPLC extends Model
{
    protected $table = 'PPLC';

    protected $primaryKey = 'PPLC_Id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

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
        'PPLC_OverShipment',
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
        'PPLC_ConfirmationInstructions',
        'PPLC_IPAN',
        'PPLC_FinalDate',
    ];
}
