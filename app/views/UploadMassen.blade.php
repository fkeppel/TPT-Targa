<div style="background-color:#FFF; border:1px solid gray; border-radius:5px; width:1638px;
            text-align:left; padding:30px; font-family:Tahoma; font-size:14px; overflow:auto;">
    <h1>Produktpass Massen Import (Zip-File aus Lidl Portal) </h1>
    <div style="float:left; width:600px; border:4px solid lightgray; margin-left:20px; padding:20px;">
        <h2 style="color:red;">Zip-Archiv</h2>
        <div>
            <form method="POST" action="/uploadMassenImport" accept-charset="UTF-8"
                  enctype="multipart/form-data" onsubmit="return eval_form();">
                <div style="width:500px; vertical-align:text-top; font-size:15px;
                            border:1px solid lightgray; padding:20px;">
                    <h3>Schritt 1: ZIP-Archive aus Lidl Portal auswählen</h3>
                    <div style="width:400px; float:left; vertical-align:text-top; font-size:15px; padding:0px;">
                        <div style="margin-top:20px;">
                            <input accept="*.xml *.zip" type="file" name="MultiZip"
                                   style="font-size:20px; margin-top:15px; width:400px; height:30px;" />
                        </div>
                        <div style="margin-top:20px; padding-bottom:20px;">
                            <h3>Status</h3>
                            <input type="radio" name="InternerStatus" value="PLAN" checked="checked" />
                            <b>PLAN</b><br>
                            <input type="radio" name="InternerStatus" value="FIX" />
                            <b>FIX</b>
                    </div>
                </div>
                    <!-- Float-Clear innerhalb Schritt 1 -->
                    <div style="clear:both;"></div>
                </div>
                <div style="width:500px; border:1px solid lightgray; padding:0 0 0 20px; margin-top:15px;">
                    <h3>Schritt 2: Importieren</h3>
                    <div style="margin-top:20px;">
                    Infomail an:<br>
                        <input name="mailto" style="font-size:20px; width:400px; height:30px;"
                               value="{{Auth::user()->PPMitarbeiter_email}}" />
                    </div>
                    <div style="margin-top:20px;">
                        <label style="display:inline-block; vertical-align:middle;">
                            Mailversand unterdrücken:
                        </label>
                        <input type="checkbox" name="mailSuppress" value="1"
                               style="margin-left:10px; vertical-align:middle;" />
                    </div>
                    <!--
                    <!-- div style="border: none;vertical-align: text-top;padding: 8px;">
                        <label for="final" style="vertical-align: top;"><b>Finaler Import:</b></label>
                        <input id="final" name="final" type="checkbox" style="width: 25px;height: 25px;"/> <br>
                    </div -->
                    <div style="margin-top:20px;">
                    Generelles Lieferdatum für IANs OHNE Liefertermin<br>
                        Woche:
                        <input name="LTWoche"
                               style="font-size:20px; width:100px; height:30px; margin-right:30px; text-align:right;"
                               value="99" />
                        Jahr:
                        <input name="LTJahr"
                               style="font-size:20px; width:100px; height:30px; text-align:right;"
                               value="9999" />
                    </div>
                    <input type="submit" value="IMPORTIEREN"
                           style="width:400px; margin-top:20px; font-size:20px; height:40px;" />
                </div>
            </form>
        </div>
    </div>
    <!-- optional, falls später weitere floats folgen -->
    <div style="clear:both;"></div>
</div>
