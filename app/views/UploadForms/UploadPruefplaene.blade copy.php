<style>
    #filesInput {
        border:none;
        width:80%;
        height:60px;
        font-size:20px;
    }
</style>
<div style="background-color: #FFF; border:1px solid gray;border-radius: 5px; width:90%;height:90%;text-align: left;padding:30px; font-family: Tahoma; font-size: 14px;margin-top:30px;">
    <h1>Massen Upload von Prüfplänen </h1>
    <div style="float: left;min-width:840px;width:50%; border:4px solid lightgray; margin-left: 20px;padding:20px; height: 500px;">
        <h2 style="color:red;">Ordner Auswahl</h2>
        <div>
            <form method="POST" action="/uploadMassenPruefplaene" accept-charset="UTF-8" enctype="multipart/form-data" onsubmit="return eval_form();">
                <div style="min-width:800px;width:80%;vertical-align:text-top;font-size: 15px; border:1px solid lightgray;height:180px; padding:20px;">
                    <h3>Schritt 1: Ordner auswählen, der nur Prüfpläne enthalten darf.</h3>
                    <div style="width:80%;float:left;vertical-align: text-top;font-size: 15px;height:40px; padding:0px;">
                        <div style="margin-top:20px;">
                            <input id='filesInput' type="file" name="MultiPdf[]"  multiple webkitdirectory=""/>
                        </div>
                    </div>
                </div>
                <div style="min-width:800px;width:80%;height:120px;border: 1px solid lightgray;padding:10px;margin-top: 15px; padding:20px;">
                    <h3>Schritt 2: Importieren</h3>
                    <input type="submit" value="IMPORTIEREN" style="width:400px;margin-top:20px;font-size:20px;height:40px;"/>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function eval_form (){
        //var answer = window.confirm("Datei(en) jetzt hochladen?");
        //return answer;
    }
</script>