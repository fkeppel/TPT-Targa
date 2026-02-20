<style>
    :root {
        --tgRed: #ff0000;
        --tgBlue: #1C73C5;
        --tgDarkBlue: #103F6B;
        --tgLightBlue: #5ec3f1;    
    }
    #ManInp {
        font-size:0.85em;
    }
    #ManInp div {
    }
    #ManInp button {
        background-color: --tgDarkBlue;
        transition: none;
    }
    #ManInp button:hover {
        background-color: --tglightblue;
        transition: none;
    }
    #ManInp label {
        border-radius: 0px;
        width: 100px;
        --border: 1px solid #003D7C;
        border: none;
        padding: 8px;
        color: var(--tgBlue);
        background-color: white;
    }
    #ManInp input {
        box-sizing:border-box;
        border-radius: 0px;
        width: 100%;
        border: 1px solid lightgray;
        padding: 8px;
        color: black;
        background-color: white;
    }
    #ManInp select {
        border-radius: 0px;
        width: 100%;
        border: 1px solid lightgray;
        padding: 8px;
        color: black;
        background-color: white;
    }
    #ManInp input:disabled {
        background-color: lightblue;
    }
    #ManInp select:disabled {
        background-color: lightblue;
    }
    #ManInp textarea {
        font-size: 1.1em;
        border: 1px solid darkblue;
        border-radius: 0px;
    }
    #ContainerTable {
        border: 1px solid darkblue;
        border-radius: 0px;
        padding: 10px;
    }
    #ContainerTable table {
        font-size: 0.8rem;
        border-collapse: collapse;
        background-color: white;
        width:100%;
        border:2px solid red;
    }
    #ContainerTable td {
        padding: 0px;
        background-color: white;
        border: 1px solid darkblue;
        vertical-align: top;
    }
    #ContainerTable input {
        margin: 0px;
        text-align: right;
        padding-right: 8px;
    }
    #ContainerTable td {
        padding: 0px;
        width: 60px;
    }
    #ContainerTable td:nth-child(1) {
        padding: 8px;
        background-color: #003D7C;
        color: white;
    }
    #ContainerTable td:nth-child(6) {
        background-color: lightgray;
        padding: 8px;
        font-weight: bold;
    }
    #ContainerTable td:nth-child(2),
    #ContainerTable td:nth-child(3),
    #ContainerTable td:nth-child(4),
    #ContainerTable td:nth-child(5),
    #ContainerTable td:nth-child(6) {
        text-align: right;
    }
    #ContainerTable th {
        padding: 8px;
        border: 1px solid gray;
        background-color: lightgray;
        text-align: right;
        width: 60px;
    }
    #tptTableCarton {
        width:100%;
        border:none;
        border-collapse: collapse;
        font-size: 0.9rem;
        font-family: Trebuchet MS, Tahoma, Verdana, Arial, sans-serif;
    }
    #tptTableCarton th {
        padding: 8px;
        border: 1px solid var(--tgDarkBlue);
        background-color: var(--tgBlue);
        color: white;
        text-align: right;
    }
    #tptTableCarton td {
        padding: 0px;
        border: 1px solid #003055;
        vertical-align: top;
    }
    #tptTableCarton th:nth-child(1) {
        width: 120px;
        text-align: left;
    }
    #tptTableCarton th:nth-child(2) {
        width: 80px;
        text-align: left;
    }
    #tptTableCarton td:nth-child(1) {
        width: 120px;
        text-align: left;
    }
    #tptTableCarton td:nth-child(2) {
        width: 80px;
        text-align: left;
    }
    #tptTableCarton th:nth-child(n+3) {
        width: 120px;
    }
    #tptTableCarton input {
        box-sizing:border-box;
        width:100%;
        text-align: right;
        border:none;
        margin: 0px;
    }
    .inpGrid{
        width:95%;
        border: none;
        display:grid;
        grid-template-columns: minmax(150px, 15%) minmax(150px, 15%) 30px minmax(150px, 15%) minmax(150px, 15%) 30px minmax(150px, 10%) minmax(150px, 15%) 30px;
    }
    .inpLable {
        border:none;
        border-bottom:1px solid darkblue;
        padding-top:10px;
        padding-left:5px;
        margin-top:10px;
    }
    .inpValue{
        margin-top:10px;
        border-bottom:1px solid darkblue;
    }
</style>
<?php
    $lang = $data['lang'];
?>
<div id="ManInp" style="border-radius: 0px;padding-left:10px; width:calc(100% - 20px); max-width:1920px;">
@if (is_null($data['InpMan']))
    <div style='border:1px solid var(--tgDarkBlue);background-color:var(--tgBlue);border-radius:0px;color:white;'>
        <h3 style='padding-left:8px;'>{{ ServiceProvider::tl($lang, 'Noch keine Serviceanfrage vorhanden') }}</h3>
    </div>
    <form action="/InputManuellInitNeu" id="FormPMInit" method="post">
        <input type="hidden" name="ppid" id="ppid" value="{{$data['pp']['PPProduktpass_Id']}}">
        <input type="hidden" name="ActivmainTab" id="hiddenActivmainTab1" value="99">
        <button id="san_neu" type="submit" name='submit' value="NeuFirst" style="margin-top:40px; margin-left:150px;width:400px; height:30px; padding:8px;font-weight:bold;margin-bottom:8px;">{{ ServiceProvider::tl($lang, 'Neue Serviceanfrage anlegen')}}A</button>
    </form>
    </div>
@else
    <?php
    $authUserTaetigkeit = Auth::user()->PPMitarbeiter_Taetigkeit;
    $disableMengen = '';
    if ($data['MengeMenge'] > 0) {
        $disableMengen = 'disabled';
    }
    $disabled = 'disabled';
    if ($data['InpMan']->PPInputManuell_StatusPM == 0) {
        $disabled = '';
    }
    $disabledMaWi = 'disabled';
    if ($data['InpMan']->PPInputManuell_StatusPM == 1 and $data['InpMan']->PPInputManuell_StatusMaWi == 0) {
        $disabledMaWi = '';
    }
    $pm = '';
    if (isset($data['Mitarbeiter'][$data['pp']->PPProduktpass_PMAdmin])) {
        $pm = $data['Mitarbeiter'][$data['pp']->PPProduktpass_PMAdmin]['email'];
    }
    ?>
    <div style='border:1px solid var(--tgDarkBlue);background-color:var(--tgBlue);border-radius:0px;color:white;padding-left:15px;'>
        <h3>{{ ServiceProvider::tl($lang, 'PM Eingabefelder')}}AAA</h3>
    </div>
    <div style="padding: 25px;color: darkblue; border: none; border-radius:0px;background-color:#FFF;"><b>{{ ServiceProvider::tl($lang, 'Bitte Zahlen in der Form 1.2345,789 eingeben')}}</b> </div>
        <div style="padding:20px;border:1px solid var(--tgBlue);border-radius:0px;">
            <div style="margin-bottom:30px;">
                <form action="/updateInputManuellNeu" id="FormPM" method="post" onsubmit="return valFormPM();">
                    <input type="hidden" name="ppid" id="ppid" value="{{$data['pp']['PPProduktpass_Id']}}">
                    <input type="hidden" name="FormHasChanged" id="FormHasChanged" value="0">
                    <input type="hidden" name="id" id="id" value="{{$data['InpMan']->PPInputManuell_Id}}">
                    <input type="hidden" name="ActivmainTab" id="hiddenActivmainTab1" value="99">
                    <input type="hidden" name="man[PPInputManuell_IsLatest]" value="{{$data['InpMan']->PPInputManuell_IsLatest}}">
                    <div class='inpGrid'>
                        <div>
                        @if ($data['InpMan']->PPInputManuell_StatusPM == 1 and $data['InpMan']->PPInputManuell_StatusMaWi == 1)
                            <button id="san_neu" type="submit" name='submit' value="Neu" class='tgButton' style='width:95%;'>{{ ServiceProvider::tl($lang, 'Neue Serviceanfrage')}}</button>
                        @endif
                        </div>
                        <div>
                        </div>
                        <div></div>
                        <div>
                        </div>
                        <div></div>
                        <div></div>
                        <div><button type="button" onclick="getVersion();" class='tgButton' style='width:95%;'>{{ ServiceProvider::tl($lang, 'anzeigen')}}</button></div>
                        <div><button type="button" onclick="aktuelleVersion({{$data['pp']['PPProduktpass_Id']}});" class='tgButton' style='width:95%;'>{{ ServiceProvider::tl($lang, 'Aktuelle Version')}}</button></div>
                        <div></div>
                        <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Vertragsnummer') }}</div>
                        <div class='inpValue'><input type="text" disabled value="IAN-{{$data['pp']['PPProduktpass_IAN']}}" /></div>
                        <div></div>
                        <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Ausmusterung') }}</div>
                        <div class='inpValue'><input type="text" disabled value="{{substr($data['pp']['PPProduktpass_Ausmusterungnummer'],0,4)}}" /></div>
                        <div></div>
                        <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Projektname') }}</div>
                        <div class='inpValue'><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_Projektname']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Projektname']['OldValue'] }}" type="text" name='man[PPInputManuell_Projektname]' value="{{$data['InpMan']->PPInputManuell_Projektname}}" /></div>
                        <div></div>
                        <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Lieferant') }}</div>
                        <div class='inpValue'><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_Lieferant']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Lieferant']['OldValue'] }}" type="text" name='man[PPInputManuell_Lieferant]' value="{{$data['InpMan']->PPInputManuell_Lieferant}}" /></div>
                        <div></div>
                        <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Stand vom') }}</div>
                        <div class='inpValue'>
                            <?php
                                $d = new DateTimeImmutable($data['InpMan']->PPInputManuell_Date);
                                $date = $d->format('d.m.Y H:i:s');
                            ?>
                            <input {{$disabled}} type="text" id="versionDate" disabled value="{{ $date }}" />
                        </div>
                        <div></div>
                        <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Versionen') }}</div>
                        <div class='inpValue'>
                            <select id="selectVersion">
                                <option value='Bitte auswählen...'>{{ ServiceProvider::tl($lang, 'Bitte auswählen...')}}</option>
                                @foreach( $data['InpManVersions'] as $imid => $dataVersion )
                                <option value="{{ $imid }}"> {{ $dataVersion }} </option>
                                @endforeach
                            </select>
                        </div> 
                        <div></div>
                        {{-- Neue Zeile 
                        <div class='inpLable'>Col1</div>
                        <div class='inpValue'>Val1</div>
                        <div>S1</div>
                        <div class='inpLable'>Col2</div>
                        <div class='inpValue'>Val2</div>
                        <div>S2</div>
                        <div class='inpLable'>Col3</div>
                        <div class='inpValue'>Val3</div>
                        <div>S3</div> --}}
                        {{-- Neue Zeile  --}}
    <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Geplanter EK Währung') }}</div>
    <div class='inpValue'>
                    <select {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_EKWSYM']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_EKWSYM']['OldValue'] }}" name='man[PPInputManuell_EKWSYM]'>
                        <option>Bitte auswählen...</option>
                        <option @if ($data['InpMan']->PPInputManuell_EKWSYM == 'EUR') selected @endif>EUR</option>
                        <option @if ($data['InpMan']->PPInputManuell_EKWSYM == 'USD') selected @endif>USD</option>
                        <option @if ($data['InpMan']->PPInputManuell_EKWSYM == 'RMB') selected @endif>RMB</option>
                    </select>
                    </div>
                    <div></div>
                    <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Geplanter EK') }}</div>
                    <div class='inpValue'>
                    <input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_GeplanterEKUSD']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_GeplanterEKUSD']['OldValue'] }}" type="text" name='man[PPInputManuell_GeplanterEKUSD]' value="{{number_format($data['InpMan']->PPInputManuell_GeplanterEKUSD,2,',','.')}}" />
                    </div>
                    <div></div>
                   <div class='inpLable'>{{ ServiceProvider::tl($lang, 'geplanter VK Preis in der Lidl Filiale (EUR)') }}</div>
                    <div class='inpValue'>
                    <input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_GeplanterVK']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_GeplanterVK']['OldValue'] }}" type="text" name='man[PPInputManuell_GeplanterVK]' value="{{number_format($data['InpMan']->PPInputManuell_GeplanterVK,2,',','.')}}" />
                    </div>
                    <div></div>
                    <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Laufzeit Garantie zum Endkunden') }}</div>
                    <div class='inpValue'>
                    <select {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_LaufzeitGarantie']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_LaufzeitGarantie']['OldValue'] }}" name='man[PPInputManuell_LaufzeitGarantie]'>
                        <option>{{ ServiceProvider::tl($lang, 'Bitte auswählen...') }}</option>
                        <option @if ($data['InpMan']->PPInputManuell_LaufzeitGarantie == '24 Monate') selected @endif value='24 Monate'>24 {{ ServiceProvider::tl($lang, 'Monate') }}</option>
                        <option @if ($data['InpMan']->PPInputManuell_LaufzeitGarantie == '36 Monate') selected @endif value='36 Monate'>36 {{ ServiceProvider::tl($lang, 'Monate') }}</option>
                        <option @if ($data['InpMan']->PPInputManuell_LaufzeitGarantie == '60 Monate') selected @endif value='60 Monate'>60 {{ ServiceProvider::tl($lang, 'Monate') }}</option>
                    </select>
                    </div>
                    <div></div>
                    <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Garantie vom Vorlieferanten') }}</div>
                    <div class='inpValue'><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_GarantieLieferant']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_GarantieLieferant']['OldValue'] }}" type="text" name='man[PPInputManuell_GarantieLieferant]' value="{{$data['InpMan']->PPInputManuell_GarantieLieferant}}" />
                    </div>
                    <div></div>
                        <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Abwicklung Lieferantengarantie') }}</div>
                        <div class='inpValue'> <?php
                            $val1 = $data['InpMan']->PPInputManuell_AbwicklungGarantie;
                            if (is_null($val1) or $val1 == '') {
                                $val1 = ServiceProvider::tl($lang, '1 zu 1 Austausch');
                            }
                            ?>
                            <input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_AbwicklungGarantie']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_AbwicklungGarantie']['OldValue'] }}" type="text" name='man[PPInputManuell_AbwicklungGarantie]' value="{{$val1}}" />
                         </div>
                        <div></div>
                        <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Sonderleistung Lieferant (FOC)') }}</div>
                        <div class='inpValue'><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_SonderleistungLieferant']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_SonderleistungLieferant']['OldValue'] }}" type="text" name='man[PPInputManuell_SonderleistungLieferant]' value="{{$data['InpMan']->PPInputManuell_SonderleistungLieferant}}" /></div>
                        <div></div>
                        <div class='inpLable' title='Max. Failure Rate in 36 Monaten (lt. Lieferant)'>{{ ServiceProvider::tl($lang, 'Max. Failure Rate 36 Mon.(Lieferant)') }}</div>
                        <div class='inpValue'><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_MaxAusfallrate']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_MaxAusfallrate']['OldValue'] }}" type="text" name='man[PPInputManuell_MaxAusfallrate]' value="{{$data['InpMan']->PPInputManuell_MaxAusfallrate}}" /></div>
                        <div></div>
                        {{-- Ende neue Zeile  --}}
                           {{-- Neue Zeile  --}}
                        <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Servicevertrag mit Lieferant vorhanden?') }}</div>
                        <div class='inpValue'>
                            <select {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_ServiceVetrag']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_ServiceVetrag']['OldValue'] }}" name='man[PPInputManuell_ServiceVetrag]'>
                                <option value="-1">{{ ServiceProvider::tl($lang, 'Bitte auswählen...') }}</option>
                                <option value="0" @if($data['InpMan']->PPInputManuell_ServiceVetrag == 0) selected @endif>{{ ServiceProvider::tl($lang, 'Nein') }}</option>
                                <option value="1" @if($data['InpMan']->PPInputManuell_ServiceVetrag == 1) selected @endif>{{ ServiceProvider::tl($lang, 'Ja') }}</option>
                            </select>
                        </div>
                        <div></div>
                        <div class='inpLable'></div>
                        <div class='inpValue'></div>
                        <div></div>
                        <div class='inpLable'></div>
                        <div class='inpValue'></div>
                        <div></div>
                        {{-- Ende neue Zeile  --}}
                    </div>
                    <div class='inpGrid'>
                        <div></div>
                        <div class='inpValue' style='grid-column: 2 / 9;'>
                            <h3 style="color:var(--tgBlue);font-size:1em;">{{ ServiceProvider::tl($lang, 'Containerloading / Angaben vom Lieferanten') }}</h3>
                            <table id='tptTableCarton'>
                                <tr>
                                    <th style="width:300px;"></th>
                                    <th style="text-align:right;">20'</th>
                                    <th>40'</th>
                                    <th>40'HC</th>
                                </tr>
                                <tr>
                                    <td style="padding:8px;">{{ ServiceProvider::tl($lang, 'Lidl Karton/Stck pro Container') }}</td>
                                    <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_ContPlan20']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_ContPlan20']['OldValue'] }}" type="text" name='man[PPInputManuell_ContPlan20]' value="{{number_format($data['InpMan']->PPInputManuell_ContPlan20,0,',','.')}}" /></td>
                                    <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_ContPlan40']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_ContPlan40']['OldValue'] }}" type="text" name='man[PPInputManuell_ContPlan40]' value="{{number_format($data['InpMan']->PPInputManuell_ContPlan40,0,',','.')}}" /></td>
                                    <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_ContPlan40HC']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_ContPlan40HC']['OldValue'] }}" type="text" name='man[PPInputManuell_ContPlan40HC]' value="{{number_format($data['InpMan']->PPInputManuell_ContPlan40HC,0,',','.')}}" /></td>
                                </tr>
                                <tr>
                                    <td style="padding:8px;">{{ ServiceProvider::tl($lang, 'Kaufland Karton/Stck pro Container') }}</td>
                                    <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_KLContPlan20']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_KLContPlan20']['OldValue'] }}" type="text" name='man[PPInputManuell_KLContPlan20]' value="{{number_format($data['InpMan']->PPInputManuell_KLContPlan20,0,',','.')}}" /></td>
                                    <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_KLContPlan40']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_KLContPlan40']['OldValue'] }}" type="text" name='man[PPInputManuell_KLContPlan40]' value="{{number_format($data['InpMan']->PPInputManuell_KLContPlan40,0,',','.')}}" /></td>
                                    <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_KLContPlan40HC']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_KLContPlan40HC']['OldValue'] }}" type="text" name='man[PPInputManuell_KLContPlan40HC]' value="{{number_format($data['InpMan']->PPInputManuell_KLContPlan40HC,0,',','.')}}" /></td>
                                </tr>
                            </table>
                        </div>
                        <div></div>
                        <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Verschiffung über (zur Berechnung der Feeder Kosten)') }}</div>
                        <div class='inpValue'  style='grid-column: 2 / 4;'>
                            <select {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_Verschiffungshafen']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Verschiffungshafen']['OldValue'] }}" name='man[PPInputManuell_Verschiffungshafen]'>
                                <option value="">{{ ServiceProvider::tl($lang, 'Bitte auswählen...') }}</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Chattogram') selected @endif>Chattogram</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Beijiao') selected @endif>Beijiao</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Chiwan') selected @endif>Chiwan</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Dalian') selected @endif>Dalian</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Fangcheng') selected @endif>Fangcheng</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Shenzhen') selected @endif>Shenzhen</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Fuzhou') selected @endif>Fuzhou</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Foshan') selected @endif>Foshan</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Hong Kong') selected @endif>Hong Kong</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Huangpu') selected @endif>Huangpu</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Jiujiang') selected @endif>Jiujiang</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Jiangmen') selected @endif>Jiangmen</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Lianyungang') selected @endif>Lianyungang</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Ningbo') selected @endif>Ningbo</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Nanjing') selected @endif>Nanjing</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Nansha') selected @endif>Nansha</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Nantong') selected @endif>Nantong</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Rongqi') selected @endif>Rongqi</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Shanghai') selected @endif>Shanghai</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Shantou') selected @endif>Shantou</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Shekou') selected @endif>Shekou</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Shunde') selected @endif>Shunde</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Qingdao') selected @endif>Qingdao</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Taicang') selected @endif>Taicang</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Tianjin Xingang') selected @endif>Tianjin Xingang</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Xiaolan') selected @endif>Xiaolan</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Xiamen') selected @endif>Xiamen</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Yantian') selected @endif>Yantian</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Zhangjiagang') selected @endif>Zhangjiagang</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Zhanjiang') selected @endif>Zhanjiang</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Zhapu') selected @endif>Zhapu</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Zhaoqing') selected @endif>Zhaoqing</option>
                                <option @if($data['InpMan']->PPInputManuell_Verschiffungshafen == 'Zhongshan') selected @endif>Zhongshan</option>
                            </select>
                        </div>
                        <div style='grid-column: 3 /-1;'></div>
                        <div class='inpLable'></div>
                        <div class='inpValue' style='grid-column: 2 /-1;'>
                            <h3 style="color:var(--tgBlue);font-size:1em;">{{ ServiceProvider::tl($lang, 'Verpackungsangaben') }}</h3>
                            <div style="float:left;">
                                <table id='tptTableCarton'>
                                    <tr>
                                        <th style="width:200px;">{{ ServiceProvider::tl($lang, 'Art') }}</th>
                                        <th>{{ ServiceProvider::tl($lang, 'VE')}}</th>
                                        <th>{{ ServiceProvider::tl($lang, 'Masse')}} (g)</th>
                                        <th>{{ ServiceProvider::tl($lang, 'Länge')}} (mm)</th>
                                        <th>{{ ServiceProvider::tl($lang, 'Breite')}} (mm)</th>
                                        <th>{{ ServiceProvider::tl($lang, 'Höhe')}} (mm)</th>
                                    </tr>
                                    <tr>
                                        <td style="padding:8px;">{{ ServiceProvider::tl($lang, 'Giftbox') }}</td>
                                        <td style="padding:8px;text-align:right;">1</td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_Masse']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Masse']['OldValue'] }}" type="text" name='man[PPInputManuell_Masse]' value="{{number_format($data['InpMan']->PPInputManuell_Masse,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_Laenge']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Laenge']['OldValue'] }}" type="text" name='man[PPInputManuell_Laenge]' value="{{number_format($data['InpMan']->PPInputManuell_Laenge,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_Breite']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Breite']['OldValue'] }}" type="text" name='man[PPInputManuell_Breite]' value="{{number_format($data['InpMan']->PPInputManuell_Breite,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_Hoehe']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Hoehe']['OldValue'] }}" type="text" name='man[PPInputManuell_Hoehe]' value="{{number_format($data['InpMan']->PPInputManuell_Hoehe,0,',','.')}}" /></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:8px;">{{ ServiceProvider::tl($lang,'LIDL VE') }}</td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_Exportkarton_VE']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Exportkarton_VE']['OldValue'] }}" type="text" name='man[PPInputManuell_Exportkarton_VE]' value="{{number_format($data['InpMan']->PPInputManuell_Exportkarton_VE,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_Exportkarton_Masse']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Exportkarton_Masse']['OldValue'] }}" type="text" name='man[PPInputManuell_Exportkarton_Masse]' value="{{number_format($data['InpMan']->PPInputManuell_Exportkarton_Masse,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_Exportkarton_Laenge']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Exportkarton_Laenge']['OldValue'] }}" type="text" name='man[PPInputManuell_Exportkarton_Laenge]' value="{{number_format($data['InpMan']->PPInputManuell_Exportkarton_Laenge,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_Exportkarton_Breite']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Exportkarton_Breite']['OldValue'] }}" type="text" name='man[PPInputManuell_Exportkarton_Breite]' value="{{number_format($data['InpMan']->PPInputManuell_Exportkarton_Breite,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_Exportkarton_Hoehe']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Exportkarton_Hoehe']['OldValue'] }}" type="text" name='man[PPInputManuell_Exportkarton_Hoehe]' value="{{number_format($data['InpMan']->PPInputManuell_Exportkarton_Hoehe,0,',','.')}}" /></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:8px;">{{ ServiceProvider::tl($lang,'LIDL VE (Version 2)') }}</td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_Exportkarton_VE_V2']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Exportkarton_VE_V2']['OldValue'] }}" type="text" name='man[PPInputManuell_Exportkarton_VE_V2]' value="{{number_format($data['InpMan']->PPInputManuell_Exportkarton_VE_V2,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_Exportkarton_Masse_V2']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Exportkarton_Masse_V2']['OldValue'] }}" type="text" name='man[PPInputManuell_Exportkarton_Masse_V2]' value="{{number_format($data['InpMan']->PPInputManuell_Exportkarton_Masse_V2,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_Exportkarton_Laenge_V2']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Exportkarton_Laenge_V2']['OldValue'] }}" type="text" name='man[PPInputManuell_Exportkarton_Laenge_V2]' value="{{number_format($data['InpMan']->PPInputManuell_Exportkarton_Laenge_V2,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_Exportkarton_Breite_V2']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Exportkarton_Breite_V2']['OldValue'] }}" type="text" name='man[PPInputManuell_Exportkarton_Breite_V2]' value="{{number_format($data['InpMan']->PPInputManuell_Exportkarton_Breite_V2,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_Exportkarton_Hoehe_V2']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Exportkarton_Hoehe_V2']['OldValue'] }}" type="text" name='man[PPInputManuell_Exportkarton_Hoehe_V2]' value="{{number_format($data['InpMan']->PPInputManuell_Exportkarton_Hoehe_V2,0,',','.')}}" /></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:8px;">{{ ServiceProvider::tl($lang,'Online Shop') }}</td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_OSExportkarton_VE']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_OSExportkarton_VE']['OldValue'] }}" type="text" name='man[PPInputManuell_OSExportkarton_VE]' value="{{number_format($data['InpMan']->PPInputManuell_OSExportkarton_VE,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_OSExportkarton_Masse']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_OSExportkarton_Masse']['OldValue'] }}" type="text" name='man[PPInputManuell_OSExportkarton_Masse]' value="{{number_format($data['InpMan']->PPInputManuell_OSExportkarton_Masse,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_OSExportkarton_Laenge']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_OSExportkarton_Laenge']['OldValue'] }}" type="text" name='man[PPInputManuell_OSExportkarton_Laenge]' value="{{number_format($data['InpMan']->PPInputManuell_OSExportkarton_Laenge,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_OSExportkarton_Breite']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_OSExportkarton_Breite']['OldValue'] }}" type="text" name='man[PPInputManuell_OSExportkarton_Breite]' value="{{number_format($data['InpMan']->PPInputManuell_OSExportkarton_Breite,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_OSExportkarton_Hoehe']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_OSExportkarton_Hoehe']['OldValue'] }}" type="text" name='man[PPInputManuell_OSExportkarton_Hoehe]' value="{{number_format($data['InpMan']->PPInputManuell_OSExportkarton_Hoehe,0,',','.')}}" /></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:8px;">{{ ServiceProvider::tl($lang,'Online Shop (Version 2)') }}</td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_OSExportkarton_VE_V2']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_OSExportkarton_VE_V2']['OldValue'] }}" type="text" name='man[PPInputManuell_OSExportkarton_VE_V2]' value="{{number_format($data['InpMan']->PPInputManuell_OSExportkarton_VE_V2,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_OSExportkarton_Masse_V2']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_OSExportkarton_Masse_V2']['OldValue'] }}" type="text" name='man[PPInputManuell_OSExportkarton_Masse_V2]' value="{{number_format($data['InpMan']->PPInputManuell_OSExportkarton_Masse_V2,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_OSExportkarton_Laenge_V2']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_OSExportkarton_Laenge_V2']['OldValue'] }}" type="text" name='man[PPInputManuell_OSExportkarton_Laenge_V2]' value="{{number_format($data['InpMan']->PPInputManuell_OSExportkarton_Laenge_V2,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_OSExportkarton_Breite_V2']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_OSExportkarton_Breite_V2']['OldValue'] }}" type="text" name='man[PPInputManuell_OSExportkarton_Breite_V2]' value="{{number_format($data['InpMan']->PPInputManuell_OSExportkarton_Breite_V2,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_OSExportkarton_Hoehe_V2']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_OSExportkarton_Hoehe_V2']['OldValue'] }}" type="text" name='man[PPInputManuell_OSExportkarton_Hoehe_V2]' value="{{number_format($data['InpMan']->PPInputManuell_OSExportkarton_Hoehe_V2,0,',','.')}}" /></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:8px;">{{ ServiceProvider::tl($lang,'Kaufland VE') }}</td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_KLExportkarton_VE']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_KLExportkarton_VE']['OldValue'] }}" type="text" name='man[PPInputManuell_KLExportkarton_VE]' value="{{number_format($data['InpMan']->PPInputManuell_KLExportkarton_VE,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_KLExportkarton_Masse']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_KLExportkarton_Masse']['OldValue'] }}" type="text" name='man[PPInputManuell_KLExportkarton_Masse]' value="{{number_format($data['InpMan']->PPInputManuell_KLExportkarton_Masse,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_KLExportkarton_Laenge']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_KLExportkarton_Laenge']['OldValue'] }}" type="text" name='man[PPInputManuell_KLExportkarton_Laenge]' value="{{number_format($data['InpMan']->PPInputManuell_KLExportkarton_Laenge,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_KLExportkarton_Breite']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_KLExportkarton_Breite']['OldValue'] }}" type="text" name='man[PPInputManuell_KLExportkarton_Breite]' value="{{number_format($data['InpMan']->PPInputManuell_KLExportkarton_Breite,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_KLExportkarton_Hoehe']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_KLExportkarton_Hoehe']['OldValue'] }}" type="text" name='man[PPInputManuell_KLExportkarton_Hoehe]' value="{{number_format($data['InpMan']->PPInputManuell_KLExportkarton_Hoehe,0,',','.')}}" /></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:8px;">{{ ServiceProvider::tl($lang,'Kaufland VE (Version 2)') }}</td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_KLExportkarton_VE_V2']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_KLExportkarton_VE_V2']['OldValue'] }}" type="text" name='man[PPInputManuell_KLExportkarton_VE_V2]' value="{{number_format($data['InpMan']->PPInputManuell_KLExportkarton_VE_V2,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_KLExportkarton_Masse_V2']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_KLExportkarton_Masse_V2']['OldValue'] }}" type="text" name='man[PPInputManuell_KLExportkarton_Masse_V2]' value="{{number_format($data['InpMan']->PPInputManuell_KLExportkarton_Masse_V2,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_KLExportkarton_Laenge_V2']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_KLExportkarton_Laenge_V2']['OldValue'] }}" type="text" name='man[PPInputManuell_KLExportkarton_Laenge_V2]' value="{{number_format($data['InpMan']->PPInputManuell_KLExportkarton_Laenge_V2,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_KLExportkarton_Breite_V2']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_KLExportkarton_Breite_V2']['OldValue'] }}" type="text" name='man[PPInputManuell_KLExportkarton_Breite_V2]' value="{{number_format($data['InpMan']->PPInputManuell_KLExportkarton_Breite_V2,0,',','.')}}" /></td>
                                        <td><input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_KLExportkarton_Hoehe_V2']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_KLExportkarton_Hoehe_V2']['OldValue'] }}" type="text" name='man[PPInputManuell_KLExportkarton_Hoehe_V2]' value="{{number_format($data['InpMan']->PPInputManuell_KLExportkarton_Hoehe_V2,0,',','.')}}" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div style="float:left;padding-top:50px; padding-left:50px;">
                                <h3 style="color:var(--tgBlue);font-size:1em;font-weight:bold;">{{ ServiceProvider::tl($lang, 'LIDL Verpackungsvorschriften') }}</h3>
                                <a href="https://targagmbh.sharepoint.com/sites/purchaseDept/SitePages/purchaseAnlage4HandbuchVerkaufsverpackungV1.3.aspx" target="_blank"><img src="{{url('/data/Icons/VerpackungMasse.png')}}" style="width:500px;border:1px solid gray;" /></a>
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                        <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Hinweise für Maße, Gewichte, VE und…...') }}</div>
                        <div class='inpValue' style='grid-column: 2 /-1;'>
                            <?php $bemHeight = 20 * (substr_count($data['InpMan']->PPInputManuell_TextGroesse, "\n") + 2); ?>
                            <textarea {{$disabled}} style="margin-bottom:25px;height:80px;width:680px;padding:8px;{{ $data['InpManCompare']['PPInputManuell_TextGroesse']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_TextGroesse']['OldValue'] }}" name='man[PPInputManuell_TextGroesse]'>{{$data['InpMan']->PPInputManuell_TextGroesse}}</textarea>
                        </div>
                        <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Gesamtmenge aus Serviceanfrage') }}</div>
                        <div class='inpValue'><input disabled type="text" id="Gesamtmenge"  name='man[PPInputManuell_MengeIAN]' value="{{ViewController::getMengeServiceAnfrage($data['InpMan']->PPInputManuell_Id) }}" /></div>
                        <div></div>
                        <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Menge DE') }}</div>
                        <div class='inpValue'><input {{$disableMengen}} type="text" name='man[PPInputManuell_MengeDE]' value="{{number_format($data['InpMan']->PPInputManuell_MengeDE,0,',','.')}}" /></div>
                        <div></div>
                        <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Menge EU') }}</div>
                        <div class='inpValue'><input {{$disableMengen}} type="text" name='man[PPInputManuell_MengeEU]' value="{{number_format($data['InpMan']->PPInputManuell_MengeEU,0,',','.')}}" /></div>
                        <div></div>
                         <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Gesamtmenge aus IAN (Aktuell)') }}</div>
                        <div class='inpValue'><input disabled type="text" id="GesamtmengeAktuell" value="{{number_format($data['pp']['PPProduktpass_Gesamtmenge'],0,',','.')}}" /></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div class='inpLable'>{{ ServiceProvider::tl($lang, 'versandfähige Onlineshop Kartonage') }}</div>
                        <div class='inpValue'>
                            <select {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_Onlinekartonage']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Onlinekartonage']['OldValue'] }}" name='man[PPInputManuell_Onlinekartonage]'>
                                <option value="-1">Bitte auswählen...</option>
                                <option value="0" @if($data['InpMan']->PPInputManuell_Onlinekartonage == 0) selected @endif>{{ ServiceProvider::tl($lang, 'Nein')}}</option>
                                <option value="1" @if($data['InpMan']->PPInputManuell_Onlinekartonage == 1) selected @endif>{{ ServiceProvider::tl($lang, 'Ja') }}</option>
                            </select>
                        </div>
                        <div></div>
                        <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Antworten bis...') }}</div>
                        <div class='inpValue'>
                            <input {{$disabled}} style="{{ $data['InpManCompare']['PPInputManuell_UAWGB']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_UAWGB']['OldValue'] }}" name="man[PPInputManuell_UAWGB]" value="{{$data['InpMan']->PPInputManuell_UAWGB}}" class="datepickerZukunftInput" />
                        </div>
                        <div></div>
                        <div  style='grid-column: 7 /-1;'></div>
                        <div class='inpLable'>
                        </div>
                        <div class='inpValue' style='grid-column: 2 /-2;padding-top:20px;padding-bottom:20px;'>                            
                            @if ($data['InpMan']->PPInputManuell_StatusPM == 0)
                                @if ($authUserTaetigkeit == 'PM' or $authUserTaetigkeit == 'PJM')
                                    <button id="san_speichern" type="submit" name="submit" class='tgButton' style="min-width:250px; width:100%;" value="speichern">{{ ServiceProvider::tl($lang, 'speichern') }}</button>
                                @endif
                            @else
                                <div style="margin:auto;border-radius:0px;padding:8px;font-size:larger;width:800px;border:1px solid darkblue;float:left;">{{ ServiceProvider::tl($lang, 'Serviceanfrage wurde gesendet!') }}</div>
                            @endif
                        </div>
                        <div></div>
                    </div>
                </form>
                @if ($data['InpMan']->PPInputManuell_StatusPM == 0)
                <form action="/writeInputNeu" id="FormSend" method="post" style="margin-top:25px;" onsubmit="return savePM();">
                    <input type="hidden" name="ppid" id="ppid" value="{{$data['pp']['PPProduktpass_Id']}}">
                    <div style="border:2px solid var(--tgBlue);">
                        <?php
                        //markus.midderhoff@targa.de 
                        $mailuser = 'kalkulationsanfrage@targa.de';
                        //$mailuser = 'info@compecon.de'; 
                        $mailcc   = $pm;
                        $mailcc2   = 'daniel.lenz@targa.de';
                        if (strtoupper( Auth::user()->PPMitarbeiter_Kuerzel) == 'FKE'){
                                $mailuser = 'f.keppel@compecon.de';
                                $mailcc = 'Targa-PM@compecon.de';
                                $mailcc2   = 'Targa-TC@compecon.de';
                            }
                        ?>
                        <fieldset style="border:none;">
                        <table>
                            <tr>
                                <th style='width:100px;text-align:left;padding:8px;'>{{ ServiceProvider::tl($lang, 'Versenden') }}</th>
                                <th style='width:100px;text-align:left;padding:0px;'><input type="checkbox" checked="checked" name="sendmail" id="sendmail" style="width:200px; height:2.2em;" /></th>
                            </tr>
                            <tr>
                                <th style='text-align:left;padding:8px;'>{{ ServiceProvider::tl($lang, 'Download') }}</th>
                                <th style='text-align:left;padding:0px;'><input type="checkbox" name="download" id="download" style="width:200px; height:2.2em;" /></th>
                            </tr>
                            <tr>
                                <th style='text-align:left;padding:8px;'>{{ ServiceProvider::tl($lang, 'senden') }}</th>
                                <th style='text-align:left;padding:0px;'><input type="hidden" name="mailto" id="mailto" value="{{ $mailuser }}" /> <input type="text" value="{{ $mailuser }}" disabled /></th>
                            </tr>
                            <tr>
                                <th style='text-align:left;padding:8px;'>{{ ServiceProvider::tl($lang, 'Kopie an') }}</th>
                                <th style='text-align:left;padding:0px;'><input   type="email" name="mailcc2" id="mailcc2" value="{{ $mailcc2 }}"  /></th>
                            </tr>
                            <tr>
                                <th style='text-align:left;padding:8px;'>{{ ServiceProvider::tl($lang, 'Kopie2 an') }}</th>
                                <th style='text-align:left;padding:0px;'><input   type="email" name="mailcc" id="mailcc" value="{{ $mailcc }}" /></th>
                            </tr>
                            <tr>
                                <th style='text-align:left;padding:8px;'>{{ ServiceProvider::tl($lang, 'E-Mailtext') }}</th>
                                <th style='text-align:left;padding:0px;'><textarea name="mailbody" id="mailbody" style="width:612px;padding:8px;">{{ ServiceProvider::tl($lang, 'Im Anhang unsere Serviceanfrage zur IAN ')}} {{$data['pp']['PPProduktpass_IAN']}}</textarea></th>
                            </tr>
                            <tr>
                            <th></th>
                            <th  style='text-align:left;padding:0px;'>
                            @if ($authUserTaetigkeit == 'PM' or $authUserTaetigkeit == 'PJM')
                                <button id="san_generieren" type="submit" onclick="return validate1();" class='tgButton' style="width:820px;">{{ ServiceProvider::tl($lang, 'Serviceanfrage senden') }}</button>
                            @endif
                            </th>
                            </tr>
                            </table>
                        </fieldset>
                    </div>
                </form>
                @endif
            </div>
        </div>
        <div style='border:1px solid var(--tgDarkBlue);background-color:var(--tgBlue);border-radius:0px;color:white;margin-top:30px;padding-left:15px;'>
            <h3>{{ ServiceProvider::tl($lang, 'MaWi Eingabefelder') }}</h3>
        </div>
        <div style="border:1px solid var(--tgBlue);border-radius:0px;padding:20px;">
            <form action="/updateInputManuellNeu" id="FormMaWi" method="post">
                <input type="hidden" name="ppid" id="ppid" value="{{$data['pp']['PPProduktpass_Id']}}">
                @if ((count($data['InpManVersions']) > 1) and ($data['InpMan']->PPInputManuell_StatusMaWi == 0 and $data['InpMan']->PPInputManuell_StatusPM == 1))
                    @if ($authUserTaetigkeit != 'PM' and $authUserTaetigkeit != 'TC' and $authUserTaetigkeit != 'PJM')
                    <button id="san_uebernahme" name="submit" value="Uebernahme" type="submit" style="margin-left:210px;width:820px; height:35px; padding:8px;font-weight:bold;margin-bottom: 18px;">{{ ServiceProvider::tl($lang, 'Daten aus Vorversion übernehmen') }}</button>
                    @endif
                @endif
                <div class='inpGrid'>
                    <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Service ZSK2 [EUR]') }}</div>
                    <div class='inpValue'>
                        <input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_Ausfallrate']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Ausfallrate']['OldValue'] }}" type="text" name='man[PPInputManuell_Ausfallrate]' value="{{number_format($data['InpMan']->PPInputManuell_Ausfallrate,4,',','.')}}" />
                    </div>
                    <div></div>
                    <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Zukauf Service Ware [%]') }}</div>
                    <div class='inpValue'>
                        <input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_ZukaufServiceWare']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_ZukaufServiceWare']['OldValue'] }}" type="text" name='man[PPInputManuell_ZukaufServiceWare]' value="{{number_format($data['InpMan']->PPInputManuell_ZukaufServiceWare,4,',','.')}}" />
                    </div>
                    <div></div>
                    <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Servicekostensatz (SKS) [EUR]') }}</div>
                    <div class='inpValue'>
                        <input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_Servicekostensatz']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Servicekostensatz']['OldValue'] }}" type="text" name='man[PPInputManuell_Servicekostensatz]' value="{{number_format($data['InpMan']->PPInputManuell_Servicekostensatz,4,',','.')}}" />
                    </div>
                    <div></div>
                    <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Preisblatt') }}</div>
                    <div class='inpValue'>
                        <?php
                            $akt = date('y');
                            $jminus = $akt - 1;
                            $jplus = $akt + 1;
                            $jplus2 = $akt + 2;
                            $years = array($jminus . '01', $jminus . '04', $jminus . '07', $jminus . '10', $akt . '01', $akt . '04', $akt . '07', $akt . '10', $jplus . '01', $jplus . '04', $jplus . '07', $jplus . '10', $jplus2 . '01', $jplus2 . '04', $jplus2 . '07', $jplus2 . '10')
                        ?>
                        <input {{$disabledMaWi}} name='man[PPInputManuell_Preisblatt]' style="{{ $data['InpManCompare']['PPInputManuell_Preisblatt']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Preisblatt']['OldValue'] }}" value="{{$data['InpMan']->PPInputManuell_Preisblatt}}"/>
                    </div>
                    <div></div>
                    <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Eingangsfracht ZFRD [EUR]') }}</div>
                    <div class='inpValue'>
                        <input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_EingangsfrachtZFRD']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_EingangsfrachtZFRD']['OldValue'] }}" type="text" name='man[PPInputManuell_EingangsfrachtZFRD]' value="{{number_format($data['InpMan']->PPInputManuell_EingangsfrachtZFRD,4,',','.')}}" />
                    </div>
                    <div></div>
                    <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Logistik ZLGK [EUR]') }}</div>
                    <div class='inpValue'>
                        <input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_LogistikZLGK']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_LogistikZLGK']['OldValue'] }}" type="text" name='man[PPInputManuell_LogistikZLGK]' value="{{number_format($data['InpMan']->PPInputManuell_LogistikZLGK,4,',','.')}}" />
                    </div>
                    <div></div>
                    <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Ausgangsfracht ZRF2 [EUR]') }}</div>
                    <div class='inpValue'>
                        <input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_AusgangsfrachtZRF2']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_AusgangsfrachtZRF2']['OldValue'] }}" type="text" name='man[PPInputManuell_AusgangsfrachtZRF2]' value="{{number_format($data['InpMan']->PPInputManuell_AusgangsfrachtZRF2,4,',','.')}}" />
                    </div>
                    <div></div>
                    <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Stück pro Palette') }}</div>
                    <div class='inpValue'>
                        <input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_StkProPalette']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_StkProPalette']['OldValue'] }}" type="text" name='man[PPInputManuell_StkProPalette]' value="{{number_format($data['InpMan']->PPInputManuell_StkProPalette,0,',','.')}}" />
                    </div>
                    <div></div>
                    <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Durch Servicerückstellung gedeckelte Ausfallrate [%]') }}</div>
                    <div class='inpValue'>
                        <input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_DeckelAusfallrate']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_DeckelAusfallrate']['OldValue'] }}" type="text" name='man[PPInputManuell_DeckelAusfallrate]' value="{{number_format($data['InpMan']->PPInputManuell_DeckelAusfallrate,4,',','.')}}" />
                    </div>
                    <div></div>   
                    <div class='inpLable'>{{ ServiceProvider::tl($lang, 'Bemerkungen') }}</div>
                    <div class='inpValue' style='grid-column: 2 /-1;'>
                        <?php $bemHeight = 20 * (substr_count($data['InpMan']->PPInputManuell_Bemerkungen, "\n") + 2) + 5; ?>
                        <textarea {{$disabledMaWi}} style="padding:8px; width:615px; height:{{$bemHeight}}px; min-height:100px; border-radius:0px;{{ $data['InpManCompare']['PPInputManuell_Bemerkungen']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Bemerkungen']['OldValue'] }}" name='man[PPInputManuell_Bemerkungen]'>{{$data['InpMan']->PPInputManuell_Bemerkungen}}</textarea>
                    </div>
                    <div ></div>
                    <div  style='grid-column: 2 /-1;'>
                        <h3 style="color:var(--tgBlue);font-size:1em;">{{ ServiceProvider::tl($lang, 'Containerdaten') }}</h3>
                        <table id='tptTableCarton' style="">
                            <tr>
                                <th style='width:70px;'>{{ ServiceProvider::tl($lang, 'Art') }}</th>
                                <th>{{ ServiceProvider::tl($lang, 'Rotterdam') }}</th>
                                <th>{{ ServiceProvider::tl($lang, 'Barcelona') }}</th>
                                <th>{{ ServiceProvider::tl($lang, 'Koper') }}</th>
                                <th>{{ ServiceProvider::tl($lang, 'USA') }}</th>
                                <th>{{ ServiceProvider::tl($lang, 'Anzahl Container') }}</th>
                                <th>{{ ServiceProvider::tl($lang, 'Stück / Container Targa') }}</th>
                                <th>{{ ServiceProvider::tl($lang, 'Stück / Container Lieferant') }}</th>
                            </tr>
                            <tr>
                                <td style="padding:8px;">40'HC</td>
                                <td><input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_ContHCRot']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_ContHCRot']['OldValue'] }}" type="text" name='man[PPInputManuell_ContHCRot]' id='man[PPInputManuell_ContHCRot]' value="{{number_format($data['InpMan']->PPInputManuell_ContHCRot,0,',','.')}}" /></td>
                                <td><input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_ContHCBar']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_ContHCBar']['OldValue'] }}" type="text" name='man[PPInputManuell_ContHCBar]' id='man[PPInputManuell_ContHCBar]' value="{{number_format($data['InpMan']->PPInputManuell_ContHCBar,0,',','.')}}" /></td>
                                <td><input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_ContHCKop']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_ContHCKop']['OldValue'] }}" ype="text" name='man[PPInputManuell_ContHCKop]' id='man[PPInputManuell_ContHCKop]' value="{{number_format($data['InpMan']->PPInputManuell_ContHCKop,0,',','.')}}" /></td>
                                <td><input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_ContHCUSA']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_ContHCUSA']['OldValue'] }}" type="text" name='man[PPInputManuell_ContHCUSA]' id='man[PPInputManuell_ContHCUSA]' value="{{number_format($data['InpMan']->PPInputManuell_ContHCUSA,0,',','.')}}" /></td>
                                <td style="padding:8px;text-align:right;"><div style="background-color: transparent;" id="contHCTotal">{{number_format($data['InpMan']->PPInputManuell_ContHCRot+$data['InpMan']->PPInputManuell_ContHCBar+$data['InpMan']->PPInputManuell_ContHCKop+$data['InpMan']->PPInputManuell_ContHCUSA ,0,',','.')}}</div></td>
                                <td><input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_ContHCStk']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_ContHCStk']['OldValue'] }}" type="text" name='man[PPInputManuell_ContHCStk]' id='man[PPInputManuell_ContHCStk]' value="{{number_format($data['InpMan']->PPInputManuell_ContHCStk,0,',','.')}}" /></td>
                                <td style="padding:8px;text-align:right;">{{number_format($data['InpMan']->PPInputManuell_ContPlan40HC,0,',','.')}}</td>
                            </tr>
                            <tr>
                                <td style="padding:8px;">40'</td>
                                <td><input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_Cont40Rot']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Cont40Rot']['OldValue'] }}" type="text" name='man[PPInputManuell_Cont40Rot]' id='man[PPInputManuell_Cont40Rot]' value="{{number_format($data['InpMan']->PPInputManuell_Cont40Rot,0,',','.')}}" /></td>
                                <td><input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_Cont40Bar']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Cont40Bar']['OldValue'] }}" type="text" name='man[PPInputManuell_Cont40Bar]' id='man[PPInputManuell_Cont40Bar]' value="{{number_format($data['InpMan']->PPInputManuell_Cont40Bar,0,',','.')}}" /></td>
                                <td><input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_Cont40Kop']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Cont40Kop']['OldValue'] }}" type="text" name='man[PPInputManuell_Cont40Kop]' id='man[PPInputManuell_Cont40Kop]' value="{{number_format($data['InpMan']->PPInputManuell_Cont40Kop,0,',','.')}}" /></td>
                                <td><input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_Cont40USA']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Cont40USA']['OldValue'] }}" type="text" name='man[PPInputManuell_Cont40USA]' id='man[PPInputManuell_Cont40USA]' value="{{number_format($data['InpMan']->PPInputManuell_Cont40USA,0,',','.')}}" /></td>
                                <td style="padding:8px;text-align:right;"><div style="background-color: transparent;" id="cont40Total">{{number_format($data['InpMan']->PPInputManuell_Cont40Rot+$data['InpMan']->PPInputManuell_Cont40Bar+$data['InpMan']->PPInputManuell_Cont40Kop+$data['InpMan']->PPInputManuell_Cont40USA,0,',','.')}}</div></td>
                                <td><input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_Cont40Stk']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Cont40Stk']['OldValue'] }}" type="text" name='man[PPInputManuell_Cont40Stk]' id='man[PPInputManuell_Cont40Stk]' value="{{number_format($data['InpMan']->PPInputManuell_Cont40Stk,0,',','.')}}" /></td>
                                <td style="padding:8px;text-align:right;">{{number_format($data['InpMan']->PPInputManuell_ContPlan40,0,',','.')}}</td>
                            </tr>
                            <tr>
                                <td style="padding:8px;">20'</td>
                                <td><input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_Cont20Rot']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Cont20Rot']['OldValue'] }}" type="text" name='man[PPInputManuell_Cont20Rot]' id='man[PPInputManuell_Cont20Rot]' value="{{number_format($data['InpMan']->PPInputManuell_Cont20Rot,0,',','.')}}" /></td>
                                <td><input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_Cont20Bar']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Cont20Bar']['OldValue'] }}" type="text" name='man[PPInputManuell_Cont20Bar]' id='man[PPInputManuell_Cont20Bar]' value="{{number_format($data['InpMan']->PPInputManuell_Cont20Bar,0,',','.')}}" /></td>
                                <td><input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_Cont20Kop']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Cont20Kop']['OldValue'] }}" type="text" name='man[PPInputManuell_Cont20Kop]' id='man[PPInputManuell_Cont20Kop]' value="{{number_format($data['InpMan']->PPInputManuell_Cont20Kop,0,',','.')}}" /></td>
                                <td><input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_Cont20USA']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Cont20USA']['OldValue'] }}" type="text" name='man[PPInputManuell_Cont20USA]' id='man[PPInputManuell_Cont20USA]' value="{{number_format($data['InpMan']->PPInputManuell_Cont20USA,0,',','.')}}" /></td>
                                <td style="padding:8px;text-align:right;"><div style="background-color: transparent;" id="cont20Total">{{number_format($data['InpMan']->PPInputManuell_Cont20Rot+$data['InpMan']->PPInputManuell_Cont20Bar+$data['InpMan']->PPInputManuell_Cont20Kop+$data['InpMan']->PPInputManuell_Cont20USA,0,',','.')}}</div></td>
                                <td><input {{$disabledMaWi}} style="{{ $data['InpManCompare']['PPInputManuell_Cont20Stk']['Style'] }}" title="{{ $data['InpManCompare']['PPInputManuell_Cont20Stk']['OldValue'] }}" type="text" name='man[PPInputManuell_Cont20Stk]' id='man[PPInputManuell_Cont20Stk]' value="{{number_format($data['InpMan']->PPInputManuell_Cont20Stk,0,',','.')}}" /></td>
                                <td style="padding:8px;text-align:right;">{{number_format($data['InpMan']->PPInputManuell_ContPlan20,0,',','.')}}</td>
                            </tr>
                        </table>
                    </div>
                    <div></div>
                    <div  style='grid-column: 2 /-1;'>
                        <table id='tptTableCarton' style='margin-top:15px;'>
                            <tr>
                                <th>{{ ServiceProvider::tl($lang, 'Hafen') }}</th>
                                <th>{{ ServiceProvider::tl($lang, 'Menge') }}</th>
                                <th>40'</th>
                                <th>20'</th>
                            </tr>
                            <?php $totalCV40 = 0;$totalCV20 = 0; $totalCVMenge= 0 ?>
                            @for($i=0;$i<15;$i++)
                                <?php
                                    $pcvId = "New$i";
                                    $hafen = '';
                                    $menge = '';
                                    $cv40 = '';
                                    $cv20 = '';
                                    if (isset($data['InpContainer'][$i]) ){
                                        $totalCVMenge += $data['InpContainer'][$i]->PPContainerVerschiffungen_Menge ;
                                        $totalCV40 += $data['InpContainer'][$i]->PPContainerVerschiffungen_40 ;
                                        $totalCV20 += $data['InpContainer'][$i]->PPContainerVerschiffungen_20;
                                        $pcvId = $data['InpContainer'][$i]->PPContainerVerschiffungen_Id;
                                        $hafen = $data['InpContainer'][$i]->PPContainerVerschiffungen_Hafen;
                                        $menge = number_format($data['InpContainer'][$i]->PPContainerVerschiffungen_Menge,0,',','.');
                                        $cv40 = number_format($data['InpContainer'][$i]->PPContainerVerschiffungen_40,4,',','.');
                                        $cv20 = number_format($data['InpContainer'][$i]->PPContainerVerschiffungen_20,4,',','.');
                                    } 
                                ?>
                            <tr>
                                <td><input style='text-align:left;' name="container[{{$pcvId}}][Hafen]" id='{{$i}}_Hafen' value='{{$hafen}}'/></td>
                                <td><input name="container[{{$pcvId}}][Menge]"  value='{{$menge}}'  id='{{$i}}_Menge' /></td>
                                <td><input name="container[{{$pcvId}}][C40]"  value='{{$cv40}}'  id='{{$i}}_C40' /></td>
                                <td><input name="container[{{$pcvId}}][C20]"  value='{{$cv20}}'  id='{{$i}}_C20' /></td>                            
                            </tr>
                            @endfor
                        </table>  
                    </div>
                </div>
                <div style='margin-top:25px;padding-left:205px;'>
                </div>
                               <br>
                @if ($data['InpMan']->PPInputManuell_StatusMaWi == 0 and $data['InpMan']->PPInputManuell_StatusPM == 1)
                <?php
                //markus.midderhoff@targa.de 
                $mailcc1   = 'Kalkulationsanfrage@targa.de'; //Auth::user()->PPMitarbeiter_email;
                $mailcc2   = 'daniel.lenz@targa.de';
                $mailcc3   = 'patrick.blome@targa.de';
                if (Auth::user()->PPMitarbeiter_Kuerzel == 'FKE'){
                    $mailcc1   = 'f.keppel@compecon.de'; //Auth::user()->PPMitarbeiter_email;
                    $mailcc2   = 'Targa-PM@compecon.de';
                    $mailcc3   = 'Targa-TC@compecon.de';
                }
                ?>
                <label>{{ ServiceProvider::tl($lang, 'Kopie an') }} {{$authUserTaetigkeit  }} </label><input type="text" name="mailcc" id="mailcc_mawi1" style="margin-bottom:18px;margin-left:6px;" value="{{$mailcc1}}" />
                    <input type="text" name="mailcc2" id="mailcc_mawi" style="margin-bottom:18px;margin-left:6px;" value="{{$mailcc2}}" /> <input type="text" name="mailcc3" id="mailcc_mawi" style="margin-bottom:18px;margin-left:6px;" value="{{$mailcc3}}" /><br>
                    @if (($authUserTaetigkeit != 'PM' and $authUserTaetigkeit != 'TC' and $authUserTaetigkeit != 'PJM') or (Auth::user()->PPMitarbeiter_Kuerzel == 'FKE'))
                        <button id="san_speichern2" name="submit" value="speichern2" type="submit" onclick="return validate2();" class='tgButton' style="margin-left:210px;min-width:250px;">{{ ServiceProvider::tl($lang, 'speichern') }}</button>
                    @endif
                <br>
                <br>
                @if (($authUserTaetigkeit != 'PM' and $authUserTaetigkeit != 'TC'  and $authUserTaetigkeit != 'PJM') or (Auth::user()->PPMitarbeiter_Kuerzel == 'FKE'))
                <button id="san_fertig" name="submit" value="Fertig" type="submit" style="margin-left:210px;min-width:250px; width:30%; height:35px; padding:8px;font-weight:bold;">{{ ServiceProvider::tl($lang, 'Anfrage abschließen Mail an PM') }} [{{ $pm }}]</button>
                @endif
                @endif
            </form>
        </div>
    </div>
    @endif
    <script>
    const KeineVer  = '{{ ServiceProvider::tl($lang, 'Keine Version ausgewählt') }}';
    const BitteAus  = '{{ ServiceProvider::tl($lang, 'Bitte auswählen...') }}';
    const BitteAlle = '{{ ServiceProvider::tl($lang, 'Bitte alle Felder ausfüllen!') }}';
    const BitteAb   = '{{ ServiceProvider::tl($lang, 'Bitte absenden nicht vergessen!') }}';
    const BitteAen  = '{{ ServiceProvider::tl($lang, 'Bitte Änderungen erst speichern!') }}';
        function getVersion() {
            console.log("Start: GetVersion");
            ver = document.getElementById('selectVersion').value;
            if (ver == BitteAus) {
                console.log(KeineVer);
                return;
            }
            console.log(ver);
            ppid = document.getElementById('ppid').value;
            var frmData = new FormData();
            frmData.append('miid', ver);
            frmData.append('ppid', ppid);
            $.ajax({
                type: "POST",
                url: '/ServiceAnfrage',
                data: frmData,
                processData: false,
                contentType: false,
                success: getVersion_success,
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
        function mySql2num(num, dec) {
            if (num == null){
                return '0,00';
            }
            str = Number.parseFloat(num).toFixed(dec).replace('.', ',');
            console.log(str);
            return str;
        }
        function aktuelleVersion(id) {
            alert('Aktuelle version von ' + id);
            var server  = "https://tpt-dev.ad.targa.de";
            window.location.href = server+"/show/" + id + "/ServiceAnfrage";
            location.reload();
        }
        function contGesamt() {
            c1 = document.getElementsByName('man[PPInputManuell_ContPlan20]')[0].value;
            c2 = document.getElementsByName('man[PPInputManuell_ContPlan40]')[0].value;
            c3 = document.getElementsByName('man[PPInputManuell_ContPlan40HC]')[0].value;
            total = c1 + c2 + c3;
            return total;
        }
        function isEmpty(elem) {
            if (elem.name == 'man[PPInputManuell_IsLatest]') {
                return false;
            };
            if (elem.name == 'man[PPInputManuell_Projektname]') {
                return elem.value == '';
            };
            if (elem.name == 'man[PPInputManuell_Lieferant]') {
                return elem.value == '';
            };
            if (elem.name == 'man[PPInputManuell_GeplanterEKUSD]') {
                return parseFloat(elem.value) <= 0;
            };
            if (elem.name == 'man[PPInputManuell_GeplanterVK]') {
                return parseFloat(elem.value) <= 0;
            };
            if (elem.name == 'man[PPInputManuell_LaufzeitGarantie]') {
                return elem.value == BitteAus;
            };
            if (elem.name == 'man[PPInputManuell_GarantieLieferant]') {
                return elem.value == '';
            };
            if (elem.name == 'man[PPInputManuell_AbwicklungGarantie]') {
                return elem.value == '';
            };
            if (elem.name == 'man[PPInputManuell_SonderleistungLieferant]') {
                return elem.value == '';
            };
            if (elem.name == 'man[PPInputManuell_MaxAusfallrate]') {
                return elem.value == '';
            };
            if (elem.name == 'man[PPInputManuell_ServiceVetrag]') {
                return elem.value < 0;
            };
            if (elem.name == 'man[PPInputManuell_ContPlan20]') {
                return elem.value == 0;
            };
            if (elem.name == 'man[PPInputManuell_ContPlan40]') {
                return elem.value == 0;
            };
            if (elem.name == 'man[PPInputManuell_ContPlan40HC]') {
                return elem.value == 0;
            };
            if (elem.name == 'man[PPInputManuell_Verschiffungshafen]') {
                return elem.value == '';
            };
            if (elem.name == 'man[PPInputManuell_Masse]') {
                return elem.value <= 0;
            };
            if (elem.name == 'man[PPInputManuell_Laenge]') {
                return elem.value <= 0;
            };
            if (elem.name == 'man[PPInputManuell_Breite]') {
                return elem.value <= 0;
            };
            if (elem.name == 'man[PPInputManuell_Hoehe]') {
                return elem.value <= 0;
            };
            if (elem.name == 'man[PPInputManuell_Exportkarton_VE]') {
                return elem.value <= 0;
            };
            if (elem.name == 'man[PPInputManuell_Exportkarton_Masse]') {
                return elem.value <= 0;
            };
            if (elem.name == 'man[PPInputManuell_Exportkarton_Laenge]') {
                return elem.value <= 0;
            };
            if (elem.name == 'man[PPInputManuell_Exportkarton_Breite]') {
                return elem.value <= 0;
            };
            if (elem.name == 'man[PPInputManuell_Exportkarton_Hoehe]') {
                return elem.value <= 0;
            };
            if (elem.name == 'man[PPInputManuell_TextGroesse]') {
                return elem.value == '';
            };
            if (elem.name == 'man[PPInputManuell_MengeDE]') {
                if (document.getElementById('Gesamtmenge').value > 0) {
                    return false;
                }
                return elem.value < 0;
            };
            if (elem.name == 'man[PPInputManuell_MengeEU]') {
                if (document.getElementById('Gesamtmenge').value > 0) {
                    return false;
                }
                return elem.value <= 0;
            };
            if (elem.name == 'man[PPInputManuell_Onlinekartonage]') {
                console.log(elem.name + "  Wert: " + elem.value);
                return elem.value < 0;
            };
            if (elem.name == 'man[PPInputManuell_UAWGB]') {
                return elem.value == '0000-00-00';
            };
            return false;
        }
        function refresh() {
            setTimeout(function() {
                location.reload();
            }, 500);
        }
        function setSession2() {
            mailcc_mawi = document.getElementById('mailcc_mawi').value;
            window.sessionStorage.setItem('MailCCMaWi', mailcc_mawi);
        }
        function setSession() {
            console.log('call setSession');
            mailto = document.getElementById('mailto').value;
            mailcc = document.getElementById('mailcc').value;
            mailcc2 = document.getElementById('mailcc2').value;
            mailbody = document.getElementById('mailbody').value;
            window.sessionStorage.setItem('MailTo', mailto);
            window.sessionStorage.setItem('MailCC', mailcc);
            window.sessionStorage.setItem('MailCC2', mailcc2);
            window.sessionStorage.setItem('MailBody', mailbody);
        }
        function validate2() {
            setSession2();
            return true;
        }
        function validate1() {
            var elements = document.getElementById("FormPM").elements;
            ret = true;
            for (i = 0; i < elements.length; i++) {
                //console.log(elements[i].name + "(" +elements[i].value+") Länge: " + elements[i].value.length );
                //console.log('Index: ' + elements[i].name.indexOf('man['));
                if (elements[i].name.indexOf('man[') != -1) {
                    console.log(elements[i].name + ': ' + elements[i].value);
                    if (isEmpty(elements[i])) {
                        elements[i].style.border = '2px solid red';
                        ret = false;
                    }
                }
            }
            console.log("ret:" + ret);
            if (!ret) {
                alert(BitteAlle);
                //console.log('vor setSession');
                setSession();
            } 
            return ret;
        }
        function summeTotalHC(){
            total = parseInt(document.getElementById('man[PPInputManuell_ContHCRot]').value) +
                    parseInt(document.getElementById('man[PPInputManuell_ContHCBar]').value) + 
                    parseInt(document.getElementById('man[PPInputManuell_ContHCKop]').value) + 
                    parseInt(document.getElementById('man[PPInputManuell_ContHCUSA]').value);
            return total;
        }
        function summeTotal40(){
            total = parseInt(document.getElementById('man[PPInputManuell_Cont40Rot]').value) +
                    parseInt(document.getElementById('man[PPInputManuell_Cont40Bar]').value) + 
                    parseInt(document.getElementById('man[PPInputManuell_Cont40Kop]').value) + 
                    parseInt(document.getElementById('man[PPInputManuell_Cont40USA]').value);
            return total;
        }
        function summeTotal20(){
            total = parseInt(document.getElementById('man[PPInputManuell_Cont20Rot]').value) +
                    parseInt(document.getElementById('man[PPInputManuell_Cont20Bar]').value) + 
                    parseInt(document.getElementById('man[PPInputManuell_Cont20Kop]').value) + 
                    parseInt(document.getElementById('man[PPInputManuell_Cont20USA]').value);
            return total;
        }
  function getVersion_success(result) {
            inputs = result.inp.InpMan;
            containerVer = result.inp.Container;
            console.log(result);
            //elems = document.getElementsByName('man[PPInputManuell_GeplanterEKUSD]');
            decFields = "[ 'PPInputManuell_GeplanterEKUSD', 'PPInputManuell_GeplanterVK', 'PPInputManuell_DeckelAusfallrate', 'PPInputManuell_GutschriftenbetragKunde', 'PPInputManuell_Ausfallrate', 'PPInputManuell_Servicekostensatz', 'PPInputManuell_EingangsfrachtZFRD', 'PPInputManuell_AusgangsfrachtZRF2', 'PPInputManuell_ZukaufServiceWare', 'PPInputManuell_LogistikZLGK', 'PPInputManuell_DeckelAusfallrate']";
            intFields = "[ 'PPInputManuell_StkProPalette', 'PPInputManuell_ContPlan20', 'PPInputManuell_ContPlan40', 'PPInputManuell_ContPlan40HC', 'PPInputManuell_Exportkarton_Masse','PPInputManuell_Exportkarton_Laenge', 'PPInputManuell_Exportkarton_Breite', 'PPInputManuell_Exportkarton_Hoehe', 'PPInputManuell_Masse', 'PPInputManuell_Laenge','PPInputManuell_Breite', 'PPInputManuell_Hoehe', 'PPInputManuell_MengeDE', 'PPInputManuell_VE', 'PPInputManuell_MengeEU', 'PPInputManuell_StkProPalette', 'PPInputManuell_MengeIAN' ]";
            elems = document.querySelectorAll('[name^="man["]');
            for (elem of elems) {
                att = elem.name.replace('man[', '').replace(']', '');
                //console.log(att);
                //console.log(inputs[att]);
                elem.value = inputs[att];
                elem.style.color = 'dodgerblue';
                if (decFields.indexOf(att) > 0) {
                    elem.value = mySql2num(inputs[att], 4);
                }
                if (intFields.indexOf(att) > 0) {
                    elem.value = inputs[att];
                }
                //console.log (elem.name.replace('man[','').replace(']',''));
            }
            clearContainerVerschiffung();
            for (i=0;i<containerVer.length;i++){
                cElemId = i + '_Hafen';
                cElem = document.getElementById(cElemId);
                cElem.value = containerVer[i].PPContainerVerschiffungen_Hafen;
                cElemId = i + '_Menge';
                cElem = document.getElementById(cElemId);
                cElem.value =  mySql2num(containerVer[i].PPContainerVerschiffungen_Menge,0);
                cElemId = i + '_C40';
                cElem = document.getElementById(cElemId);
                cElem.value =  mySql2num(containerVer[i].PPContainerVerschiffungen_40,4);
                cElemId = i + '_C20';
                cElem = document.getElementById(cElemId);
                cElem.value =  mySql2num(containerVer[i].PPContainerVerschiffungen_20,4);
            }
            document.getElementById('contHCTotal').innerHTML =  summeTotalHC();            
            document.getElementById('cont40Total').innerHTML =  summeTotal40();            
            document.getElementById('cont20Total').innerHTML =  summeTotal20();            
            verDate = new Intl.DateTimeFormat("de-DE", {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            }).format(new Date(inputs.PPInputManuell_Date));
            document.getElementById('versionDate').value = verDate;
            if (inputs.PPInputManuell_IsLatest < 0 ) {
                $bt1 = document.getElementById('san_generieren').style.display = "inline";
                $bt2 = document.getElementById('san_speichern').style.display = "inline";
                $bt2 = document.getElementById('san_speichern2').style.display = "inline";
                $bt3 = document.getElementById('san_neu').style.display = "inline";
                $bt4 = document.getElementById('san_fertig').style.display = "inline";
            } else {
                hideBtn('san_generieren');
                hideBtn('san_speichern');
                hideBtn('san_speichern2');
                hideBtn('san_neu');
                hideBtn('san_fertig');
            }
            //elem[0].value =  i.PPInputManuell_GeplanterEKUSD;
        }
        function hideBtn(id){
                b = document.getElementById(id);
                if (b){
                    b.style.visibility = 'hidden';
                }
        }  
        function showBtn(id){
                b = document.getElementById(id);
                if (b){
                    b.style.visibility = 'visible';
                }
        }
        $(document).ready(function() {
            setMailElements();
        });
        function setMailElements() {
            mailto = window.sessionStorage.getItem('MailTo');
            mailcc_mawi = window.sessionStorage.getItem('MailCCMaWi');
            if (mailcc_mawi) {
                document.getElementById('mailcc_mawi').value = mailcc_mawi;
            }
            if (!mailto) {
                return;
            }
            mailcc = window.sessionStorage.getItem('MailCC');
            mailbody = window.sessionStorage.getItem('MailBody');
            document.getElementById('mailto').value = mailto;
            document.getElementById('mailcc').value = mailcc;
            document.getElementById('mailbody').value = mailbody;
        }
        function valFormPM() {
            alert(BitteAb);
            return true;
        }
        function savePM() {
            chn = document.getElementById('FormHasChanged');
            if (chn.value == 1) {
                alert(BitteAen);
                return false;
            } 
            window.sessionStorage.clear()
            return true;
        }
        $('#FormPM').change(function() {
            chn = document.getElementById('FormHasChanged');
            /*frm = document.getElementById('FormSend');
            frm.style.display = 'none';*/
            chn.value = 1;
        });
        $(".datepickerZukunftInput").datepicker({
            locale: 'de',
            minDate: '0d',
            numberOfMonths: 1,
            showButtonPanel: true,
            showWeek: true,
            firstDay: 1,
            dateFormat: "yy-mm-dd",
            monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
            monthNamesShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
            dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
            dayNamesShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
            dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
        });
          function clearContainerVerschiffung(){
            for (i=0;i<15;i++){
                cElemId = i + '_Hafen';
                cElem = document.getElementById(cElemId);
                cElem.value = '';
                cElemId = i + '_Menge';
                cElem = document.getElementById(cElemId);
                cElem.value =  '';
                cElemId = i + '_C40';
                cElem = document.getElementById(cElemId);
                cElem.value =  '';
                cElemId = i + '_C20';
                cElem = document.getElementById(cElemId);
                cElem.value =  '';
            }
        }
    </script>
