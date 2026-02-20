<style>
    .container {
        width: 530px;
        border: 1px solid lightgray;
        text-align: center;
        margin: 0 auto;
    }


    .box {
        font-size: 1.25rem;
        /* 20 */
        background-color: orange;
        color: white;
        position: relative;
        padding: 10px;
    }

    .box.has-advanced-upload {
        outline: 2px dashed darkblue;
        outline-offset: -10px;

        -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
        transition: outline-offset .15s ease-in-out, background-color .15s linear;
    }

    .box.is-dragover {
        outline-offset: -20px;
        outline-color: #c8dadf;
        background-color: #fff;
    }

    .box__dragndrop,
    .box__icon {
        display: none;
    }

    .box.has-advanced-upload .box__dragndrop {
        display: inline;
    }

    .box.has-advanced-upload .box__icon {
        width: 200px;
        height: 80px;
        fill: #92b0b3;
        border: 5px solid pink;
        display: block;
        margin-bottom: 40px;
    }

    .box.is-uploading .box__input,
    .box.is-success .box__input,
    .box.is-error .box__input {
        visibility: hidden;
    }

    .box__uploading,
    .box__success,
    .box__error {
        display: none;
    }

    .box.is-uploading .box__uploading,
    .box.is-success .box__success,
    .box.is-error .box__error {
        display: block;
        position: absolute;
        top: 50%;
        right: 0;
        left: 0;

        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
    }

    .box__uploading {
        font-style: italic;
    }

    .box__success {
        -webkit-animation: appear-from-inside .25s ease-in-out;
        animation: appear-from-inside .25s ease-in-out;
    }

    @-webkit-keyframes appear-from-inside {
        from {
            -webkit-transform: translateY(-50%) scale(0);
        }

        75% {
            -webkit-transform: translateY(-50%) scale(1.1);
        }

        to {
            -webkit-transform: translateY(-50%) scale(1);
        }
    }

    @keyframes appear-from-inside {
        from {
            transform: translateY(-50%) scale(0);
        }

        75% {
            transform: translateY(-50%) scale(1.1);
        }

        to {
            transform: translateY(-50%) scale(1);
        }
    }

    .box__restart {
        font-weight: 700;
    }

    .box__restart:focus,
    .box__restart:hover {
        color: #39bfd3;
    }

    .box__file {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }

    .box__file+.clxlabel {
        width: 240px;
        height: 50px;
        text-overflow: ellipsis;
        white-space: nowrap;
        cursor: pointer;
        display: inline-block;
        overflow: hidden;
    }

    .box__file+.clxlabel:hover strong,
    .box__file:focus+.clxlabel strong,
    .box__file.has-focus+.clxlabel strong {
        color: #39bfd3;
    }

    .box__file:focus+.clxlabel,
    .box__file.has-focus+.clxlabel {
        outline: 1px dotted darkblue;
        outline: -webkit-focus-ring-color auto 5px;
    }

    .box__file+.clxlabel * {
        /* pointer-events: none; */
        /* in case of FastClick lib use */
    }

    .box__button {
        font-weight: 700;
        color: #e5edf1;
        background-color: #003049;
        display: block;
        padding: 8px 16px;
        margin: 40px auto 0;
    }

    .box__button:hover,
    .box__button:focus {
        background-color: #0f3c4b;
    }

    #FileGrid1 {
        padding:0px;
        display:grid;
        grid-template-columns: 515px 270px 154px;
        font-family: Arial, Helvetica, sans-serif;
       
        font-size: 12px;
    }
    #Filegrid1 div {
        border:1px solid lightgray;
        
        border-radius: 0px;
        padding:0px;
    }

    #FileGrid2 {
        padding:0px;
        
        border:none!important;
        border-radius: 0px;
       
    }
    #Filegrid2 div {
        border:1px solid lightgray;
        
        border-radius: 0px;
        padding:0px;
    }

    .fileDeleted {
        display: none !important;
    }
    .fileShowDeleted {
        display: inline-block !important;
    }

    .btnHide {
        width:200px;
        padding:8px;
        margin:5px;
    }

#FileProtokollTable th {
    text-align: left;
    padding: 5px;
}
</style>

<?php 
    $ord = $data['Kategorien']; 

    $compactView = "";
    $komplettView = "display:none;";
    $viewId = 1;
    
    $fgWidth='width:50%;';

    if (!$data['tabs']['compactView']){
        //$compactView = "display:none;";
        $compactView = "";
        $komplettView = "";
        $viewId = 1;
        $fgWidth='width:72%;';
    } 
    
?>


<div style="height:880px;border:1px solid lightgray;border-radius:5px;position:relative;">
        <input type="hidden" value ={{$viewId}} id="viewId" />
      <div id="tabContainer" style="border:none;height:875px;overflow: auto;">
        <div id="tabs2" style="border:1px solid none;">
            <ul>
                <?php $tbid      = 0; ?>
                @foreach ( $data['files']['types'] as $type)
                <li>
                    <a href="#{{$type['Type']}}" onclick="setSubCat('{{$type['Type']}}',{{$tbid++}});">{{$type['Type']}}</a>
                </li>
                @endforeach
                @if (Auth::user()->PPMitarbeiter_Gruppe == 'admin')
                <li>
                    <a href="#FileProtokoll">Datei-Protokoll</a>
                </li>
                @endif
            </ul>
            <?php $tabid     = 3; ?>
            @foreach ( $data['files']['types'] as $type)
            <div id="{{$type['Type']}}" style="height:830px;overflow:hidden;border:1px solid gray;">
                <?php $tabid++; ?>
                <div id="tabs{{$tabid}}">
                    <ul>
                        <?php $subcatndx = 0 ?>
                        @foreach($data['files']['subtypes'] as $kat)
                        @if ($kat['ParentId'] == $type['Id'])
                        <li>
                            <a href="#{{urlencode($kat['Kategorie'])}}"
                                onclick="setSubSubCat('{{$subcatndx++}}');">{{$kat['Kategorie']}}</a>
                        </li>
                        @endif
                        @endforeach
                    </ul>

                    @foreach($data['files']['subtypes'] as $kat)

                    @if ($kat['ParentId'] == $type['Id'])

                    <div id="{{urlencode($kat['Kategorie'])}}" style="float: left; width:100%;border: none;height: 780px; overflow: hidden;">
                    <div>
                        <button onclick="showFileGrid(1);" style='margin:0px; margin-bottom:6px;padding:6px;margin-right:10px;' >Komplett</button>
                        <button onclick="showFileGrid(2);" style='margin:0px; margin-bottom:6px;padding:6px;'>Kompakt</button>
                    </div>
                    <div name="FileGridContainer" style="min-width:1000px;{{$fgWidth}}border:none;float:left;height:720px;border-radius:0px;overflow:auto;">
                                @foreach($data['files']['files'] as $file)
                                    @if ($file['PPPPFiles_Type'] == $type['Type'] and $file['PPPPFiles_SubKat'] == $kat['Kategorie'] )
                                    <div id="FileGrid1" name="FileGrid1" style="{{$komplettView}}"  class="{{ $kat['Kategorie'] }} {{ trim($file['PPPPFiles_Ordnung']) }} @if($file['PPPPFiles_Status'] == 0) fileDeleted @endif "   >
                                        <!-- include('projects.pp_files_sub') -->
                                    

                                        
                                    </div>
                                    <div id="FileGrid2"  name="FileGrid2" style="{{$compactView}}"  class="CV{{ $kat['Kategorie'] }} CV{{ trim($file['PPPPFiles_Ordnung']) }} @if($file['PPPPFiles_Status'] == 0) fileDeleted @endif "   >
                                        @include('projects.pp_files_sub_liste')
                                    </div> 
                                    @endif
                                @endforeach
                        </div>
                        <div style="margin:0 auto;float: left; width:460px;border:none;height:780px;position: relative;">
                            
                            
                            @if(isset($ord[$kat['Kategorie']]))
                            <div>
                               
                               <div style="width: 450px;padding:10px;"> <h3>Filterfunktionen</h3>
                                    <form>
                                    
                                       <fieldset> <label>Kategorie:
                                            <select id="FilterOrdnung{{ $kat['Kategorie'] }}" name="Ordnung" style="width:380px;padding:4px;" >
                                                <option>Alles</option>
                                                @foreach ($ord[$kat['Kategorie']] as $o)
                                                <option>{{ $o }}</option>
                                                @endforeach
                                            </select>
                                        </label><br>
                                        <label><button type="button" style="padding:10px;width:380px;" onclick="filter('{{ $kat['Kategorie'] }}');"><b>Filtern</b></button></label></fieldset>
                                    </form>
                                </div>
                            </div>
                            @endif
                            
                            
                            <!-- div style="margin-top:-20px;">
                                <div style="width: 450px;padding:10px;"> <h3>Massen Download/Mailversand</h3>
                               
                                    <form>
                                        <fieldset>
                                            <div style="line-height:28px;padding-left:4px;">

                                                <span style="vertical-align:middle;"><b>e-mail:</b></span> <input id="mail_{{$kat['Kategorie']}}" style="vertical-align:middle;width:35px;border-radius:0px;" type="checkbox" checked/>
                                                <span style="vertical-align:middle;" ><b>an:</b></span> <input id="mailto_{{$kat['Kategorie']}}" style="width:120px;border-radius:0px;" value="{{Auth::user()->PPMitarbeiter_email}}" /> 
                                                <span style="vertical-align:middle;"><b>Zip:</b></span> <input id="zip_{{$kat['Kategorie']}}" style="vertical-align:middle;width:35px;border-radius:0px;" type="checkbox" checked />
                                                <span style="vertical-align:middle;"><b>DL:</b></span> <input id="download_{{$kat['Kategorie']}}" style="vertical-align:middle;width:35px;border-radius:0px;" type="checkbox" />
                                            </div>
                                            <button type="button" style="padding:10px;width:180px;" onclick='alleMarkieren("{{$kat['Kategorie']}}");'><b>Alle</b></button>
                                            <button type="button" style="padding:10px;width:180px;" onclick='selectFiles("{{$kat['Kategorie']}}");'><b>Ausführen</b></button>
                                        </fieldset>
                                    </form>
                                </div>
                            </div -->

                            <div style="position: absolute; bottom: 10px;border:none;width: 450px;padding:10px;">
                                <h3>Upload</h3>
                            {{-- Form::open(array('id'=>$kat['Kategorie'],'url'=>'uploadFiles','method'=>'POST','files'=>'true','name'=>'UplD','enctype'=>"multipart/form-data",'style'=>'margin:0auto;')) --}}
                            <form name="UplD"  id="{{  $kat['Kategorie'] }}" action="/uploadFiles" method="post" enctype="multipart/form-data"  style="margin: 0 auto;" onsubmit="return validateUpload('{{ $kat['Kategorie'] }}')">
                                {{Form::hidden('ppid',$data['pp']['PPProduktpass_Id'])}}
                                {{Form::hidden('Kategorie',$kat['Kategorie'])}}
                                {{Form::hidden('filetype',$type['Type'])}}
                                <?php 
                                    if (is_null($data['tabs']['subTabName']) or strlen($data['tabs']['subTabName']) < 2 ){
                                        $data['tabs']['subTabName'] = 'EKPM';
                                    }
                                ?>
                                <input type="hidden" name="ActivmainTab" id="hiddenActivmainTab1" value="{{$data['tabs']['mainTab']}}">
                                <input type="hidden" name="ActivmainTabIndex" id="hiddenActivmainTabIndex" value="{{$data['tabs']['mainTabIndex']}}">
                                <input type="hidden" name="ActivsubTabIndex" id="hiddenActivsubTabIndex" value="{{$data['tabs']['subTabIndex']}}"> {{-- {{$data['tabs']['subTabIndex']}} --}}
                                <input type="hidden" name="ActivsubTabName" id="hiddenActivsubTabName" value="{{$data['tabs']['subTabName']}}"> {{-- {{$data['tabs']['subTabName']}} --}}
                                <input type="hidden" name="ActivsubsubTabIndex" id="hiddenActivsubsubTabIndex" value="{{$data['tabs']['subsubTabIndex']}}"> {{-- {{$data['tabs']['subsubTabIndex']}} --}}
    
                                {{--  Type:{{  $type['Type']  }}<br>
                                Kat: {{ $kat['Kategorie'] }}<br>
                                Pid: {{ $data['pp']['PPProduktpass_Id'] }}<br>
                                --}}
    
                               
                                
                                <fieldset>

                                    @if(isset($ord[$kat['Kategorie']]))
                                    <label>Kategorie:
                                        <select name="Ordnung" id="ordnung{{ $kat['Kategorie']}}" style="width:380px;padding:4px;">
                                            <option value="--">--</option>
                                            @foreach ($ord[$kat['Kategorie']] as $o)
                                            <option>{{ $o }}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <br>
                                     @endif
                                     <label>Bemerkung:
                                        <textarea name="bemerkung" id="bemerkungId" style="width: 380;padding: 4px; height:80px;" ></textarea>
                                    </label>
                                    <br>
                                    <label>Link (mit http(s)://):
                                        <input type="text" name="link" id="link{{ $kat['Kategorie']}}" style="width: 380;padding: 4px;" />
                                    </label>
                                    <br>
                                    <label>Link Anzeigename :
                                        <input type="text" name="linkName" id="linkNameId" style="width: 380;padding: 4px;" />
                                    </label>
                                    <br>
                                    <label>Datei Auswahl:
                                        <input type="file" name="file" id="file{{ $kat['Kategorie']}}" style="display: inline; width:380px;font-size: 10px;">
                                    </label><br>
                                    <label><button type="submit" style="padding:10px;width:380px;"><b>Upload</b></button></label>
                                    
                                </fieldset>
                            </form>
                           
                            {{-- Form::close() --}}
                        </div><br>
                        
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endforeach

            @if (Auth::user()->PPMitarbeiter_Gruppe == 'admin')
            <div id="FileProtokoll" style="float: left; width:1475px;border: none;height: 780px; overflow: hidden;">
                    <h3>Datei-Protokoll</h3>

                    <table id="FileProtokollTable">
                        <tr>
                            <th>Datei</th>
                            <th>Hochgeladen am</th>
                            <th>Hochgeladen von</th>
                            <th>Gelöscht am</th>
                            <th>Gelöscht von</th>
                        </tr>
                        @if(isset($data['FileProtokoll']) and count($data['FileProtokoll']) > 0)
                        @foreach ($data['FileProtokoll']  as $p)
                        <?php
                            $dateC = date_format(date_create($p->created_at), 'd.m.y [H:i:s]');
                            $dateU = date_format(date_create($p->updated_at), 'd.m.y [H:i:s]');
                        ?>
                        <tr>
                            <td>{{$p->PPPPFiles_Name}}</td>
                            <td>{{$dateC}}</td>
                            <td>{{$p->CreateUser}}</td>
                            <td>@if ( $p->PPPPFiles_Status == 0) {{$dateU}} @endif</td>
                            <td>@if ( $p->PPPPFiles_Status == 0) {{$p->DeleteUser}} @endif</td>
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


    function    alleMarkieren (kat){

        var allElems = document.getElementsByClassName('selectableFiles');
        var elems = document.getElementById(kat).getElementsByClassName('selectableFiles');
        var fileIds = [];
        var check = true;

        for (i=0; i< elems.length; i++){
            if (elems[i].checked){
                check = false;
                break;
            }
        }
        for (i=0; i< allElems.length; i++){
            allElems[i].checked = false;
        }

        for (i=0; i< elems.length; i++){
            elems[i].checked = check;
        }

        
    }

    function sendAjax(fileIds, mailto, zip, download){
        

        if ( fileIds.length < 1 ){
            
            return;
        }
        var jsonArray = JSON.parse(JSON.stringify(fileIds));
       
        $.ajax({
            type:'POST',
            url:'/handleFiles',
            data:{  'fileIds': jsonArray,
                    'mailto': mailto,
                    'zip':zip,
                    'download':download},
            success: function(result) {
                if (result.error == "true") {
                    alert("An error occurred: " & result.errorMessage);
                } else {
                    console.log(result);
                    if (result.download == 1){

                        var ffd = result.filesForDownload;
    
                        for (i=0; i<ffd.length; i++){
                            console.log(ffd[i]);
                            
                            setTimeout(function (path) { window.location = path; }, 200 + i * 200, ffd[i]);
                            
                        }
                    }
                }
            }
        });
    }


    function    selectFiles (kat){

        //console.log(kat);
       
        var mailto = document.getElementById('mailto_' + kat).value;
        var zip = 0;
        if (document.getElementById('zip_' + kat).checked){
            zip = 1;
        }

        var download = 0;
        if (document.getElementById('download_' + kat).checked){
            download = 1;
        }
        

       
        var elems = document.getElementsByClassName('selectableFiles');
        var fileIds = [];
        var j = 0;
        for (i=0; i< elems.length; i++){

            if (elems[i].checked){
                fileIds[j++] = elems[i].id;
                console.log(i + elems[i].id );
            }

        }
        if ( fileIds.length < 1 ){
            alert( 'Keine Dateien ausgewählt');
            
            return false;
        }
        sendAjax(fileIds, mailto, zip, download);
    }


    function validateUpload(id){
        
        
        var file_elem = document.getElementById('file'+id);
        var link_elem = document.getElementById('link'+id);
        if (id != 'Produktpass' && id != 'PDFs' && id != 'Projektbild' ){
            var ordnung_elem = document.getElementById('ordnung'+id);
            if(ordnung_elem[ordnung_elem.selectedIndex].value == "--"){
                alert ("Keine Kategorie ausgewählt!");
                return false;
            } 
        }
    
        if(file_elem.value == ""){
            if (link_elem.value == ""){
                alert ("Keine Datei und kein Link ausgewählt!");
                return false;
            }
        }

        if(link_elem.value == ""){
            if (file_elem.value == ""){
                alert ("Keine Datei und kein Link ausgewählt!");
                return false;
            }
        } 
       
       

       

        return true;
        
    }
  

    function hasClass( target, className ) {
        return new RegExp('(\\s|^)' + className + '(\\s|$)').test(target.className);
    }

  /*  function showDiv (grid){

        console.log("Show Grid:" + grid);

        var showGrid1 = 'none';
        var showGrid2 = 'grid';
        if (grid == 1){
            showGrid1 = 'grid';
            showGrid2 = 'none';
        }

        var elems1 = document.getElementsByName('FileGrid1');
        console.log (elems1);
        for(var i=0; i<=elems1.length; i++){
            elems1[i].style.display = showGrid1;
        }  
        
        var elems1 = document.getElementsByName('FileGrid2');
        console.log (elems1);
        for(var i=0; i<=elems1.length; i++){
            elems1[i].style.display = showGrid2;
        }

    }*/
       
       
    function _filter (kat){

        var filter_elem = document.getElementById('FilterOrdnung' + kat).value;
       var elems = document.getElementsByClassName(kat);
       
       

        console.log("Filter: " + filter_elem);

       if (filter_elem == 'Alles'){
        for(var i=0; i<=elems.length; i++){
                elems[i].style.display = 'grid';
            }
            return;
        }     
        
       var elems2 = document.getElementsByClassName(kat);
        
       for(var i=0; i<=elems2.length; i++){
            if (elems2[i] != undefined){
                if (hasClass(elems2[i],filter_elem.trim())) {
                    elems2[i].style.display = 'grid';
                } else {
                    elems2[i].style.display = 'none';
                }
            }
        }
       } 

    function _filterCV (kat){

        var filter_elem = document.getElementById('FilterOrdnung' + kat).value;
        var elems = document.getElementsByClassName('CV' + kat);

       console.log("Filter: " + filter_elem);

       if (filter_elem == 'Alles'){
       for(var i=0; i<=elems.length; i++){
            elems[i].style.display = 'grid';
            }
            return;
        } 

        var elems2 = document.getElementsByClassName('CV' + kat);
        for(var i=0; i<=elems2.length; i++){
            if (elems2[i] != undefined){
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

    function filter (kat){

       var viewId = document.getElementById('viewId').value;

       console.log('View Id: ' + viewId);

       if (viewId == 1){
            _filter(kat);
        }
       if (viewId == 2){
            _filterCV(kat);
       }
 

       //showFileGrid(viewId);

 
    }

    function setCat(cat) {
        //alert("CAT :" + cat);
        //document.getElementById('hiddenActivmainTab').value = cat;
    }

    function setSubCat(cat, catndx) {

        console.log("SubCat" + cat+" " +catndx);
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
   
    function activateTabsAfterUpload1( param ) {

        //alert('OK' + param);

        
        var maintab = document.getElementById('hiddenActivmainTab1').value;
        var maintabIndex = document.getElementById('hiddenActivmainTabIndex').value;
        var subtabIndex = document.getElementById('hiddenActivsubTabIndex').value;
        var subtabName = document.getElementById('hiddenActivsubTabName').value;
        var subsubtabIndex = document.getElementById('hiddenActivsubsubTabIndex').value;

        if (maintab == 0){
            return;
        }

        console.log("XXXmain:" + maintab + " maintabIndex:" + maintabIndex + " maintabIndex:" + maintabIndex + " subtabName:" +     subtabName + " subsubtabIndex:" +     subsubtabIndex);
        $("#tabs").tabs({ disabled: 0 });
        $("#tabs").tabs({ active: maintabIndex });
        var mainTabName = "#tabs-" + maintab;
        console.log("maintab:"  + mainTabName);
        $(mainTabName).tabs({ disabled: 0 }); //subtract one because zero-based
        $(mainTabName).tabs({ active: subtabIndex }); //subtabIndex  subtract one because zero-based
        var sT = "#" + subtabName;
        console.log("ABCsT:"  + sT);
        $(sT).tabs({ disabled: 0 }); //subtract one because zero-based
        console.log(subsubtabIndex );
        $(sT).tabs({ active: subsubtabIndex }); // subsubtabIndex subtract one because zero-based
    }

    $(function () {
        //alert("Ready");
        activateTabsAfterUpload1(1);
        //alert("Ready Reeady");
    });


    (function (document, window, index) {
        // feature detection for drag&drop upload
        var isAdvancedUpload = function () {
            var div = document.createElement('div');
            return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
        }();
        // applying the effect for every form
        var forms = document.querySelectorAll('.box');
        Array.prototype.forEach.call(forms, function (form) {
            var input = form.querySelector('input[type="file"]'),
                label = form.querySelector('label'),
                errorMsg = form.querySelector('.box__error span'),
                restart = form.querySelectorAll('.box__restart'),
                droppedFiles = false,
                showFiles = function (files) {
                    label.textContent = files.length > 1 ? (input.getAttribute('data-multiple-caption') || '').replace('{count}', files.length) : files[0].name;
                },
                triggerFormSubmit = function () {
                    var event = document.createEvent('HTMLEvents');
                    event.initEvent('submit', true, false);
                    form.dispatchEvent(event);
                };
            // letting the server side to know we are going to make an Ajax request
            var ajaxFlag = document.createElement('input');
            ajaxFlag.setAttribute('type', 'hidden');
            ajaxFlag.setAttribute('name', 'ajax');
            ajaxFlag.setAttribute('value', 1);
            form.appendChild(ajaxFlag);
            // automatically submit the form on file select
            input.addEventListener('change', function (e) {
                showFiles(e.target.files);
                // triggerFormSubmit();


            });
            // drag&drop files if the feature is available
            if (isAdvancedUpload) {
                form.classList.add('has-advanced-upload'); // letting the CSS part to know drag&drop is supported by the browser

                ['drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop'].forEach(function (event) {
                    form.addEventListener(event, function (e) {
                        // preventing the unwanted behaviours
                        e.preventDefault();
                        e.stopPropagation();
                    });
                });
                ['dragover', 'dragenter'].forEach(function (event) {
                    form.addEventListener(event, function () {
                        form.classList.add('is-dragover');
                    });
                });
                ['dragleave', 'dragend', 'drop'].forEach(function (event) {
                    form.addEventListener(event, function () {
                        form.classList.remove('is-dragover');
                    });
                });
                form.addEventListener('drop', function (e) {
                    droppedFiles = e.dataTransfer.files; // the files that were dropped
                    showFiles(droppedFiles);
                    // triggerFormSubmit();

                });
            }


            // if the form was submitted
            form.addEventListener('submit', function (e) {
                // preventing the duplicate submissions if the current one is in progress
                if (form.classList.contains('is-uploading'))
                    return false;
                form.classList.add('is-uploading');
                form.classList.remove('is-error');
                if (isAdvancedUpload) // ajax file upload for modern browsers
                {
                    e.preventDefault();
                    // gathering the form data
                    var ajaxData = new FormData(form);
                    if (droppedFiles) {
                        Array.prototype.forEach.call(droppedFiles, function (file) {
                            ajaxData.append(input.getAttribute('name'), file);
                        });
                    }

                    // ajax request
                    var ajax = new XMLHttpRequest();
                    ajax.open(form.getAttribute('method'), form.getAttribute('action'), true);
                    ajax.onload = function () {
                        form.classList.remove('is-uploading');
                        var data = JSON.parse(ajax.responseText);
                        if (ajax.status >= 200 && ajax.status < 400) {
                            label.textContent = "";
                            document.getElementById("bemerkungId").value = "";
                            document.getElementById('UplMessageId').innerHTML = "Datei hochgeladen!";
                            //form.classList.add(data.success == true ? 'is-success' : 'is-error');
                            if (!data.success) {
                                errorMsg.textContent = data.error;
                            }
                            var nLD = JSON.parse(data.tabs);
                            var link = "/showAfterUpload/" + nLD.ppid + "/2/" + nLD.subTabName + "/" + nLD.subTabIndex + "/" + nLD.subsubTabIndex;
                            //console.log (link);
                            window.location.href = link;
                        } else {

                            alert('Error. Please, contact  Webadmin');
                        }
                    };
                    ajax.onerror = function () {
                        form.classList.remove('is-uploading');
                        alert('Error. Please, try again!');
                    };
                    ajax.send(ajaxData);
                } else // fallback Ajax solution upload for older browsers
                {
                    var iframeName = 'uploadiframe' + new Date().getTime(),
                        iframe = document.createElement('iframe');
                    $iframe = $('<iframe name="' + iframeName + '" style="display: none;"></iframe>');
                    iframe.setAttribute('name', iframeName);
                    iframe.style.display = 'none';
                    document.body.appendChild(iframe);
                    form.setAttribute('target', iframeName);
                    iframe.addEventListener('load', function () {
                        var data = JSON.parse(iframe.contentDocument.body.innerHTML);
                        form.classList.remove('is-uploading')
                        form.classList.add(data.success == true ? 'is-success' : 'is-error')
                        form.removeAttribute('target');
                        if (!data.success) {
                            errorMsg.textContent = data.error;
                        }
                        iframe.parentNode.removeChild(iframe);
                    });
                }
            });
            // restart the form if has a state of error/success
            Array.prototype.forEach.call(restart, function (entry) {
                entry.addEventListener('click', function (e) {
                    e.preventDefault();
                    form.classList.remove('is-error', 'is-success');
                    input.click();
                });
            });
            // Firefox focus bug fix for file input
            input.addEventListener('focus', function () {
                input.classList.add('has-focus');
            });
            input.addEventListener('blur', function () {
                input.classList.remove('has-focus');
            });
        });
    }(document, window, 0));

    function validatedelete(){
        
        if (confirm("Datei wirklich löschen?") == true) {
            return true;
        }
        return false;
    }

    function showDeleted(){
        //alert("gelöschte Uploads werden jetzt angezeigt");
        const elems = document.getElementsByClassName('fileDeleted');
        //console.log(elems);
        for(var i= 0; i < elems.length; i++){
            //console.log(elems[i]);
            elems[i].classList.add("fileShowDeleted");
            elems[i].classList.remove("fileDeleted");
        }
    }

    function hideDeleted(){
        //alert("gelöschte Uploads werden jetzt nicht mehr angezeigt");
        const elems = document.getElementsByClassName('fileShowDeleted');
        //console.log(elems);
        for(var i= 0; i < elems.length; i++){
            //console.log(elems[i]);
            elems[i].classList.add("fileDeleted");
            elems[i].classList.remove("fileShowDeleted");
        }
    }

    function showFileGrid( gridno ){
        
        console.log('Umschalten nach: ' + gridno);

        var viewId = document.getElementById('viewId');
        viewId.value = gridno;
       
        var nameShow="";
        var nameHide="";

        if(gridno == 1){

            nameShow = "FileGrid1";
            nameHide = "FileGrid2";

        }
        if(gridno == 2){

            nameShow = "FileGrid2";
            nameHide = "FileGrid1";
        }

        var elems =  document.getElementsByName(nameHide);
        for(let i = 0;i < elems.length; i++)
        {
            elems[i].style.display = 'none';  
           

        }
       
        elems =  document.getElementsByName(nameShow);
        for(let i = 0;i < elems.length; i++)
        {
            elems[i].style.display = '';  
           
        } 
        
        elems =  document.getElementsByName('FileGridContainer');
        for(let i = 0;i < elems.length; i++)
        {
            if (gridno == 1){
                elems[i].style.width = "72%";
            }
            if (gridno == 2){
                elems[i].style.width = "72%";
            }
        }
       
    }

</script>