<div style="font-family:Arial;padding:40px; font-size:1.2rem;">
<h1>Transfer der Dateien nach Sharepoint</h1>
<h3>Anzahl der IANs mit übertragbaren Dateien: {{$data['all']}}.<br> 
    Dateien aus {{$data['openTransfers']}} IANs wurden noch nicht übertragen.<br>
Dateien aus {{$data['transferd']}} IANs  wurden übertragen.<br>
 davon {{$data['ok']}} erfolgreich und  {{$data['error']}} mit Fehlern.</h3>
<form method='post' action="/post_upl2spo">
    <label>Aus wievielen IANs sollen die Datein übertragen werden?</label>
    <input name="maxIAN" value="2" style="padding:10px;width:50px;font-size:1.2rem;" /><br>
    <button type="submit" style="width:120px;padding:10px;margin-top:20px;font-size:1.2rem;">Transfer</button>
</form>
</div>