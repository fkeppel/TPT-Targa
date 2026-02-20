<style>
    label, input, textarea, select {
        display: inline-block; vertical-align: top; margin:2px;
    }

    label {width:250px;}
    input{width:300px;}
    ul {list-style-type: none;}
    div {font-family: Tahoma;
         font-size:12px;}
    </style>
    <div style="border: 1px solid gray; border-radius: 5px; width:1630px;padding:10px;text-align:left;margin:0 auto;" id="AdressenMainDiv" >

    {{ Form::model($adresse['adr'], array('url'=>'adressen/store/'.$adresse['adr']['Id'], 'class'=>'form-signin')) }}



    <fieldset>
        <legend>Adressen</legend>

        <ul>
            <li>{{ Form::label('Id') }}{{ Form::text('Id') }}</li>

            <li>{{ Form::label('Art') }}{{ Form::select('Art',$adresse['arten'])}}</li>
            <li>{{ Form::label('Firma1') }}{{ Form::text('Firma1',NULL,array('style'=>'width:600px;')) }}</li>
            <li>{{ Form::label('Firma2') }}{{ Form::text('Firma2',NULL,array('style'=>'width:600px;')) }}</li>
            <li>{{ Form::label('Ansprechpartner') }}{{ Form::text('Ansprechpartner',NULL,array('style'=>'width:600px;')) }}</li>
            <li>{{ Form::label('Adresse1') }}{{ Form::text('Adresse1',NULL,array('style'=>'width:600px;')) }}</li>
            <li>{{ Form::label('Adresse2') }}{{ Form::text('Adresse2',NULL,array('style'=>'width:600px;')) }}</li>
            <li>{{ Form::label('Matchcode') }}{{ Form::text('Matchcode',NULL,array('style'=>'width:600px;')) }}</li>
            <li>{{ Form::label('PLZ') }}{{ Form::text('PLZ') }}</li>
            <li>{{ Form::label('Ort') }}{{ Form::text('Ort',NULL,array('style'=>'width:600px;')) }}</li>
            <li>{{ Form::label('Postfach') }}{{ Form::text('Postfach',NULL,array('style'=>'width:600px;')) }}</li>
            <li>{{ Form::label('Land')}}{{ Form::text('Land',NULL,array('style'=>'width:600px;')) }}</li>
            <li>{{ Form::label('Telefon') }}{{ Form::text('Telefon',NULL,array('style'=>'width:600px;')) }}</li>
            <li>{{ Form::label('Mobil') }}{{ Form::text('PPAdressen_Mobil',NULL,array('style'=>'width:600px;')) }}</li>
            <li>{{ Form::label('Fax') }}{{ Form::text('Fax',NULL,array('style'=>'width:600px;')) }}</li>
            <li>{{ Form::label('email') }}{{ Form::text('email',NULL,array('style'=>'width:600px;')) }}</li>
            <li>{{ Form::label('web') }}{{ Form::text('web',NULL,array('style'=>'width:600px;')) }}</li>
            <li>{{ Form::label('Lidl-Id') }}{{ Form::text('PPAdressen_LidlId') }}</li>
            <li>{{ Form::label('Abgangshafen') }}{{ Form::select('PPAdressen_Abgangshafen',$adresse['haefen'],$adresse['adr']['PPAdressen_Abgangshafen'],array('style'=>'width:600px;')) }}</li>
            <li><label>Agent Alt</label><input value="{{ $adresse['adr']['PPAdressen_Agent'] }}" /></li>

            <li><label>Agent</label><select name="PPAdressen_AgentId">
                <option value="0">Bitte wählen...</option>
                @foreach ($adresse['agents'] as $aid => $agent) 
                <option value="{{ $aid }}" @if ($aid == $adresse['adr']['PPAdressen_AgentId']) selected @endif>{{ $agent }}</option>
                @endforeach
                </select>
            </li>
            <li><label>Standard Provision</label><input name="PPAdressen_DefaultProvision" value="{{ $adresse['adr']['PPAdressen_DefaultProvision'] }}" /></li>
            <li>
                <label>Standard EK Währung</label>
                <select  name="PPAdressen_DefaultWsym">
                    <option>EUR</option>
                    <option>USD</option>
                </select>
            </li>
            <!-- li>{{ Form::label('Agent') }}{{ Form::text('PPAdressen_Agent') }}</!-li -->
            <li>{{ Form::label('EORI') }}{{ Form::text('EORI',NULL,array('style'=>'width:600px;')) }}</li>
            <li>{{ Form::label('Steurnummer') }}{{ Form::text('Steuernummer',NULL,array('style'=>'width:600px;')) }}</li>
            <li>{{ Form::label('USt-ID') }}{{ Form::text('USt_Id',NULL,array('style'=>'width:600px;')) }}</li>

            <!--li>{{ Form::label('Step-Zertifikat:') }}
            <?php
            $stepValid = "";
            $bsciValid = "";
            if (strlen($adresse['adr']['PPAdressen_ZertStepValid']) >= 10) {
                $stepValid = date('d.m.Y', strtotime($adresse['adr']['PPAdressen_ZertStepValid']));
            }
            if (strlen($adresse['adr']['PPAdressen_ZertBSCIValid']) >= 10) {
                $bsciValid = date('d.m.Y', strtotime($adresse['adr']['PPAdressen_ZertBSCIValid']));
            }
            ?>
            <!--select name="PPAdressen_ZertStep">
                <option value="1" @if($adresse['adr']['PPAdressen_ZertStep'] == 1)Selected="selected"@endif>Ja</option>
                <option value="0" @if($adresse['adr']['PPAdressen_ZertStep'] == 0)Selected="selected"@endif>Nein</option>
            </select>
            {{ Form::label('Gültig bis: [jjjj-mm-tt]') }} <input type="text" name="PPAdressen_ZertStepValid" value="{{$stepValid}}"/>
        </li -->
            <li>{{ Form::label('BSCI-Zertifikat:') }}
                <select name="PPAdressen_ZertBSCI">
                    <option value="1" @if($adresse['adr']['PPAdressen_ZertBSCI'] == 1)Selected="selected"@endif>Ja</option>
                    <option value="0" @if($adresse['adr']['PPAdressen_ZertBSCI'] == 0)Selected="selected"@endif>Nein</option>
                </select>
                {{ Form::label('Gültig bis: [tt.mm.jjjj]') }} <input type="text" name="PPAdressen_ZertBSCIValid" value="{{$bsciValid}}"/></li>
            <li>{{ Form::label('Liefertermin') }}{{ Form::text('PPAdressen_LT',NULL,array('style'=>'width:600px;')) }}</li>

        </ul>

    </fieldset>

    {{ Form::submit('speichern', array('class'=>'btn btn-large btn-primary btn-block'))}}
    {{ Form::button('Löschen', array('onclick'=>' xconfirmDeleteAdresse('.$adresse['adr']['Id'].');','class'=>'btn','style'=>'width:120px;background-color:red;'))}}



    {{ Form::close() }}

</div>

<script>

    function  xconfirmDeleteAdresse(id) {
        var confirm = window.confirm('Adresse:' + id + ' Wiklich löschen?');
        if (confirm) {
            $.ajax({
                type: "POST",
                url: "/adressen/delete/" + id,
                data: {'id': id},
                cache: false,
                success: function () {
                    $("#AdressenMainDiv").html("Adresse wurde gelöscht!");

                    //alert("Adresse gelöscht!");
                    //window.close();
                },
                error: function (jqXHR, textStatus, ex) {
                    alert(textStatus + "," + ex + "," + jqXHR.responseText);
                }
            });

        } else {
            alert('Adresse wurde nicht gelöscht!');
        }
    }

</script>