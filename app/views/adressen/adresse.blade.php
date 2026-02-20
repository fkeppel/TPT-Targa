<style>
    #addressShow {
        border: none;
        border-radius: 0px;
    }
    #addressShow div {
        border: 1px solid rgb(196, 201, 199);
        border-radius: 0px;
        padding:3px;
        padding-left:6px;
        padding-top:5px;
        background-color: lightslategray;
        color:white;
        font-size:0.85rem;
    }

    #addressShow .value {
        border:1px solid firebrick;
        padding:0px;
    }


    #addressShow .valueSelect {
        border:none;
        width:100%;
        height:100%;
    }


    #addressShow .noBorder {
        border:none;
        background-color: transparent;
        padding:0px;
    }

    #addressShow .valueInput {
        border:none;
        width:100%;
        height:100%;
        padding:6px;
    }

    #addressShow .btnSave, .btnDel {
        width:100%;
        height:100%;
        height:35px;

    }
    #addressShow .btnDel {
        background-color: rgb(197, 40, 40);
        color:white;
        border: 1px solid gray;
    }
</style>



<div style="border: none; border-radius: 5px; width:1630px;padding:10px; padding-top:50px;text-align:left;margin:0 auto;" id="AdressenMainDiv">

    {{ Form::model($adresse['adr'], array('url'=>'adressen/store/'.$adresse['adr']['Id'], 'class'=>'form-signin')) }}

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
    <div>
        <fieldset>
            <legend style="margin:10px;"><span style="padding-left:10px;padding-right: 10px;font-weight: bold;">{{ $adresse['adr']['Matchcode']  }}</span></legend>

            <div id="addressShow" style="display:grid; grid-template-columns: 200px 500px 200px 500px; grid-gap: 8px;padding: 10px;">

                <div class="label" >{{ Form::label('Id') }}</div>
                <div class="value">{{ Form::text('Id',Null, array('class' => 'valueInput')) }}</div>

                <div>{{ Form::label('Art') }}</div>
                <div class="value" >{{ Form::select('Art',$adresse['arten'],Null,array('class'=>'valueSelect'))}}</div>


                <div>{{ Form::label('Matchcode') }}</div>
                <div style="grid-column: span 3;" class="value">{{ Form::text('Matchcode',NULL,array('class' => 'valueInput')) }}</div>



                <div class="label">{{ Form::label('Firma1') }}</div>
                <div class="value" >{{ Form::text('Firma1',NULL,array('class' => 'valueInput')) }}</div>

                <div class="label">{{ Form::label('Firma2') }}</div>
                <div class="value">{{ Form::text('Firma2',NULL,array('class' => 'valueInput')) }}</div>

                <div class="label">{{ Form::label('Ansprechpartner') }}</div>
                <div class="value">{{ Form::text('Ansprechpartner',NULL,array('class' => 'valueInput')) }}</div>



                <div class='noBorder'>&nbsp;</div>
                <div class='noBorder'>&nbsp;</div>

                <div class="label">{{ Form::label('Adresse1') }}</div>
                <div class="value">{{ Form::text('Adresse1',NULL,array('class' => 'valueInput')) }}</div>

                <div class="label">{{ Form::label('Adresse2') }}</div>
                <div class="value">{{ Form::text('Adresse2',NULL,array('class' => 'valueInput')) }}</div>

            
                <div class="label">{{ Form::label('PLZ') }}</div>
                <div class="value">{{ Form::text('PLZ',NULL,array('class' => 'valueInput')) }}</div>

                <div class="label">{{ Form::label('Ort') }}</div>
                <div class="value">{{ Form::text('Ort',NULL,array('class' => 'valueInput')) }}</div>

                <div class="label">{{ Form::label('Postfach') }}</div>
                <div class="value">{{ Form::text('Postfach',NULL,array('class' => 'valueInput')) }}</div>

                <div class="label">{{ Form::label('Land')}}</div>
                <div class="value">{{ Form::text('Land',NULL,array('class' => 'valueInput')) }}</div>

                <div class="label">{{ Form::label('Telefon') }}</div>
                <div class="value">{{ Form::text('Telefon',NULL,array('class' => 'valueInput')) }}</div>

                <div class="label">{{ Form::label('Mobil') }}</div>
                <div class="value">{{ Form::text('PPAdressen_Mobil',NULL,array('class' => 'valueInput')) }}</div>

                <div class="label">{{ Form::label('Fax') }}</div>
                <div class="value">{{ Form::text('Fax',NULL,array('class' => 'valueInput')) }}</div>

                <div class="label">{{ Form::label('email') }}</div>
                <div class="value">{{ Form::text('email',NULL,array('class' => 'valueInput')) }}</div>

                <div class="label">{{ Form::label('web') }}</div>
                <div class="value">{{ Form::text('web',NULL,array('class' => 'valueInput')) }}</div>

                <div class="label">{{ Form::label('Lidl-Id') }}</div>
                <div class="value">{{ Form::text('PPAdressen_LidlId',NULL,array('class' => 'valueInput')) }}</div>

                <div class="label">{{ Form::label('Abgangshafen') }}</div>
                <div class="value">{{Form::select('PPAdressen_Abgangshafen',$adresse['haefen'],$adresse['adr']['PPAdressen_Abgangshafen'],array('class' => 'valueInput'))}}</div>

                <div class='noBorder'>&nbsp;</div>
                <div class='noBorder'>&nbsp;</div>

                <div class="label">{{ Form::label('Agent alt') }}</div>
                <div class="value"><input value="{{ $adresse['adr']['PPAdressen_Agent'] }}" class="valueInput" /></div>

                <div class="label"><label>Agent</label></div>
                <div class="value"><select name="PPAdressen_AgentId" class="valueSelect">
                        <option value="0">Bitte wählen...</option>
                        @foreach ($adresse['agents'] as $aid => $agent)
                        <option value="{{ $aid }}" @if ($aid==$adresse['adr']['PPAdressen_AgentId']) selected @endif>{{
                            $agent }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="label" ><label>Standard Provision [%]</label></div>
                <div class="value"><input name="PPAdressen_DefaultProvision"  value="{{ $adresse['adr']['PPAdressen_DefaultProvision'] }}"  class="valueInput" /></div>

                <div class="label"><label>Standard EK Währung</label></div>
                <div class="value"><select name="PPAdressen_DefaultWsym" class="valueSelect">
                        <option>EUR</option>
                        <option>USD</option>
                    </select>
                </div>

                <div class="label">{{ Form::label('EORI') }}</div>
                <div class="value">{{ Form::text('EORI',NULL,array('class' => 'valueInput')) }}</div>

                <div class="label">{{ Form::label('Steuernummer') }}</div>
                <div class="value">{{ Form::text('Steuernummer',NULL,array('class' => 'valueInput')) }}</div>

                <div class="label">{{ Form::label('USt-ID') }}</div>
                <div class="value">{{ Form::text('USt_Id',NULL,array('class' => 'valueInput')) }}</div>

                <div class='noBorder'>&nbsp;</div>
                <div class='noBorder'>&nbsp;</div>

                <div class="label">{{ Form::label('BSCI-Zertifikat:') }}</div>
                <div class="value">
                            <select name="PPAdressen_ZertBSCI" class="valueSelect">
                                <option value="1" @if($adresse['adr']['PPAdressen_ZertBSCI']==1)Selected="selected"
                                    @endif>Ja</option>
                                <option value="0" @if($adresse['adr']['PPAdressen_ZertBSCI']==0)Selected="selected"
                                    @endif>Nein</option>
                            </select>
                </div>
                
                <div class="label">{{ Form::label('Gültig bis: [tt.mm.jjjj]') }} </div>
                <div class="value"><input class="valueInput" type="text" name="PPAdressen_ZertBSCIValid" value="{{$bsciValid}}" /></div>
                       
                <div class="label">{{ Form::label('Liefertermin') }}</div>
                <div class="value">{{Form::text('PPAdressen_LT',NULL,array('class' => 'valueInput')) }}</div>

                <div class='noBorder'>&nbsp;</div>
                <div class='noBorder'>&nbsp;</div>

                <div class='noBorder'>&nbsp;</div>
                <div class='noBorder'> {{ Form::button('Löschen', array('onclick'=>'xconfirmDeleteAdresse('.$adresse['adr']['Id'].');','class'=>'btnDel'))}}</div>

                <div class='noBorder'>&nbsp;</div>
                <div class='noBorder'>  {{ Form::submit('speichern', array('class'=>'btnSave'))}}</div>

             


            </div>

        </fieldset>
    </div>

  
   
    {{ Form::close() }}

</div>

<script>

    function xconfirmDeleteAdresse(id) {
        var confirm = window.confirm('Adresse:' + id + ' Wiklich löschen?');
        if (confirm) {
            $.ajax({
                type: "POST",
                url: "/adressen/delete/" + id,
                data: { 'id': id },
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