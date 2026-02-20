<script>
  $( function() {
    $( "#menu" ).menu();
  } );
   $( function() {
    $( "#menuFiles" ).menu();
  } );
  </script>
  <style>
    .ui-menu { width: 189px; }
    .FileContainer {
        float:left; 
        width:calc(100% - 10px); 
        border:none;
        --height:95%;
        overflow:auto;
    }
    .hidden { 
        display:none;
    }
    #FileDetails {
        display:grid;
        grid-template-columns: 20% 80%;
    }
    #FileDetails div {
        border:1px solid lightgray;
        padding:8px;
    }
    .fileIcons {
        margin-left:20px;
        margin-right:20px;
        height:24px;
    }
    .fileLabel {
        border:1px solid darkgray;
        background-color:lightgray;
        font-weight:bold;
    }
    #ovUpload {
        position: fixed; /* Sit on top of the page content */
        width: 100%; /* Full width (cover the whole page) */
        height: 100%; /* Full height (cover the whole page) */
        top: 0;
        left: 0;
        background-color: rgba(0,0,0,0.5); /* Black background with opacity */
        z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
        cursor: pointer; /* Add a pointer on hover */
        padding:20%;
    }
     #ovUpload .tbl{
        border-collapse:collapse;
        width:100%;
     }
     #ovUpload .label{
        border:1px solid gray;
        background-color:lightgray;
        color:darkblue;
        padding:8px;
        vertical-align:top;
        width:35%;
     }   
     #ovUpload .value{
        border:1px solid lightgray;
        padding:8px;
        width:55%;
     }
    #ovUpload .valuep0 {
        border:1px solid lightgray;
        padding:0px; 
     }
  </style>
  <?php
    $lang = $data['lang'];
    $ord = $data['Kategorien'];
    $ordText = array();
    foreach ($ord as $ok => $ot){
        foreach($ot as $oo){
            $ordText [$ok][] = ServiceProvider::tl($lang, $oo ) ;
        }
    }
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
?> 
<div id='ovUpload' class='hidden' style=''>
    <div style='padding:10px; background-color:white;color:darkgray;border:2px solid gray; width:60%;height:280px;'>
        <h5>Datei-Upload</h5>
        <form action="/uploadFilesNew" method="post" enctype="multipart/form-data" style='width:100%;'>
            <input type='hidden' id='ppidUpl'/>
            <input type='hidden' id='typeUpl'/>
            <input type='hidden' id='katUpl' />
            <table class='tbl'>
                <tr>
                    <td class='label'>{{ ServiceProvider::tl($lang,'Dateien')}}</td>
                    <td class='value'><input id="fileUpl" name="fileUpl[]" type="file" multiple/><td>
                </tr>
                <tr>
                    <td class='label'>{{ ServiceProvider::tl($lang,'Bemerkung') }}</td>
                    <td class='valuep0'><textarea id='bemerkungUpl' style='width:calc(100% - 4px);height:100px;margin:0;border:none;padding:10px;' name="bemerkungUpl"></textarea></td>
                </tr>
                <tr>
                    <td  class='label'>{{ ServiceProvider::tl($lang,'Kategorie') }}</td> 
                    <td  class='valuep0'><select style='width:100%;height:30px;margin:0px;' name="ordnungUpl" id="ordnungUpl"></select></td>
                </tr>
                <tr>
                <td></td>
                    <td style='padding:10px;'><button type='button' id='btn_upload' style='width:50%;height:40px;'><b>Upload</b></button><button type='button' style='margin-left:50px;height:40px;width:20%;color:darkgray;' onclick='closeUpload();'>{{ ServiceProvider::tl($lang,'schliessen') }}</button></td>
                </tr>
            </table>
        </form>
        <br>
        <br>
        <div id='messageUpl'  style='display:none;width:calc(100% - 20px);height:100px;margin-top:20px;padding:10px; border:2px solid darkgray;background-color: rgba(0,0,0,0.5); position:relative;bottom:0px;left:0px;'>
            <span style='color:white;font-size:1.2em;fon-weight:bold;'>{{ ServiceProvider::tl($lang,'Upload der Dateien gestartet! Bitte warten bis Dialog geschlossen wird.') }}</span>
        </div>
    </div>
</div>
<div style='float:left;'>
    <ul id="menuFiles">
    @foreach ( $data['files']['types'] as $type)
        <li><div  class='parent' id='{{$type['Type']}}' >{{ ServiceProvider::tl($lang, $type['Type'] )}}</div>
        <ul>
         @foreach($data['files']['subtypes'] as $kat)
            @if ($kat['ParentId'] == $type['Id'])
          <li><div class='child' id='{{ServiceProvider::noBlanks($kat['Kategorie'])}}'>{{ ServiceProvider::tl($lang, $kat['Kategorie'] )}}</div></li>
          @endif
         @endforeach
        </ul>
        </li>
    @endforeach
    </ul>
</div>
<div id="FilesParent" style='float:left;border:1px solid lightgray;width:80%;min-height:600px;overflow:auto;height: calc(100% - 50px);'>
    @foreach ( $data['files']['types'] as $type)
        @foreach($data['files']['subtypes'] as $kat)
            @if ($kat['ParentId'] == $type['Id'])
                <div class='FileContainer hidden' id='cont_{{ ServiceProvider::noBlanks($kat['Kategorie']) }}'>
                    <div style='Border:1px solid lightgray;'>
                        <div style='width:calc(100% - 26px);padding:8px;background-color:lightgray;'><b>{{$type['Type']}}</b> [{{$kat['Kategorie']}}]</div>
                        <div style='width:calc(100% - 26px);padding:8px;'>
                        @if(isset($ord[$kat['Kategorie']]))
                            <div style="width:100%;border: 1px solid lightgray;padding:6px;border-radius:0px;">
                                Filter: <select id="FilterOrdnung{{ServiceProvider::noBlanks($kat['Kategorie'])}}" name="Ordnung" style="width:380px;padding:4px;border:1px solid gray;">
                                            <option value='Alles'>{{ ServiceProvider::tl($lang, 'Alles')}}</option>
                                            @foreach ($ord[$kat['Kategorie']] as $o)
                                            <option value='{{ $o }}'>{{ ServiceProvider::tl($lang, $o )}}</option>
                                            @endforeach
                                        </select>
                                <button type="button" style="padding:6px;" onclick="filter('{{ServiceProvider::noBlanks($kat['Kategorie'])}}');"><b>{{ ServiceProvider::tl($lang, 'Filtern' )}}</b></button>
                                <?php 
                                    $param = array( 'PPId'    => $data['pp']->PPProduktpass_Id, 
                                                    'Kat'     => $kat['Kategorie'], 
                                                    'Type'    => $type['Type'], 
                                                    'OrdnungText' => $ordText,
                                                    'Ordnung' => $ord);
                                    $jParams = json_encode($param);
                                ?> 
                                <button type="button" style="padding:6px;" onclick='openUpload({{ $jParams }});'><b>Upload</b></button>
                            </div>
                        @endif
                        </div>
                    </div>
                    <div style='Border:1px solid gray;overflow:auto;max-height: calc(100% - 120px);'>
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
                            ?>
                        @if ($file['PPPPFiles_Type'] == $type['Type'] and  $file['PPPPFiles_SubKat'] == $kat['Kategorie'])
                        <div id='File_{{$file['PPPPFiles_Id']}}' style='border:none;width:calc(100% - 4px);float:left;border:none;'>
                            <div name="{{ServiceProvider::noBlanks($file['PPPPFiles_SubKat'])}}_{{$file['PPPPFiles_Ordnung']}}" class='' style="border:none;padding-top:10px;padding-left:10px; margin-bottom: 10px;position:relative;">
                                {{Form::open(array('url' => 'updateRemarkFiles', 'method' => 'POST', 'files' => 'true', 'data-ajax' => 'true'))}}
                                    <input type="hidden" name="fileid" id="fileid" value="{{$file['PPPPFiles_Id']}}">
                                    <input type="hidden" name="ppid" id="hiddenActivmainTab" value="{{$data['pp']['PPProduktpass_Id']}}">
                                    <div id="FileDetails" style="border:none; ">
                                        <div  class='fileLabel'  >{{ ServiceProvider::tl($lang,'Hochgeladen am')}}:</div>
                                        <div>{{date_format(date_create_from_format('Y-m-d H:i:s',$file['PPPPFiles_Date']),'d.m.Y H:i')}}  @if (is_null($file['PPPPFiles_SharePointLink'])) NO-SPO @endif</div>
                                        <div  class='fileLabel'  >{{ ServiceProvider::tl($lang,'Letzte Änderung SPO')}}:</div>
                                        <div>{{$lc}}</div>
                                        <div  class='fileLabel'  >{{ ServiceProvider::tl($lang,'Kategorie')}}:</div>
                                        <div>
                                            @if(isset($ord[$kat['Kategorie']]))
                                                <select id="OrdnungSub_{{ $file['PPPPFiles_Id'] }}" name="OrdnungSub" style="width:220px;padding:4px;margin-left:0px;">
                                                    @foreach ($ord[$kat['Kategorie']] as $o)
                                                    <option @if( trim($file['PPPPFiles_Ordnung']) == trim($o) ) selected @endif value='{{ $o }}'>{{ ServiceProvider::tl($lang, $o )}}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                        @if (strlen($file['PPPPFiles_Link']) > 0 )
                                            <div class='fileLabel'  >Link: </div>
                                            <div><a href="{{ $file['PPPPFiles_Link'] }}" target="_blank">{{ $file['PPPPFiles_LinkName'] }}</a></div>
                                        @else 
                                            <div class='fileLabel' style="height:170px;">{{ ServiceProvider::tl($lang,'Dateiname')}}:</div>
                                            <div style="overflow:auto;height:170px;">
                                                <div style='float:left;border:1px solid lightgray;float:left;height:146px; padding:0px;overflow:hidden;position:relative;'>
                                                    @if (strtoupper(substr($file['PPPPFiles_Name'],-4)) == '.JPG' || strtoupper(substr($file['PPPPFiles_Name'],-5)) == '.JPEG' || strtoupper(substr($file['PPPPFiles_Name'],-4)) == '.PNG'|| strtoupper(substr($file['PPPPFiles_Name'],-4)) == '.GIF' )
                                                        <div style="border:none;padding:0px;height:calc(100% - 20px); ">
                                                            @if($isSharepoint)
                                                                <a href="{{  ViewController::getSpoLink($file['PPPPFiles_Id'],1) }}" download="{{ViewController::getSpoDLName($file['PPPPFiles_Id'],1)}}" target="_blank">
                                                                    <img src="{{url($dllogo)}}" style="height:90%;width:auto;border:none;">
                                                                </a>
                                                            @else 
                                                                @if ($type['Type'] == 'PPUpload')
                                                                    <a href="{{$server.'/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_TPTFilenameOld']}}" download="{{$file['PPPPFiles_TPTFilenameOld']}}" target="_blank">
                                                                        <img src="url($spo_file)" style="height:90%;width:auto;border:none;">
                                                                    </a>
                                                                @else
                                                                    <a href="{{$server.'/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_TPTFilenameOld']}}" download="{{substr($file['PPPPFiles_TPTFilenameOld'],7)}}" target="_blank">
                                                                        <img src="{{$server.'/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_TPTFilenameOld']}}" style="height:90%;width:auto;border:none;" />
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
                                                                <button style="border:none;width:100%;padding:10px;margin:0;opacity: 0.8;font-size:0.7rem;" type="submit" value="als Projektbild festlegen">{{ ServiceProvider::tl($lang,'als Projektbild festlegen')}}</button>
                                                            </form>
                                                        </div>
                                                    @else
                                                        @if ($type['Type'] == 'PPUpload')
                                                            <a href="{{ViewController::getSpoLink($file['PPPPFiles_Id'],1)}}" target="_blank" download="{{$file['PPPPFiles_Name']}}">
                                                        @else
                                                            <a href="{{ViewController::getSpoLink($file['PPPPFiles_Id'],1)}}" target="_blank" download="{{substr($file['PPPPFiles_Name'],7)}}">
                                                        @endif
                                                        @if (strlen($dllogo)> 10)
                                                            <img src="{{$dllogo}}" alt="Datei" style="height:80%;border:none;" />
                                                        @else
                                                            {{substr($file['PPPPFiles_Name'],7)}}
                                                        @endif
                                                        </a>
                                                        @if ($ext == 'xml')
                                                            <div style="width:98px; text-align:center; position:absolute;bottom:0px;left:0;padding:4px;margin:0;border-top:1px solid lightgray;border-top:1px solid lightgray;">
                                                                    <a href='{{url("/diffXML/".$data['pp']['PPProduktpass_Id']."/".$file['PPPPFiles_Id'])}}' target='_blank' style='color:gray;text-decoration:none;'>vergleichen</a>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                                <div style='border:none;float:left;height:(100% - 20px);width:80%;padding:0px;position:relative;'>
                                                    @if(strlen($file['PPPPFiles_SharePointLink'])>0)
                                                        <div style='padding:5px;border:1px solid lightgray;'>{{ $file['PPPPFiles_Name'] }}
                                                        <div style="position: absolute;top:0px;right:0;padding:0px;margin:0;">
                                                           <button style="width:20px;padding:0px;margin:0;height:20px;background-color:red;color:white;border:none;" title="{{ ServiceProvider::tl($lang,'Datei löschen!')}}" type="button" onclick="deleteFile('{{$file['PPPPFiles_Id']}}');"><b>X</b></button>
                                                        </div>
                                                        </div>
                                                        <div style='padding:5px;border:1px solid lightgray;'>
                                                            <a href="{{ ViewController::getSpoLink($file['PPPPFiles_Id'], 2) }}" target="blank"><img src="{{url('/data/Icons/Download.jpg')}}" class='fileIcons' />DOWNLOAD</a>
                                                        </div>
                                                        <div style='padding:5px;border:1px solid lightgray;'>
                                                            <a href="{{ ViewController::getSpoLink($file['PPPPFiles_Id'], 1) }}" target="blank"><img src="{{url('/data/Icons/OpenInBrowser.jpg')}}" class='fileIcons' />{{ ServiceProvider::tl($lang,'Öffnen im Browser')}}</a>
                                                        </div>
                                                        @if ($showEdit2)
                                                            <div style='padding:5px;border:1px solid lightgray;'>
                                                                <a href="{{ ViewController::getSpoLink($file['PPPPFiles_Id'], 3) }}" target="blank"><img src="{{url('/data/Icons/OpenInApp.jpg')}}" class='fileIcons' />{{ ServiceProvider::tl($lang,'Öffnen in App (wenn hinterlegt)')}}</a>
                                                            </div>
                                                        @endif
                                                    @else
                                                        @if ($type['Type'] == 'PPUpload')
                                                            {{ $file['PPPPFiles_Name'] }}
                                                        @else
                                                            {{ substr($file['PPPPFiles_Name'],7) }}
                                                        @endif<br>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        <div  class='fileLabel'  style="height:84px;">{{ ServiceProvider::tl($lang,'Bemerkung')}}:</div>
                                        <div style="padding:0px;height:100px;position:relative;">
                                            <textarea name="TA" style="border-radius:0px;border:none;width:calc(100% - 20px);height:calc(100% - 22px);padding:10px;" id="textarea-container_{{$file['PPPPFiles_Id']}}">{{$file['PPPPFiles_Description']}}</textarea>
                                            <div style="position:absolute; bottom:0; right:0;border:none;margin:0;padding:0;"><button style="width:150px;padding:10px;margin:0;" type="button" value="Bemerkung ändern"  onclick="saveRemark({{$file['PPPPFiles_Id']}});"><b>{{ ServiceProvider::tl($lang,'Änderungen speichern')}}</b></button></div>
                                        </div>
                                    </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach
</div>
<script>
    var lang = "{{ $data['lang'] }}";
    var delFile = 'Datei wirklich löschen?';
    if (lang = 'EN'){
        delFile = 'Realy delete this File?';
    }
    $('.parent').click(function(evt){
        ////console.log('Parent: ' + this.id );  
    })
    $('.child').click(function(evt){
        hideAll();
        var elem = document.getElementById('cont_' + this.id);
        //elem.className += " otherclass";
        //console.log(elem.classList);
        elem.classList.remove("hidden");
        //console.log('Cild: ' + this.id );  
    })
    function hideAll (){
        const parentDiv = document.getElementById('FilesParent'); 
        const childElements = parentDiv.children; 
        const childArray = Array.from(childElements); 
        //console.log(childArray); 
        for (var i = 0; i < childArray.length; i++) {
            //console.log('Div Id: ' + childArray[i].id);
            childArray[i].classList.add("hidden");
            //Do something
        }
    }
    function _filterOld(kat) {
        var filter_elem = document.getElementById('FilterOrdnung' + kat).value;
        //alert(filter_elem);
        var name1 = 'fileSub_' + filter_elem;
        //var elems = document.getElementsByName(name1);
        /* var elems = document.querySelectorAll('[name^="fileSub"]');
        console.log(elems);
        if (filter_elem == 'Alles') {
            for (var i = 0; i <= elems.length; i++) {
                console.log(elems[i].name);
                elems[i].style.display = 'grid';
            }
            return;
        } */
        var elems2 = document.getElementsByClassName('fileSub_' + kat);
        for (var i = 0; i <= elems2.length; i++) {
            if (elems2[i] != undefined) {
                console.log(elems2[i]);
                if (hasClass(elems2[i], filter_elem.trim())) {
                    elems2[i].style.display = 'grid';
                } else {
                    elems2[i].style.display = 'none';
                }
            }
        }
    }
    function _hide(kat) {
        //alert(kat);
        var elems = document.querySelectorAll("[name^='" +kat + "']");
        console.log('_hide');
        console.log(elems);
        for (var i = 0; i <= elems.length; i++) {
            //console.log(elems[i].name);
            if (elems[i] != undefined) {
                elems[i].classList.add("hidden");
            }
        }
    } 
    function _show(kat) {
        //alert(kat);
        var elems = document.querySelectorAll("[name^='" +kat + "']");
        for (var i = 0; i <= elems.length; i++) {
            //console.log(elems[i].name);
            if (elems[i] != undefined) {
                elems[i].classList.remove("hidden");
            }
        }
    } 
    function _filter(kat) {
        _hide(kat);
        //var filter_elem = document.getElementById('FilterOrdnung' + kat).value;
        //var elemX = '#FilterOrdnung' + kat + ' option:selected';   // Option um den Text zu erhalten
        //var filter_elem = $(elemX).text();
        var elemX = '#FilterOrdnung' + kat ;   // Option um den Wert zu erhalten
        var filter_elem = $(elemX).val();
        //alert('Filter: ' + filter_elem);
        if (filter_elem == 'Alles'){
            _show(kat);
            return;
        }
        var name1 = kat + '_' + filter_elem;
        //console.log(name1); 
        var elems2 = document.getElementsByName(name1);
        //console.log(elems2);
        for (var i = 0; i <= elems2.length; i++) {
            if (elems2[i] != undefined) {
                //console.log(elems2[i].name);
                //elems2[i].style.display = 'grid';
                elems2[i].classList.remove("hidden");
            }
        }
    }
    function _filterCV(kat) {
        var filter_elem = document.getElementById('FilterOrdnung' + kat).value;
        var elems = document.getElementsByClassName('CV' + kat);
        //console.log("Filter: " + filter_elem);
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
                //console.log(_class);
                if (hasClass(elems2[i], _class)) {
                    elems2[i].style.display = 'grid';
                } else {
                    //console.log('hide: ' + _class)
                    elems2[i].style.display = 'none';
                }
            }
        }
    }
    function filter(kat) {
        var viewId =  1; //document.getElementById('viewId').value;
        //console.log('View Id: ' + viewId);
        if (viewId == 1) {
            _filter(kat);
        }
        if (viewId == 2) {
            _filterCV(kat);
        }
    }
    function removeOptions(selectElement) {
        var i, L = selectElement.options.length - 1;
        for(i = L; i >= 0; i--) {
            selectElement.remove(i);
        }
    }
    function openUpload(jParams){
        //alert('openUpload');
        //console.log(jParams);
        var ppid = jParams.PPId;
        var kat = jParams.Kat;
        var type = jParams.Type;
        var Ordnung1 = jParams.Ordnung;
        var OrdnungText = jParams.OrdnungText;
        var selectO = Ordnung1[kat];
        var selectV = OrdnungText[kat];
        //for(var k in selectO){
        //    console.log(selectO[k]);
        //}
        var elem = document.getElementById('ovUpload');
        elem.classList.remove("hidden");
        //elem = document.getElementById('uploadType');
        //elem.innerHTML = 'Type: '+ uplType + ' Kategorie: ' + uplKat;    
        var selectElement = document.getElementById('ordnungUpl');
        removeOptions(selectElement);
        selectElement.add(new Option(''));
        for(var k in selectO){
            selectElement.add(new Option(selectV[k], selectO[k]));
        }
        var ppidElement = document.getElementById('ppidUpl');
        var typeElement = document.getElementById('typeUpl');
        var katElement = document.getElementById('katUpl');
        katElement.value = kat;
        typeElement.value = type;
        ppidElement.value = ppid;
    } 
    function readValue(id){
       console.log(id);
       var elem = document.getElementById(id);
       if (elem){
           console.log('Wert: ' +  elem.value);
            return elem.value;
       }
       console.log('Kein Wert');
       return '';
    }
    function closeUpload(){
        var elem = document.getElementById('ovUpload');
         elem.classList.add("hidden");
    }
    function closeMessage(){
        var elem = document.getElementById('messageUpl');
         elem.classList.add("hidden");
    } 
    function openMessage(){
        var elem = document.getElementById('messageUpl');
         elem.classList.remove("hidden");
    }
    $(document).ready(function() { 
        $("#btn_upload").click(function() { 
            //console.log('Upload in progress!');
            //alert('Upload in progress!');
            var fd = new FormData(); 
            var files = $('#fileUpl').prop("files");
            jQuery.each(jQuery('#fileUpl')[0].files, function(i, file) {
                 fd.append('file_'+i, file);
            });
            var ppid = readValue('ppidUpl');
            var type = readValue('typeUpl');
            var kat = readValue('katUpl');
            var ord = readValue('ordnungUpl');
            if (ord == '' ){
                alert('Bitte Kategorie angeben!');
                return;
            }   
            var bemerkung = readValue('bemerkungUpl');
            console.log('30% : ' + ppid + type + kat + ord );
            //fd.append('file', files);
            fd.append('ppid', ppid);
            fd.append('type', type);
            fd.append('kat', kat);
            fd.append('ord', ord);
            fd.append('bemerkung', bemerkung);
            document.getElementById('messageUpl').style.display = 'inline';
            //closeUpload();
            $.ajax({ 
                url: '/uploadFilesNew', 
                type: 'post', 
                data: fd, 
                contentType: false, 
                processData: false, 
                success: function(response){ 
                    if(response != 0){ 
                        //alert('file uploaded'); 
                        closeUpload();
                        initFiles();
                        //alert ('https://tpt-dev.ad.targa.de/showNeu/'+ ppid + '/' + lang );
                        //window.location.href = 'https://tpt-dev.ad.targa.de/showNeu/'+ ppid + '/' + lang ;
                    } 
                    else{ 
                        alert('file not uploaded'); 
                    } 
                }, 
            }); 
        }); 
    }); 
    function validatedelete() {
        if (confirm(delFile) == true) {
            return true;
        }
        return false;
    }
    function saveRemark(fid){
        //console.log('File_Id: ' + fid);
        var url = '/updateRemarkFilesAjax';
        var remark = $('#textarea-container_'+fid).val();
        var OrdnungSub = $('#OrdnungSub_' + fid).val();
        var data = {    fileid:fid,
                        remark:remark,
                        OrdnungSub:OrdnungSub };
        //console.log (data);
        $.ajax({
            url:url,    //the page containing php script
            type: "post",    //request type,
            dataType: 'json',
            data: data,
            success:function(data){
                console.log(data);
                alert('Datensatz gespeichert!');
            }
        });
    }
    function deleteFile(fid){
        if (!validatedelete()){
            return;
        }
        console.log('File_Id: ' + fid);
        var url = '/deleteFileNeu';
        var data = {    fileid:fid  };
        $.ajax({
            url:url,    //the page containing php script
            type: "post",    //request type,
            dataType: 'json',
            data: data,
            success:function(data){
                console.log(data);
                alert('Datensatz gelöscht!');
                var delElem = document.getElementById('File_' + fid);
                delElem.classList.add('hidden');
                //window.location.href('https://tpt-dev.ad.targa.de/showNeu/'+ ppid + '/' + lang + '#Dateien');
            }
        });
    }
    function initFiles(){
        var tabid = 'Dateien';
        var inParams = {
                        tabid: tabid,
                        ppid: "{{ $data['pp']->PPProduktpass_Id }}",
                        lang: "{{ $data['lang'] }}"
                    };
                    //alert(JSON.stringify(inParams));
                    var params = JSON.stringify(inParams);
                    //alert(tabid);
                    $.ajax({
                        type: "POST",
                        url: "/content",
                        data: inParams,
                        success: function(data) {
                            console.log('Return: ' + tabid);
                            console.log(data);
                            var t = '#' + tabid;
                            $(t).html(data);
                        }
                    });
    }
    function diffXML(ppid, fid){
       alert('ppid: ' + ppid + ' fid: ' + fid);
    }
</script>