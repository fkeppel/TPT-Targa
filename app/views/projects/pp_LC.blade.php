<?php $bgcolor1 = "#f6a828"; ?>

<style>


    #LCData td{
        border:none;
        padding:3px;
        vertical-align: middle;
        padding-left:10px;
    }
    #LCData table {
        margin:0px;
    }
    #LC_OPEN textarea{
        width:800px;
        border-radius: 0px;
        border: 1px solid darkblue;
        height:400px;
        padding:5px;
        margin: 0px;
    }

    #LC_OPEN .small_textarea{
        width:800px;
        border-radius: 0px;
        border: 1px solid darkblue;
        height:125px;
        padding:5px;
        margin: 0px;
    }


    #LC_OPEN table{
        padding: 0px;
        border-collapse: collapse;

    }
    #LC_OPEN input{
        width:800px;
        padding:5px;
        border:1px solid darkblue;
        border-radius: 0px;
        margin:0px;

    }
    .td_label {
        width:320px;
        font-weight: bold;
        border:1px solid darkblue;
        padding:5px;
    }
    .td_value {
        width:400px;
        padding:0px;
        border:1px solid darkblue;
    }


</style>

<div id="LC_OPEN" style="border:1PX SOLID gray; border-radius: 0px; height:844px;overflow: auto; padding: 2px;">

    <h1>LC-Eröffnung</h1>

    <?php
    $amount   = $data['pp']->PPProduktpass_Gesamtmenge * $data['purchase']->PPPurchase_EK;
    $dto      = new DateTime();

    $prjIANs = $data['LCALL']['ProjektIANS'];

    try {
        $fobdate = $dto->setISODate($data['purchase']->PPPurchase_FOBYear + 2000, $data['purchase']->PPPurchase_FOBWeek)->format("Y-m-d");
    }
    catch (Exception $ex) {
        $fobdate = "";
    }
    $amount = 0;

    $lcdate = "";
    if (strlen($data['LC']['PPLC_FinalDate']) >= 10) {
        $lcdate = date('d.m.Y', strtotime($data['LC']['PPLC_FinalDate']));
    }

    foreach ($data['POS'] as $po) {

        if (isset($po['PO']->PPPurchase_EK) and isset($po['PP']->PPProduktpass_Gesamtmenge)) {

            $amount += $po['PP']->PPProduktpass_Gesamtmenge * $po['PO']->PPPurchase_EK;
        }
    }
    ?>

    <div>

        <div id="frm_button" style="float:left;">
            <button onclick="frm_submit();" class="btn" style="width:120px;background-color: #e78f08;border:none;height:25px;">L/C speichern</button>
        </div>
        <div id="frm_button"  style="float:left; margin-left: 10px;">
            {{ Form::open( array('url'=>'outPDFLC/'.$data['pp']['PPProduktpass_Id'], 'class'=>'form-signin')) }}
            {{ Form::submit('PDF LC', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;border:none;'))}}
            {{ Form::close() }}
        </div>
        <div id="frm_button"  style="float:left; margin-left: 10px;">
            {{ Form::open( array('url'=>'outPDFLCFinal/'.$data['pp']['PPProduktpass_Id'].'/1', 'class'=>'form-signin')) }}
            {{ Form::submit('PDF LC Final', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;border:none;'))}}
            {{ Form::close() }}
        </div>
        <div style="clear: both;">&nbsp;</div>
    </div>

    {{ Form::model($data['LC'], array('url'=>'updatelc', 'class'=>'form-signin', 'id' => 'frm_lc')) }}
    {{Form::hidden('PPLC_Id',$data['LC']['PPLC_Id'])}}
    {{Form::hidden('Produktpass_Id',$data['pp']->PPProduktpass_Id)}}


    <div id="LCData" style="border:1px solid darkblue; height:110px;margin-top: -10px;border-radius: 0px;">

        <table style="font-family: Tahoma, Arial, sans-serif;font-size: 12px;">
            <tr>
                <td><b>Status</b></td>
                <td>{{ Form::select('LC[PPLC_StatusId]',$data['LCStati'],$data['LC']['PPLC_StatusId'],array('style'=>'padding:4px;width:200px;')) }}</td>
                <td><b>LC-Number</b></td>
                <td> {{ Form::Text('LC[PPLC_LCNo]',$data['LC']['PPLC_LCNo'],array('style'=>'padding:4px;width:200px;')) }}</td>
                <td><b>Debit-Note</b></td>
                <td> {{ Form::Text('LC[PPLC_DebitNote]',$data['LC']['PPLC_DebitNote'],array('style'=>'padding:4px;width:200px;')) }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><b>LC-Eröffung</b></td>
                <td> {{ Form::Text('LC[PPLC_Eroeffnung]',$data['LC']['PPLC_Eroeffnung'],array('style'=>'padding:4px;width:200px;')) }}</td>
                <td><b>Remark</b></td>
                <td> {{ Form::Text('LC[PPLC_Bemerkung]',$data['LC']['PPLC_Bemerkung'],array('style'=>'padding:4px;width:200px;')) }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><b>LC-Andienung</b></td>
                <td> {{ Form::Text('LC[PPLC_Andienung]',$data['LC']['PPLC_Andienung'],array('style'=>'padding:4px;width:200px;')) }}</td>
                <td></td>
                <td></td>
            </tr>
        </table>


    </div>
    <div style="border:1px solid darkblue; height:624px;overflow: auto;border-radius: 0px;">
        <table>
            <tr>
                <td class="td_label">Last Upload Date:</td>
                <td  class="td_value"><input disabled="disabled" value="{{$lcdate}}" /></td>
            </tr>
            <tr>
                <td class="td_label">Project:</td>
                <td  class="td_value"><input disabled="disabled" value="{{$prjIANs}}" /></td>
            </tr>
            <tr>
                <td  class="td_label">Projectdescription:</td>
                <td class="td_value"><input disabled="disabled" value="{{$data['purchase']->PPPurchase_Translate_Projectdescription}}" /></td>
            </tr>
            <tr>
                <td  class="td_label">Applicant:</td>
                <td class="td_value"><textarea class="small_textarea" name="LC[PPLC_Applicant]">@if (strlen(trim($data['LC']['PPLC_Applicant'])) > 0 and $data['LC']['PPLC_Applicant'] != "N.N."){{$data['LC']['PPLC_Applicant']}}@else{{$data['LCTexte']['LC_Applicant']}}@endif</textarea></td>
            </tr>
            <tr>
                <td class="td_label">Beneficiary:</td>
                <td class="td_value"><textarea class="small_textarea" name="LC[PPLC_Beneficiary]">@if(strlen(trim($data['LC']['PPLC_Beneficiary'])) > 0 and $data['LC']['PPLC_Beneficiary'] != "N.N."){{$data['LC']['PPLC_Beneficiary']}}@else{{$data['Supplier']}}@endif</textarea></td>
            </tr>
            <tr>
                <td class="td_label">Advising Bank:</td>
                <td class="td_value"><textarea class="small_textarea" name="LC[PPLC_AdvisingBank]">{{$data['LC']['PPLC_AdvisingBank']}}</textarea></td>
            </tr>
            <tr>
                <td class="td_label">Advising Bank Land:</td>
                <td class="td_value"><input name="LC[PPLC_AdvisingBankLand]" value="{{$data['LC']['PPLC_AdvisingBankLand']}}" /></td>
            </tr>
            <tr>
                <td class="td_label">Form of Documentary Credit:</td>
                <td class="td_value"><input name="LC[PPLC_FormOfDocumentaryCredit]" value="@if(strlen(trim($data['LC']['PPLC_FormOfDocumentaryCredit'])) > 0 and $data['LC']['PPLC_FormOfDocumentaryCredit'] != "N.N."){{$data['LC']['PPLC_FormOfDocumentaryCredit']}}@else{{$data['LCTexte']['LC_FormOfDocumentaryCredit']}}@endif" /></td>
            </tr>
            <tr>
                <td class="td_label">Applicable Rules:</td>
                <td class="td_value"><input name="LC[PPLC_ApplicableRules]" value="@if(strlen(trim($data['LC']['PPLC_ApplicableRules'])) > 0 and $data['LC']['PPLC_ApplicableRules'] != "N.N."){{$data['LC']['PPLC_ApplicableRules']}}@else{{$data['LCTexte']['LC_ApplicableRules']}}@endif" /></td>
            </tr>
            <tr>
                <td class="td_label">Date and Place of Expiry:</td>
                <td class="td_value"><input name="LC[PPLC_DateAndPlaceOfExpiry]" value="{{$data['LC']['PPLC_DateAndPlaceOfExpiry']}}" /></td>
            </tr>
            <tr>
                <td class="td_label">Currency Code and Amount:</td>
                <td class="td_value"><input  name="LC[PPLC_Amount]" value="@if(isset($data['LC']['PPLC_Amount']) and $data['LC']['PPLC_Amount'] != 'N.N.' ){{$data['LC']['PPLC_Amount']}}@else{{$data['purchase']->PPPurchase_Currency}} {{number_format($amount,2,',','.')}}@endif" /></td>
            </tr>
            <tr>
                <td class="td_label"></td>
                <td class="td_value" style="border:2px solid orange"><input disabled="disabled" value="{{$data['purchase']->PPPurchase_Currency}} {{number_format($amount,2,',','.')}}" /></td>
            </tr>
            <tr>
                <td class="td_label">Available with ..... By:</td>
                <td class="td_value"><textarea class="small_textarea" name="LC[PPLC_AvailableWith]">{{$data['LC']['PPLC_AvailableWith']}}</textarea></td>
            </tr>

            <tr>
                <td class="td_label">Negotiation/Deferred Payment Details:</td>
                <td class="td_value"><input  name="LC[PPLC_TOP]" value="@if(isset($data['LC']['PPLC_TOP']) and $data['LC']['PPLC_TOP'] != 'N.N.' ){{$data['LC']['PPLC_TOP']}}@else{{$data['purchase']->PPPurchase_LC_TOP}}@endif" /></td>
            </tr>
            <tr>
                <td class="td_label"></td>
                <td class="td_value" style="border:2px solid orange"><input disabled="disabled" value="{{$data['purchase']->PPPurchase_LC_TOP}}" /></td>
            </tr>
            <tr>
                <td class="td_label">Partial Shipment:</td>
                <td class="td_value"><input name="LC[PPLC_PartitialShipment]" value="@if(strlen(trim($data['LC']['PPLC_PartitialShipment'])) > 0 and $data['LC']['PPLC_PartitialShipment'] != "N.N."){{$data['LC']['PPLC_PartitialShipment']}}@else{{$data['LCTexte']['LC_PartitialShipment']}}@endif" /></td>
            </tr>
            <tr>
                <td class="td_label">Transshipment:</td>
                <td class="td_value"><input name="LC[PPLC_TransShipment]"  value="@if(strlen(trim($data['LC']['PPLC_TransShipment'])) > 0 and $data['LC']['PPLC_TransShipment'] != "N.N."){{$data['LC']['PPLC_TransShipment']}}@else{{$data['LCTexte']['LC_TransShipment']}}@endif" /></td>
            </tr>

            <?php
            $pol = "";
            if (isset($data['LC']['PPLC_POL']) and $data['LC']['PPLC_POL'] != 'N.N.') {
                $pol = $data['LC']['PPLC_POL'];
            }
            else {
                if (isset($data['haefen'][$data['ab']->PPAB_Abgangshafen])) {
                    $pol = $data['haefen'][$data['ab']->PPAB_Abgangshafen];
                }
            }
            $pol2 = "";
            if (isset($data['haefen'][$data['ab']->PPAB_Abgangshafen])) {
                $pol2 = $data['haefen'][$data['ab']->PPAB_Abgangshafen];
            }
            ?>

            <tr>
                <td class="td_label">Port of Loading / Airport of Departure:</td>
                <td class="td_value"><input  name="LC[PPLC_POL]" value="{{$pol}}" /></td>
            </tr>
            <tr>
                <td class="td_label"></td>
                <td class="td_value" style="border:2px solid orange"><input disabled="disabled" value="{{$pol2}}" /></td>
            </tr>


            <tr>
                <td class="td_label">For Transportation to:</td>
                <td class="td_value">
                    <select name="LC[PPLC_TextPort]">
                        <option>Bitte wählen...</option>
                        <option @if($data['LC']['PPLC_TextPort'] == "Europa") selected='selected' @endif >Europa</option>
                        <option @if($data['LC']['PPLC_TextPort'] == "USA") selected='selected' @endif >USA</option>
                    </select>
                    <?php
                    $text_port = "N.N.";
                    if ($data['LC']['PPLC_TextPort'] == "Europa") {
                        $text_port = $data['LCTexte']['LC_Port_Europe'];
                    }
                    if ($data['LC']['PPLC_TextPort'] == "USA") {
                        $text_port = $data['LCTexte']['LC_Port_USA'];
                    }
                    ?>
                    <textarea  name="LC[PPLC_ForTransportationTo]" style="height:110px;">@if(strlen(trim($data['LC']['PPLC_ForTransportationTo'])) > 0 and $data['LC']['PPLC_ForTransportationTo'] != "N.N."){{$data['LC']['PPLC_ForTransportationTo']}}@else{{$text_port}}@endif</textarea></td>
            </tr>



            <tr>
                <td class="td_label">Latest Date of Shipment:</td>
                <td class="td_value"><textarea  style="height:80px;" name="LC[PPLC_LDOS]">@if(isset($data['LC']['PPLC_LDOS']) and $data['LC']['PPLC_LDOS'] != 'N.N.' ){{$data['LC']['PPLC_LDOS']}}@else{{$fobdate}} Calendarweek: {{$data['purchase']->PPPurchase_FOBWeek}}/{{$data['purchase']->PPPurchase_FOBYear}}  @endif</textarea></td>
            </tr>
            <tr>
                <td class="td_label"></td>
                <td class="td_value" style="border:2px solid orange;"><textarea style="height:80px;" disabled="disabled">{{$fobdate}} Calendarweek: {{$data['purchase']->PPPurchase_FOBWeek}}/{{$data['purchase']->PPPurchase_FOBYear}} </textarea></td>
            </tr>
            <tr>
                <td class="td_label">Description of the Goods:</td>
                <td class="td_value"><textarea name="LC[PPLC_DOTG]">@if(isset($data['LC']['PPLC_DOTG']) and $data['LC']['PPLC_DOTG'] != 'N.N.'){{$data['LC']['PPLC_DOTG']}}@else{{$data['LCDescGoods']}}@endif</textarea></td>
            </tr>   <tr>
                <td class="td_label"></td>
                <td class="td_value"><textarea disabled="disabled">{{$data['LCDescGoods']}}</textarea></td>
            </tr>
            <tr>
                <td class="td_label">Overshipment:</td>
                <td class="td_value"><input name="LC[PPLC_OverShipment]" value="@if (strlen(trim($data['LC']['PPLC_OverShipment'])) > 0 and $data['LC']['PPLC_OverShipment'] != "N.N."){{$data['LC']['PPLC_OverShipment']}}@else{{$data['LCTexte']['LC_OverShipment']}}@endif" /></td>
            </tr>
            <tr>
                <td class="td_label">Other specifications:</td>
                <td class="td_value"><input name="LC[PPLC_OtherSpec]" value="@if (strlen(trim($data['LC']['PPLC_OtherSpec'])) > 0 and $data['LC']['PPLC_OtherSpec'] != "N.N."){{$data['LC']['PPLC_OtherSpec']}}@else{{$data['LCTexte']['LC_OtherSpec']}}@endif" /></td>
            </tr>
            <?php
            $docs = "LC_DocumentsRequired";
            if ($data['LC']['PPLC_TextPort'] == "USA") {
                $docs = "LC_DocumentsRequiredUSA";
            }
            ?>
            <tr>
                <td class="td_label">Documents Required:</td>
                <td class="td_value"><textarea  name="LC[PPLC_DocumentsRequired]">@if(strlen(trim($data['LC']['PPLC_DocumentsRequired'])) > 0  and $data['LC']['PPLC_DocumentsRequired'] != 'N.N.' ){{$data['LC']['PPLC_DocumentsRequired']}}@else{{$data['LCTexte'][$docs]}}@endif</textarea></td>
            </tr>

            <tr>
                <td class="td_label">Additional Conditions:</td>
                <td class="td_value"><textarea class="small_textarea" name="LC[PPLC_AdditionalConditions]">@if(strlen(trim($data['LC']['PPLC_AdditionalConditions'])) > 0  and $data['LC']['PPLC_AdditionalConditions'] != 'N.N.' ){{$data['LC']['PPLC_AdditionalConditions']}}@else{{$data['LCTexte']['LC_AdditionalConditions']}}@endif</textarea></td>
            </tr>
            <tr>
                <td class="td_label">Deduction</td>
                <td class="td_value"><textarea class="small_textarea" name="LC[PPLC_Deduction]">{{$data['LC']['PPLC_Deduction']}}</textarea></td>
            </tr>
            <tr>
                <td class="td_label">Charges:</td>
                <td class="td_value"><textarea  style="height:125px;" name="LC[PPLC_Charges]">@if(strlen(trim($data['LC']['PPLC_Charges'])) > 0  and $data['LC']['PPLC_Charges'] != 'N.N.' ){{$data['LC']['PPLC_Charges']}}@else{{$data['LCTexte']['LC_Charges']}}@endif</textarea></td>
            </tr>
            <tr>
                <td class="td_label">Periode For Presentation:</td>
                <td class="td_value"><textarea style="height:80px;" name="LC[PPLC_PeriodeForPresentation]">@if(strlen(trim($data['LC']['PPLC_PeriodeForPresentation'])) > 0  and $data['LC']['PPLC_PeriodeForPresentation'] != 'N.N.' ){{$data['LC']['PPLC_PeriodeForPresentation']}}@else{{$data['LCTexte']['LC_PeriodeForPresentation']}}@endif</textarea></td>
            </tr>
            <tr>
                <td class="td_label">Confirmation Instructions:</td>
                <td class="td_value"><textarea style="height:80px;" name="LC[PPLC_ConfirmationInstructions]">@if(strlen(trim($data['LC']['PPLC_ConfirmationInstructions'])) > 0  and $data['LC']['PPLC_ConfirmationInstructions'] != 'N.N.' ){{$data['LC']['PPLC_ConfirmationInstructions']}}@else{{$data['LCTexte']['LC_ConfirmationInstructions']}}@endif</textarea></td>
            </tr>
            <tr>
                <td class="td_label">Inst/Paying/Accept/Negotiate Bank:</td>
                <td class="td_value"><textarea style="height:80px;" name="LC[PPLC_IPAN]">@if(strlen(trim($data['LC']['PPLC_ConfirmationInstructions'])) > 0  and $data['LC']['PPLC_IPAN'] != 'N.N.' ){{$data['LC']['PPLC_IPAN']}}@else{{$data['LCTexte']['LC_IPAN']}}@endif</textarea></td>
            </tr>
        </table>
    </div>
    {{ Form::close() }}
</div>


<script>
    function frm_submit() {

        frm = document.getElementById("frm_lc");
        frm.submit();
    }
</script>