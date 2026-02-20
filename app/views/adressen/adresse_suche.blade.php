<style>
    #adressSucheCntr div {
        border: 1px solid lightgray;
        border-radius: 0px;
        padding: 6px;
        text-align: left;
        font-size: 0.9rem;

    }

    #adressSucheCntr {
        border:none;
        height: 987px;
        overflow: hidden;
    }
</style>

<?php 
    $adressen = $params['adr'];
    $art = $params['art'];
?>


<div id="adressSucheCntr" >
    
            <div style="position:relative; height:70px;border:none;">
                <div style="position:relative;width:400px;border:none;">
                    <form id="adressSuche" action="/sucheAdresse" method="post" style="padding: 0px; height: 63px;">
                            <input type="hidden" name="art" value="{{ $art }}">
                            <div style="padding:20px;"><b>Adress-Suche:</b> <input name="searchAddress" placeholder="Suchbegriff"  onchange="searchForm();" style="padding: 8px; font-size:1.1rem; margin-left:12px; "/></div>
                       
                    </form>
                </div>
                <div style="position:absolute; right:265px; top:0px; padding-top:7px;border:none;">
                    <div style="padding-top:18px;">
                        {{ Form::open(array('url'=>'adressen/create', 'class'=>'form-signin')) }}
                        {{ Form::submit('Neue Adresse', array('class'=>'btn btn-large btn-primary btn-block'))}}
                        {{ Form::close() }}
                    </div>
                </div>
                
    
            </div>
   

    <div style="border:none;padding:20px;width:1609px;overflow: hidden;">
        <div style="padding:0px;display:grid; grid-template-columns: 50px 350px 80px 350px 150px 150px  180px 180px 100px 17px; ">


            <!--td style="width:20px;text-align: center; background-color: #c0c0c0;">Id</td-->

            <div style="background-color: #c0c0c0;">ID</div>
            <div style="background-color: #c0c0c0;">Matchcode</div>
            <div style="background-color: #c0c0c0;">Art</div>
            <div style="background-color: #c0c0c0;">Adresse</div>
            <div style="background-color: #c0c0c0;">STeP</div>
            <div style="background-color: #c0c0c0;">BSCI</div>
            <div style="background-color: #c0c0c0;">Telefon</div>
            <div style="background-color: #c0c0c0;">Agent</div>
            <div style="grid-column:span 2; background-color: #c0c0c0;">Lidl-Id</div>

        </div>

        <div
            style="padding:0px;display:grid; grid-template-columns: 50px 350px 80px 350px 150px 150px  180px 180px 100px; height:720px; overflow: auto;height:822px; grid-auto-rows: minmax(min-content, max-content); ">
            @foreach ($adressen as $adr)


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

            <div>{{ Form::open(array('url'=>'adressen/show/'.$adr->Id, 'class'=>'form-signin')) }}
                {{ Form::submit($adr->Id, array('class'=>'btn btn-large btn-primary btn-block'))}}
                {{ Form::close() }}</div>
            <div>{{$adr->Matchcode}}</div>
            <div>{{$adr->PPAdressarten_Art}}</div>
            <div><span style="color:darkblue;">{{$adr->Firma1}}</span><br />{{$adr->PLZ}} {{$adr->Ort}}<br /><b>{{$adr->Land}}</b></div>
            <div style="text-align:center;">{{$certStep}}<br><span style="{{$certStepColor}}">{{$certStepValid}}</span>
            </div>
            <div style="text-align:center;">{{$certBSCI}}<br><span style="{{$certBSCIColor}}">{{$certBSCIValid}}</span>
            </div>

            <div>T: {{$adr->Telefon}}<br>M: {{$adr->PPAdressen_Mobil}}</div>

            <div>{{$adr->PPAdressen_Agent}}</div>
            <div>{{$adr->PPAdressen_LidlId}}</div>



            @endforeach

        </div>
    </div>
</div>


<script>
    function searchForm (){
        
        var frm = document.getElementById('adressSuche');
        frm.submit();

    }
</script>