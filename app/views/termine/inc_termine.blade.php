<style>
    .yourBtn {
        width: 350px;
        padding: 25px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border: 1px solid darkblue;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        background-color: #DDD;
        cursor: pointer;
        color: darkblue;
    }
    .cell table {
        border-collapse: collapse;
        width: 300px;
        font-size: 12px;
    }
    .cell td {
        width: 150px;
        background-color: none;
        padding: 4 4 4 8;
        border: 1px solid darkblue;
    }
    .trenner {
        border: none;
    }
    .cell {
        border: none;
    }
</style>
<div ondblclick="return js('{{ $t['id'] }}');"
    style="position:relative;background-color:rgb({{ isset($t['bgcolor']) ? $t['bgcolor'] : '255,0,0' }});border-radius: 0px; width:30px;height:50px;overflow:hidden;"
    title="{{ $t['terminart'] }} {{ $t['datafield'] }}- {{ $pp['ian'] }} - {{ $t['status'] }}">
    <div class="overlay" id="div_{{ $t['id'] }}" style="padding:15px;overflow: hidden;">
        <div
            style="position:relative; margin: 0 auto;border:1px solid darkblue;border-radius: 0px;background-color: #c0c0c0;height: 968px;">
            <div style="margin:0 auto;border:none;border-radius: 0px;">
                <div style="border:none;border-radius: 0px;background-color: transparent;">
                    <form id="frm{{ $t['id'] }}" Method="post" action="#">
                        <input type="hidden" name="Termine_Id{{ $t['id'] }}" value="{{ $t['id'] }}">
                        <fieldset style="border:none;">
                            <div style="padding-top: 8px; padding-bottom: 8px;">
                                <span
                                    style="font-size: 18px; font-weight: bold;padding: 5px; padding-top:8px; padding-bottom: 8px;color:darkblue;">{{ $t['terminart'] }}</span>
                            </div>
                            <div style="border:none;">
                                <div style="border: none; margin-bottom: 20px;">
                                    <div style="border: none;float: left;">
                                        <table class="cell">
                                            <tr>
                                                <td>IAN1</td>
                                                <td><a href="show/{{ $pp['id'] }}" target="_blank">{{ $pp['ian'] }}</a>
                                                    <!-- a href="showAfterUpload/{{ $pp['id'] }}/6/Musterung/11/0" target="_blank">{{ $pp['ian'] }}</a -->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Terminart</td>
                                                <td>{{ $t['terminart'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>Liefertermin</td>
                                                <td>{{ $pp['lty'] }}/{{ $pp['ltw'] }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="cell" style="border: none;float:left;">
                                        <table>
                                            <tr>
                                                <td>Lieferant</td>
                                                <td>
                                                    @if (isset($po['supplierid']))
                                                        <a href='adressen/show/{{ $po['supplierid'] }}'
                                                            target='_blank'>{{ $po['supplier'] }}</a>
                                                        @if ($t['terminart'] == 'BSCI' and isset($po['bsci']))
                                                            <br>BSCI gültig bis: {{ $po['bsci'] }}
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>LT</td>
                                                <td>
                                                    @if ($t['rot'] != '')
                                                        Soll: LT{{ $t['rot'] }} Wochen <br>
                                                    @endif
                                                    KW @if ($pp['ltw'] + $t['rot'] <= 0)
                                                        {{ $pp['lty'] - 1 }}/{{ $pp['ltw'] + $t['rot'] + 52 }}
                                                    @else
                                                        {{ $pp['lty'] }}/{{ $pp['ltw'] + $t['rot'] }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Datenfeld</td>
                                                <td>{{ $t['datafield'] }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both;">&nbsp;</div>
                            <div style="color:darkblue;border-radius: 0px;">
                                <div>
                                    <div>
                                        <div class="cell" style="">
                                            <table>
                                                <tr>
                                                    <td>Anzeigetext</td>
                                                    <td style="width:500px;padding:0;">
                                                        <input type="text" value="{{ $t['label'] }}"
                                                            name="Termine_Label{{ $t['id'] }}"
                                                            id="Termine_Label{{ $t['id'] }}"
                                                            style="width:500px;border:none;padding:5px;" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:top;">Anmerkung<br> (Ansicht im
                                                        Terminfeld)</td>
                                                    <td style="padding:0;">
                                                        <textarea name='Termine_Bemerkung{{ $t['id'] }}' id="Termine_Bemerkung{{ $t['id'] }}"
                                                            style='width:500px;height:80px;overflow:auto;border:none;padding:5px;font-family:Arial;'>{{ $t['bemerkung'] }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Zusändigkeit {{ $t['ma'] }} {{ $t['id'] }}</td>
                                                    <td>{{ Form::select('Termine_Mitarbeiter', $kalender['mitarbeiterliste'], $t['ma'], ['id' => 'Termine_Mitarbeiter' . $t['id'], 'style' => 'width:100px;padding:5px;']) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Zu erledigen bis</td>
                                                    <td>{{ Form::text('Termine_Datum', substr($t['start'], 0, 10), ['style' => 'width:100px;', 'id' => 'Termine_Datum' . $t['id'], 'class' => 'datepicker']) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>erledigt am</td>
                                                    <td>{{ Form::text('Termine_Datum_Ende', substr($t['ende'], 0, 10), ['style' => 'width:100px;', 'id' => 'Termine_Datum_Ende' . $t['id'], 'class' => 'datepicker']) }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="cell" style="padding:10px;">
                                            @if (Auth::User()->PPMitarbeiter_Gruppe == 'user' or Auth::User()->PPMitarbeiter_Gruppe == 'admin')
                                                <button type="button" id="ajaxCall_SaveDateX"
                                                    onclick="cpc_tsaveM('{{ $t['id'] }}');"
                                                    style="width:360px;height:45px;">
                                                    <span
                                                        style="font-size: 24px; font-weight: bold;color:darkblue;">Speichern</span>
                                                </button><br>
                                                <span id="messagebox{{ $t['id'] }}"
                                                    style="color:red;font-size: 14px; font-weight: bold;"></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                    @if ($t['terminart'] == 'Nacharbeit')
                        <div
                            style="border-top:1px solid darkblue;border-bottom:1px solid darkblue; padding:4 0 4 10; border-radius:0px;height:58px;">
                            <?php $i = 1; ?>
                            @foreach ($termineMusterung as $tm)
                                <div style="float:left;width:150px;">
                                    <input type="checkbox"
                                        id="{{ $tm->PPBoardSpalte_Bezeichnung }}_{{ $t['id'] }}"
                                        name="{{ $tm->PPBoardSpalte_Bezeichnung }}"><span
                                        style="color:darkblue;font-size: 11px;">{{ $tm->PPBoardSpalte_Bezeichnung }}</span>
                                </div>
                                <?php
                                if ($i % 9 == 0) {
                                    echo "<div style='clear:both;'></div>";
                                }
                                $i++;
                                ?>
                            @endforeach
                        </div>
                    @endif
                    <div style="padding:10px;">
                        <div style="padding-top: 8px; padding-bottom: 8px;">
                            <span
                                style="font-size: 18px; font-weight: bold;padding: 5px; padding-top:8px; padding-bottom: 8px;color:darkblue;">Termin
                                History</span>
                        </div>
                        <div
                            style="width:1375px;border:1px solid darkblue; border-radius: 0px; height:450px;padding:0px;overflow: auto;padding:5px;text-align: left;">
                            <div class="terminHist" style="margin:0px auto;width:100%;">
                                <div class="thRow">
                                    <!--div class="thHeader" style="width:40px;">MA</div-->
                                    <!-- div class="thHeader" style="width:40px;">Receiver</div -->
                                    <div class="thHeader" style="">Status</div>
                                    <!--div class="thHeader" style="">Datum</div-->
                                    <div class="thHeader" style="">Kategorie</div>
                                    <div class="thHeader" style="">Erledigen durch</div>
                                    <div class="thHeader" style="">Erledigen bis</div>
                                    <!--div class="thHeader" style="width:120px;">Erledigt am</div-->
                                    <div class="thHeader" style="">Bemerkung</div>
                                    <div class="thHeader" style="">Upload</div>
                                    <div class="thHeader" style=""></div>
                                </div>
                                <!-- Neuer Eintrag HISTORY -->
                                <div class="thRow">
                                    <input type="hidden" id="StatChange_PPId_{{ $t['id'] }}"
                                        value = "{{ $pp['id'] }}" />
                                    <input type="hidden" id="StatChange_StatusAlt_{{ $t['id'] }}"
                                        value="{{ $t['status'] }}" />
                                    <!--div  class="thCellNew"><input type="hidden" id ="StatChange_Sender_{{ $t['id'] }}" value="{{ Auth::User()->PPMitarbeiter_Id }}" disabled/> {{ Auth::User()->PPMitarbeiter_Kuerzel }}</div -->
                                    <!-- div  class="thCellNew"><select id="StatChange_Receiver_{{ $t['id'] }}" >
                                    @foreach ($kalender['mitarbeiterliste'] as $maid => $ma)
                                        <option value="{{ $maid }}">{{ $ma }}</option>
                                    @endforeach
                                    </select></div -->
                                    <div class="thCellNew">
                                        {{ Form::select('Termine_Status', $t['stati'], $t['status'], ['id' => 'Termine_Status' . $t['id'], 'style' => 'width:120px;padding:5px;']) }}
                                    </div>
                                    <!--div class="thCellNew">{{ date('Y-m-d') }}</div-->
                                    <div class="thCellNew">
                                        <select id="StatChange_Categorie_{{ $t['id'] }}"
                                            style="width:150px;padding: 5px;">
                                            <option>Sonstige</option>
                                            <option>Mengendifferenz</option>
                                            <option>Qualität</option>
                                            <option>Farbe</option>
                                        </select>
                                    </div>
                                    <div class="thCellNew">
                                        <select id="StatChange_Receiver_{{ $t['id'] }}"
                                            style="width:100px;padding: 5px;">
                                            @foreach ($kalender['mitarbeiterliste'] as $mid => $ma)
                                                <option value="{{ $mid }}">{{ $ma }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="thCellNew">
                                        <input style="width:100px;padding: 5px;"
                                            id="StatChange_DoUntil_{{ $t['id'] }}" class="datepicker"
                                            value="2021-08-10" />
                                    </div>
                                    <!--div class="thCellNew">
                                        <input style="width:100px;padding: 5px;" id="StatChange_DoneAt_{{ $t['id'] }}" class="datepicker" />
                                    </div-->
                                    <div class="thCellNew">
                                        <textarea style="min-width:500px;padding: 5px;height:70px;" id="StatChange_Remark_{{ $t['id'] }}"
                                            placeholder="Neuer Eintrag"></textarea>
                                    </div>
                                    <div class="thCellNew">
                                        <div id="retMes{{ $t['id'] }}"
                                            style="float:left;width:150px;height:50px;border:1px solid red;display:none;">
                                        </div>
                                        <div class="dropC" id="dropContainer_{{ $t['id'] }}"
                                            style="border-radius: 0px;border:1px solid black;height:50px; width:150px;padding:4px;vertical-align:central; text-align:center;">
                                            Drag & Drop
                                        </div>
                                        <input type="file" id="xFile{{ $t['id'] }}"
                                            style="display: none;" />
                                    </div>
                                    <div class="thCellNew">
                                        <input type="button" id="button{{ $t['id'] }}"
                                            style="width:80px;height:60px;font-weight: bold;color:darkblue;"
                                            onclick="cpc_save_stateChange({{ $t['id'] }});" value="Speichern">
                                    </div>
                                </div>
                            </div>
                            <div
                                style='border:1px solid darkblue;overflow: auto;height:325px;margin-top:10px;border-radius: 0px;'>
                                <div class="terminHist" style="margin:0px auto; width:calc(100%-10px);"
                                    id="jsonSpace{{ $t['id'] }}">
                                    <div class="thRow">
                                        <div class="thHeader2" style="width:40px;">MA</div>
                                        <!-- div class="thHeader" style="width:40px;">Receiver</div -->
                                        <div class="thHeader2" style="width:150px;">Status</div>
                                        <div class="thHeader2" style="width:120px;">Datum</div>
                                        <div class="thHeader2" style="width:100px;">Kategorie</div>
                                        <div class="thHeader2" style="width:120px;">Erledigen bis</div>
                                        <div class="thHeader2" style="width:40px;">von</div>
                                        <div class="thHeader2" style="width:120px;">Erledigt am</div>
                                        <div class="thHeader2" style="width:550px;">Bemerkung</div>
                                        <div class="thHeader2" style="width:100px;">Upload</div>
                                        <div class="thHeader2" style="width:100px;">Aktion</div>
                                    </div>
                                    @foreach ($t['log'] as $log)
                                        <div class="thRow" style="">
                                            <div class="thCell">
                                                @if (isset($log->PPTermineChanges_Mitarbeiter_Id))
                                                    {{ $kalender['mitarbeiterliste'][$log->PPTermineChanges_Mitarbeiter_Id] }}
                                                @endif
                                            </div>
                                            <div class="thCell">
                                                @if ($log->PPTermineChanges_oldStatus != $log->PPTermineChanges_newStatus)
                                                    {{ $log->PPTermineChanges_oldStatus }} =>
                                                    {{ $log->PPTermineChanges_newStatus }}
                                                @else
                                                    History-Eintrag
                                                @endif
                                            </div>
                                            <div class="thCell">{{ substr($log->PPTermineChanges_Date, 0, 10) }}</div>
                                            <div class="thCell">{{ $log->PPTermineChanges_Categorie }}</div>
                                            <div class="thCell">{{ substr($log->PPTermineChanges_DoUntil, 0, 10) }}
                                            </div>
                                            <div class="thCell">
                                                @if (isset($kalender['mitarbeiterliste'][$log->PPTermineChanges_Receiver]))
                                                    {{ $kalender['mitarbeiterliste'][$log->PPTermineChanges_Receiver] }}
                                                @endif
                                            </div>
                                            <div class="thCell"'>{{ substr($log->PPTermineChanges_DoneAt, 0, 10) }}
                                            </div>
                                            <div class="thCell">{{ $log->PPTermineChanges_Remark }}</div>
                                            <div class="thCell">
                                                @if (strlen($log->URL) > 0)
                                                    <a href="{{ $log->URL }}" target="_blank"><img
                                                            src="images/download_100x31.jpg" /></a>
                                                @endif
                                            </div>
                                            <div class="thCell">
                                                @if (strlen($log->PPTermineChanges_DoneAt) < 10)
                                                    <button id="btnErledig{{ $t['id'] }}"
                                                        onclick="setErledigt({{ $t['id'] }},{{ $log->PPTermineChanges_Id }});">Erledigt</button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button
                style="width:35px;height:35px;background-color:red;color:white;position:absolute;right:0;top:0;text-align: center; border:1px solid darkred; margin:0 auto;"
                class="close" id="btn_{{ $t['id'] }}">x</button>
        </div>
    </div>
    <?php
    if ($t['ma'] != 0) {
        $ma = '*';
    } else {
        $ma = '';
    }
    ?>
    @if (strlen(trim($t['bemerkung'])) > 0)
        <div style='position:absolute; bottom:0px; right:0px; width:10px;height:10px;background-color: #e78f08; border:none;border-radius: 0px;margin:0px;'
            title="{{ $t['bemerkung'] }}">&nbsp;</div>
    @endif
    <span style='font-size: 8px;font-family: tahoma;'>{{ $t['label'] }}</span>
</div>
<script>
    function getFile(id) {
        document.getElementById("file_" + id).click();
    }
    function sub(obj, id) {
        var file = obj.value;
        var fileName = file.split("\\");
        //document.getElementById("yourBtn_" + id).innerHTML = fileName[fileName.length - 1];
        document.getElementById("yourBtn_" + id).style.color = "limegreen";
        document.getElementById("yourBtn_" + id).style.backgroundColor = "limegreen";
        frm = document.getElementById("form_" + id);
        console.log(frm);
        frm.submit();
        event.preventDefault();
    }
    function sendAjax(tid) {
        alert(tid);
        $.ajax({
            type: 'POST',
            url: 'testAjax',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(msg) {
                alert("Bis hier immer noch  OK" + tid);
                console.log(msg);
                document.getElementById("Res" + tid).innerHTML = msg.wasanders;
            }
        });
    }
</script>
