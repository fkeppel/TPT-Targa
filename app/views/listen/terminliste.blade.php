<style>
    .header1 {
        padding:4px;
        border:1px solid #818080;
        background-color: #cfcac2;
        border-radius: 0px;
        font-weight: bold;
    }
    #terminliste div {
        border-radius: 0px;
        font-size: 0.8rem;
        font-family:'Open Sans', Tahoma,  Arial,  sans-serif
    }
    #terminliste .searchP {
        border:1px solid gray;
        font-size: 0.8rem;
        border-radius: 0px !important;
    }
    .searchP select {
        width:100%;
        height:34px;
        border:none;
        border-radius: 0px!important;
        outline: none !important;
    }
    .searchP option {
        color:black;
        border-radius: 0px!important;
        padding:5px;
        font-size: 0.9rem;
    }
    #resultTable div {
        border:1px solid lightgray;
        border-radius: 0px!important;
        padding:6px;
    }
</style>
<div id="terminliste" style="padding-left:90px;text-align: left;height:calc(100% - 30px);overflow: auto;border:none; border-radius:0px; max-width:1500px;min-width:820px;margin-top:24px;">
    {{ Form::open(array('url'=>'/terminlisteFilter','id'=>'Terminliste')) }}
    <input type="hidden" name="art" value="{{ Session::get('art') }}" />
    <?php 
        $lang = 'DE';
        if ( isset($_COOKIE['TPTLanguage']) ){
            $lang = $_COOKIE['TPTLanguage'];
        } else {
            $lang = Auth::user()->PPMitarbeiter_Language;
        }
        $_art = ServiceProvider::tl($lang,'Terminliste - '); 
        if (Session::get('art') == 'PP'){
            $_art .= ServiceProvider::tl($lang,'Projekte');
        } 
        if (Session::get('art') == 'MU'){
            $_art .= ServiceProvider::tl($lang,'Musterung');
        }  
    ?>
    <div style="display: grid; grid-template-columns: 7% 28% 7% 7% 7% 8% 14% 14% 6%;    font-size:11px; ">
            <div style="grid-column: 1/ span 9;"><p style="font-size:1.5rem;color:#1c94c4;padding:0px;"><b>{{ $_art }}</b></p></div>
            <div class="header1">{{ ServiceProvider::tl($lang,'Verantwortlich') }}<br><a href="/terminliste/1U" style="text-decoration: none;">&#9650;</a> <a href="/terminliste/1D" style="text-decoration: none;">&#9660;</a></div>
            <div class="header1">{{ ServiceProvider::tl($lang,'Projekt') }}/{{ ServiceProvider::tl($lang,'IAN') }}<br><a href="/terminliste/2U" style="text-decoration: none;">&#9650;</a> <a href="/terminliste/2D" style="text-decoration: none;">&#9660;</a></div>
            <div class="header1">{{ ServiceProvider::tl($lang,'Musterung') }}<br><a href="/terminliste/8U" style="text-decoration: none;">&#9650;</a> <a href="/terminliste/8D" style="text-decoration: none;">&#9660;</a></div>
            <div class="header1">{{ ServiceProvider::tl($lang,'Anzeigetext') }}</div>
            <div class="header1">{{ ServiceProvider::tl($lang,'Bemerkung') }}</div>
            <!-- div class="header1" style="text-align: rigth;">Ist-Termin<br><a href="/terminliste/3U" style="text-decoration: none;">&#9650;</a> <a href="/terminliste/3D" style="text-decoration: none;">&#9660;</a></div -->
            <div class="header1" style="text-align: rigth;">{{ ServiceProvider::tl($lang,'Soll-Termin') }}<br><a href="/terminliste/6U" style="text-decoration: none;">&#9650;</a> <a href="/terminliste/6D" style="text-decoration: none;">&#9660;</a></div>
            <div class="header1" style="text-align: rigth;">{{ ServiceProvider::tl($lang,'Terminart') }}<br><a href="/terminliste/4U" style="text-decoration: none;">&#9650;</a> <a href="/terminliste/4D" style="text-decoration: none;">&#9660;</a></div>
            <div class="header1">{{ ServiceProvider::tl($lang,'Status Milestone') }}<br><a href="/terminliste/5U" style="text-decoration: none;">&#9650;</a> <a href="/terminliste/5D" style="text-decoration: none;">&#9660;</a></div>
            <div class="header1">{{ ServiceProvider::tl($lang,'Aktion')}}   <br></div>
            <!--   Start -->
            <!--   COL 1 -->
            <div class="searchP">
                <select name="qVerantwortlicher" id="qVerantwortlicher" style="border-radius:0px!important;" >
                   <option value="%">{{ ServiceProvider::tl($lang,'Alle') }}</option>
                    @foreach ($data['mitarbeiter'] as $m)
                        <option title="@if (isset($data['mitarbeiterNamen'][$m])) {{ $data['mitarbeiterNamen'][$m] }} @endif" value="{{ $m }}" @if(Session::get('qMA') == $m)selected = 'selected' @endif >{{ $m }}</option>
                    @endforeach
                </select>
                <!-- <input style="width:80px;" type="text" name="qVerantwortlicher" id="qiVerantwortlicher" value="{{Session::get('qMA');}}"/> -->
            </div>
            <!--   COL 2 -->
            <div class="searchP">
                <select name="qIAN" id="qIAN"  style="border-radius:0px!important;">
                    <option value="%">{{ ServiceProvider::tl($lang,'Alle') }}</option>
                    @foreach ($data['searchValues']['PPs'] as $pp)
                        <option value="{{ $pp->PPProduktpass_IAN }}" @if ($pp->PPProduktpass_IAN == Session::get('qIAN')) selected="selected" @endif><b>{{ $pp->PPProduktpass_IAN }}</b> [{{ $pp->PPProduktpass_Ausmusterungnummer }}] {{  ServiceProvider::tl($lang,$pp->PPProduktpass_Artikelbezeichnung) }}</option>
                    @endforeach
                </select>
                <!-- input style="width:80px;" type="text" name="qIAN" id="qiIAN" value="{{Session::get('qIAN');}}"/ -->
            </div>
            <!--   COL 3 -->
            <div class="searchP">
                <select name="qAusm" id="qAusm" style="border-radius:0px!important;">
                    <option value="%">{{ ServiceProvider::tl($lang,'Alle')}}</option>
                    @foreach ($data['searchValues']['AUSM'] as $ausm)
                        <option value="{{ $ausm->PPProduktpass_Ausmusterungnummer }}" @if ($ausm->PPProduktpass_Ausmusterungnummer == Session::get('qAusm')) selected="selected" @endif>{{ $ausm->PPProduktpass_Ausmusterungnummer }}</option>
                    @endforeach
                </select>
                <!-- <input style="width:80px;" type="text" name="qAusm" id="qAusm" value="{{Session::get('qAusm');}}"/> -->
            </div>
            <!-- COL4 -->
            <div class="searchP">
                @if (Session::get('art') == 'PP')
                <!--select  name="qintStatus" id="qintStatus" style="border-radius:0px!important;">
                    <option value="%">Alle</option>
                    <option value="FIX" @if (Session::get('qintStatus') == 'FIX') selected="selected" @endif >FIX</option>
                    <option value="GELIEFERT" @if (Session::get('qintStatus') == 'GELIEFERT') selected="selected" @endif >GELIEFERT</option>
                    <option value="ABSAGE" @if (Session::get('qintStatus') == 'ABSAGE') selected="selected" @endif >ABSAGE</option>
                    <-- option value="FIX,GELIEFERT,ABSAGE" @if (Session::get('qintStatus') == 'FIX,ABSAGE') selected="selected" @endif >FIX + GELIEFERT + ABSAGE</option !-->
                </select-->
                @else 
                <!--select  name="qintStatus" id="qintStatus" style="border-radius:0px!important;">
                    <option value="%">Alle</option>
                    <option value="PLAN" @if (Session::get('qintStatus') == 'PLAN') selected="selected" @endif >PLAN</option>
                    <option value="MUSTERUNG" @if (Session::get('qintStatus') == 'MUSTERUNG') selected="selected" @endif >MUSTERUNG</option>
                </select-->
                @endif
                <!-- <input  style="width:80px;" type="text" name="qStatus" id="qiStatus" value="{{Session::get('qStatus');}}" style="width:75px;"/ -->
            </div> 
            <!-- COL5 -->
            <div class="searchP">
                <!-- select  name="qStatus" id="qStatus"style="border-radius:0px!important;">
                    <option value="%">Alle</option>
                    <option value="Neu" @if (Session::get('qStatus') == 'Neu') selected="selected" @endif >Neu</option>
                    <option value="In Arbeit" @if (Session::get('qStatus') == 'In Arbeit') selected="selected" @endif >In Arbeit</option>
                    <option value="Vorversion" @if (Session::get('qStatus') == 'Vorversion') selected="selected" @endif >Vorversion</option>
                    <option value="Final" @if (Session::get('qStatus') == 'Final') selected="selected" @endif >Final</option>
                    <option value="Abgerechnet" @if (Session::get('qStatus') == 'Abgerechnet') selected="selected" @endif >Abgerechnet</option>
                    <option value="Canceld" @if (Session::get('qStatus') == 'Cancelled') selected="selected" @endif >Cancelled</option>
                </select -->
                <!-- <input  style="width:80px;" type="text" name="qStatus" id="qiStatus" value="{{Session::get('qStatus');}}" style="width:75px;"/ -->
            </div> 
            <!-- COL6 -->
            <div class="searchP"><input  style="height:35px;" type="text" name="qSollTermin" id="qiSollTermin" value="{{Session::get('qSollTermin');}}"/></div>
            <div class="searchP">
                <select name="qTerminart" id="qTerminart" style="border-radius:0px!important;">
                    <option value="%">{{ ServiceProvider::tl($lang,'Alle') }}</option>
                    @foreach ($data['searchValues']['tas'] as $ta)
                        <option value="{{ $ta->PPBoardSpalte_Bezeichnung }}" @if ($ta->PPBoardSpalte_Bezeichnung == Session::get('qTerminart')) selected="selected" @endif>{{ $ta->PPBoardSpalte_Bezeichnung }}</option>
                    @endforeach
                </select>
                <!-- input  style="width:266px;" type="text" name="qTerminart" id="qTerminart" value="{{Session::get('qTerminart');}}"/-->
            </div>
            <!-- COL7 -->
            <div class="searchP">
                <?php $fcol = Session::get('qfcol'); ?>
                <table style='border:none;border-collapse:collapse;font-size:0.8rem;'>
                    <tr>
                        <td style="padding:4px;  text-align:left;">{{ ServiceProvider::tl($lang,'Erledigte anzeigen') }}:</td>
                        <td style="padding:4px;  text-align:center;"><input style="height:15px;" type="checkbox" name="fcol[all]"  @if (isset($fcol['all'])) checked='checked' @endif /></td>
                    </tr>
                    <tr>
                        <td style="padding:4px;  text-align:left;" title='Termine, bei denen ich als Vertretung eingetragen bin, werden nicht angezeigt!'>{{ ServiceProvider::tl($lang,'Nur eigene') }}:</td>
                        <td style="padding:4px;  text-align:center;"><input style="height:15px;" type="checkbox" name="fcol[onlyMy]"  @if (isset($fcol['onlyMy'])) checked='checked' @endif /></td>
                    </tr>
                </table>
            </div>
            <!-- COL8 -->
            <div   class="searchP" >
                <div  style=" text-align:center; padding:6px;  float: left;">
                    <button type="submit" style="font-size:0.75rem;width:75px;cursor:pointer;">{{ ServiceProvider::tl($lang,'Filtern') }}</button>
                </div>
                <div  style=" text-align:center; padding:6px;  float:left;">
                    <button type="submit" onclick="delInput();" style="font-size:0.75rem;width:75px;cursor:pointer;">{{ ServiceProvider::tl($lang,'Löschen') }}</button>
                </div>
            </div>
        </div>
    {{ Form::close() }}
    @if (isset($data['bg']) and count($data['bg']) > 0)
    <div id="tl2" style="overflow: auto;border:1px solid gray;margin-top:-10px;border-radius: 0px; height:calc(100% - 220px);">
        <!--div id="resultTable" style="display: grid; grid-template-columns: 100px 400px 100px 100px 100px 120px  200px 200px;  font-size:11px;table-layout: fixed;border:none;overflow: auto;" -->
        <div id="resultTable"  style="display: grid; grid-template-columns: 7% 28.3% 7% 7% 7.2%  8%  14% 14.5% 6%;    font-size:11px; ">
            @foreach ($data['bg'] as $key => $bgcol)
            <?php   $row  = $data['aTermine'][$key];
                    $attLabel = 'PPTermine_Label';
                    $attBemerkungen = 'PPTermine_Bemerkungen';
                    $attLabel_translate = 'PPTermine_LabelEN';
                    $attBemerkungen_translate = 'PPTermine_BemerkungenEN';
                    if ($lang != 'DE'){
                        $attLabel = 'PPTermine_LabelEN';
                        $attBemerkungen = 'PPTermine_BemerkungenEN';
                        $attLabel_translate = 'PPTermine_Label';
                        $attBemerkungen_translate = 'PPTermine_Bemerkungen';
                    }
                    $cpcCol = $row->Background;
                    if ($row->PPTermine_Status == 'offen'){
                        $cpcCol = "189,215,238";
                    } 
                    if ($row->PPTermine_Status == 'erledigt'){
                        $cpcCol = "198,254,206";
                    } 
                    $overdue = false;
                    $_now = date('Y-m-d H:i:s');
                    if ($_now > $row->DateMilestone){
                        $overdue = true;
                    }
            ?>
            <div style="background-color:rgb(235, 238, 240); padding-top:20px;text-align: center;"><span @if(Auth::user()->PPMitarbeiter_Kuerzel == $row->PPMitarbeiter_Kuerzel)style='font-weight:bold;'@endif>{{$row->PPMitarbeiter_Kuerzel}}</span></div>
            <div>
                <a href="/show/{{$row->PPProduktpass_Id}}" target="_blank" style="text-decoration: none;color:#000; cursor:pointer;">
                    <span style="margin-right: 25px; color:darkblue;font-weight: bold;">{{$row->PPProduktpass_IAN}}</span> <br><span> {{ ServiceProvider::tl($lang,'Liefertermin')}}: {{$row->PPProduktpass_Liefertermin}}/{{$row->PPProduktpass_LieferterminJahr}}</span>
                </a><br>
                {{ ServiceProvider::transContent($lang,'PPProduktpass', 'PPProduktpass_Artikelbezeichnung', $row->PPProduktpass_Id, $row ) }}<br>
            </div>
            <div>{{substr($row->PPProduktpass_Ausmusterungnummer,0,4)}}</div>
            <div title='{{ $row->{$attLabel_translate} }}' style="max-height:110px; ovefolow:auto;font-size:0.7rem;" >
                <!-- b>{{$row->InternerStatus}}</b -->
                {{ $row->{$attLabel} }}
            </div>
            <div title='{{$row->{$attBemerkungen_translate} }}' style="max-height:110px; ovefolow:auto;font-size:0.7rem;" >
                <!-- b>{{$row->PPProduktpass_Status}}</b --> 
                {{ $row->{$attBemerkungen} }}
            </div>
            <div>
                <span>{{date("d.m.Y", strtotime($row->DateMilestone))}} 
                @if($row->PPTermineChanges_Categorie == 'Hauptaufgabe')
                @if(substr($row->PPTermineChanges_DoUntil,0,4) != "0000") <span style="@if($overdue)color:red;@endif"><b>&bull;</b></span>
                @elseif ($data['manSoll'][$key] != '')
                <span style="@if($overdue)color:red;@endif"><b>*</b></span>
                @endif
                @else 
                <span style='font-size:0.5rem;@if($overdue)color:red;@endif'><b>#</b></span>
                @endif
            </div>
            <div>
                @if (strlen($row->PPBoardSpalte_Oberbez)>1)
                <b>{{ ServiceProvider::tl($lang,$row->PPBoardSpalte_Oberbez) }}</b><br>
                @endif
                <span style='font-size:0.9rem;'>{{ ServiceProvider::tl($lang, $row->PPBoardSpalte_Bezeichnung )}}</span><br>@if($row->PPTermineChanges_Categorie == 'Hauptaufgabe')<b>{{ ServiceProvider::tl($lang,'Hauptaufgabe') }}</b>@else <b>{{ ServiceProvider::tl($lang,'Unteraufgabe')}}:</b><br>{{$row->PPTermineChanges_Categorie}}@endif
            </div>
            <div style="padding-top:20px; background-color:rgb({{$cpcCol}}); border:1px solid darkgray;position:relative;">
                <?php $xboard = 1000; if (Session::get('art') == 'MU') { $xboard = 1001; } ?>
                <!-- {{substr($data['bg'][$key],1)}} -->
                <div  onclick="ajax_getTerminTab({{$row->PPProduktpass_Id}}, {{$row->PPTermine_Id}}, {{ $xboard }} , 'All', 1)" style="background-color:transparent;text-align: center; vertical-align:middle; margin:0px; color:darkblue; border:none; cursor:pointer;"> 
                        <b>{{ ServiceProvider::tl($lang,$row->PPTermine_Status) }}</b>
                </div>
            </div>
            <div></div>
            @endforeach
        </div>
    </div>
    @else
    <div style="grid-column:1/span 7;"><div  style="margin:0 auto;border:1px solid gray; padding:10px;"><h1 style="color:#4169e1;font-size:14px;">{{$data['error']}}</h1></div></div>
    @endif
</div>
<script>
    $(document).ready(function(){
    });
    function delInput(params) {
        //alert('löschen');
        document.getElementById("qVerantwortlicher").selectedIndex = 0;
        document.getElementById("qAusm").selectedIndex = 0;
        document.getElementById("qIAN").selectedIndex = 0;
        document.getElementById("qStatus").selectedIndex = 0;
        document.getElementById("qintStatus").selectedIndex = 0;
        document.getElementById("qTerminart").selectedIndex = 0;
        return true;
    }
    function ajax_getTerminTab(ppid, tid, board, select, openOnly) {
        window.open("/getTerminFromId/" + ppid + "/" + tid + "/" + board,target='_blank', "toolbar=no,scrollbars=no,resizable=no,top=10,left=10,width=1900,height=1220,rel=noreferrer,rel=nopener");
        //window.open("/getTerminFromId/" + ppid + "/" + tid + "/" + board + "/" + select + "/" + openOnly, "_blank", "rel=noopener,rel=noreferrer,toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=100,width=1235,height=1920");
    }
</script>
