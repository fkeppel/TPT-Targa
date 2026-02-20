<script>
    $(function() {

    $(function() {

    $(".datepicker").datepicker(
    {
    numberOfMonths: 1,
            showButtonPanel: true,
            showWeek: true,
            firstDay: 1,
            dateFormat: "dd.mm.yy",
            monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
            monthNamesShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
            dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
            dayNamesShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
            dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
    });
    });
    });</script>


<div style="position:relative;background-color: #c0c0c0;font-family: Tahoma; padding:10px;" >

    <div  style="height:420px;background-color: #c0c0c0;" id="cpcdivTerminEdit">
        <div style="background-color: #c0c0c0;border:1px solid gray;">
            <div style="width:90px;float: left;background-color: #c0c0c0;">
                {{$data['IAN']}}:
            </div>
            <div style="width:270px;float: left;background-color: #c0c0c0;">
                {{$data['header']->PPBoardSpalte_Oberbez}}<br/>
                {{$data['header']->PPBoardSpalte_Bezeichnung}}</div>
            <div style="clear: both;"></div>
        </div>


        <div style='margin-top:30px;background-color: #c0c0c0;border-radius:0px;text-align: left;'>
            {{ Form::open(array('url'=>'termineupdate/'.$data['termin']->PPTermine_Id."/edit"),array('id'=>'cpcfrmTerminEdit')) }}

            <fieldset style="margin-top:-25px;height:395px;background-color: #c0c0c0;text-align: left;">
                <legend>Termin</legend>
                <div style="background-color: #c0c0c0;color:darkblue;padding:8px;margin-top:-10px;">
                    {{--LT:{{$l['ltJahr']}}/{{$l['lt']}}  Soll: LT{{$h['rot']}} Wochen  KW @if ($l['lt']+$h['rot'] <= 0){{$l['ltJahr']-1}}/{{$l['lt']+$h['rot']+52}} @else {{$l['ltJahr']}}/{{$l['lt']+$h['rot']}}@endif --}}

                </div>
                <div style="background-color: #c0c0c0;color:darkblue;padding:8px;">

                    <div style="float: left;width:150px;background-color: #c0c0c0; color:darkblue;">
                        {{ Form::label('Erledigen bis') }}<br>
                        {{ Form::text('Termine_Datum',substr($data['termin']->PPTermine_DatumStart,0,4)=='0000'?'':date("d.m.Y", strtotime($data['termin']->PPTermine_DatumStart)), array('class'=>'datepicker'))}}
                    </div>
                    <div style="float: left;width:150px;background-color: #c0c0c0;margin-left:15px;">
                        {{ Form::label('Erledigt am') }}
                        {{ Form::text('Termine_Datum_Ende',substr($data['termin']->PPTermine_DatumEnde,0,4)=='0000'?'':date("d.m.Y", strtotime($data['termin']->PPTermine_DatumEnde)), array('class'=>'datepicker'))}}
                    </div>
                    <div style="clear: both;"></div>
                </div>

                <div style="background-color: #c0c0c0;padding:8px;color:darkblue;">
                    {{ Form::label('Anzeigetext') }}<br>
                    {{ Form::text('Termine_Label',$data['termin']->PPTermine_Label,array('style'=>'width:320px;border:1px solid gray;padding:2px;')) }}
                </div>

                <div style="background-color: #c0c0c0;padding:8px;vertical-align: top;color:darkblue;">
                    {{ Form::label('Bemerkung') }}<br>
                    {{ Form::textarea('Termine_Bemerkung',$data['termin']->PPTermine_Bemerkungen,array('style'=>'width:320px;height:80px;overflow:auto;border:1px solid gray;padding:5px;font-family:Arial;')) }}
                </div>

                <div style="background-color: #c0c0c0;padding:8px;vertical-align: top;color:darkblue;margin-top: -10px;">
                    <div style="float: left;width:160px;background-color: #c0c0c0;color:darkblue;">
                        <p style="margin-bottom:5px;">{{ Form::label('Staus') }}</p>
                        {{ Form::select('Termine_Status',$data['stati'],$data['termin']->PPTermine_Status,array('style'=>"width:150px;")) }}
                    </div>
                    <div style="float: left;background-color: #c0c0c0;margin-left:8px;color:darkblue;">
                        <p style="margin-bottom:5px;">{{ Form::label('Zuständig') }}</p>
                        {{ Form::select('Termine_Mitarbeiter',$data['ma'],$data['termin']->PPTermine_MAZustaendigkeit,array('style'=>"width:150px;")) }}
                    </div>
                    <div style="clear: both;"></div>
                </div>
                <div style="padding:10px;text-align: left;background-color: #c0c0c0;">
                    @if (Auth::User()->PPMitarbeiter_Gruppe  != 'extern')
                    <button style="width: 320px;" onclick="cpc_save_termin();">Speichern</button>
                    @endif
                    {{-- Form::submit('speichern', array('class'=>'btn','style'=>'width:320px;'))--}}
                </div>


            </fieldset>
            {{ Form::close() }}
        </div>


    </div>



</div>

<div style="background-color: #e9e9e9;position:absolute;bottom:0;left: 0;">
    <?php $hist = strlen($data['termin']->PPTermine_History) > 2 ? str_replace("\n", "\\n", $data['termin']->PPTermine_History) : "Noch keine Änderungen!"; ?>
    <button onclick="showHist('{{$hist}}');">Historie</button>
</div>

<button onclick="cpc_popupTerminEditClose();" style="position:absolute;right:0px;bottom: 0px;">X</button>