<style>
    td{
        border:1px solid gray;
        padding:4px;
    }
</style>
<div style="background: #FFF;margin:0 auto;margin:20px;width:1610px;">
    <table style="font-family: Tahoma;font-size:12px;text-align: left;border-collapse: collapse;table-layout: fixed;">

        <tr>
            <!--td style="width:20px;text-align: center; background-color: #c0c0c0;">Id</td-->

            <td style="width:150px;background-color: #c0c0c0;">Matchcode</td>
            <td style="width:60px;background-color: #c0c0c0;">Art</td>
            <td style="width:150px;background-color: #c0c0c0;">Adresse</td>
            <td style="width:150px;background-color: #c0c0c0;">STeP</td>
            <td style="width:150px;background-color: #c0c0c0;">BSCI</td>

            <td style="width:100px;background-color: #c0c0c0;">Telefon</td>

            <td style="width:100px;background-color: #c0c0c0;">Agent</td>
            <td style="width:100px;background-color: #c0c0c0;">Lidl-Id</td>

            <td style="width:100px;background-color: #c0c0c0;">Aktion</td>
        </tr>


        @foreach ($adressen as $adr)
        <tr>

            <?php
            $certStep = '';
            $certStepValid = "";
            $certStepColor = "";
            if ($adr->PPAdressen_ZertStep == 1) {
                $certStep = 'Ja';
                $dateStep = date_create($adr->PPAdressen_ZertStepValid);
                if (date_diff(date_create(date('Y-m-d')), $dateStep)->format('%r%a') < 0) {
                    $certStepColor = "color:red;";
                } else {
                    $certStepColor = "color:green;";
                }
                $certStepValid = date_format($dateStep, "d.m.Y");
            }
            $certBSCI = '';
            $certBSCIValid = "";
            $certBSCIColor = "";
            if ($adr->PPAdressen_ZertBSCI == 1) {
                $dateBSCI = date_create($adr->PPAdressen_ZertBSCIValid);
                $certBSCIValid = date_format($dateBSCI, "d.m.Y");
                $certBSCI = 'Ja';
                if (date_diff(date_create(date('Y-m-d')), $dateBSCI)->format('%r%a') < 0) {
                    $certBSCIColor = "color:red;";
                } else {
                    $certBSCIColor = "color:green;";
                }
            }
            ?>
            <!--td style="text-align: center;">{{$adr->Id}}</td-->
            <td style="">{{$adr->Matchcode}}</td>
            <td style="">{{$adr->PPAdressarten_Art}}</td>
            <td style="">{{$adr->Firma1}}<br />{{$adr->PLZ}} {{$adr->Ort}}<br />{{$adr->Land}}</td>
            <td style="text-align:center;">{{$certStep}}<br><span style="{{$certStepColor}}">{{$certStepValid}}</span></td>
            <td style="text-align:center;">{{$certBSCI}}<br><span style="{{$certBSCIColor}}">{{$certBSCIValid}}</span></td>

            <td style="">T: {{$adr->Telefon}}<br>M: {{$adr->PPAdressen_Mobil}}</td>

            <td style="">{{$adr->PPAdressen_Agent}}</td>
            <td style="">{{$adr->PPAdressen_LidlId}}</td>

            <td>
                {{ Form::open(array('url'=>'adressen/show/'.$adr->Id, 'class'=>'form-signin')) }}
                {{ Form::submit('ansehen', array('class'=>'btn btn-large btn-primary btn-block'))}}
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach


    </table>
    <div style="text-align: left;margin:0 auto;padding-top:10px;">


        {{ Form::open(array('url'=>'adressen/create', 'class'=>'form-signin')) }}
        {{ Form::submit('Neue Adresse', array('class'=>'btn btn-large btn-primary btn-block'))}}
        {{ Form::close() }}
    </div>
</div>
