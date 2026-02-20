<title>Lomotex</title>
<style>
    .div_header_rotate {
        width:80px;
        overflow:hidden;
        margin-left:-20px;
        background: none;
        height:30px;
        text-align:center;
        transform:rotate(-90deg);
        -webkit-transform:rotate(-90deg);
        font-family: "Open-Sans Tahoma Arial";
        font-size:11px;
        font-weight: bold;

    }

    .rotate {
        /* FF3.5+ */
        -moz-transform: rotate(-90.0deg);
        /* Opera 10.5 */
        -o-transform: rotate(-90.0deg);
        /* Saf3.1+, Chrome */
        -webkit-transform: rotate(-90.0deg);
        /* IE6,IE7 */
        filter: progid DXImageTransform.Microsoft.BasicImage(rotation=0.083);
        /* IE8 */
        -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)";
        /* Standard */
        transform: rotate(-90.0deg);
    }

    .overlay {
        background-color: #c0c0c0;
        border: 1px solid gray;
        border-radius:0px;
        height: 400px;
        width: 350px;
        position: absolute;
        top: 0px;
        left:0px;
        z-index: 99;
        display: none;
    }
    ul {
        list-style-type: none;
    }
    li{margin:8px;}
    form{
        font-family: Tahoma;
        font-size: 11px;
        color:#FFF;
        margin:15px;
        width:300px;
        height:250px;
    }
    td{ padding:4px; font-family:'Open sans', Tahoma, Arial; font-size: 11px;border:1px solid gray;vertical-align: text-top;}
    .cpctdHeader1{
        vertical-align: middle;
    }
    table{ border-collapse: collapse;margin:0px;}
    div{
        border-radius: 0px;
    }
    .sort_icon_up {

        background-image: url(/css/images/icons.png);
        background-position: 0px 0;
        width: 16px;
        height:16px;
        position:absolute;
        top:0px;
        left:1px;

    }
    .sort_icon_undef {

        background-image: url(/css/images/icons.png);
        background-position: -176px -112;
        width: 16px;
        height:16px;

    }
    .sort_icon_down {

        background-image: url(/css/images/icons.png);
        background-position: -64px 0;
        width: 16px;
        height:16px;
        position:absolute;
        bottom: 0px;
        left:0px;

    }
    .cpctdHeaderLeft{
        background-color: lightgray;
        vertical-align: bottom;

    }
    .cpctdHeaderLeft div{
        background-color: lightgray;

    }
    .divHeaderLeft {
        padding-top: 10px;
        width:45px;
        height:17px;
        padding-left: 25px;
        position: relative;
        border:none;
        font-weight: bold;
        text-align: left;
        border: none;
    }
</style>
<script>
    function resetForm(){


    document.getElementById('q0').setAttribute('value', '');
    document.getElementById('q1').selectedIndex = 0;
    document.getElementById('q2').selectedIndex = 0;
    document.getElementById('q3').setAttribute('value', '');
    document.getElementById('q4').setAttribute('value', '');
    document.getElementById('q5').setAttribute('value', '');
    document.getElementById('q6').setAttribute('value', '');
    document.getElementById('q7').setAttribute('value', '');
    document.getElementById('q8').setAttribute('value', '');
    document.getElementById('q9').setAttribute('value', '');
    document.getElementById('q10').setAttribute('value', '');
    document.getElementById('q30').selectedIndex = 0;
    document.getElementById('q31').setAttribute('value', '');
    document.getElementById('q32').setAttribute('value', '');
    document.getElementById('q42').setAttribute('value', '');
    document.getElementById('q43').setAttribute('value', '');
    }

    function js(id) {
    $('#div_' + id).fadeIn();
    return true;
    }

    $(function (){
    $('.close').click(function() {
    idstr = $(this).attr('id').substr(4);
    //alert('Id: '+idstr);
    $("#div_" + idstr).fadeOut();
    });
    })

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
            });
    $(function() {

    $("#searchform").accordion();
    });</script>


<!-- Kopf mit Suchfeldern  -->
<div  style="width:1685px;overflow: auto;overflow: hidden;text-align: left;border:1px solid red;position: relative;">
    {{ Form::open(array('url' => 'filterTermine','style'=>'color:#101010;height:120px;margin:5px;', 'id'=>'formFilter')) }}
    <div id="search_form" style="overflow: auto;border:none;height: 160px;width:1650px;margin:0 auto;">

        <?php $qry   = Session::get("cpcqQry"); ?>
        <span style="font-size:9px;color:#101010;">{{Session::get("cpcFilterWerte")}}</span><br>


        <div style="height:90px;width: 60px;border:none;float:left;overflow:hidden;padding:5px;background-color:#DEDEDE;">
            Projekt-Filter
        </div>
        <div style="height:120px;width: 400px;border:none;float:left;overflow:auto;padding-top:5px;padding-left:5px;">

            <div style="margin-right:10px;float:left;text-align:left;">

                {{Form::text('qQry[5]',$qry[5],array('id'=>'q5','placeholder'=>'IAN','style'=>'width:120px;margin-top:4px;padding:5px;'))}} <br>
                {{Form::text('qQry[6]',$qry[6],array('id'=>'q6','placeholder'=>'Artikel','style'=>'width:120px;margin-top:4px;'))}}<br>
                {{Form::label('Status Projekt',  Null,array('style'=>'width:100px;'))}}<br>
                {{Form::select('qQry[1]',array(''=>'','Neu'=>'Neu','Vorversion'=>'Vorversion','In Arbeit'=>'In Arbeit','Final'=>'Final','Abgeschlossen'=>'Abgeschlossen'),'',array('id'=>'q1','placeholder'=>'Status','style'=>'width:120px;margin-top:4px;'))}} <br>


            </div>
            <div style="margin-right:10px;float:left;text-align:left;">


                {{-- Form::label('Projekt',  Null,array('style'=>'width:100px;')) --}}
                {{Form::text('qQry[7]',$qry[7],array('id'=>'q7','placeholder'=>'Projekt','style'=>'width:120px;margin-top:4px;'))}}<br>
                {{Form::text('qQry[42]',$qry[42],array('id'=>'q42','placeholder'=>'Produzent','style'=>'width:120px;margin-top:4px;'))}}<br>




                {{Form::label('Musterung',  Null,array('style'=>'width:100px;'))}}<br>
                {{Form::select('qQry[9]',$kalender['ausmusterungen'],'',array('id'=>'q9','placeholder'=>'Musterung','style'=>'width:120px;margin-top:4px;'))}}<br>


            </div>
            <div style="margin-right:10px;float:left;text-align:left;">
                {{-- Form::label('Datum Import',  Null,array('style'=>'width:100px;')) --}}
                {{Form::text('qQry[31]',$qry[31],array('id'=>'q31','placeholder'=>'Datum Import','style'=>'width:120px;margin-top:4px;'))}}<br>
                {{Form::text('qQry[43]',$qry[43],array('id'=>'q43','placeholder'=>'Land','style'=>'width:120px;margin-top:4px;'))}}<br>




                {{Form::label('MA Import',  Null,array('style'=>'width:100px;'))}}<br>
                {{Form::select('qQry[30]',$kalender['verantwortlicher'],'',array('id'=>'q30','placeholder'=>'MA Import','style'=>'width:120px;margin-top:4px;'))}}<br>

            </div>

        </div>
        <div style="height:90px;width: 60px;border:none;float:left;overflow:hidden;padding:5px;background-color:#DEDEDE;">
            Termin-Filter
        </div>
        <div style="height:95px;width: 900px;border:none;float:left;overflow:auto;padding-top:5px;padding-left:5px;">
            <div style="margin-right:10px;float:left;text-align:left;">
                {{-- Form::label('Freitext',     Null,array('style'=>'width:100px;')) --}}
                {{Form::text('qQry[10]',$qry[10],array('id'=>'q10','Placeholder'=>'Freitext','style'=>'width:120px;margin-top:4px;'))}}<br>

                {{Form::text('Place',null,array('style'=>'width:120px;margin-top:6px;border:1px solid #FFF;'))}}<br>


                {{Form::label('Verantwortlicher',Null,array('style'=>'width:100px;'))}} <br>
                {{Form::select('qQry[2]',$kalender['verantwortlicher'],'',array('id'=>'q2','style'=>'width:120px;margin-top:4px;'))}}<br>

            </div>
            <div style="margin-right:10px;float:left;text-align:left;">
                {{-- Form::label('Anzeigetext',           Null,array('style'=>'width:100px;')) --}}
                {{Form::text('qQry[4]',$qry[4],array('id'=>'q4','Placeholder'=>'Anzeigetext','style'=>'width:120px;margin-top:4px;'))}}
            </div>
            <div style="margin-right:10px;float:left;text-align:left;">
                {{-- Form::label('Bemerkungen',     Null,array('style'=>'width:100px;')) --}}
                {{Form::text('qQry[3]',$qry[3],array('id'=>'q3','Placeholder'=>'Bemerkung','style'=>'width:120px;margin-top:4px;'))}}<br>


                {{Form::text('Place',null,array('style'=>'width:120px;margin-top:6px;border:1px solid #FFF;'))}}<br>
                {{ Form::label('Status Termin',   Null,array('style'=>'width:100px;')) }} <br>
                {{Form::select('qQry[0]',$kalender['termin_stati'],null,array('id'=>'q0','style'=>'width:120px;margin-top:4px;'))}}
            </div>

            <div style="margin-right:10px;float:left;text-align:left;margin-left:30px;">
                <table>
                    <tr>
                        <td style="width:180px;border:none;padding:2px;">Spalten Status speichern</td>
                        <td style="width:100px;padding:2px;border:none;"><input type="checkbox" style="width:100px;" value="ColSpeichern" name="UserSettings_Save" id="UserSettings_Save"/></td>
                    </tr>
                    <tr>
                        <td style="width:180px;border:none;padding:2px;">Spalten Status löschen</td>
                        <td style="width:100px;padding:2px;border:none;"><input type="checkbox" style="width:100px;" value="ColLoeschen" name="UserSettings_Delete" id="UserSettings_Delete"/></td>
                    </tr>
                    <tr>
                        <td style="border:none;padding:2px;">Name</td>
                        <td style="border:none;padding:2px;"><input type="text" style="width:100px;" id="UserSettings_Name" name="UserSettings_Name"/></td>
                    </tr>
                    <tr>
                        <td  style="border:none;">Spalten Status auswählen</td>
                        <td  style="border:none;">{{Form::select('UserSettings_Setting',$kalender['userSettings'],null,array('id'=>'UserSettingsCol','style'=>'width:120px;margin-top:4px;'))}}</td>
                    </tr>

                </table>




            </div>


        </div>
        <div style="height:100px;width: 110px;border:none;float:left;overflow:hidden;border:none;text-align: right;">
            <div style="margin-right:10px;float:left;text-align:left;">
                <div style="margin-right:0px;float:left;text-align:left;margin-left:10px;border:none;">
                    {{Form::text('qQry[32]',$qry[32],array('id'=>'q32','placeholder'=>'Ausmusterung (akt.)','style'=>'width:90px;margin-top:4px;'))}}<br>
                </div>
                <div style="clear: both;"></div>
                <div style="float:left;">{{Form::submit('Filtern',array('style'=>'width:90px;margin-top:15px;margin-left:10px;margin-right:10px;height:22px;'))}}</div>
                <div  style="float: left;">{{Form::button('leeren',array('onclick'=>'resetForm();', 'style'=>'width:90px;margin-top:15px;margin-left:10px;margin-right:10px;height:22px;'))}}</div>
                <!--BUTTON onclick="colStatusSave();">Col Status</BUTTON-->
            </div>
            <div style="width:50px;overflow:auto;height:50px; position: absolute; top:2px;right:2px;background-color: orange;">
                <div id="InfoMarker"> </div>
            </div>
        </div>
        <div style="clear: both;"></div>

    </div>
    {{Form::close()}}
</div>

<!-- Ergebnisbereich -->

<h1>TEST</h1>


@if ($kalender['hasData'])

<div style="width:1685px;padding:10px;overflow-y: auto; overflow-x: auto;  height: 825px;text-align: left;padding:0px;">
    <?php $excol = Session::get('cpcCOLS'); ?>
    <table style="table-layout: fixed;border-collapse: collapse;font-size:12px; font-family: Arial;width:3000px;">
        <tr style="font-size: 1px; height: 2px;">
            <td style="width:20px; height: 2px;"> <!-- Auswahl -->&nbsp; </td>
            <td style="width:80px; height: 2px;"> <!-- Projekt -->&nbsp; </td>
            <td style="width:100px; height: 2px;"> <!-- MA Import -->&nbsp; </td>
            <td style="width:60px; height: 2px;"> <!-- Status -->&nbsp; </td>
            <td style="width:250px; height: 2px;"> <!-- Artikel -->&nbsp; </td>
            <td style="width:80px; height: 2px;"> <!-- LT -->&nbsp; </td>
            <td style="width:70px; height: 2px;"> <!-- Herkunft -->&nbsp; </td>
            <td style="width:70px; height: 2px;"> <!-- FOB -->&nbsp; </td>
            <td style="width:70px; height: 2px;">  <!-- IAN -->&nbsp; </td>
            @foreach ($kalender['header'] as $h)
            <?php
            if (isset($excol[$h['id']]) and $excol[$h['id']]) {
                $visi = "collapse";
            }
            else {
                $visi = "visible";
            }
            ?>
            <td id="col_{{$h['id'];}}" style="width:40px;visibility:{{$visi}}  height: 2px;"></td>
            @endforeach
        </tr>
        <tr >
            <td >
                <a href="#" id="cbt_einblenden"  onclick="einblendenAlle();"/><div style="width:10px;height:10px;background-color: red;margin:5px;"></div></a>
            </td>
            <td  colspan="8">&nbsp;</td>
            <?php $i           = 1; ?>
            @foreach ($kalender['header'] as $h)
            <td >{{--$h['rot'];--}}
                <div style="width:50px;margin:0 auto;">
                    <a href="#" id="lcbt_{{$h['id']}}"  onclick="einblenden('{{$h['id']}}', 'l')" style="text-decoration: none; color:#000;">
                        <div style="width:10px;height:18px;margin:2px;float:left;text-decoration: none; color:#000;"><</div>
                    </a>
                    <a href="#" id="cbt_{{$h['id']}}"  onclick="ausblenden('{{$h['id']}}')" style="text-decoration: none; color:#000;">
                        <div style="width:10px;height:18px;margin:2px;float:left;text-align: center;">{{$i}}</div>
                    </a>
                    <a href="#" id="rcbt_{{$h['id']}}"  onclick="einblenden('{{$h['id']}}', 'r')" style="text-decoration: none; color:#000;">
                        <div style="width:10px;height:18px;margin:2px;float:left;">></div>
                    </a>

                </div>

            </td>
            <?php $i           = $i + 1; ?>
            @endforeach
        </tr>
        <tr style="background-color: lightgray;">
            <td  colspan="9">&nbsp;</td>

            @foreach ($kalender['header'] as $h)
            @if ($h['colspan'] !=0)
            <td colspan="{{$h['colspan']}}" >
                {{$h['obez']}}
            </td>
            @endif
            @endforeach
        </tr>

        <tr style="height:95px;">
            <td class="cpctdHeaderleft">A</td>
            <td class="cpctdHeaderleft">
                <div class="divHeaderLeft">
                    Projekt <a href="/termine/projekt/U"><div class="sort_icon_up" ></div></a> <a href="/termine/projekt/D"><div class="sort_icon_down" ></div></a>
                </div>
            </td>
            <td class="cpctdHeaderleft">
                <div  class="divHeaderLeft" style="width:90px;">
                    MA Import <a href="/termine/import_ma/U"><div class="sort_icon_up"></div></a> <a href="/termine/import_ma/D"><div class="sort_icon_down" ></div></a>
                </div>
            </td>
            <td class="cpctdHeaderleft">
                <div  class="divHeaderLeft" style="width:37px;">
                    Status <a href="/termine/status/U"><div class="sort_icon_up"></div></a> <a href="/termine/status/D"><div class="sort_icon_down" ></div></a>
                </div>
            </td>
            <td class="cpctdHeaderleft">
                <div  class="divHeaderLeft">
                    Artikel <a href="/termine/artikelbez/U"><div class="sort_icon_up"></div></a> <a href="/termine/artikelbez/D"><div class="sort_icon_down" ></div></a>
                </div>
            </td>
            <td class="cpctdHeaderleft">
                <div  class="divHeaderLeft">
                    LT <a href="/termine/wbislt/U"><div class="sort_icon_up"></div></a> <a href="/termine/wbislt/D"><div class="sort_icon_down" ></div></a>
                </div>
            </td>
            <td class="cpctdHeaderleft">
                <div  class="divHeaderLeft">
                    Herkunft <a href="/termine/wbislt/U"><div class="sort_icon_up"></div></a> <a href="/termine/wbislt/D"><div class="sort_icon_down" ></div></a>
                </div>
            </td>
            <td class="cpctdHeaderleft">
                <div  class="divHeaderLeft">
                    FOB <a href="/termine/FOBsort/U"><div class="sort_icon_up"></div></a> <a href="/termine/FOBsort/D"><div class="sort_icon_down" ></div></a>
                </div>
            </td>
            <td class="cpctdHeaderleft">
                <div  class="divHeaderLeft">
                    IAN <a href="/termine/ppian/U"><div class="sort_icon_up"></div></a> <a href="/termine/ppian/D"><div class="sort_icon_down" ></div></a>
                </div>
            </td>
            @foreach ($kalender['header'] as $h)
            <td class="cpctdHeader1" ><div class="div_header_rotate" >{{$h['bez']}}</div> </td>
            @endforeach
        </tr>

        <?php
        $lproject    = "X";
        $lcolor      = 0;
        ?>
        @foreach ($kalender['termine']  as $l)

        <?php
        $pbgcolor[0] = "#FFFF00";
        $pbgcolor[1] = "#FFBF00";
        if ($lproject != $l['projekt'] or $lproject == "") {
            $lcolor++;
            $lcolor   = $lcolor % 2;
            $lproject = $l['projekt'];
        }
        ?>

        <?php
        $rowid = Session::get('cpcMarkRow');
        if ($rowid == $l['ppid']) {
            $borderstyle = "border: 3px solid red;";
        }
        else {
            $borderstyle = "border: 1px solid lightgray;";
        }
        ?>

        <tr id="tr_{{$l['ppid']}}" class="notmarked" style="<?php echo($borderstyle); ?>" >
            <td style="background-color:{{$pbgcolor[$lcolor]}};">
                <input type="checkbox" id="cb_{{$l['ppid']}}" onclick="markRow('{{$l['ppid']}}','{{$l['ppian']}}<br>{{$l['artikelbez']}}');"/>
            </td>
            <td  style="background-color:{{$pbgcolor[$lcolor]}};" title="{{$l['projekt']}}">
                {{$l['projekt']}}
            </td>
            <td  style="background-color:{{$pbgcolor[$lcolor]}};">
                {{$l['import_datum']}}<br>
                {{$l['import_ma']}}
            </td>
            <td  style="background-color:{{$pbgcolor[$lcolor]}};">
                {{$l['status']}}
            </td>
            <td  style="background-color:{{$pbgcolor[$lcolor]}};">
                {{ $l['artikelbez']}}
            </td>
            <td  style="background-color:{{$pbgcolor[$lcolor]}};">
                @if ($l['ltJahr']>0 )
                <span style="color:blue;">{{$l['lt']}}/{{$l['ltJahr']}}</span>  ({{ $l['wbislt']}})<br>
                @foreach ($l['liefertermine'] as $key => $value)
                <span style="color:blue;" title="{{$value}}">{{$key}}</span> @if(strlen($value)> 6) {{substr($value,0,5)}} <span style="color:red;" title="{{$value}}">+</span> @else {{$value}} @endif <br>
                @endforeach
                @else
                {{$l['lt']}}/-- (--)
                @endif
            </td>
            <td  style="background-color:{{$pbgcolor[$lcolor]}};">{{ $l['herkunft']}}<br>  {{ substr($l['produktionsstaette'],0,15)}}      </td>
            <td  style="background-color:{{$pbgcolor[$lcolor]}};">
                <?php
                $lj = $l['ltJahr'];
                $lz = 0;
                if ($l['herkunft'] == "Türkei") {
                    $lz = 3;
                } if ($l['herkunft'] == "Ägypten") {
                    $lz = 3;
                } if ($l['herkunft'] == "Äthiopien") {
                    $lz = 4;
                }
                if ($lz == 0) {
                    $lz = 6;
                } $lw = $l['lt'] - $lz;
                if ($lw < 0) {
                    $lj--;
                    $lw += 52;
                }
                ?>
                {{$lw}}/{{$lj}}<br>
                {{$l['FOB']}}
            </td>
            <td  style="background-color:{{$pbgcolor[$lcolor]}};">
                <a href="/show/{{$l['ppid']}}" target="_blank" style="text-decoration: none;color:#000;">
                    @if (strlen($l['ppian'])>6)
                    {{substr($l['ppian'],0,10)}}X
                    @else
                    <span style="font-size:12px; "><b>{{$l['ppian']}}</b></span>
                    @endif
                </a>
            </td>
            @foreach ($kalender['header'] as $h)
            <?php $id = isset($l[$h['id']]) ? $l[$h['id']]['id'] : 0 ?>
            @if ($id !=0)
            <td style="background-color:rgb({{$l[$h['id']]['bgcolor']}});vertical-align: top;">
                @else
            <td style="background-color:#ababab;vertical-align: top;">
                @endif
                <div style="border:none;height:28px;position:relative;">

                    @if ($id !=0)
                    @if (strlen($l[$h['id']]['bemerkung']) > 2)
                    <div style='background-color: #ab56fE;width: 8px;height:14px;position: absolute; top:0px; right:0px; z-index:95;padding:2px;'>
                        <span title="{{$l[$h['id']]['bemerkung']}}">B</span></div>
                    @endif
                    @if ($h['id'] == 53)
                    @include('termine.termine_edit8w')
                    @else
                    @include('termine.termine_edit')
                    @endif
                    @else
                    <div style="height:30px;background-color:#a1b6D6;padding:4px;">&nbsp;</div>
                    @endif
                </div>
            </td>
            @endforeach
        </tr>
        @endforeach


    </table>
</div>

@else
keine Termine ausgewählt!
@endif

<script>
function ausblendenX (str){
            //alert(str);
            document.getElementById('col_' + str).setAttribute('style', 'visibility:collapse');
}
</script>

    <script>
function markRow (id, ian){


                    $.ajax({
                    type: "GET",
                            url: "/markRow/" + id,
                            data: "",
                            cache: false,
                            success: function()
                            {
                            var bc = 'lightgray';
                            var bl = 1;
                            if (document.getElementById('cb_' + id).checked){
                            bl = 3;
                            bc = 'red';
                            document.getElementById("InfoMarker").innerHTML = document.getElementById("InfoMarker").innerHTML + "<br>" + ian;
                            } else {
                            bl = 1;
                            bc = 'lightgray';
                            document.getElementById("InfoMarker").innerHTML = "Markiert:";
                            };
                            document.getElementById("tr_" + id).style.borderWidth = bl;
                            document.getElementById("tr_" + id).style.borderColor = bc;
                            },
                            error: function(data)
                            {
                            //alert("Es ist ein Fehler aufgetreten!");
                            }
                    });
            }
</script>

<script>
function search_ausblenden (){
        alert('und weg');
document.getElementById('search_form').setAttribute('style', 'display:none');
        }

</script>

<script>

function ausblenden (id){


$.ajax({
type: "GET",
        url: "/colAusblenden/" + id,
        data: "",
        cache: false,
        success: function()
        {
        document.getElementById('col_' + id).setAttribute('style', 'visibility:collapse');
        },
        error: function(data)
        {
        //alert("Es ist ein Fehler aufgetreten!");
        }
});
}

</script>

<script>

function einblenden (id,d){


                    if (d == 'l') id = parseInt(id) - 1;
            if (d == 'r') id = parseInt(id) + 1;
            $.ajax({
            type: "GET",
                    url: "/colEinblenden/" + id,
                    data: "",
                    cache: false,
                    success: function()
                    {

                    document.getElementById('col_' + id).setAttribute('style', 'visibility:visible');
                    },
                    error: function(data)
                    {
                    alert("Es ist ein Fehler aufgetreten!");
                    }
            });
        }

        function colStatusSave(){

                    $.ajax({
                    type: "GET",
                            url: "/colStatusSave",
                            data: "",
                            cache: false,
                            success: function()
                            {

                            alert("Col Status gesichert!");
                            },
                            error: function(data)
                            {
                            alert("Es ist ein Fehler aufgetreten!");
                            }
                    });
                }

</script>

<script>

function einblendenAlle (){


    $.ajax({
    type: "GET",
            url: "/colEinblendenAlle",
            data: "",
            cache: false,
            success: function()
            {

            for (i = 32; i < 66; i++) {
            document.getElementById('col_' + i).setAttribute('style', 'visibility:visible');
            }
            },
            error: function(data)
            {
            //alert("Es ist ein Fehler aufgetreten!");
            }
    });
//alert('Einblenden');



}

</script>
<script>


function cpc_tsave(id) {


    var values = {
    "Termine_Id": id,
            "Termine_Datum": $("#Termine_Datum" + id)[0].value,
            "Termine_Datum_Ende": $("#Termine_Datum_Ende" + id)[0].value,
            "Termine_Label": $("#Termine_Label" + id)[0].value,
            "Termine_Bemerkung": $("#Termine_Bemerkung" + id)[0].value,
            "Termine_Status": $("#Termine_Status" + id)[0].value,
            "Termine_Mitarbeiter": $("#Termine_Mitarbeiter" + id)[0].value

    };
//console.log
var jsonString = JSON.stringify(values);
//alert(jsonString);
cpc_SendAjaxJsonRequest("termineupdatejson", jsonString);
return false;
}




function cpc_SendAjaxJsonRequest(url, jsonObject)
{

    $.ajax({
    type: "POST",
            url: url,
            data: {

            jsonObject: jsonObject
            },
            success: cpc_onSuccess

    });
}

/**
* AJAX-Response auswerten
*/
function cpc_onSuccess(content)
{
    // Das empfangene Objekt wird wieder zum Objekt geparst
    //alert(content);
    //response = JSON.parse( content );

    var sResult = content.cont;
// console.log(content.cont);
//var msgcontainer = $("#messagebox"+content.id);

// geladenes Template im Container "content" austauschen
//$("#content").html(response.template);

$("#messagebox" + content.id)[0].innerHTML = sResult;
// Pruefen ob die Eingabe richtig ist,

}


</script>