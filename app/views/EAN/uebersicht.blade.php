<div style="width:1680px;height:960px;border:none;font-family:Tahoma,Arial, sans-serif;font-size:14px;">
    <h2>EAN-Codes</h2> 

    <div style="border:none;height:880px; overflow:auto;padding-left:100px;padding-top:30px;">

        <div id="EAN-Tabs">
            <ul>
                <li>
                    <a href="#EAN-Uebersicht">Übersicht</a>
                </li>
                <li>
                    <a href="#EAN-Erstellen">EAN erstellen</a>
                </li>

                @if ($data['hauptbenutzer'] == $data['aktbenutzer'])
                <li>
                    <a href="#EAN-Verwalten">EAN suchen/löschen</a>
                </li>
                @endif

                <li>
                    <a href="#EAN-Basis">EAN Basisnummernverwaltung</a>
                </li>
            </ul>

            <div id="EAN-Uebersicht" style="height:790px;overflow:auto;text-align: left;border: 1px solid lightgray;">
                <h3>Übersicht EAN-Nummern</h3>
                {{ Form::open( array('url'=>'EAN', 'class'=>'form-signin')) }}
                {{ Form::hidden('IAN', '123456') }}
                <table>
                    <tr>
                        <td style="padding:10px;">{{ Form::label('Basisnummer') }}</td>
                        <td style="padding:10px;">{{ Form::select('EAN_Nummern_EAN_Basisnummer_Id', $data['bn']) }}</td>
                        <td colspan="2"  style="padding:10px;">{{ Form::submit('anzeigen', array('class'=>'btn','style'=>'width:120px;background-color:lightgray;'))}}</td>
                    </tr>
                </table>


                {{ Form::close()}}

                <p><b>Anzeige der EAN für: {{ $data['basisname']}}</b></p>
                <div style="padding:30px;">
                    <div>
                        <table style="font-family:Tahoma,Arial, sans-serif;font-size:14px;">
                            <tr style="background-color: lightgray;border: 1px solid gray;height:30px;">
                                <td style="width:150px;padding:5px;">EAN</td>
                                <td style="width:150px;padding:5px;">IAN/Artikel</td>
                                <td style="width:80px;padding:5px;">Benutzer</td>
                                <td style="width:50px;padding:5px;">Status</td>
                                <td style="width:100px;padding:5px;text-align: right;">Angelegt am</td>
                            </tr>
                        </table>
                    </div>
                    <div style="overflow: auto;height:400px;border:none; width:700px;">
                        <table style="font-family:Tahoma,Arial, sans-serif;font-size:14px;">
                            <?php $u = $data['user']; ?>
                            @foreach ($data['eans'] as $ean)

                            <tr>
                                <td style="width:150px;padding:5px;">{{$ean['EAN_Nummern_EAN']}}</td>
                                <td style="width:150px;padding:5px;">{{$ean['EAN_Nummern_IAN']}}</td>
                                <td style="width:80px;padding:5px;">{{$u[$ean['EAN_Nummern_MA']]}}</td>
                                <td style="width:50px;padding:5px;">{{$ean['EAN_Nummern_Status']}}</td>
                                <td style="width:100px;padding:5px;text-align: right;">{{date('d.m.y', strtotime($ean['EAN_Nummern_LetzteAenderung']))}}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

            </div>
            <div id="EAN-Erstellen" style="height:790px;overflow:auto;text-align: left;border:1px solid lightgray;">




                <div style="width:600px; height:750px; float:left;padding:20px;border: 1px solid lightgray;">
                    <h3>EAN-Nummern erstellen</h3>
                    {{ Form::open( array('url'=>'#', 'class'=>'form-signin', 'id'=>'newEAN', 'onsubmit' => 'newEANs();')) }}

                    <table>
                        <tr>
                            <td style="width:250px;padding:6px;">{{ Form::label('Basisnummer') }} </td>
                            <td style="width:350px;padding:6px;">{{ Form::select('inpBasis', $data['bn'],null,array('style' => 'width:250px;height:30px;', 'id' => 'inpBasis')) }}</td>
                        </tr>
                        <tr>
                            <td style="padding:6px;">{{ Form::label('IAN / Artikelnummer') }} </td>
                            <td style="padding:6px;">{{ Form::Text('inpArtikel',null,array('style' => 'width:250px;;', 'id' => 'inpArtikel') ) }}</td>
                        </tr>
                        <tr>
                            <td style="padding:6px;"> {{ Form::label('Anzahl') }}</td>
                            <td style="padding:6px;"> {{ Form::Text('inpAnzahl', null,array('style' => 'width:250px;;', 'id' => 'inpAnzahl')) }}</td>
                        </tr>
                        <tr>
                            <td style="padding:6px;"> {{ Form::label('EAN-Nummern ergänzen') }}</td>
                            <td style="padding:6px;"> {{ Form::checkbox('inpAdd', null, false, array("id"=>"inpAdd")) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding:6px;">{{ Form::submit('EAN anlegen', array('class'=>'btn','style'=>'width:515px;height:30px;background-color: #FFF;'))}}</td>
                        </tr>
                    </table>





                    {{ Form::close()}}

                    <div style="padding-top:50px;">

                        <button id="idClearForm" onclick="clearForm();">Maske löschen</button>

                    </div>
                </div>
                <div style="width:600px; height:750px;padding:20px;float:left;margin-left:20px; border: 1px solid lightgray;">
                    <h3>Neu erstellte EAN</h3>
                    <div id="JSONNewEans" style="padding-left:20px;">

                    </div>
                </div>

            </div>

            @if ($data['hauptbenutzer'] == $data['aktbenutzer'])

            <div id="EAN-Verwalten" style="height:790px;overflow:auto;text-align: left;">
                <h3>EAN Verwaltung</h3>
                {{ Form::open( array('url'=>'#', 'class'=>'form-signin', 'id'=>'idSearchEAN', 'onsubmit' => 'searchEAN();')) }}
                {{ Form::Text('inpEAN',null,array('style' => 'width:250px;;', 'id' => 'inpEAN') ) }}
                {{ Form::submit('suchen', array('class'=>'btn','style'=>'width:120px;background-color: lightgray;'))}}

                {{ Form::close()}}



                <div id="SearchResultEAN">

                </div>

            </div>
            @endif

            <div id="EAN-Basis" style="height:650px;overflow:auto;text-align: left;">
                <h3>Basisnummern Verwaltung</h3>

                <div>                
                    <table style="font-family: Tahoma, Arial, sans-serif;font-size: 14px;">
                        <tr style="height:25px;background-color: lightgray;border:1px solid gray;">
                            <th style="width:150px;text-align: left;padding:4px;">Bezeichnung</th>
                            <th style="width:150px;text-align: left;padding:4px;">Basisnummer</th>
                            <th style="width:40px;text-align: right;padding:4px;">Max</th>
                            <th style="width:120px;text-align: center;padding:4px;">Aktion</th>
                        </tr>
                        @foreach ($data['basisnummern'] as $bn )
                        <tr>
                            <td style="padding:4px;">{{$bn->EAN_Basisnummern_Kd}}</td>
                            <td style="padding:4px;">{{$bn->EAN_Basisnummern_Nummer}}</td>
                            <td style="padding:4px;text-align:right;"><input id="inpMax{{$bn->EAN_Basisnummern_Id}}" value="{{$bn->EAN_Basisnummern_Max}}" style="width:35px;border:none;text-align: right;"/> </td>
                            <td style="padding:4px 4px 4px 40px;">
                                <button style="width:60px;" onclick="changeBasisnummer('{{$bn->EAN_Basisnummern_Id}}');">ändern</button>
                                @if ($bn->candelete)
                                <button style="width:60px;"  onclick="deleteBasisnummer('{{$bn->EAN_Basisnummern_Id}}');">löschen</button>
                                @endif
                            </td>  
                        </tr>
                        @endforeach
                        <tr>
                            <td style="padding:0px;"><input type="text" id="inpBezX" style="width:150px;border:1px solid lightgray;"/></td>
                            <td style="padding:0px;"><input type="text" id="inpBasisX" style="width:150px;border:1px solid lightgray;"/></td>
                            <td style="padding:0px;text-align:right;"><input type="text" id="inpMaxX" style="width:40px;border:1px solid lightgray;text-align: right;"/></td>
                            <td style="padding:0px;padding-left:40px;"><button style="width:60px;"  onclick="newBasisnummer();">neu</button></td>
                        </tr>
                    </table>
                </div>

                @if ($data['hauptbenutzer'] == $data['aktbenutzer'])
                <div style="padding:20px;font-family:Tahoma,Arial,sans-serif; font-size:14px;padding-left:80px;margin-top: 50px;">

                    Hauptbenutzer: <input type="text" style="border:1px solid lightgray;width:100px;" id="inpNeuerHauptbenutzer" value="{{$data['hauptbenutzer']}}"/><br>
                    <div style="margin-top:10px;"><button style="width:200px;" onclick="xhangeHauptbenutzer();">ändern</button></div>
                    <div id="msgNeuerHauptbenutzer" style="padding:40px;margin-top:20px;"> </div>
                </div>
                @endif

                <div id="JSONManageEans">

                </div>

            </div>

        </div>
    </div>
</div>

<script>

    $("#JSONEAN").submit(function(event) { event.preventDefault(); });
    $("cMangeEAN").submit(function(event) { event.preventDefault(); });
    $("#newEAN").submit(function(event) { event.preventDefault(); });
    $("#manageEANs").submit(function(event) {event.preventDefault(); });
    $("#idSearchEAN").submit(function(event) {event.preventDefault(); });
    function clearForm(){

    document.getElementById ("inpBasis").value = 0;
    document.getElementById ("inpArtikel").value = "";
    document.getElementById ("inpAnzahl").value = "";
    document.getElementById ("JSONNewEans").innerHTML = "<div></div>";
    return false;
    }

    function xhangeHauptbenutzer(){

    //alert("Neuer Hauptbenutzer");

    var newuser = document.getElementById ("inpNeuerHauptbenutzer").value;
    var data = {neuerHauptbenutzer:newuser};
    $.ajax({
    type: 'POST',
            url: "EAN/changehauptbenutzer",
            data: data,
            beforeSend: function (xhr) {
            if (xhr && xhr.overrideMimeType) {
            xhr.overrideMimeType('application/json;charset=utf-8');
            }
            },
            dataType: 'json',
            success: function (data) {
            var newuser = document.getElementById ("inpNeuerHauptbenutzer");
            newuser.style.color = "red";
            var elem = document.getElementById ("msgNeuerHauptbenutzer");
            elem.innerHTML = data['message'];
            },
            error:function (data, status) {
            var newuser = document.getElementById ("inpNeuerHauptbenutzer").value;
            newuser.text = "Fehler";
            var elem = document.getElementById ("msgNeuerHauptbenutzer");
            //elem.innerHTML = data['message'];
            elem.innerHTML = status;
            }
    });
    }

    function changeBasisnummer(id){

    //alert("Neuer Hauptbenutzer");

    var inpMax = document.getElementById ("inpMax" + id).value;
    //alert (inpMax);return;

    var data = {id:id, newMax:inpMax};
    $.ajax({
    type: 'POST',
            url: "EAN/changemax",
            data: data,
            beforeSend: function (xhr) {
            if (xhr && xhr.overrideMimeType) {
            xhr.overrideMimeType('application/json;charset=utf-8');
            }
            },
            dataType: 'json',
            success: function (data) {
            var inpMax = document.getElementById ("inpMax" + id);
            inpMax.style.color = "green";
            },
            error:function (data, status) {
            var inpMax = document.getElementById ("inpMax" + id);
            inpMax.style.color = "red";
            }
    });
    }

    function newBasisnummer(){



    var inpBez = document.getElementById ("inpBezX").value;
    var inpBasis = document.getElementById ("inpBasisX").value;
    var inpMax = document.getElementById ("inpMaxX").value;
    var data = {newBasis:inpBasis, newBezeichnung:inpBez, newMax:inpMax};
    $.ajax({
    type: 'POST',
            url: "EAN/newbasisnummer",
            data: data,
            beforeSend: function (xhr) {
            if (xhr && xhr.overrideMimeType) {
            xhr.overrideMimeType('application/json;charset=utf-8');
            }
            },
            dataType: 'json',
            success: function (data) {
            alert("Neue Basisnummer angelegt!");
            location.reload(true);
            },
            error:function (data, status) {
            var inpMax = document.getElementById ("inpBezX");
            inpMax.value = "Fehler";
            }
    });
    }

    function deleteBasisnummer(bid){




    var data = {id:bid};
    $.ajax({
    type: 'POST',
            url: "EAN/deletebasisnummer",
            data: data,
            beforeSend: function (xhr) {
            if (xhr && xhr.overrideMimeType) {
            xhr.overrideMimeType('application/json;charset=utf-8');
            }
            },
            dataType: 'json',
            success: function (data) {

            alert("Basisnummer gelöscht!");
            location.reload(true);
            },
            error:function (data, status) {

            alert("Fehler beim löschen!");
            }
    });
    }



    function newEANs () {

    //alert('newEANs');
    console.log("newEANs");
    var basis = document.getElementById ("inpBasis").value;
    var artikel = document.getElementById ("inpArtikel").value;
    var anzahl = document.getElementById ("inpAnzahl").value;
    var eanadd = document.getElementById ("inpAdd").checked;
    var add = 0;
    if (eanadd){
    add = 1
    }
    anzahl = anzahl * 1;
    var data = { inpBasis:basis, inpArtikel:artikel, inpAnzahl:anzahl, inpAdd:add};
    if (basis == 0){
    alert('Bitte Basisnummer angeben!');
    return false;
    }

    if (artikel.length <= 0){
    alert('Bitte Artikel oder IAN angeben!');
    return false;
    }

    if (anzahl <= 0 || anzahl > 25){
    alert('Anzahl ausserhalb des gültigen Bereichs <0..25>!');
    return false;
    }



    console.log(data);
    $.ajax({
    type: 'POST',
            url: "EAN/create",
            data: data,
            beforeSend: function (xhr) {
            if (xhr && xhr.overrideMimeType) {
            xhr.overrideMimeType('application/json;charset=utf-8');
            }
            },
            dataType: 'json',
            success: function (data) {

            var elem = document.getElementById ("JSONNewEans");
            elem.innerHTML = data['view'];
            console.log("newEANS: success");
            },
            error:function (data, status) {

            var elem = document.getElementById ("JSONNewEans");
            elem.innerHTML = data['view'] + "fail<br>";
            }
    });
    console.log("Ende newEANs");
    return false;
    }


    function manageEANs () {

    alert('manageEANs');
    console.log("manageEANs");
    var data = { action:'manage'};
    $.ajax({
    type: 'POST',
            url: "EAN/manage",
            data: data,
            beforeSend: function (xhr) {
            if (xhr && xhr.overrideMimeType) {
            xhr.overrideMimeType('application/json;charset=utf-8');
            }
            },
            dataType: 'json',
            success: function (data) {
            //alert("Erfolg");
            var elem = document.getElementById ("JSONManageEans");
            elem.innerHTML = data['view'];
            console.log("manageEANS: success");
            },
            error:function (data, status) {
            alert("Fail: " + status);
            var elem = document.getElementById ("JSONManageEans");
            elem.innerHTML = "fail<br>";
            }
    });
    console.log("Ende manageEANs");
    return false;
    }

    function searchEAN () {

    //alert('searchEAN'); 
    console.log("searchEAN");
    var inpEAN = document.getElementById("inpEAN").value;
    var data = { action:'search', searchstr: inpEAN};
    $.ajax({
    type: 'POST',
            url: "EAN/search",
            data: data,
            beforeSend: function (xhr) {
            if (xhr && xhr.overrideMimeType) {
            xhr.overrideMimeType('application/json;charset=utf-8');
            }
            },
            dataType: 'json',
            success: function (data) {
            //alert("Erfolg search");
            var elem = document.getElementById ("SearchResultEAN");
            elem.innerHTML = data['view'];
            console.log("search: success");
            },
            error:function (data, status) {
            //alert("Fail Search: "+status);
            var elem = document.getElementById ("SearchResultEAN");
            elem.innerHTML = "fail<br>";
            console.log ("search Error");
            }
    });
    console.log("Ende searchEAN");
    return false;
    }

    function deleteEAN (ean, action) {

    //alert(ean);
    //console.log("Lösche: " + ean);


    var ian = "";
    if (action == "Zuordnen"){
    ian = prompt("IAN eingeben", "IAN");
    }


    var data = {
    action: action,
            eanid: ean,
            IAN: ian
    };
    console.log ("Delete EAN EAN_Id: " + ean + " IAN: " + ian);
    $.ajax({
    type: 'POST',
            url: "EAN/delete",
            data: data,
            beforeSend: function (xhr) {
            if (xhr && xhr.overrideMimeType) {
            xhr.overrideMimeType('application/json;charset=utf-8');
            }
            },
            dataType: 'json',
            success: function (data) {
            //alert("Erfolg");
            //var responseelem = document.getElementById ("EANStatus"+ean);
            searchEAN()
                    //console.log (responseelem);
                    //responselem.innerHTML = "<div>OK</div>";
                    console.log("deleteEAN: success");
            },
            error:function (data, status) {
            //alert("Fail: "+status);
            var responseelem = document.getElementById ("EANStatus" + ean);
            //responselem.innerHTML = "<div>BAD</div>";  
            console.log("deleteEAN: Error")
            }
    });
    console.log("deleteean");
    return false;
    }

</script>
