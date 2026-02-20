<html>
  <?php  $vc = new ViewController();
         $vc->init('formDateiauswahl', array('ppid' => 2561));
         $files = $vc->files();
  ?>
<!-- div>
  <div>{{ $vc->pp('PPProduktpass_Ausmusterungnummer') }}</div>
  <div>{{ $vc->file(66386, 'PPPPFiles_Name') }}</div>
  <table>
    @foreach ($files as $fid => $file)
      <tr>
        <td>{{ $file->PPPPFiles_Name}}</td>
        <td>{{ $file->PPPPFiles_SharePointLink }}</td>
      </tr>      
    @endforeach
  </table>
</div -->
  <div style='padding:50px;'>
  <div style='font-family:Arial;'>
      <!-- img  src="blob:https://targagmbh.sharepoint.com/889d0cc8-4b2f-4746-bc75-26742548bab0" style="with:400px;" /-->
      <h3>Beispiel von Herrn Midderhoff:</h3>
      <br>
      <img  src="https://targagmbh.sharepoint.com/sites/TPTStorage/Freigegebene%20Dokumente/IANs/427244_2304/427244.JPG" style="width:400px;margin-bottom:20px;" />
      <br>
      <a href="https://targagmbh.sharepoint.com/sites/TPTStorage/Freigegebene%20Dokumente/IANs/427244_2304/427244.JPG" target="_blank">Link zum Bild</a>
      <br>  
      <h3>Beispiel Externes Bild:</h3>
      <br>
      <img  src="https://data.wdr.de/ddj/deepfake-quiz-erkennen-sie-alle-ki-bilder/Titelbild.jpg" style="width:400px;margin-bottom:20px;" />
  </div>
  <div style="margin-top:20px;width:600px;height:300px;border:1px solid darkblue;padding:20px;font-family:Arial, Helvetica, sans-serif;font-size:1.2rem;">
        <form method="post" action="UploadSharePoint" enctype="multipart/form-data">
          <h3>Datei-Upload zum Sharepointaccount tptupload@targa.gmbh</h3>
          <label>IAN:<br><br>
              <input name="ian" type="text" style="width: 100px;" > 
            </label>  <br><br>
            <!--label>Rechte
              <select name='permission'>
                <option value="0">None</option>
                <option value="1">Guest</option>
                <option value="2">Reader</option>
                <option value="3">Contributor</option>
                <option value="4">WebDesigner</option>
                <option value="5">Administrator</option>
              </select>
            <label-->
              Datei auswählen:<br><br>
              <input name="uplSharepoint" type="file" style="width: 400px;" > 
            </label>  <br><br>
            <button>upload</button>
          </form>
    </div>
  </div>
</html>