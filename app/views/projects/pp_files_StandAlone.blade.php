<style>
    .container {
        width: 530px;
        border: 1px solid lightgray;
        text-align: center;
        margin: 0 auto;
    }
    #FileGrid1 {
        padding: 0px;
        display: grid;
        grid-template-columns: 10% 18% 48%;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        border: 4px dotted red!imortant;
    }
    #Filegrid1 div {
        border-radius: 0px;
        padding: 0px;
    }
    #FileGrid2 {
        padding: 0px;
        border: 4px dotted lime!imortant;
        border-radius: 0px;
    }
    #Filegrid2 div {
        border: 1px solid lightgray;
        border-radius: 0px;
        padding: 0px;
    }
    .fileDeleted {
        display: none !important;
    }
    .fileShowDeleted {
        display: inline-block !important;
    }
    .btnHide {
        width: 200px;
        padding: 8px;
        margin: 5px;
    }
    #FileProtokollTable th {
        text-align: left;
        padding: 5px;
    }
    #FileProtokollTable td {
        text-align: left;
        color: darkslategray;
        font-size: 0.85em;
        padding: 5px;
    }
    .cpcFileUpload label {
        width: 80%;
    }
    .cpcFileUpload select {
        width: 80%;
    }
    #tabs2 {
        height: 100%;
        border: 4px solid lime;
    }
    #FileDetails {
        display: grid;
        grid-template-columns: 150px 660px;
        border-collapse: collapse;
        border: 10px solid dodgerblue;
    }
    #FileDetails div {
        padding: 5px;
        border: 1px solid darkgray;
    }
    #FileDetails textarea {
        border: none;
        min-height: 64px;
        width: 99%;
    }
    .ui-widget-header {
        border: 1px solid #c5c5c5;
        background: #c5c5c5 url(images/ui-bg_gloss-wave_35_f6a828_500x100.png) 50% 50% repeat-x;
        color: #333333;
        font-weight: bold;
    }
    .ui-widget.ui-widget-content {
        border: 1px solid #c5c5c5;
    }
    .ui-widget-content {
        border: 1px solid #dddddd;
        background: #ffffff;
        color: #333333;
    }
    .wrapper {
        display: grid;
        width: 100%;
        /*grid-template-columns: 150px 180px 650px x450pxx 100px;*/
        grid-template-columns: 10% 30% 50% 10%;
        grid-column-gap: 0px;
        grid-row-gap: 0px;
        margin: 0px;
        padding: 0px;
        border: none !important;
        grid-template-rows: max-content;
    }
    .cell {
        border: 1px solid lightgray !important;
    }
    .btn {
        padding: 0px !important;
        padding-top: -10px !important;
        border: none;
        width: 100%;
        height: 28px;
    }
    .ui-widget-header {
        border: 1px solid #c5c5c5;
        background: #c5c5c5 url(images/ui-bg_gloss-wave_35_f6a828_500x100.png) 50% 50% repeat-x;
        color: #333333;
        font-weight: bold;
    }
    .ui-widget.ui-widget-content {
        border: 1px solid #c5c5c5;
    }
    .ui-widget-content {
        border: 1px solid #dddddd;
        background: #ffffff;
        color: #333333;
    }
    .btnFake {
        background-color: var(--tgBlue);
        width: 100%;
        height: 28px;
        color: white;
        text-align: center !important;
        font-size: 1em;
        font-weight: bold;
        font-family: Trebuchet MS, Tahoma, Verdana, Arial, sans-serif;
        border: none;
    }
    .btnFake a {
        text-decoration: none;
        color: white;
        font-family: Trebuchet MS, Tahoma, Verdana, Arial, sans-serif;
    }
    .upl {
        width:100%;
        border: 1 px solid dodgerblue;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }
    .uplLeft {
        font-weight: bolder;
        font-size: 1em;
        float:left;
        width:28%;
        border:none;
   }
   .uplRight {
        float:left;
        width:65%;
        border:none;
   }
    .fileSelector input[type=file]::file-selector-button {
        border: 2px solid darkblue;
        color:white;
        padding: .2em .4em;
        border-radius: .2em;
        background-color: #1C73C5;
        transition: 1s; 
        width:200px;
        height:60px;
    }
    .fileSelector  input[type=file]::file-selector-button:active{
        background-color: #c1c1c1;
    }
</style>
<?php
    $ord = $data['Kategorien'];
    $compactView = "";
    $komplettView = "display:none;";
    $viewId = 1;
    $fgWidth = 'width:50%;';
    if (!$data['tabs']['compactView']) {
        $compactView = "display:none;";
        $komplettView = "";
        $viewId = 1;
        $fgWidth = 'width:72%;';
    }
    $img = "\\data\\Icons\\download.png";
    $dlSymbol = '<div style="float:left; border: none;margin-right:5px;"><img style="height:18px;" src="'.$img.'" /></div>';
    $isSharepoint = $data['pp']['PPProduktpass_Transferd2Sharepoint'] > 0;
    $countFiles = $data['files']['TOTAL'];
    $transferdFiles = $data['files']['TRANSFERD'];
    $server = "https://tpt-dev.ad.targa.de";
    $showEdit2 = true;
    $lang = Auth::user()->PPMitarbeiter_Language;
?> 
<div  style="border:1px solid gray;border-radius:0px;position:relative;height:100%;overflow:auto;">
    <input type="hidden" value={{$viewId}} id="viewId" />
    <input type="hidden" value='OK' id="TestDouble" />
    <div id="tabContainer" style="border:none;height:99%;overflow: auto;">
        <div id="tabs2x" style="border:none;height:98%;">
            <ul>
                <?php $tbid      = 0; ?>
                @foreach ( $data['files']['types'] as $type)
                    <li><a href="#{{$type['Type']}}" onclick="setSubCat('{{$type['Type']}}',{{$tbid++}});">{{$type['Type']}}</a></li>
                @endforeach
                @if (Auth::user()->PPMitarbeiter_Gruppe == 'admin')
                    <li><a href="#FileProtokoll">{{ ServiceProvider::tl($lang, 'Datei-Protokoll') }}</a></li>
                @endif
            </ul>
            <?php $tabid     = 3; ?>
            @foreach ( $data['files']['types'] as $type)
            <div id="{{$type['Type']}}" style="height:97%;overflow:hidden;padding:0px; border:1px solid lightgray;" >
                <?php $tabid++; ?>
                <div id="tabsx{{$tabid}}" style=" border:1px solid lightgray;">
                    <ul>
                        <?php $subcatndx = 0 ?>
                        @foreach($data['files']['subtypes'] as $kat)
                            @if ($kat['ParentId'] == $type['Id'])
                            <li><a href="#{{urlencode($kat['Kategorie'])}}" onclick="setSubSubCat('{{$subcatndx++}}');">{{$kat['Kategorie']}}</a></li>
                            @endif
                        @endforeach
                    </ul>
                    @foreach($data['files']['subtypes'] as $kat)
                    @if ($kat['ParentId'] == $type['Id'])
                    <div id="{{urlencode($kat['Kategorie'])}}" style="width:100%;overflow:auto;border:1px solid lightgray;">
                        <div style="border:1px solid lightgray;margin:0 auto;border-radius:0px;">
                                @if(false)
                                <div>
                                    <form action="/upload2Sharepoint" method="post">
                                        <input type="hidden" name="ppid" value="{{ $data['pp']['PPProduktpass_Id'] }}"/>
                                        <button type="submit" style="width:100%;height:30px;padding:8px;background-color:tomato;">({{ $transferdFiles }} / {{ $countFiles}}) {{ ServiceProvider::tl($lang,' Dateien wurden nach Sharepoint transferiert') }}</button> 
                                    </form>
                                </div>
                                <!-- else -->
                                <div>
                                        <button type="button" style="width:100%;height:30px;padding:8px;background-color:#239B56;">{{ ServiceProvider::tl($lang,' Dateien wurden nach Sharepoint transferiert') }}</button> 
                                    </form>
                                </div>
                                @endif
                                <div id='fileUpload' style="border:1px solid lightgray;padding:10px;">
                                    <h3>Datei-Upload</h3>
                                    <form name="UplD" id="form_{{  $kat['Kategorie'] }}" action="/uploadFiles" method="post" enctype="multipart/form-data" style="margin: 0 auto;">
                                        {{Form::hidden('ppid',$data['pp']['PPProduktpass_Id'])}}
                                        {{Form::hidden('Kategorie',$kat['Kategorie'])}}
                                        {{Form::hidden('filetype',$type['Type'])}}
                                        <input type='hidden' name="versioning" id="ver_{{  $kat['Kategorie'] }}", value='0' />
                                        <?php
                                        if (is_null($data['tabs']['subTabName']) or strlen($data['tabs']['subTabName']) < 2) {
                                            $data['tabs']['subTabName'] = 'EKPM';
                                        }
                                        ?>
                                        <input type="hidden" name="ActivmainTab" id="hiddenActivmainTab1" value="{{$data['tabs']['mainTab']}}">
                                        <input type="hidden" name="ActivmainTabIndex" id="hiddenActivmainTabIndex" value="{{$data['tabs']['mainTabIndex']}}">
                                        <input type="hidden" name="ActivsubTabIndex" id="hiddenActivsubTabIndex" value="{{$data['tabs']['subTabIndex']}}"> 
                                        <input type="hidden" name="ActivsubTabName" id="hiddenActivsubTabName" value="{{$data['tabs']['subTabName']}}"> 
                                        <input type="hidden" name="ActivsubsubTabIndex" id="hiddenActivsubsubTabIndex" value="{{$data['tabs']['subsubTabIndex']}}"> 
                                        <input type='hidden' id='testDbl{{ $kat['Kategorie']}}'/>
                                        <fieldset class="cpcFileUpload"> 
                                            <div style="width:25%;float:left;border:none;padding:10px;" class='fileSelector'>
                                                <div class='upl'>
                                                        <span>{{ ServiceProvider::tl($lang,'Klicken oder Drag&Drop von Datei(en) möglich')}}</span>
                                                        <input type="file" name="file[]" id="file{{ $kat['Kategorie']}}" style="display:inline;border:none;width:100%;margin-left:-5px;" multiple><br>
                                                        <!-- input type="file" name="file[]" id="file{{ $kat['Kategorie']}}" class="jfilestyle" data-input="true" data-theme="red" data-text="Klicken oder Datei(en) hier ablegen" -->
                                                </div>
                                            </div>
                                            <div style="width:30%;float:left;border:none;padding:8px;">
                                                @if(isset($ord[$kat['Kategorie']]))
                                                <div class='upl'>
                                                    <div class='uplLeft'>{{ ServiceProvider::tl($lang,'Kategorie')}};</div>
                                                    <div class='uplRight'>
                                                        <select style='width:70%;padding:8px;height:40px;font-weight:bolder;' name="Ordnung" id="ordnung{{ $kat['Kategorie']}}">
                                                            <option value="--">--</option>
                                                            @foreach ($ord[$kat['Kategorie']] as $o)
                                                                <option>{{ $o }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class='upl'><div class='uplLeft'>Link (mit http(s)://):</div><div class='uplRight'><input type="text" name="link" id="link{{ $kat['Kategorie']}}" style="width:90%;padding: 4px;" /></div></div>
                                                <div class='upl'><div class='uplLeft'>Link {{ ServiceProvider::tl($lang,'Anzeigename')}}:</div><div class='uplRight'><input type="text" name="linkName" id="linkNameId" style="width:90%;padding: 4px;" /></div></div>
                                            </div>
                                            <div style="width:40%;float:left;border:none;padding:8px;">
                                                <div class='upl'>
                                                    <div class='uplLeft'>{{ ServiceProvider::tl($lang,'Bemerkung')}}:</div>
                                                    <div class='uplRight'><textarea name="bemerkung" id="bemerkungId" style="width:100%;padding: 4px; height:74px;"></textarea></div>
                                                </div>
                                            </div>
                                            <button type="button" style="height:40px;padding:6px;margin-left:9px;margin-top:0px;width:91.5%;border:1px solid darkblue;" onclick="validateUpload('{{ $kat['Kategorie'] }}')"><b>Upload</b></button>
                                        </fieldset>
                                    </form>
                                </div>
                        </div>   
                        <div style="border:1px solid lightgray;border-radius:0;padding:10px;overflow:auto;width:100%;">
                            @if(isset($ord[$kat['Kategorie']]))
                            <div style="width:100%;border: 1px solid lightgray;padding:6px;border-radius:0px;">
                                Filter: <select id="FilterOrdnung{{ $kat['Kategorie'] }}" name="Ordnung" style="width:380px;padding:4px;border:1px solid gray;">
                                            <option>Alles</option>
                                            @foreach ($ord[$kat['Kategorie']] as $o)
                                            <option>{{ $o }}</option>
                                            @endforeach
                                        </select>
                                <button type="button" style="padding:6px;" onclick="filter('{{ $kat['Kategorie'] }}');"><b>Filtern</b></button>
                                <button onclick="showFileGrid(1);" style='margin:0px; margin-bottom:6px;padding:6px;margin-right:10px;'>Komplett</button>
                                <button onclick="showFileGrid(2);" style='margin:0px; margin-bottom:6px;padding:6px;'>Kompakt</button>
                            </div>
                            @endif
                            @if (Auth::user()->PPMitarbeiter_Id >0)
                            <div name="FileGridContainer" style="border:1px solid lightgray;float:left;border-radius:0px;overflow:auto;width:100%;min-width:1000px;height:445px;">
                            <?php $pos = 0; ?>
                            @foreach($data['files']['files'] as $file)
                                <?PHP
                                    $pos++;
                                    $fileparts = pathinfo($file['PPPPFiles_Name']);
                                    if (isset($fileparts['extension'])){
                                        $ext       = $fileparts['extension'];
                                    }else {
                                        $ext       = 'default';
                                    }
                                    $dllogo    = "/images/" . strtolower($ext) . ".png";
                                    if (!file_exists(public_path().$dllogo)){
                                        $dllogo    = "/images/default.png";
                                    }
                                    $lc = '#';
                                    if (isset($data['FilesLastChange'][$file['PPPPFiles_Name']])){
                                        $lc = $data['FilesLastChange'][$file['PPPPFiles_Name']];
                                    }
                                    //$dllogo = "/images/icon_xml.png";
                                ?>
                                @if ($file['PPPPFiles_Type'] == $type['Type'] and $file['PPPPFiles_SubKat'] == $kat['Kategorie'] )
                                <div id="FileGrid1" name="FileGrid1" style="{{$komplettView}}" class="{{ $kat['Kategorie'] }} {{ trim($file['PPPPFiles_Ordnung']) }} @if($file['PPPPFiles_Status'] == 0) fileDeleted @endif ">
                                    <!-- include('projects.pp_files_sub') -->
                                    @if (strlen($file['PPPPFiles_Name']) > 0)
                                      <div style="position: relative;border: 1px solid lightgray;margin-bottom: 10px;">
                                        <!--
                                        <div style="position: absolute;bottom:0px;">
                                            <form action="/deleteFiles/{{$file['PPPPFiles_Id']}}" method="POST" style="border: none;" onsubmit="return validatedelete();">
                                                {{Form::hidden('ppid',$data['pp']['PPProduktpass_Id']);}}
                                                <input type="hidden" name="ActivmainTab" id="hiddenActivmainTab" value="#tabs-6">
                                                <input type="hidden" name="ActivsubTabIndex" id="hiddenActivsubTabIndex" value="{{$data['tabs']['subTabIndex']}}">
                                                <input type="hidden" name="ActivsubTabName" id="hiddenActivsubTabName" value="{{$data['tabs']['subTabName']}}">
                                                <input type="hidden" name="ActivsubsubTabIndex" id="hiddenActivsubsubTabIndex" value="{{$data['tabs']['subsubTabIndex']}}">
                                                <button style="width:150px;padding:10px;" type="submit" value="löschen"><b>Datei löschen</b></button>
                                            </form>
                                        </div>
                                        @if ($ext == 'xml')
                                        <div style="position: absolute;bottom:48px;">
                                            <form action="/compareXML" method="post" target="_blank">
                                                <input type="hidden" name="ppid" value="{{$data['pp']['PPProduktpass_Id']}}">
                                                <input type="hidden" name="filecompare" value="{{$file['PPPPFiles_Id']}}">
                                                <button style="width:150px;padding:10px;" type="submit" value="vergleichen"><b>Vergleichen</b></button>
                                            </form>
                                        </div>
                                        @endif
                                            -->
                                        </div>
                                    <!-- Vorschaubild -->
                                    <div style="position:relative;border: 1px solid lightgray;margin-bottom: 10px;padding-top:10px;padding-left:10px;">
                                        @if (strtoupper(substr($file['PPPPFiles_Name'],-4)) == '.JPG' || strtoupper(substr($file['PPPPFiles_Name'],-5)) == '.JPEG' || strtoupper(substr($file['PPPPFiles_Name'],-4)) == '.PNG'|| strtoupper(substr($file['PPPPFiles_Name'],-4)) == '.GIF' )
                                            <div style="border:none;">
                                              <?php 
                                                            $spo_tenant = 'https://targagmbh.sharepoint.com/sites/TPTStorage/';
                                                            $spo_path = 'Freigegebene%20Dokumente/IANs/999999_9901/';
                                                            $spo_filename = '2024-01-10%2020_26_27-TermineController.php%20-%20targa%20%5BSSH_%2010.254.0.62%5D%20-%20Visual%20Studio%20Code.png';
                                                            $spo_file = $spo_tenant.$spo_path.$spo_filename;
                                                ?>
                                                @if($isSharepoint)
                                                        <?php 
                                                            $spo_tenant = 'https://targagmbh.sharepoint.com/sites/TPTStorage/';
                                                            $spo_path = 'Freigegebene%20Dokumente/IANs/999999_9901/';
                                                            $spo_filename = '2024-01-10%2020_26_27-TermineController.php%20-%20targa%20%5BSSH_%2010.254.0.62%5D%20-%20Visual%20Studio%20Code.png';
                                                            $spo_file = $spo_tenant.$spo_path.$spo_filename;
                                                        ?>
                                                    <a href="{{  ViewController::getSpoLink($file['PPPPFiles_Id'],1) }}" download="{{ViewController::getSpoDLName($file['PPPPFiles_Id'],1)}}" target="_blank">
                                                       <img src="{{url($dllogo)}}" style="margin:0 auto;height:80%;border:1px solid gray;">
                                                    </a>
                                                @else 
                                                    @if ($type['Type'] == 'PPUpload')
                                                    <a href="{{$server.'/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_TPTFilenameOld']}}" download="{{$file['PPPPFiles_TPTFilenameOld']}}" target="_blank">
                                                         <img src="{{url($spo_file)}}" style="height:80%;border:border:1px solid gray;">
                                                    </a>
                                                    @else
                                                    <a href="{{$server.'/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_TPTFilenameOld']}}" download="{{substr($file['PPPPFiles_TPTFilenameOld'],7)}}" target="_blank">
                                                         <img src="{{$server.'/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_TPTFilenameOld']}}" style="height:80%;border:1px solid gray;" />
                                                    </a>
                                                    @endif
                                                @endif
                                            </div>
                                            <div style="border:none;position: absolute; bottom:0px; left:0px;padding:0px;margin:0;">
                                                    <form method="POST" action="/setProjectPic" accept-charset="UTF-8" data-ajax="true" style="border:none;margin:0;" enctype="multipart/form-data">
                                                        <input name="ppid" type="hidden" value="{{ $data['pp']['PPProduktpass_Id'] }}">
                                                        <input name="pppic" type="hidden" value="{{ $file['PPPPFiles_Name'] }}">
                                                        <input type="hidden" name="ActivmainTab" id="hiddenActivmainTab" value="#tabs-6">
                                                        <input type="hidden" name="ActivsubTabIndex" id="hiddenActivsubTabIndex" value="{{$data['tabs']['subTabIndex']}}">
                                                        <input type="hidden" name="ActivsubTabName" id="hiddenActivsubTabName" value="{{$data['tabs']['subTabName']}}">
                                                        <input type="hidden" name="ActivsubsubTabIndex" id="hiddenActivsubsubTabIndex" value="{{$data['tabs']['subsubTabIndex']}}">
                                                        <button style="border:none;width:100%;padding:10px;margin:0;" type="submit" value="als Projektbild festlegen">{{ ServiceProvider::tl($lang,'als Projektbild festlegen')}}</button>
                                                    </form>
                                            </div>
                                        @else
                                            <div style="border:none;">
                                                @if ($type['Type'] == 'PPUpload')
                                                    <a href="{{ViewController::getSpoLink($file['PPPPFiles_Id'],1)}}" target="_blank" download="{{$file['PPPPFiles_Name']}}">
                                                @else
                                                    <a href="{{ViewController::getSpoLink($file['PPPPFiles_Id'],1)}}" target="_blank" download="{{substr($file['PPPPFiles_Name'],7)}}">
                                                @endif
                                                @if (strlen($dllogo)> 10)
                                                    <img src="{{$dllogo}}" alt="Datei" style="margin:0 auto;height:80%;border:1px solid gray;">
                                                @else
                                                    {{substr($file['PPPPFiles_Name'],7)}}
                                                @endif
                                                </a>
                                            </div>
                                        @endif
                                        <div style="position: absolute;bottom:0px;right:0;padding:0px;margin:0;">
                                            <form action="/deleteFiles/{{$file['PPPPFiles_Id']}}" method="POST" style="border: none;margin:0;" onsubmit="return validatedelete();">
                                                {{Form::hidden('ppid',$data['pp']['PPProduktpass_Id']);}}
                                                <input type="hidden" name="ActivmainTab" id="hiddenActivmainTab" value="#tabs-6">
                                                <input type="hidden" name="ActivsubTabIndex" id="hiddenActivsubTabIndex" value="{{$data['tabs']['subTabIndex']}}">
                                                <input type="hidden" name="ActivsubTabName" id="hiddenActivsubTabName" value="{{$data['tabs']['subTabName']}}">
                                                <input type="hidden" name="ActivsubsubTabIndex" id="hiddenActivsubsubTabIndex" value="{{$data['tabs']['subsubTabIndex']}}">
                                                <button style="width:150px;padding:10px;margin:0;" type="submit" value="löschen"><b>{{ ServiceProvider::tl($lang,'Datei löschen')}}</b></button>
                                            </form>
                                        </div>
                                        @if ($ext == 'xml')
                                        <div style="position: absolute;bottom:0px;left:0;padding:0px;margin:0;">
                                            <form action="/compareXML" method="post" target="_blank" style="margin:0;">
                                                <input type="hidden" name="ppid" value="{{$data['pp']['PPProduktpass_Id']}}">
                                                <input type="hidden" name="filecompare" value="{{$file['PPPPFiles_Id']}}">
                                                <button style="width:150px;padding:10px;margin:0;" type="submit" value="vergleichen"><b>{{ ServiceProvider::tl($lang,'Vergleichen')}}</b></button>
                                            </form>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="fileSub" style=" border: 1px solid lightgray;padding-top:10px;padding-left:10px; margin-bottom: 10px;position:relative;">
                                        {{Form::open(array('url' => 'updateRemarkFiles', 'method' => 'POST', 'files' => 'true', 'data-ajax' => 'true'))}}
                                        <input type="hidden" name="fileid" id="fileid" value="{{$file['PPPPFiles_Id']}}">
                                        <input type="hidden" name="ppid" id="hiddenActivmainTab" value="{{$data['pp']['PPProduktpass_Id']}}">
                                        <input type="hidden" name="ActivmainTab" id="hiddenActivmainTab" value="#tabs-6">
                                        <input type="hidden" name="ActivsubTabIndex" id="hiddenActivsubTabIndex" value="{{$data['tabs']['subTabIndex']}}">
                                        <input type="hidden" name="ActivsubTabName" id="hiddenActivsubTabName" value="{{$data['tabs']['subTabName']}}">
                                        <input type="hidden" name="ActivsubsubTabIndex" id="hiddenActivsubsubTabIndex" value="{{$data['tabs']['subsubTabIndex']}}">
                                        <!-- EDIT File Details -->
                                        <div id="FileDetails" style="border:none; ">
                                            <div style="background-color:lightgray ;font-weight:bold;">{{ ServiceProvider::tl($lang,'Hochgeladen am')}}:</div>
                                            <div>{{date_format(date_create_from_format('Y-m-d H:i:s',$file['PPPPFiles_Date']),'d.m.Y H:i')}}  @if (is_null($file['PPPPFiles_SharePointLink'])) NO-SPO @endif</div>
                                            <div style="background-color:lightgray ;font-weight:bold;">{{ ServiceProvider::tl($lang,'Letzte Änderung SPO')}}:</div>
                                            <div>{{$lc}}</div>
                                            <div style="background-color:lightgray ;font-weight:bold;">{{ ServiceProvider::tl($lang,'Kategorie')}}:</div>
                                            <div>
                                                @if(isset($ord[$kat['Kategorie']]))
                                                <select id="OrdnungSub{{ $kat['Kategorie'] }}" name="OrdnungSub" style="width:220px;padding:4px;margin-left:0px;">
                                                    @foreach ($ord[$kat['Kategorie']] as $o)
                                                    <option @if( trim($file['PPPPFiles_Ordnung']) == trim($o) ) selected @endif>{{ $o }}</option>
                                                    @endforeach
                                                </select>
                                                @endif
                                            </div>
                                            @if (strlen($file['PPPPFiles_Link']) > 0 )
                                            <div style="background-color:lightgray ;font-weight:bold;">Link: </div>
                                            <div><a href="{{ $file['PPPPFiles_Link'] }}" target="_blank">{{ $file['PPPPFiles_LinkName'] }}</a></div>
                                            @else 
                                            <div style="background-color:lightgray ;font-weight:bold;">{{ ServiceProvider::tl($lang,'Dateiname')}}:</div>
                                            <div style="overflow:auto;">
                                            @if(strlen($file['PPPPFiles_SharePointLink'])>0)
                                                        <span>{{ $file['PPPPFiles_Name'] }}</span><br>
                                                        <a href="{{ ViewController::getSpoLink($file['PPPPFiles_Id'], 2) }}" target="blank">DOWNLOAD</a><br>
                                                        <a href="{{ ViewController::getSpoLink($file['PPPPFiles_Id'], 1) }}" target="blank">Öffnen im Browser</a><br>
                                                        @if ($showEdit2)
                                                            <a href="{{ ViewController::getSpoLink($file['PPPPFiles_Id'], 3) }}" target="blank">Öffnen in App (wenn hinterlegt)</a>
                                                        @endif
                                            @else
                                                    @if ($type['Type'] == 'PPUpload')
                                                    {{ $file['PPPPFiles_Name'] }}
                                                    @else
                                                    {{ substr($file['PPPPFiles_Name'],7) }}
                                                    @endif<br>
                                            @endif
                                            </div>
                                            @endif
                                            <div style="background-color:lightgray ;font-weight:bold;">{{ ServiceProvider::tl($lang,'Bemerkung')}}:</div>
                                            <div style="padding:0px;"><textarea name="TA" id="textarea-container_{{$file['PPPPFiles_Id']}}">{{$file['PPPPFiles_Description']}}</textarea></div>
                                            <script>
                                                var $textArea = $("#textarea-container_{{$file['PPPPFiles_Id']}}");
                                                resizeTextArea($textArea);
                                                function resizeTextArea($element) {
                                                    $element.height($element[0].scrollHeight);
                                                }
                                            </script>
                                            <!-- div><span>Datei auswählen:</span> <input style="border:2px solid darkblue;width:20px;height:20px;" type="checkbox" class="selectableFiles" id="{{$file['PPPPFiles_Id']}}" value="1" /></div -->
                                            <div style="position:absolute; bottom:0; right:0;border:none;margin:0;padding:0;"><button style="width:150px;padding:10px;margin:0;" type="submit" value="Bemerkung ändern"><b>{{ ServiceProvider::tl($lang,'Änderungen speichern')}}</b></button></div>
                                        </div>
                                        <!-- ENDE EDIT File Details -->
                                        {{ Form::close() }}
                                    </div>
                                    @endif
                                </div>
                                <div id="FileGrid2" name="FileGrid2" style="{{$compactView}}" class="CV{{ $kat['Kategorie'] }} CV{{ trim($file['PPPPFiles_Ordnung']) }} @if($file['PPPPFiles_Status'] == 0) fileDeleted @endif ">
                                    <!-- include('projects.pp_files_sub_liste') -->
                                    @if (strlen($file['PPPPFiles_Name']) > 0)
                                    <Form action="/updateFilesCompact" , method='POST'>
                                        <input type="hidden" name="fileid" id="fileid" value="{{$file['PPPPFiles_Id']}}">
                                        <input type="hidden" name="ppid" id="ppid" value="{{$data['pp']['PPProduktpass_Id']}}">
                                        <input type="hidden" name="ActivmainTab" id="hiddenActivmainTab" value="#tabs-6">
                                        <input type="hidden" name="ActivsubTabIndex" id="hiddenActivsubTabIndex" value="{{$data['tabs']['subTabIndex']}}">
                                        <input type="hidden" name="ActivsubTabName" id="hiddenActivsubTabName" value="{{$data['tabs']['subTabName']}}">
                                        <input type="hidden" name="ActivsubsubTabIndex" id="hiddenActivsubsubTabIndex" value="{{$data['tabs']['subsubTabIndex']}}">
                                        <input type="hidden" name="filecompare" value="{{$file['PPPPFiles_Id']}}">
                                        <div class="wrapper">
                                            <div class="cell" style="padding:4px;">{{date_format(date_create_from_format('Y-m-d H:i:s',$file['PPPPFiles_Date']),'d.m.Y H:i:s')}}</div>
                                            <div class="cell">
                                                @if(isset($ord[$kat['Kategorie']]))
                                                <select id="Ordnung{{ $kat['Kategorie'] }}" name="Ordnung" style="width:100%;margin:0px;outline:none;border:1px solid lightgray;border-radius:0px;font-weight:bolder;padding:8px;">
                                                    @foreach ($ord[$kat['Kategorie']] as $o)
                                                    <option @if($file['PPPPFiles_Ordnung']==trim($o)) selected @endif>{{ $o }}</option>
                                                    @endforeach
                                                </select>
                                                @endif
                                            </div>
                                            <div class="cell">
                                                <div style="padding:5px;border:none;">
                                                    @if(strlen($file['PPPPFiles_LinkName'])>0)
                                                        <a href="{{ $file['PPPPFiles_Link'] }}" target="_blank">{{ $file['PPPPFiles_LinkName'] }}</a>
                                                    @else
                                                        @if(strlen($file['PPPPFiles_SharePointLink'])>0)
                                                        <?php 
                                                            $ian = $data['pp']['PPProduktpass_IAN'];
                                                            $spLink = $file['PPPPFiles_SharePointLink'];
                                                            $link = "https://targagmbh.sharepoint.com/sites/TPTStorage/Freigegebene%20Dokumente/Forms/AllItems.aspx?id=%2Fsites%2FTPTStorage%2FFreigegebene%20Dokumente%2FIANs%2F$ian%2F/$spLink";
                                                        ?>
                                                        <div>
                                                            <span style='color:darkblue;font-weight:bold;'>{{$file['PPPPFiles_Name']}}</span><br>
                                                            <a href="{{ ViewController::getSpoLink($file['PPPPFiles_Id'], 2) }}" target="blank">DOWNLOAD</a><br>
                                                            <a href="{{ ViewController::getSpoLink($file['PPPPFiles_Id'], 1) }}" target="blank">Öffnen im Browser</a><br>
                                                            <a href="{{ ViewController::getSpoLink($file['PPPPFiles_Id'], 3) }}" target="blank">Öffnen in App (wenn hinterlegt)</a>
                                                        </div>
                                                        @else
                                                            @if ($type['Type'] == 'PPUpload')
                                                            <a href="{{url('/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_Name'])}}" download="{{$file['PPPPFiles_Name']}}" target="_blank" title="{{$file['PPPPFiles_Description']}}">{{$file['PPPPFiles_Name']}} </a>
                                                            @else
                                                            <a href="{{url('/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_Name'])}}" download="{{substr($file['PPPPFiles_Name'],7)}}" target="_blank" title="{{$file['PPPPFiles_Description']}}">{{substr($file['PPPPFiles_Name'],7)}}</a>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </div>
                                                <textarea style="margin:0px;width:100%;height:60px;border:none; border-top:1px solid lightgray; border-radius:0px;outline-style:none;" name="TA" id="textarea-container_{{$file['PPPPFiles_Id']}}">{{$file['PPPPFiles_Description']}}</textarea>
                                            </div>
                                            <div class="cell">
                                                <button class="btn" name="btn" style="margin-bottom:20px;background-color:red;" type="submit" value="löschen" onclick="return validatedelete();"><b>{{ ServiceProvider::tl($lang,'löschen')}}</b></button>
                                                @if ($ext == 'xml')
                                                <div style="height:27px; text-align:center;background-color:#1C73C5;border:none;margin-bottom:2px;margin-top:-18px;padding-top: 5px;"><a href="/compareXMLExt/{{$data['pp']['PPProduktpass_Id']}}/{{$file['PPPPFiles_Id']}}" target="_blank" style="color:white;">{{ ServiceProvider::tl($lang,'vergleichen')}}</a></div>
                                                @endif
                                                <button class="btn" name="btn" type="submit" value="speichern"><b>{{ ServiceProvider::tl($lang,'speichern')}}</b></button>
                                            </div>
                                        </div>
                                    </Form>
                                    @endif
                                </div>
                                @endif
                            @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                @endforeach
                </div>
            </div>
            @endforeach
            @if (Auth::user()->PPMitarbeiter_Gruppe == 'admin')
            <div id="FileProtokoll" style="float: left; min-width:1200px;border: none;height:95%; width:80%; overflow: auto; ">
                <h3>Datei-Protokoll</h3>
                <table id="FileProtokollTable" style="border-collapse:collapse;padding:15px;">
                    <tr>
                        <th style="padding:6px;">{{ ServiceProvider::tl($lang,'Datei')}}</th>
                        <th style="padding:6px;">{{ ServiceProvider::tl($lang,'Hochgeladen am')}}</th>
                        <th style="padding:6px;">{{ ServiceProvider::tl($lang,'Hochgeladen von')}}</th>
                        <th style="padding:6px;">{{ ServiceProvider::tl($lang,'Gelöscht am')}}</th>
                        <th style="padding:6px;">{{ ServiceProvider::tl($lang,'Gelöscht von')}}</th>
                    </tr>
                    @if(isset($data['FileProtokoll']) and count($data['FileProtokoll']) > 0)
                        @foreach ($data['FileProtokoll'] as $p)
                            <?php
                            $dateC = date_format(date_create($p->created_at), 'd.m.y [H:i:s]');
                            $dateU = date_format(date_create($p->updated_at), 'd.m.y [H:i:s]');
                            ?>
                            <tr>
                                <td style="padding:6px;">{{$p->PPPPFiles_Name}}</td>
                                <td style="padding:6px;">{{$dateC}}</td>
                                <td style="padding:6px;">{{$p->CreateUser}}</td>
                                <td style="padding:6px;">@if($p->PPPPFiles_Status == 0) {{$dateU}} @endif</td>
                                <td style="padding:6px;">@if($p->PPPPFiles_Status == 0) {{$p->DeleteUser}} @endif</td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
<script>
    'use strict';
     $( function() {
        console.log('HALLO');
        $('#tabs2x').tabs();
        $('#tabsx3').tabs();
        $('#tabsx4').tabs();
        $('#tabsx5').tabs();
        $('#tabsx6').tabs();
        $('#tabsx7').tabs();
        $('#tabsx8').tabs();
        $('#tabsx9').tabs();
        $('#tabsx10').tabs();
        $('#tabsx11').tabs();
        $('#tabsx12').tabs();
        $('#tabsx13').tabs();
        $('#tabsx14').tabs();
        $('#tabsx15').tabs();
        $('#tabsx16').tabs();
        $('#tabsx17').tabs();
        $('#tabsx18').tabs();
        $('#tabsx19').tabs();
        $('#tabsx20').tabs();
      } );
    function alleMarkieren(kat) {
        var allElems = document.getElementsByClassName('selectableFiles');
        var elems = document.getElementById(kat).getElementsByClassName('selectableFiles');
        var fileIds = [];
        var check = true;
        for (i = 0; i < elems.length; i++) {
            if (elems[i].checked) {
                check = false;
                break;
            }
        }
        for (i = 0; i < allElems.length; i++) {
            allElems[i].checked = false;
        }
        for (i = 0; i < elems.length; i++) {
            elems[i].checked = check;
        }
    }
    function sendAjax(fileIds, mailto, zip, download) {
        if (fileIds.length < 1) {
            return;
        }
        var jsonArray = JSON.parse(JSON.stringify(fileIds));
        $.ajax({
            type: 'POST',
            url: '/handleFiles',
            data: {
                'fileIds': jsonArray,
                'mailto': mailto,
                'zip': zip,
                'download': download
            },
            success: function(result) {
                if (result.error == "true") {
                    alert("An error occurred: " & result.errorMessage);
                } else {
                    console.log(result);
                    if (result.download == 1) {
                        var ffd = result.filesForDownload;
                        for (i = 0; i < ffd.length; i++) {
                            console.log(ffd[i]);
                            setTimeout(function(path) {
                                window.location = path;
                            }, 200 + i * 200, ffd[i]);
                        }
                    }
                }
            }
        });
    }
    function selectFiles(kat) {
        //console.log(kat);
        var mailto = document.getElementById('mailto_' + kat).value;
        var zip = 0;
        if (document.getElementById('zip_' + kat).checked) {
            zip = 1;
        }
        var download = 0;
        if (document.getElementById('download_' + kat).checked) {
            download = 1;
        }
        var elems = document.getElementsByClassName('selectableFiles');
        var fileIds = [];
        var j = 0;
        for (i = 0; i < elems.length; i++) {
            if (elems[i].checked) {
                fileIds[j++] = elems[i].id;
                console.log(i + elems[i].id);
            }
        }
        if (fileIds.length < 1) {
            alert('Keine Dateien ausgewählt');
            return false;
        }
        sendAjax(fileIds, mailto, zip, download);
    }
    function validateUpload(id) {
        if (_validateUpload(id)){
           var frm = document.getElementById('form_'+id);
           frm.submit();
           return true;
        } 
        return false;
    }
    function _validateUpload(id) {
        //alert('TEST: ' + id);
        //checkFilesExist('file'+id);
        var file_elem = document.getElementById('file' + id);
        var link_elem = document.getElementById('link' + id);
        if (id != 'Produktpass' && id != 'PDFs' && id != 'Projektbild') {
            var ordnung_elem = document.getElementById('ordnung' + id);
            if (ordnung_elem[ordnung_elem.selectedIndex].value == "--") {
                alert("Keine Kategorie ausgewählt!");
                return false;
            }
        }
        if (file_elem.value == "") {
            if (link_elem.value == "") {
                alert("Keine Datei und kein Link ausgewählt!");
                return false;
            }
        }
        if (link_elem.value == "") {
            if (file_elem.value == "") {
                alert("Keine Datei und kein Link ausgewählt!");
                return false;
            }
        }
        uploadDouble(id);
        if (document.getElementById('ver_'+id).value > 0){
            return true;
        }
        return false;
    }
    function hasClass(target, className) {
        return new RegExp('(\\s|^)' + className + '(\\s|$)').test(target.className);
    }
    function _filter(kat) {
        var filter_elem = document.getElementById('FilterOrdnung' + kat).value;
        var elems = document.getElementsByClassName(kat);
        console.log("Filter: " + filter_elem);
        if (filter_elem == 'Alles') {
            for (var i = 0; i <= elems.length; i++) {
                elems[i].style.display = 'grid';
            }
            return;
        }
        var elems2 = document.getElementsByClassName(kat);
        for (var i = 0; i <= elems2.length; i++) {
            if (elems2[i] != undefined) {
                if (hasClass(elems2[i], filter_elem.trim())) {
                    elems2[i].style.display = 'grid';
                } else {
                    elems2[i].style.display = 'none';
                }
            }
        }
    }
    function _filterCV(kat) {
        var filter_elem = document.getElementById('FilterOrdnung' + kat).value;
        var elems = document.getElementsByClassName('CV' + kat);
        console.log("Filter: " + filter_elem);
        if (filter_elem == 'Alles') {
            for (var i = 0; i <= elems.length; i++) {
                elems[i].style.display = 'grid';
            }
            return;
        }
        var elems2 = document.getElementsByClassName('CV' + kat);
        for (var i = 0; i <= elems2.length; i++) {
            if (elems2[i] != undefined) {
                var _class = 'CV' + filter_elem.trim();
                console.log(_class);
                if (hasClass(elems2[i], _class)) {
                    elems2[i].style.display = 'grid';
                } else {
                    console.log('hide: ' + _class)
                    elems2[i].style.display = 'none';
                }
            }
        }
    }
    function filter(kat) {
        var viewId = document.getElementById('viewId').value;
        console.log('View Id: ' + viewId);
        if (viewId == 1) {
            _filter(kat);
        }
        if (viewId == 2) {
            _filterCV(kat);
        }
    }
    function setCat(cat) {
        //alert("CAT :" + cat);
        //document.getElementById('hiddenActivmainTab').value = cat;
    }
    function setSubCat(cat, catndx) {
        console.log("SubCat" + cat + " " + catndx);
        var inp = $('input[id="hiddenActivsubTabIndex"]');
        inp.val(catndx);
        var inp2 = $('input[id="hiddenActivsubTabName"]');
        inp2.val(cat);
    }
    function setSubSubCat(catndx) {
        console.log("SUBSUB:" + catndx);
        var inp = $('input[id="hiddenActivsubsubTabIndex"]');
        inp.val(catndx);
    }
    function activateTabsAfterUpload1(param) {
        //alert('OK' + param);
        var maintab = document.getElementById('hiddenActivmainTab1').value;
        var maintabIndex = document.getElementById('hiddenActivmainTabIndex').value;
        var subtabIndex = document.getElementById('hiddenActivsubTabIndex').value;
        var subtabName = document.getElementById('hiddenActivsubTabName').value;
        var subsubtabIndex = document.getElementById('hiddenActivsubsubTabIndex').value;
        if (maintab == 0) {
            return;
        }
        console.log("main:" + maintab + " maintabIndex:" + maintabIndex + " maintabIndex:" + maintabIndex + " subtabName:" + subtabName + " subsubtabIndex:" + subsubtabIndex);
        $("#tabs").tabs({
            disabled: 0
        });
        $("#tabs").tabs({
            active: maintabIndex
        });
        var mainTabName = "#tabs-" + maintab;
        console.log("maintab:" + mainTabName);
        $(mainTabName).tabs({
            disabled: 0
        }); //subtract one because zero-based
        $(mainTabName).tabs({
            active: subtabIndex
        }); //subtabIndex  subtract one because zero-based
        var sT = "#" + subtabName;
        console.log("ABCsT:" + sT);
        $(sT).tabs({
            disabled: 0
        }); //subtract one because zero-based
        console.log(subsubtabIndex);
        $(sT).tabs({
            active: subsubtabIndex
        }); // subsubtabIndex subtract one because zero-based
    }
    $(function() {
        //alert("Ready");
        activateTabsAfterUpload1(1);
        //alert("Ready Reeady");
    });
    function validatedelete() {
        if (confirm("Datei wirklich löschen?") == true) {
            return true;
        }
        return false;
    }
    function showDeleted() {
        //alert("gelöschte Uploads werden jetzt angezeigt");
        const elems = document.getElementsByClassName('fileDeleted');
        //console.log(elems);
        for (var i = 0; i < elems.length; i++) {
            //console.log(elems[i]);
            elems[i].classList.add("fileShowDeleted");
            elems[i].classList.remove("fileDeleted");
        }
    }
    function hideDeleted() {
        //alert("gelöschte Uploads werden jetzt nicht mehr angezeigt");
        const elems = document.getElementsByClassName('fileShowDeleted');
        //console.log(elems);
        for (var i = 0; i < elems.length; i++) {
            //console.log(elems[i]);
            elems[i].classList.add("fileDeleted");
            elems[i].classList.remove("fileShowDeleted");
        }
    }
    function showFileGrid(gridno) {
        console.log('Umschalten nach: ' + gridno);
        var viewId = document.getElementById('viewId');
        viewId.value = gridno;
        var nameShow = "";
        var nameHide = "";
        if (gridno == 1) {
            nameShow = "FileGrid1";
            nameHide = "FileGrid2";
        }
        if (gridno == 2) {
            nameShow = "FileGrid2";
            nameHide = "FileGrid1";
        }
        var elems = document.getElementsByName(nameHide);
        for (let i = 0; i < elems.length; i++) {
            elems[i].style.display = 'none';
        }
        elems = document.getElementsByName(nameShow);
        for (let i = 0; i < elems.length; i++) {
            elems[i].style.display = '';
        }
        elems = document.getElementsByName('FileGridContainer');
        for (let i = 0; i < elems.length; i++) {
            if (gridno == 1) {
                //elems[i].style.width = "72%";
            }
            if (gridno == 2) {
                //elems[i].style.width = "72%";
            }
        }
    }
    function uploadDouble(kat) {
        var id = 'file' + kat;
        const fileInput = document.getElementById(id);
        var ppidElem = document.getElementsByName('ppid')[0];
        var ppid = ppidElem.value;
        const selectedFiles = fileInput.files;
        var f =[];
        for (let i = 0; i < selectedFiles.length; i++) {
            f.push(selectedFiles[i].name);
        }
        //alert(kat);
        $.ajax({
            async:false,
            type: 'POST',
            url: '/existFilesSharepoint',
            data: { 'files': f,
                    'ppid': ppid
                  } ,
            success: function(result) {
                if (result.error == "true") {
                    alert("An error occurred: " & result.errorMessage);
                    document.getElementById('ver_'+kat).value =  0;
                    return;
                } else {
                    //alert('Dateien wurden schon hochgeladen!');
                    //console.log (result.errorMessage);
                    var r = JSON.parse(result);
                    var retval = r['ReturnValue']; 
                    var listFiles = r['FilesExists'];
                    var kats = r['Kats'];
                    //console.log(result);
                    //console.log(retval);
                    //console.log(listFiles);
                    //console.log('KATS');
                    if (retval){
                        var fns = '';
                        for (let i = 0; i < listFiles.length; i++) {
                                fns = fns + listFiles[i] + '  ['+ kats[i]['Kat'] + '/'+ kats[i]['SubKat'] + ']\n';
                        }
                        fns = fns + '\nDateien sind schon vorhanden. Überschreiben?';
                        var answer = window.confirm(fns, 'Ja', 'Nein');
                        if (answer) {
                            //testDbl.value = 'OK';
                            alert ('Dateien werden überschrieben!');
                            document.getElementById('ver_'+kat).value =  1;
                            return;
                        } else {
                            var answer2 = window.confirm('Neue Version?');
                            if (answer2){
                                var verid = 'ver_'+kat;
                                var idver = document.getElementById(verid);
                                alert ('Dateien werden versioniert!');
                                idver.value = 99;
                                document.getElementById('ver_'+kat).value =  2;
                                return;
                            } else {
                                alert ('Dateien werden NICHT hochgeladen!');
                                document.getElementById('ver_'+kat).value =  0;
                                return;
                            }
                        }
                   } else {
                    document.getElementById('ver_'+kat).value =  1;
                   }
                }
            }
        });
        return;
        //document.getElementById('testDbl'+kat).value =  'E'; 
    }
</script>