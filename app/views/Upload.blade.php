<?php 
   if (isset($_COOKIE['TPTLanguage'])) {
        $lang = $_COOKIE['TPTLanguage'];
    } else {
        $lang = Auth::user()->PPMitarbeiter_Language;
        $_COOKIE['TPTLanguage'] = $lang;
    }
?>
<div style="background-color: #FFF; border:1px solid gray;border-radius: 5px; width:1638px;height:895px;text-align: left;padding:30px; font-family: Tahoma; font-size: 14px;">
    <h1>{{ ServiceProvider::tl($lang, 'Produktpass Upload/Import')}} </h1>
    <!-- div style="width:600px;float:left;border:4px solid lightgray;padding:20px;height:550px;">
        <h2>Excel-Import</h2>
        {{Form::open(array('url' => 'upload', 'method' => 'POST', 'files' => 'true'))}}
        <div style="width:500px;height:100px;border: 1px solid lightgray;padding:10px;">
            <h3 title="Derzeit Heimtex 3 und Bekleidung (ohne Sport)">Schritt 1: Importart auswählen</h3>
            <select name="Importart" style="height:30px;width:250px;padding:5px;">
                @foreach($data['importarten'] as $art)
                <option value="{{$art['id']}}" style="height:20px;">{{$art['art']}}</option>
                @endforeach
            </select>
        </div>
        <div style="width:500px;height:150px;border: 1px solid lightgray;padding:10px;margin-top: 15px;">
            <h3>Schritt 2: Produktpass-Datei (XLS) auswählen</h3>
            <div style="width:200px;float:left;vertical-align: text-top;font-size: 15px;height:40px; padding:0px;">
                <div style="float:left;">
                    Neue Version:
                    <input type="hidden" name="IsNewVersion" value="0" />
                </div>
                <div style="float:left;padding-left:10px;">
                    <input style="width:25px;height:25px;" type="checkbox" name="IsNewVersion" value="1" checked="checked"/>
                </div>
            </div>
            <div style="width:200px;float:left;vertical-align:text-top;  ;font-size: 15px;">
                <div style="float:left;">
                    Charge: <input  type="hidden" name="IsNewVersionCharge" value="0" />
                </div>
                <div style="float:left;padding-left: 10px;">
                    <input  style="width:25px;height:25px;" type="checkbox" name="IsNewVersionCharge" value="1" checked="checked" />
                </div>
            </div>
            <div style="margin-top:20px;"><input type="file" name="file" style="font-size:20px;margin-top: 15px;width:400px;height: 30px;"/></div>
        </div>
        <div style="width:500px;height:120px;border: 1px solid lightgray;padding:10px;margin-top: 15px;">
            <h3>Schritt 3: Importieren</h3>
            <input type="submit" value="IMPORTIEREN" style="width:400px;margin-top:20px;font-size:20px;height:40px;"/>
        </div>
        {{ Form::close() }}
    </div-->
    <div style="float: left;width:600px; border:4px solid lightgray; margin-left: 20px;padding:20px; height: 550px;">
        <h2 style="color:red;">{{ ServiceProvider::tl($lang, 'XML-Import (XML-Datei oder Zip-Archiv') }} </h2>
        <div>
            <form method="POST" action="/importXML" accept-charset="UTF-8" enctype="multipart/form-data" onsubmit="return eval_form();">
            <input type="hidden" name="XML" value="1" />
            <input type="hidden" name="FINAL" value="0" />
            <input type="hidden" name="force" value="0" />
            <div style="width:500px;vertical-align:text-top;font-size: 15px; border:1px solid lightgray;height:227px; padding:20px;">
                    <h3>{{ ServiceProvider::tl($lang, 'Schritt 1: Produktpass-Datei (XML/ZIP) auswählen') }}</h3>
                <div style="width:400px;float:left;vertical-align: text-top;font-size: 15px;height:40px; padding:0px;">
                        <div style="margin-top:20px;">
                        <input   accept="*.xml *.zip" type="file" name="file" style="font-size:20px;margin-top: 15px;width:400px;height: 30px;"/></div>
                    <div style="margin-top:20px;padding-bottom:20px;"><h3>{{ ServiceProvider::tl($lang, 'Status') }}</h3><input type="radio"  name="InternerStatus" value="PLAN" checked='checked'/> <b>PLAN</b><br><input type="radio"  name="InternerStatus" value="FIX"/> <b>FIX</b></div>
                </div>
            </div>
            <div style="width:500px;height:190px;border: 1px solid lightgray;padding:10px;margin-top: 15px; padding: 0 0 0 20;">
                <h3>{{ ServiceProvider::tl($lang, 'Schritt 2: Importieren') }}</h3>
                <div style="margin-top:20px;">
                {{ ServiceProvider::tl($lang, 'Infomail an')}}:<br>
                <input name="mailto" style="font-size:20px;width:400px;height: 30px;" value="{{Auth::user()->PPMitarbeiter_email}}"/></div>
                <!-- div style="border: none;vertical-align: text-top;padding: 8px;">
                    <label for="final" style="vertical-align: top;"><b>Finaler Import:</b></label>
                    <input id="final" name="final" type="checkbox" style="width: 25px;height: 25px;"/> <br>
                </div -->
                <input type="submit" value="{{ ServiceProvider::tl($lang, 'IMPORTIEREN') }}" style="width:400px;margin-top:20px;font-size:20px;height:40px;"/>
            </div>
           </form>
        </div>
    </div>
</div>
<script>
    function eval_form (){
        var answer = window.confirm("Datei(en) jetzt hochladen?");
        return answer;
    }
</script>