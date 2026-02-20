<div style="background-color: #FFF; border:1px solid gray;border-radius: 5px; width:1638px;height:908px;text-align: left;padding:30px; font-family: Tahoma; font-size: 14px;">

    <h1>Inquiry Upload/Import </h1>

    <div style="margin-top:20px;border:1px solid lightgray;padding:50px; width:400x;float: left;">

        <h1>XLS Import</h1>
        {{Form::open(array('url' => 'upload', 'method' => 'POST', 'files' => 'true'))}}

        <input type="hidden" name="Importart" value="12">
        <div style="width:500px;height:350px;border: 1px solid lightgray;padding:10px;margin-top: 15px;">
            <h3>Schritt 1: Produktpass-Datei (XLS) für Inquiry auswählen</h3>

            <input type="hidden" name="IsNewVersion" value="1" />
            <input type="hidden" name="IsNewVersionCharge" value="1" />
            <input type="hidden" name="IsInquiry" value="1" />
            <input type="file" name="file" style ="margin-top: 15px;width:400px;height: 60px;padding:20px;"/>
            <br><br>
            <h3>ODER Ordner auswählen der NUR!!! hochzuladenen PPs enthält.</h3>
            <br>
            <input type="file" name="dirupload[]" id="file_input" multiple webkitdirectory="">
            <br><br> Bitte darauf achten, dass keine PPs doppelt hochgeladen werden. Habe ich bei dem Bulk import noch nicht abgefangen!!
        </div>
        <div style="width:500px;height:170px;border: 1px solid lightgray;padding:10px;margin-top: 15px;">
            <h3>Schritt 2: Importieren</h3>
            <input type="hidden" name="IsBW" value="0"/>
            <div style="width:400px;height: 40px;position: relative;">
                <div style="width:180px;height:35px; position: absolute;right:0px;bottom:0px;">
                    <div style="font-weight: bold;float:left;padding-top:5px;">Bettwäsche Aufträge: </div><div style="float:left;">
                        <input type="hidden" name="IsBW" value="0" />
                        <input type="checkbox" name="IsBW" value="1" style="width:25px;height:25px;"/> </div>
                </div>
            </div>
            <input type="submit" value="IMPORTIEREN" style="width:400px;margin-top:20px;background-color: greenyellow;padding:20px;border:1px solid lightgray;"/>
        </div>
        {{ Form::close() }}
    </div>
    <div style="margin-left:25px;margin-top:20px;border:1px solid lightgray;padding:50px; width:400x;float: left;">
        <h1>XML-Import <span style="color:red;">Neu</span></h1>
        {{Form::open(array('url' => 'importXMLInq', 'method' => 'POST', 'files' => 'true'))}}


        <div style="width:500px;height:350px;border: 1px solid lightgray;padding:10px;margin-top: 15px;">
            <h3>Schritt 1: Einzelne Produktpass-Datei (XML)  oder ZIP-Ordner für Inquiry auswählen</h3>

            <input type="hidden" name="IsNewVersion" value="1" />
            <input type="hidden" name="IsNewVersionCharge" value="1" />
            <input type="hidden" name="IsInquiry" value="1" />
            <input type="file" name="file" style ="margin-top: 15px;width:400px;height: 60px;padding:20px;"/>
            <br><br>
            <h3>ODER Ordner auswählen der NUR!!! hochzuladenen PPs enthält.</h3>
            <br>
            <input type="file" name="dirupload[]" id="file_input" multiple webkitdirectory="">
            <br><br> Bitte darauf achten, dass keine PPs doppelt hochgeladen werden. Habe ich bei dem Bulk import noch nicht abgefangen!!
        </div>
        <div style="width:400px;height:170px;border: 1px solid lightgray;padding:10px;margin-top: 15px;">
            <h3>Schritt 2: Importieren</h3>
            <input type="hidden" name="IsBW" value="0"/>
            <div style="width:400px;height: 40px;position: relative;">
                <div style="width:180px;height:35px; position: absolute;right:0px;bottom:0px;">
                    <div style="font-weight: bold;float:left;padding-top:5px;">Bettwäsche Aufträge: </div><div style="float:left;">
                        <input type="hidden" name="IsBW" value="0" />
                        <input type="checkbox" name="IsBW" value="1" style="width:25px;height:25px;"/> </div>
                </div>
            </div>
            <input type="submit" value="IMPORTIEREN" style="width:400px;margin-top:20px;background-color: greenyellow;padding:20px;border:1px solid lightgray;"/>
        </div>
        {{ Form::close() }}
    </div>

</div>
