<style>
    label, input, textarea, select {
        display: inline-block; vertical-align: top; margin:2px;
    }

    label {width:250px;}
    input{width:300px;}
    ul {list-style-type: none;}
    div {font-family: Tahoma;
         font-size:12px;}

    .std_table{

        display: table;
        border-collapse: collapse;
        font-family:tahoma;
        font-size:12px;
    }
    .std_rowH, .std_row {
        display:table-row;
    }
    .std_cellH, .std_cell{
        padding:4px;
        border-radius: 0;
        display:table-cell;
        height:25px;
    }
    .std_cellH{
        background-color:lightgray;
        border:1px solid gray;
        width:120px;
        float:left;
        vertical-align: center;
    }
    .std_cell{
        background:none;
        border:1px solid gray;
        width:120px;
        float:left;
        vertical-align: middle;
        text-align: center;
        height:45px;

    }
    .std_input{
        font-family:tahoma;
        font-size:12px;
        width:95px;
        border:none;
        text-align:right;
        padding-right:8px;
        border:2px solid darkblue;
        background-color: lightgray;
        padding:4px;
    }

    .std_checkbox {
        border:1px solid darkblue;
        width:30px;
        height:30px;
    }
</style>




<div style="border: 1px solid gray; border-radius: 5px;height:600px;text-align:left;padding:5px;margin: 0 auto;">
    <h1 style="color:#27408B"> Verwaltung Ländergrössen</h1>

    {{ Form::open(array('url'=>'stammdaten/cs', 'class'=>'form-signin')) }}


    <fieldset>
        <legend style="font-size: 18px;">Ländergröße</legend>

        <ul>
            <li>{{ Form::label('Ländergröße')}}{{ Form::select('PPBW_Laendergroesse_Id', $csa['cbCont'],$csa['cs_id']) }} {{ Form::submit('anzeigen', array('name'=>'submit_button','style'=>'width:100px;','class'=>'btn btn-large btn-primary btn-block'))}}
            </li>
        </ul>
        @if ($csa['cs'])
        {{Form::hidden('CS[Id]',$csa['cs']->PPBW_Laendergroessen_Id)}}
        {{Form::hidden('CS[Einheit_Alt]',$csa['cs']->PPBW_Laendergroessen_Einheit)}}

        <div class="std_table">
            <div class="std_rowH">
                <div class="std_cellH">Land</div>
                <div class="std_cellH">Größe</div>
                <div class="std_cellH">Einheit</div>
                <div class="std_cellH">&nbsp;</div>
                <div class="std_cellH">Bett [Breite {{$csa['cs']->PPBW_Laendergroessen_Einheit}}]</div>
                <div class="std_cellH">Breite verdoppeln</div>
                <div class="std_cellH">Bett [Länge {{$csa['cs']->PPBW_Laendergroessen_Einheit}}]</div>
                <div class="std_cellH">Länge verdoppeln</div>
                <div class="std_cellH">Bett [Saumbreite cm]</div>
                <div class="std_cellH">Bett [Saumlänge cm]</div>
                <div class="std_cellH">Bett [qm]</div>


            </div>

            <?php
            $f = 1;
            if ($csa['cs']->PPBW_Laendergroessen_Einheit == 'inch') {
                $f = 2.54;
            }

            $qmBett    = 0;
            $qmKissen  = 0;
            $qmDuvet   = 0;
            $lBett     = 0;
            $lKissen   = 0;
            $lDuvet    = 0;
            $bBett     = 0;
            $bKissen   = 0;
            $bDuvet    = 0;
            $anzKissen = 0;

            $lBett = $csa['cs']->PPBW_Laendergroessen_Bett_Laenge * $f + ($csa['cs']->PPBW_Laendergroessen_Bett_Verdoppeln == 'B'
                        ? 0 : 1) * $csa['cs']->PPBW_Laendergroessen_Bett_Laenge * $f;
            $bBett = $csa['cs']->PPBW_Laendergroessen_Bett_Breite * $f + ($csa['cs']->PPBW_Laendergroessen_Bett_Verdoppeln == 'B'
                        ? 1 : 0) * $csa['cs']->PPBW_Laendergroessen_Bett_Breite * $f;

            $lKissen   = $csa['cs']->PPBW_Laendergroessen_Kissen_Laenge * $f + ($csa['cs']->PPBW_Laendergroessen_Kissen_Verdoppeln == 'B'
                        ? 0 : 1) * $csa['cs']->PPBW_Laendergroessen_Kissen_Laenge * $f;
            $bKissen   = $csa['cs']->PPBW_Laendergroessen_Kissen_Breite * $f + ($csa['cs']->PPBW_Laendergroessen_Kissen_Verdoppeln == 'B'
                        ? 1 : 0) * $csa['cs']->PPBW_Laendergroessen_Kissen_Breite * $f;
            $anzKissen = $csa['cs']->PPBW_Laendergroessen_Anz_Kissen;

            $lBett += $csa['cs']->PPBW_Laendergroessen_Bett_SaumLaenge;
            $bBett += $csa['cs']->PPBW_Laendergroessen_Bett_SaumBreite;

            $lKissen += $csa['cs']->PPBW_Laendergroessen_Kissen_SaumLaenge;
            $bKissen += $csa['cs']->PPBW_Laendergroessen_Kissen_SaumBreite;

            if (!is_null($csa['cs']->PPBW_Laendergroessen_Duvet_Laenge) and strlen(trim($csa['cs']->PPBW_Laendergroessen_Duvet_Laenge)) > 0) {
                $lDuvet = $csa['cs']->PPBW_Laendergroessen_Duvet_Laenge * $f + ($csa['cs']->PPBW_Laendergroessen_Duvet_Verdoppeln == 'B'
                            ? 0 : 1) * $csa['cs']->PPBW_Laendergroessen_Duvet_Laenge * $f;
                $bDuvet = $csa['cs']->PPBW_Laendergroessen_Duvet_Breite * $f + ($csa['cs']->PPBW_Laendergroessen_Duvet_Verdoppeln == 'B'
                            ? 1 : 0) * $csa['cs']->PPBW_Laendergroessen_Duvet_Breite * $f;

                $lDuvet += $csa['cs']->PPBW_Laendergroessen_Duvet_SaumLaenge;
                $bDuvet += $csa['cs']->PPBW_Laendergroessen_Duvet_SaumBreite;
            }


            $qmBett   = $lBett * $bBett / 10000;
            $qmKissen = $anzKissen * $lKissen * $bKissen / 10000;
            $qmDuvet  = $anzKissen * $lDuvet * $bDuvet / 10000;
            $qmTotal  = $qmBett + $qmKissen + $qmDuvet;
            ?>
            <div class="std_row">

                <div class="std_cell">{{$csa['cs']->PPBW_Laendergroessen_Land}}</div>
                <div class="std_cell">{{$csa['cs']->PPBW_Laendergroessen_Groesse}}</div>
                <div class="std_cell">{{Form::select('CS[Einheit]', array("cm" => "cm", "inch" =>"inch"),$csa['cs']->PPBW_Laendergroessen_Einheit, array('class'=>'std_input'))}}</div>
                <div class="std_cell">&nbsp;</div>
                <div class="std_cell">{{Form::text('CS[Bett_Breite]', $csa['cs']->PPBW_Laendergroessen_Bett_Breite, array('class'=>'std_input'))}}</div>
                <div class="std_cell">{{Form::radio('CS[Bett_Verdoppeln]', 'B',$csa['cs']->PPBW_Laendergroessen_Bett_Verdoppeln == 'B', array('class'=>'std_checkbox'))}}</div>
                <div class="std_cell">{{Form::text('CS[Bett_Laenge]', $csa['cs']->PPBW_Laendergroessen_Bett_Laenge, array('class'=>'std_input'))}}</div>
                <div class="std_cell">{{Form::radio('CS[Bett_Verdoppeln]', 'L',$csa['cs']->PPBW_Laendergroessen_Bett_Verdoppeln == 'L', array('class'=>'std_checkbox'))}}</div>
                <div class="std_cell">{{Form::text('CS[Bett_SaumBreite]', $csa['cs']->PPBW_Laendergroessen_Bett_SaumBreite, array('class'=>'std_input'))}} </div>
                <div class="std_cell">{{Form::text('CS[Bett_SaumLaenge]', $csa['cs']->PPBW_Laendergroessen_Bett_SaumLaenge, array('class'=>'std_input'))}}</div>
                <div class="std_cell" style="text-align: right;">{{$bBett}} x  {{$lBett}} = {{ number_format( $qmBett,2,",",".") }}</div><br>
            </div>

            <div class="std_rowH">
                <div class="std_cellH">&nbsp;</div>
                <div class="std_cellH">&nbsp;</div>
                <div class="std_cellH">&nbsp;</div>
                <div class="std_cellH">Anzahl Kissen</div>
                <div class="std_cellH">Kissen [Breite {{$csa['cs']->PPBW_Laendergroessen_Einheit}}]</div>
                <div class="std_cellH">Breite verdoppeln</div>
                <div class="std_cellH">Kissen [Länge {{$csa['cs']->PPBW_Laendergroessen_Einheit}}]</div>
                <div class="std_cellH">Länge verdoppeln</div>
                <div class="std_cellH">Kissen [Saumbreite cm]</div>
                <div class="std_cellH">Kissen [Saumlänge cm]</div>
                <div class="std_cellH">Kissen [qm]</div>
            </div>

            <div class="std_row">
                <div class="std_cell">&nbsp;</div>
                <div class="std_cell">&nbsp;</div>
                <div class="std_cell">&nbsp;</div>
                <div class="std_cell">{{Form::text('CS[Anz_Kissen]', $csa['cs']->PPBW_Laendergroessen_Anz_Kissen, array('class'=>'std_input'))}}</div>
                <div class="std_cell">{{Form::text('CS[Kissen_Breite]', $csa['cs']->PPBW_Laendergroessen_Kissen_Breite, array('class'=>'std_input'))}}</div>
                <div class="std_cell">{{Form::radio('CS[Kissen_Verdoppeln]','B', $csa['cs']->PPBW_Laendergroessen_Kissen_Verdoppeln == 'B', array('class'=>'std_checkbox'))}}</div>
                <div class="std_cell">{{Form::text('CS[Kissen_Laenge]', $csa['cs']->PPBW_Laendergroessen_Kissen_Laenge, array('class'=>'std_input'))}}</div>
                <div class="std_cell">{{Form::radio('CS[Kissen_Verdoppeln]','L', $csa['cs']->PPBW_Laendergroessen_Kissen_Verdoppeln == 'L', array('class'=>'std_checkbox'))}}</div>
                <div class="std_cell">{{Form::text('CS[Kissen_SaumBreite]', $csa['cs']->PPBW_Laendergroessen_Kissen_SaumBreite, array('class'=>'std_input'))}}</div>
                <div class="std_cell">{{Form::text('CS[Kissen_SaumLaenge]', $csa['cs']->PPBW_Laendergroessen_Kissen_SaumLaenge, array('class'=>'std_input'))}}</div>
                <div class="std_cell"  style="text-align: right;"> {{$anzKissen}} x  {{$bKissen}} x {{$lKissen}} = {{ number_format($qmKissen,2,",",".") }}</div>
            </div>
            <div class="std_rowH">
                <div class="std_cellH">&nbsp;</div>
                <div class="std_cellH">&nbsp;</div>
                <div class="std_cellH">&nbsp;</div>
                <div class="std_cellH">&nbsp;</div>
                <div class="std_cellH">D-Flap [Breite cm] </div>
                <div class="std_cellH">Breite verdoppeln</div>
                <div class="std_cellH">D-Flap [Länge cm]</div>
                <div class="std_cellH">Länge verdoppeln</div>
                <div class="std_cellH">D-Flap [S.Breite cm] </div>
                <div class="std_cellH">D-Flap [S.Länge cm]</div>
                <div class="std_cellH">D-Flap [qm]</div>
                <div class="std_cellH">Total [qm]</div>

            </div>
            <div class="std_row">
                <div class="std_cell">&nbsp;</div>
                <div class="std_cell">&nbsp;</div>
                <div class="std_cell">&nbsp;</div>
                <div class="std_cell">&nbsp;</div>
                <div class="std_cell">{{Form::text('CS[Duvet_Breite]', $csa['cs']->PPBW_Laendergroessen_Duvet_Breite, array('class'=>'std_input'))}}</div>
                <div class="std_cell">{{Form::radio('CS[Duvet_Verdoppeln]', 'B',$csa['cs']->PPBW_Laendergroessen_Duvet_Verdoppeln == 'B', array('class'=>'std_checkbox'))}}</div>
                <div class="std_cell">{{Form::text('CS[Duvet_Laenge]', $csa['cs']->PPBW_Laendergroessen_Duvet_Laenge, array('class'=>'std_input'))}}</div>
                <div class="std_cell">{{Form::radio('CS[Duvet_Verdoppeln]', 'L',$csa['cs']->PPBW_Laendergroessen_Duvet_Verdoppeln == 'L', array('class'=>'std_checkbox'))}}</div>
                <div class="std_cell">{{Form::text('CS[Duvet_SaumBreite]', $csa['cs']->PPBW_Laendergroessen_Duvet_SaumBreite, array('class'=>'std_input'))}} </div>
                <div class="std_cell">{{Form::text('CS[Duvet_SaumLaenge]', $csa['cs']->PPBW_Laendergroessen_Duvet_SaumLaenge, array('class'=>'std_input'))}} </div>
                <div class="std_cell"  style="text-align: right;"> {{$anzKissen}} x {{$bDuvet}} x  {{$lDuvet}} = {{ number_format($qmDuvet,2,",",".") }}</div>
                <div class="std_cell"  style="text-align: right;">{{ number_format($qmTotal,2,",",".") }}</div>
            </div>
        </div>
        <div style="text-align:right;padding-right: 100px;padding-top: 30px;">
            {{ Form::submit('speichern', array('name'=>'submit_button','style'=>'width:100px;','class'=>'btn btn-large btn-primary btn-block'))}}
        </div>
        @else
        <div style="margin-top:300px;padding-left:500px;">

            <div style="width:500px;">
                <p style="margin-top: 10px; margin-right:20px; float:left;">Land:</p>
                {{Form::text('NeuesLand', "", array('class'=>'std_input', 'style'=>"padding-left:15px;text-align:left;border:1px solid lightgray;width:100px;height:30px;"))}}
            </div>
            <br>
            <div style="text-align: left;">
                {{ Form::submit('Neues Land anlegen / Grösse ergänzen', array('name'=>'submit_button','style'=>'width:250px;','class'=>'btn btn-large btn-primary btn-block'))}}
            </div>

            <div style="margin-top:20px;">
                <p style="color:mediumblue;">{{$csa['msg']}}</p>
            </div>

        </div>
        @endif
    </fieldset>

    {{ Form::close() }}

</div>

