<div style="position:relative;">
    <div class="overlay" id="div_{{$id}}" style="border:none;width:477px;height:620px;position:fixed;top:5%;left:40%;">
        <div style="position:relative; margin: 0 auto;border:4px solid gray;height:610px;background-color: #c0c0c0;">
            <div style="margin:0 auto;background-color:#c0c0c0;border:none;height:530px;">
                {{ Form::open() }}
                <input type="hidden" name="Termine_Id{{$id}}" value="{{$id}}">
                <fieldset style="width:400px;margin-top:-10px;height:515px; border:2px solid darkblue;">
                    <legend>
                        <p>
                            Termin (8-Wochenmuster)
                        </p>
                    </legend>
                    <div style="background-color: #FFF;color:darkblue;padding:8px;margin-top:-10px;">
                        {{$h['bez']}}
                        <br>
                        IAN:{{$l[$h['id']]['ian']}}
                        <br>
                        LT:{{$l['ltJahr']}}/{{$l['lt']}}
                        <br>
                        @if ($h['rot'] != '')Soll: LT{{$h['rot']}} Wochen @endif
                        <br>
                        KW @if ($l['lt']+$h['rot'] <= 0){{$l['ltJahr']-1}}/{{$l['lt']+$h['rot']+52}} @else {{$l['ltJahr']}}/{{$l['lt']+$h['rot']}}@endif

                    </div>
                    <div style="background-color: #c0c0c0;color:darkblue;padding:8px;">

                        <div style="float: left;width:150px;background-color: #c0c0c0; color:darkblue;">
                            {{ Form::label('Erledigt am') }}
                            <br>
                            {{ Form::text('Termine_Datum',$l[$h['id']]['start'], array('id'=>'Termine_Datum'.$id,'class'=>'datepicker'))}}
                        </div>
                        <div style="float: left;width:150px;background-color: #c0c0c0;margin-left:15px;">
                            {{ Form::label('Erledigen bis') }}
                            {{ Form::text('Termine_Datum_Ende',$l[$h['id']]['ende'], array('id'=>'Termine_Datum_Ende'.$id,'class'=>'datepicker'))}}
                        </div>
                        <div style="clear: both;"></div>
                    </div>

                    <div style="background-color: #c0c0c0;padding:8px;color:darkblue;">
                        {{ Form::label('Anzeigetext') }}
                        <br>
                        {{ Form::text('Termine_Label',$l[$h['id']]['label'],array('id'=>'Termine_Label'.$id,'style'=>'width:320px;border-radius:0px;border:1px solid gray;padding:2px;')) }}
                    </div>

                    <div style="background-color: #c0c0c0;padding:8px;vertical-align: top;color:darkblue;">
                        {{ Form::label('Bemerkung') }}
                        <br>
                        {{ Form::textarea('Termine_Bemerkung',$l[$h['id']]['bemerkung'],array('id'=>'Termine_Bemerkung'.$id,'style'=>'width:320px;height:80px;overflow:auto;border:1px solid gray;padding:5px;font-family:Arial;')) }}
                    </div>

                    <div style="background-color: #c0c0c0;padding:8px;vertical-align: top;color:darkblue;margin-top: -10px;">
                        <div style="float: left;width:160px;background-color: #c0c0c0;color:darkblue;">
                            <?php
                            $as = explode("x", $h['stati']);
                            $xs["Neu"] = "Neu";
                            $ilocal = 0;
                            foreach ($as as $s) {
                                $ilocal++;
                                if (isset($kalender['stati_all'][$s])) {
                                    $xs[$kalender['stati_all'][$s]] = $kalender['stati_all'][$s];
                                }
                            }
                            ?>
                            <p style="margin-bottom:5px;">
                                {{ Form::label('Status') }}
                            </p>
                            {{ Form::select('Termine_Status',$xs,$l[$h['id']]['status'],array('id'=>'Termine_Status'.$id,'style'=>"width:150px;")) }}
                        </div>
                        <div style="float: left;width:160px;background-color: #c0c0c0;margin-left:8px;color:darkblue;">
                            <p style="margin-bottom:5px;">
                                {{ Form::label('Zuständig') }}
                            </p>
                            {{ Form::select('Termine_Mitarbeiter',$kalender['mitarbeiterliste'],$l[$h['id']]['mitarbeiter'],array('id'=>'Termine_Mitarbeiter'.$id,'style'=>"width:150px;")) }}
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                    <div style="padding:10px;background-color:#c0c0c0;height:65px;">
                        <span style="color:darkblue;">8-Wochenmuster geliefert an:</span>
                        <br>
                        <table>
                            <?php $countm = 0 ?>
                            @foreach($l[$h['id']]['8WMuster'] as $muster)
                            @if ($countm == 6 or $countm == 0)
                            <tr>
                                <?php $countm = 0 ?>
                                @endif
                                <?php $countm++ ?>
                                <td style="padding:3px;">{{$muster->PPProduktpass_Menge_Country}}</td>
                                <td style="padding:3px;padding-right:6px;">{{Form::checkbox('AWM_'.$id.'_'.$muster->PPProduktpass_Menge_Country, $muster->PPProduktpass_Menge_8WMuster, $muster->PPProduktpass_Menge_8WMuster, array('class'=>'AWM'.$id,'id'=>'AWM_'.$id.'_'.$muster->PPProduktpass_Menge_Country))}}</td>

                                @if ($countm == 6)
                            </tr>
                            @endif
                            @endforeach
                        </table>
                    </div>
                </fieldset>
                {{ Form::close() }}

            </div>
            <div style="text-align: center;background-color: #c0c0c0;padding:10px;border:2pxsolid red;">
                <button id="ajaxCall_SaveDateX"  onclick="tsaveW('{{$id}}');" style="width:360px;">
                    Speichern
                </button>
                <div id="messagebox{{$id}}" style="height: 30px; border: none;color:red;background-color: #C0C0C0;">
                    &nbsp;
                </div>

            </div>

            <button style="width:25px;height:25px;background-color:red;color:white;position:absolute;right:0;bottom:0;text-align: center; border:1px solid gray;margin:o auto;" class="close" id="btn_{{$l[$h['id']]['id']}}">
                x
            </button>

            <div style="background-color: #e9e9e9;position:absolute;bottom:0;">
                <?php $hist = strlen($l[$h['id']]['history']) > 2 ? str_replace("\n", "\\n", $l[$h['id']]['history']) : "Noch keine Änderungen!"; ?>
                <button onclick="showHist('<?php str_replace("\"", "", $hist); ?>');">
                    Historie
                </button>
            </div>
        </div>
    </div>

    <?php
    if ($l[$h['id']]['mitarbeiter'] != 0) {
        $ma = "*";
    } else {
        $ma = "";
    }
    ?>

    <div id="o{{$l[$h['id']]['id']}}" title="{{$h['bez']}} - {{$l['ppian']}} - {{$l[$h['id']]['status']}}" ondblclick="return js('{{$l[$h['id']]['id']}}');" style="padding:2px;overflow:hidden;height:24px;background-color:rgb({{isset($l[$h['id']]['bgcolor'])?$l[$h['id']]['bgcolor']:'255,0,0'}});color:{{$kalender['colors'][$l[$h['id']]['status']]['color']}};font-size:9px;">

        <!--{{$kalender['colors'][$l[$h['id']]['status']]['bg']}}-->
        @if ($l[$h['id']]['label'] != "")
        {{$l[$h['id']]['label']}} <sup>{{$ma}}</sup>
        @else
        @if ($l[$h['id']]['start'] != "")
        {{$l[$h['id']]['start']}} <sup>{{$ma}}</sup>
        <br>
        {{$l[$h['id']]['status']}}

        @else
        {{$l[$h['id']]['status']}} <sup>{{$ma}}</sup>
        @endif
        @endif
    </div>
</div>

