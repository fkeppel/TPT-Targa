<div style="background-color: #FFF; border:1px solid gray;border-radius: 5px; width:1638px;height:895px;text-align: left;padding:30px; font-family: Tahoma; font-size: 14px;">
    <h1>Upload Themenplanung</h1>
    <div style="float: left;width:600px; border:4px solid lightgray; margin-left: 20px;padding:20px; height: 550px;">
        <h2 style="color:red;">Themenplanung-Import (XLSX-Datei)</h2>
        <div>
            <form action='importThemenplanung' method='post' enctype='multipart/form-data'>
                <div style="width:500px;vertical-align:text-top;font-size: 15px; border:1px solid lightgray;height:227px; padding:20px;">
                    <h3>Schritt 1: Themenplanungs-Datei (XLSX) auswählen</h3>
                    <div style="width:400px;float:left;vertical-align: text-top;font-size: 15px;height:40px; padding:0px;">
                        <div style="margin-top:20px;"><input  accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"  type="file" name="themenplanung" style="font-size:20px;margin-top: 15px;width:400px;height: 30px;"/></div>
                    </div>
                </div>
                <div style="width:500px;height:150px;border: 1px solid lightgray;padding:10px;margin-top: 15px; padding: 20px;">
                    <h3>Schritt 2: Importieren</h3>
                    <input type="submit" value="IMPORTIEREN" style="width:400px;margin-top:20px;font-size:20px;height:40px;"/>
                </div>
            </form>
        </div>
    </div>
</div>
