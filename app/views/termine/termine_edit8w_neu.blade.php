<div style="width:30px;height:10px;border-radius: 0px;background-color: rgb({{$t['bg']}});"><span style="font-size:8px;">&nbsp;</span></div>
<div ondblclick="return js('{{$t['id']}}');" style="position:relative;background-color:rgb({{isset($t['bgcolor'])?$t['bgcolor']:'255,0,0'}});border-radius: 0px; width:30px;height:50px;overflow:hidden;"  title="{{$t['terminart']}} {{$t['datafield']}}- {{$pp['ian']}} - {{$t['status']}}">
    <div class="overlay" id="div_{{$t['id']}}" style="border:none;width:477px;height:620px;position:fixed;top:5%;left:40%;">
        <div style="position:relative; margin: 0 auto;border:4px solid gray;height:610px;background-color: #c0c0c0;">
            <div style="margin:0 auto;background-color:#c0c0c0;border:none;height:530px;">
                {{ Form::open() }}
                <input type="hidden" name="Termine_Id{{$t['id']}}" value="{{$t['id']}}">
                <fieldset style="width:410px;margin-top:10px;height:515px; border:2px solid darkblue;">
                    <legend>
                        <p>
                            Termin
                        </p>
                    </legend>
                    <div style="background-color: #FFF;color:darkblue;padding:8px;margin-top:-10px;">
                        {{$t['terminart']}}
                        <br>
                        IAN:{{$pp['ian']}}
                        <br>
                        LT:{{$pp['lty']}}/{{$pp['ltw']}}
                        <br>
                        @if ($t['rot'] != '')Soll: LT{{$t['rot']}} Wochen @endif
                        <br>
                        KW @if ($pp['ltw']+$t['rot'] <= 0){{$pp['lty']-1}}/{{$pp['ltw']+$t['rot']+52}} @else {{$pp['lty']}}/{{$pp['ltw']+$t['rot']}}@endif
                        <br>
                        Datenfeld: {{$t['datafield']}}
                        <br>
                        @if ($t['terminart'] == 'BSCI' and isset($po['supplierid']) and isset($po['bsci']))
                        Lieferant: <a href='adressen/show/{{$po['supplierid']}}'  target='_blank'>{{$po['supplier']}}</a><br>BSCI gültig bis: {{$po['bsci']}}
                        @endif


                    </div>
                    <div style="background-color: #c0c0c0;color:darkblue;padding:8px;">

                        <div style="float: left;width:150px;background-color: #c0c0c0; color:darkblue;">
                            {{ Form::label('Erledigen bis') }}
                            <br>
                            {{ Form::text('Termine_Datum',substr($t['start'],0,10), array('id'=>'Termine_Datum'.$t['id'],'class'=>'datepicker'))}}
                        </div>
                        <div style="float: left;width:150px;background-color: #c0c0c0;margin-left:15px;">
                            {{ Form::label('Erledigt am') }}
                            {{ Form::text('Termine_Datum_Ende',substr($t['ende'],0,10), array('id'=>'Termine_Datum_Ende'.$t['id'],'class'=>'datepicker'))}}
                        </div>
                        <div style="clear: both;"></div>
                    </div>

                    <div style="background-color: #c0c0c0;padding:8px;color:darkblue;">
                        {{ Form::label('Anzeigetext') }}
                        <br>
                        {{ Form::text('Termine_Label',$t['label'],array('id'=>'Termine_Label'.$t['id'],'style'=>'width:320px;border-radius:0px;border:1px solid gray;padding:2px;')) }}
                    </div>

                    <div style="background-color: #c0c0c0;padding:8px;vertical-align: top;color:darkblue;">
                        {{ Form::label('Bemerkung') }}
                        <br>
                        {{ Form::textarea('Termine_Bemerkung',$t['bemerkung'],array('id'=>'Termine_Bemerkung'.$t['id'],'style'=>'width:320px;height:80px;overflow:auto;border:1px solid gray;padding:5px;font-family:Arial;')) }}
                    </div>

                    <div style="background-color: #c0c0c0;padding:8px;vertical-align: top;color:darkblue;margin-top: -10px;">
                        <div style="float: left;width:160px;background-color: #c0c0c0;color:darkblue;">

                            <p style="margin-bottom:5px;">
                                {{ Form::label('Staus') }}
                            </p>
                            {{ Form::select('Termine_Status',$t['stati'],$t['status'],array('id'=>'Termine_Status'.$t['id'],'style'=>"width:150px;")) }}
                        </div>
                        <div style="float: left;width:160px;background-color: #c0c0c0;margin-left:8px;color:darkblue;">
                            <p style="margin-bottom:5px;">
                                {{ Form::label('Zuständig') }}
                            </p>
                            {{ Form::select('Termine_Mitarbeiter',$kalender['mitarbeiterliste'],$t['ma'],array('id'=>'Termine_Mitarbeiter'.$t['id'],'style'=>"width:150px;")) }}
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                    @if ($header->PPBoardSpalte_Id == 53)
                    <div style="padding:10px;background-color:#c0c0c0;height:65px;">
                        <span style="color:darkblue;">8-Wochenmuster geliefert an:</span>
                        <br>
                        <table>
                            <?php $countm = 0 ?>
                            @foreach($pp['8WMuster'] as $muster)
                            @if ($countm == 6 or $countm == 0)
                            <tr>
                                <?php $countm = 0 ?>
                                @endif
                                <?php $countm++ ?>
                                <td style="padding:3px;">{{$muster->PPProduktpass_Menge_Country}}</td>
                                <td style="padding:3px;padding-right:6px;">{{Form::checkbox('AWM_'.$t['id'].'_'.$muster->PPProduktpass_Menge_Country, $muster->PPProduktpass_Menge_8WMuster, $muster->PPProduktpass_Menge_8WMuster, array('class'=>'AWM'.$t['id'],'id'=>'AWM_'.$t['id'].'_'.$muster->PPProduktpass_Menge_Country))}}</td>

                                @if ($countm == 6)
                            </tr>
                            @endif
                            @endforeach
                        </table>
                    </div>
                    @endif
                </fieldset>
                {{ Form::close() }}

            </div>
            <div style="text-align: center;background-color: #c0c0c0;padding:10px;border:2pxsolid red;">
                <button id="ajaxCall_SaveDateX"  onclick="cpc_tsave('{{$t['id']}}');" style="width:360px;">
                    Speichern
                </button>
                <div id="messagebox{{$t['id']}}" style="height: 30px; border: none;color:red;background-color: #C0C0C0;">
                    &nbsp;
                </div>

            </div>
            <button style="width:25px;height:25px;background-color:red;color:white;position:absolute;right:0;bottom:0;text-align: center; border:1px solid gray;margin:o auto;" class="close" id="btn_{{$t['id']}}">x</button>
            <div style="background-color: #e9e9e9;position:absolute;bottom:0;">
                <?php $hist = strlen($t['history']) > 2 ? str_replace("\n", "\\n", $t['history']) : "Noch keine Änderungen!"; ?>
                <button onclick="showHist('<?php str_replace("\"", "", $hist); ?>');">Historie</button>
            </div>
        </div>
    </div>

    <?php
    if ($t['ma'] != 0) {
        $ma = "*";
    } else {
        $ma = "";
    }
    ?>
    @if(strlen(trim($t['bemerkung']))>0)
    <div style='position:absolute; bottom:0px; right:0px; width:10px;height:10px;background-color: #e78f08; border:none;border-radius: 0px;margin:0px;'>&nbsp;</div>
    @endif
    <span style='font-size: 8px;font-family: tahoma;'> {{$t['label']}}</span>
</div>

