<style>
    .cpc_POLabel{
        width:180px;
    }
    #mainPO li {
        list-style: none;
    }
</style>

<div style="position: relative;">


    {{ Form::model($data['purchase'], array('url'=>'updatepurchase/'.$data['pp']['PPProduktpass_Id'], 'class'=>'form-signin')) }}
    @if (!$data['pp']['PPProduktpass_IsRevision'])
    <div style="margin:0 auto;text-align:center;width:110px;position:absolute;top:10px;right:18; z-index: 100;padding-top:8px;border-top:none;">
        {{ Form::submit('speichern', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;'))}}
    </div>
    @endif
    <div id="mainPO" style="width:600px;float:left;">
        <fieldset style="height:800px;">
            <legend>
                Purchase - Order
            </legend>


            <li>
                {{ Form::label('PPPurchase_ScNumber','SC') }}{{ Form::text('PPPurchase_ScNumber') }}
            </li>
            <li>
                {{ Form::label('PPPurchase_Inquiry','Inquiry') }}{{ Form::textarea('PPPurchase_Inquiry') }}
            </li>
            <li>
                {{ Form::label('PPPurchase_Supplier','Supplier') }}{{ Form::select('PPPurchase_Supplier',$data['suppliers'],$data['purchase']->PPPurchase_Supplier,array('style'=>'padding:4px;')) }}
            </li>
            <li>
                {{ Form::label('PPPurchase_Remark','Remark') }}{{ Form::textarea('PPPurchase_Remark') }}
            </li>
            <li>
                {{ Form::label('PPPurchase_Currency','Currency') }}{{ Form::select('PPPurchase_Currency', array(' ' =>'N.N.','EUR'=>'EUR', 'USD'=>'USD'), $data['purchase']->PPPurchase_Currency, array('style'=>'width:80px;')) }}
            </li>
            <li>
                {{ Form::label('PPPurchase_ExcR_Calc','Exchangerate Calc') }}{{ Form::text('PPPurchase_ExcR_Calc',number_format($data['purchase']['PPPurchase_ExcR_Calc'],4,',','.'),  array('style'=>'width:80px;')) }}
            </li>
            <li>
                {{ Form::label('PPPurchase_ExcR_Save','Exchangerate save/Date') }}{{ Form::text('PPPurchase_ExcR_Save',number_format($data['purchase']['PPPurchase_ExcR_Save'],4,',','.'), array('style'=>'width:80px;')) }} {{ Form::text('PPPurchase_ExcR_Save_Date',$data['purchase']->PPPurchase_ExcR_Save_Date,  array('style'=>'width:80px;')) }}
            </li>
            <li>
                {{ Form::label('PPPurchase_ExcR_Remark','Exchangerate Remarks') }}{{ Form::textarea('PPPurchase_ExcR_Remark') }}
            </li>
            <li>
                {{ Form::label('PPPurchase_CustomsCode','Customs Code') }}{{ Form::text('PPPurchase_CustomsCode') }}
            </li>

            <li>
                {{ Form::label('PPPurchase_Status','Status') }}{{ Form::text('PPPurchase_Status') }}
            </li>



            <div style="height:224px;overflow: auto;border:1px solid darkblue; padding: 10px;">
                <?php
                $Kfiles = array();
                foreach ($data['files']['files'] as $file) {
                    if ($file['PPPPFiles_Type'] == 'Kalkulation') {
                        $Kfiles[$file['PPPPFiles_Id']]['filename'] = $file['PPPPFiles_Name'];
                        $Kfiles[$file['PPPPFiles_Id']]['path']     = $file['PPPPFiles_Pfad'];
                        $Kfiles[$file['PPPPFiles_Id']]['date']     = $file['PPPPFiles_Date'];
                        $Kfiles[$file['PPPPFiles_Id']]['desc']     = $file['PPPPFiles_Description'];
                    }
                }
                ?>

                <table style="font-size:11px;">
                    <tr style="background-color:lightgray;">
                        <td>Datum</td>
                        <td>Bezeichnung</td>
                        <td>File</td>
                        <td>Download</td>
                    </tr>

                    @foreach($Kfiles as $id =>  $kfile)
                    <tr>
                        <td>{{date_format(date_create($kfile['date']),"Y-m-d")}}
                        <td>{{$kfile['desc']}}</td>
                        <td style="width:200px;">{{substr($kfile['filename'],7)}}</td>
                        <td><a href="{{'/data/'.$kfile['path'].'/'.$kfile['filename']}}" target="_blank">download</a></td>

                        @endforeach
                </table>

            </div>


        </fieldset>
    </div>
    <div id='mainPO' style="width:600px;float:left;">
        <fieldset style="height:800px;">
            <legend>
                Interne Daten
            </legend>
            <br>
            <span style="color:#1c94c4;margin:18px;margin-left:42px;"><b>Gesamtmenge: {{number_format($data['pp']->PPProduktpass_Gesamtmenge,0,',','.')}}</b></span>
            <?php
            $showSave                 = $data['purchase']->PPPurchase_ExcR_Save <> 0
                        ? 1 : 0;
            ?>
            <?php $kalk['VKP']              = $data['ab']->PPAB_VKEUR; ?>
            <?php $kalk['VKP3']             = $kalk['VKP'] - ($kalk['VKP'] * 0.3 / 100); ?>
            <?php $kalk['Menge']            = $data['pp']->PPProduktpass_Gesamtmenge; ?>
            <?php $kalk['EK_FW']            = $data['purchase']->PPPurchase_EK_Calc; ?>
            <?php
            $kalk['EK_EURC']          = $data['purchase']->PPPurchase_ExcR_Calc <> 0
                        ? $data['purchase']->PPPurchase_EK_Calc / $data['purchase']->PPPurchase_ExcR_Calc
                        : 0;
            ?>
            <?php
            $kalk['EK_EURS']          = $data['purchase']->PPPurchase_ExcR_Save <> 0
                        ? $data['purchase']->PPPurchase_EK_Calc / $data['purchase']->PPPurchase_ExcR_Save
                        : 0;
            ?>
            <?php $kalk['Fracht_Stk']       = $data['purchase']->PPPurchase_Fracht; ?>
            <?php $kalk['ZollC']            = ($kalk['EK_EURC'] + $kalk['Fracht_Stk']) * $data['purchase']->PPPurchase_Zoll / 100; ?>
            <?php $kalk['ZollS']            = ($kalk['EK_EURS'] + $kalk['Fracht_Stk']) * $data['purchase']->PPPurchase_Zoll / 100; ?>
            <?php $kalk['EKProvisionC']     = $kalk['EK_EURC'] * $data['purchase']->PPPurchase_EKProvision / 100; ?>
            <?php $kalk['EKProvisionS']     = $kalk['EK_EURS'] * $data['purchase']->PPPurchase_EKProvision / 100; ?>
            <?php $kalk['ESPC']             = $kalk['EK_EURC'] + $kalk['Fracht_Stk'] + $kalk['ZollC'] + $kalk['EKProvisionC'] ?>
            <?php $kalk['ESPS']             = $kalk['EK_EURS'] + $kalk['Fracht_Stk'] + $kalk['ZollS'] + $kalk['EKProvisionS'] ?>
            <?php
            $kalk['Ausgangsfrachten'] = $data['purchase']->PPPurchase_Ausgangsfrachten;
            $kalk['Pruefkosten']      = $data['purchase']->PPPurchase_Pruefkosten;
            ?>
            <?php $kalk['FinanzierungC']    = $kalk['ESPC'] * $data['purchase']->PPPurchase_Finanzierungskosten / 100 ?>
            <?php $kalk['FinanzierungS']    = $kalk['ESPS'] * $data['purchase']->PPPurchase_Finanzierungskosten / 100 ?>

            <?php $kalk['Lizenz']           = $kalk['VKP'] * $data['purchase']->PPPurchase_Lizenzgebuehren / 100 ?>
            <?php $kalk['Kosten']           = $data['purchase']->PPPurchase_Kosten; ?>
            <?php $kalk['SonstKostenProz']  = $kalk['VKP'] * $data['purchase']->PPPurchase_SonstKostenProz / 100 ?>

            <?php $kalk['SKPC']             = $kalk['ESPC'] + $kalk['Ausgangsfrachten'] + $kalk['FinanzierungC'] + $kalk['Pruefkosten'] + $kalk['Lizenz'] + $kalk['Kosten'] + $kalk['SonstKostenProz'] ?>
            <?php $kalk['SKPS']             = $kalk['ESPS'] + $kalk['Ausgangsfrachten'] + $kalk['FinanzierungS'] + $kalk['Pruefkosten'] + $kalk['Lizenz'] + $kalk['Kosten'] + $kalk['SonstKostenProz'] ?>



            <li>
                {{ Form::label('','',array('class'=>'cpc_POLabel','style'=>'float:left;')) }}
                <div style="margin-top:2px;width:75px; border:none; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;"></div>
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;background-color: lightgray;">ExR (Calc)</div>
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;background-color: lightgray;">ExR (Save)</div>
                <div style="clear: both;"></div>
            </li>
            <li>
                {{ Form::label('PPPurchase_EK_Calc','EK Lieferant (FW)',array('class'=>'cpc_POLabel','style'=>'float:left;')) }}{{ Form::text('PPPurchase_EK_Calc',number_format($data['purchase']['PPPurchase_EK_Calc'],2,',','.'),array('style'=>'width:80px;text-align:right;float:left;')) }}
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{ number_format($kalk['EK_EURC'],4,',','.') }}</div>
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{ number_format($kalk['EK_EURS'],4,',','.')}}</div>
                <div style="clear: both;"></div>
            </li>
            <li>
                {{ Form::label('PPPurchase_EKProvison','EK Provision (%)',array('class'=>'cpc_POLabel','style'=>'float:left;')) }}{{ Form::text('PPPurchase_EKProvision',number_format($data['purchase']['PPPurchase_EKProvision'],2,',','.'),array('style'=>'width:80px;text-align:right;float:left;')) }}
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($kalk['EKProvisionC'],4,',','.')}}</div>
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($showSave * $kalk['EKProvisionS'],4,',','.')}}</div>
                <div style="clear: both;"></div>
            </li>
            <li>
                {{ Form::label('PPPurchase_Fracht','Fracht / Stk. (EUR)',array('class'=>'cpc_POLabel','style'=>'float:left;')) }}{{ Form::text('PPPurchase_Fracht',number_format($data['purchase']['PPPurchase_Fracht'],4,',','.'),array('style'=>'width:80px;text-align:right;float:left;')) }}
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{ number_format($kalk['Fracht_Stk'],4,',','.')}}</div>
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{ number_format($showSave * $kalk['Fracht_Stk'],4,',','.')}}</div>
                <div style="clear: both;"></div>
            </li>
            <li>
                {{ Form::label('PPPurchase_Zoll','Zölle (%)',array('class'=>'cpc_POLabel','style'=>'float:left;')) }}{{ Form::text('PPPurchase_Zoll',number_format($data['purchase']['PPPurchase_Zoll'],2,',','.'),array('style'=>'width:80px;text-align:right;float:left;')) }}
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($kalk['ZollC'],4,',','.')}}</div>
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($showSave * $kalk['ZollS'],4,',','.')}}</div>
                <div style="clear: both;"></div>
            </li>
            <li>
                {{ Form::label('Einstandspreis','Einstandspreis (EUR)' ,array('class'=>'cpc_POLabel','style'=>'float:left;color:red;')) }} {{ Form::text(NULL,NULL,array('style'=>'width:80px;text-align:right;float:left;')) }}
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($kalk['ESPC'],4,',','.')}}</div>
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($showSave * $kalk['ESPS'],4,',','.')}}</div>
                <div style="clear: both;"></div>
            </li>
            <li>
                {{ Form::label('PPPurchase_Ausgangsfrachten','Ausgangsfrachten/ Stk (EUR)',array('class'=>'cpc_POLabel','style'=>'float:left;')) }}{{ Form::text('PPPurchase_Ausgangsfrachten',number_format($data['purchase']['PPPurchase_Ausgangsfrachten'],4,',','.'),array('style'=>'width:80px;text-align:right;float:left;')) }}
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($kalk['Ausgangsfrachten'],4,',','.')}}</div>
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($showSave * $kalk['Ausgangsfrachten'],4,',','.')}}</div>
                <div style="clear: both;"></div>
            </li>
            <li>
                {{ Form::label('PPPurchase_Finanzierungskosten','Finanzierungskst. (% ESP)',array('class'=>'cpc_POLabel','style'=>'float:left;')) }}{{ Form::text('PPPurchase_Finanzierungskosten',number_format($data['purchase']['PPPurchase_Finanzierungskosten'],2,',','.'),array('style'=>'width:80px;text-align:right;float:left;')) }}
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($kalk['FinanzierungC'],4,',','.')}}</div>
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($showSave * $kalk['FinanzierungS'],4,',','.')}}</div>
                <div style="clear: both;"></div>
            </li>
            <li>
                {{ Form::label('PPPurchase_Pruefkosten','Prüfkst. / Stk (EUR)',array('class'=>'cpc_POLabel','style'=>'float:left;')) }}{{ Form::text('PPPurchase_Pruefkosten',number_format($data['purchase']['PPPurchase_Pruefkosten'],4,',','.'),array('style'=>'width:80px;text-align:right;float:left;')) }}
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($kalk['Pruefkosten'],4,',','.')}}</div>
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($showSave * $kalk['Pruefkosten'],4,',','.')}}</div>
                <div style="clear: both;"></div>
            </li>
            <li>
                {{ Form::label('PPPurchase_Lizenzgebuehren','Lizenzgebühren (% VKP)',array('class'=>'cpc_POLabel','style'=>'float:left;')) }}{{ Form::text('PPPurchase_Lizenzgebuehren',number_format($data['purchase']['PPPurchase_Lizenzgebuehren'],2,',','.'),array('style'=>'width:80px;text-align:right;float:left;')) }}
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($kalk['Lizenz'],4,',','.')}}</div>
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($showSave * $kalk['Lizenz'],4,',','.')}}</div>
                <div style="clear: both;"></div>
            </li>
            <li>
                {{ Form::label('PPPurchase_Kosten','Sonstige Kosten / Stk (EUR)',array('class'=>'cpc_POLabel','style'=>'float:left;')) }}{{ Form::text('PPPurchase_Kosten',number_format($data['purchase']['PPPurchase_Kosten'],4,',','.'),array('style'=>'width:80px;text-align:right;float:left;')) }}
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($kalk['Kosten'],4,',','.')}}</div>
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($showSave * $kalk['Kosten'],4,',','.')}}</div>
                <div style="clear: both;"></div>
            </li>
            <li>
                {{ Form::label('PPPurchase_SonstKostenProz','Sonstige Kosten  (% VKP)',array('class'=>'cpc_POLabel','style'=>'float:left;')) }}{{ Form::text('PPPurchase_SonstKostenProz',number_format($data['purchase']['PPPurchase_SonstKostenProz'],2,',','.'),array('style'=>'width:80px;text-align:right;float:left;')) }}
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($kalk['SonstKostenProz'],4,',','.')}}</div>
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($showSave * $kalk['SonstKostenProz'],4,',','.')}}</div>
                <div style="clear: both;"></div>
            </li>
            <li>
                {{ Form::label('Selbstkostenpreis','Selbstkostenpreis (EUR)' ,array('class'=>'cpc_POLabel','style'=>'float:left;color:red;')) }} {{ Form::text(NULL,NULL,array('style'=>'width:80px;text-align:right;float:left;')) }}
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($kalk['SKPC'],4,',','.')}}</div>
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($showSave * $kalk['SKPS'],4,',','.')}}</div>
                <div style="clear: both;"></div>
            </li>
            <li>
                {{ Form::label('Verkaufspreis','Verkaufspreis (EUR)' ,array('class'=>'cpc_POLabel','style'=>'float:left;color:red;')) }} {{ Form::text(NULL,NULL,array('style'=>'width:80px;text-align:right;float:left;')) }}
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($kalk['VKP'],4,',','.')}}</div>
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($showSave * $kalk['VKP'],4,',','.')}}</div>
                <div style="clear: both;"></div>
            </li>
            <li>
                {{ Form::label('Verkaufspreis','Verkaufspreis -0,3%  (EUR)' ,array('class'=>'cpc_POLabel','style'=>'float:left;color:red;')) }} {{ Form::text(NULL,NULL,array('style'=>'width:80px;text-align:right;float:left;')) }}
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($kalk['VKP3'],4,',','.')}}</div>
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($showSave * $kalk['VKP3'],4,',','.')}}</div>
                <div style="clear: both;"></div>
            </li>
            <li style="margin-top:20px;">
                {{ Form::label('EK-Volumen','EK-Volumen (EUR)' ,array('class'=>'cpc_POLabel','style'=>'float:left;color:red;')) }} {{ Form::text(NULL,NULL,array('style'=>'width:80px;text-align:right;float:left;')) }}
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($kalk['SKPC']*$kalk['Menge'],2,',','.')}} €</div>
                <div style="margin-top:2px;width:100px; border:1px solid #d8d8d8; border-radius: 5px;padding:4px;float:left;text-align: right;height:15px;">{{number_format($showSave * $kalk['SKPS']*$kalk['Menge'],2,',','.')}} €</div>
                <div style="clear: both;"></div>
            </li>

            <div style="padding:30px;">
                {{ Form::submit('Neu berechnen', array('class'=>'btn','style'=>'width:180px;background-color: #e78f08;'))}}

            </div>
            {{ Form::close() }}
        </fieldset>
    </div>
    <div style="clear:both;"></div>
    {{ Form::close() }}
</div>