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
        grid-template-columns:minmax(600px,55%) minmax(90px,8%) minmax(120px,12%) minmax(180px,20%);
    }
    .FileCompact {
        display:grid;
        grid-template-columns:minmax(600px,55%) minmax(90px,8%) minmax(120px,12%) minmax(180px,20%);
    }
    #FileDetails div {
        border:1px solid lightgray;
        padding:8px;
        height:calc(100% - 2px);
        display: inline-block;
        white-space: nowrap;
    }
    .fileIcons {
        margin-left:5px;
        height:20px;
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
        padding:10%;
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
    .FileCompactHeader {
        border:1px solid lightgray;
        background-color:#bbbbbb;
        padding:4px;
        padding-left:10px;
    }
    /************************************************/
    .cpcInput input[type="file"] {
        position: relative;
        width:100%;
        height:180px;
    }
    .cpcInput input[type="file"]::file-selector-button {
    width: 380px;
    height:250px;
    border:4px solid pink;
    color: transparent;
    }
    /* Faked label styles and icon */
    .cpcInput input[type="file"]::before {
    position: absolute;
    pointer-events: none;
    top: 10px;
    left: 16px;
    height: 20px;
    width: 20px;
    content: "";
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%230964B0'%3E%3Cpath d='M18 15v3H6v-3H4v3c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-3h-2zM7 9l1.41 1.41L11 7.83V16h2V7.83l2.59 2.58L17 9l-5-5-5 5z'/%3E%3C/svg%3E");
    }
    .cpcInput input[type="file"]::after {
    position: absolute;
    pointer-events: none;
    top: 11px;
    left: 40px;
    color: #0964b0;
    content: "select/drop";
    }
    /* ------- From Step 1 ------- */
    /* file upload button */
    .cpcInput input[type="file"]::file-selector-button {
    border-radius: 4px;
    padding: 0 16px;
    height: 40px;
    cursor: pointer;
    background-color: white;
    border: 1px solid rgba(0, 0, 0, 0.16);
    box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.05);
    margin-right: 16px;
    transition: background-color 200ms;
    }
    /* file upload button hover state */
    .cpcInput input[type="file"]::file-selector-button:hover {
    background-color: #f3f4f6;
    }
    /* file upload button active state */
    .cpcInput input[type="file"]::file-selector-button:active {
    background-color: #e5e7eb;
    }
    .cpcInput {
        border:4px solid red;
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
<div id="FilesParent" style='float:left;border:1px solid lightgray;width:87%;min-height:600px;overflow:auto;height: calc(100% - 50px);'>
    @if (Auth::user()->PPMitarbeiter_Id == 1)
        @include ('ian.newFileAfterUpload')
    @else
        @include ('ian.newFileAfterUpload')
    @endif
</div>
<script>
    var lang = "{{ $data['lang'] }}";
    var delFile = 'Datei wirklich löschen?';
    if (lang == 'EN'){
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
    function showNewFile(type, kat) {
        updateHTML('<h5>TEST in Überschrift</h5>')
        return;
        alert('Neue Datei Type:'+ type + ' Kat:' +kat);
        elem = document.getElementById('newFileUpload_' + type + '_' + kat);
        elem.classList.remove('hidden');
    }
    function updateHTML(html) {
        elem = document.getElementById('FilesParent');
        elem.innerHTML = '<div style="border:5px solid red;">' + html + '</div>';
    }
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
        var fileUpl = document.getElementById('fileUpl');
        fileUpl.value = '';
        var bemerkungUpl = document.getElementById('bemerkungUpl');
        bemerkungUpl.value = '';
        var ordnungUpl = document.getElementById('ordnungUpl');
        ordnungUpl.value = '';
        elem.classList.add("hidden");
        document.getElementById('messageUpl').style.display = 'none';
    }
    function clearElem (elem){
        var elem1 = document.getElementById(elem);
        if (elem1){
            elem1.value = '';
        }
    }
    function closeMessageNew(kat){
        clearElem('fileUpl' + kat);
        clearElem('bemerkungUpl' + kat);
        clearElem('ordnungUpl' + kat);
        var msg = document.getElementById('messageUpl' + kat);
        if (msg){
            msg. classlist.add('hidden');
        }
    }
    function closeMessage(){
        var elem = document.getElementById('messageUpl');
         elem.classList.add("hidden");
    } 
    function openMessage(){
        var elem = document.getElementById('messageUpl');
         elem.classList.remove("hidden");
    } 
    function openMessageNew(kat){
        var elem = document.getElementById('messageUpl' + kat);
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
                        console.log (response);
                        closeUpload();
                        //console.log(response);
                        var html = response.view;
                        var kat = response.kat;
                        initFiles(html);
                        var activeDiv = document.getElementById('cont_' + kat);
                        activeDiv.classList.remove('hidden');
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
    function initFiles_X(){
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
    function initFiles(html){
       var elem = document.getElementById('FilesParent');
        //elem.innerHTML = JSON.stringify(html);
        elem.innerHTML = html;
    }
    function refreshFiles(ppid, kat) {
        //alert('Refresh PPId: '+ ppid + ' Kategorie:' + kat);
        var data = {    ppid:ppid,
                        kat:kat };
        //console.log (data);
        $.ajax({
            url:"/refreshFiles",    //the page containing php script
            type: "post",    //request type,
            dataType: 'json',
            data: data,
            success:function(response){
                //alert ('Daten wurden aktualisiert!')
                //console.log (response);
                var html = response.view;
                var kat = response.kat;
                initFiles(html);
                var activeDiv = document.getElementById('cont_' + kat);
                activeDiv.classList.remove('hidden');
            }
        });
    }
    function plsWait(ppid, kat){
        var wait = 'Bitte warten bis die Datei auf dem Sharepoint-Server verfügbar ist!';
        var lang1 = '{{$data["lang"]}}';
        //alert('Sprache:' + lang1);
        if (lang1 != 'DE'){
            wait = 'Please wait until File is transferd to Your Sharepoint-Server!';
        }
        alert(wait);
        refreshFiles(ppid, kat);
    }
    /************************************************/
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
    function uploadFiles (jparams){
        var ppid = jparams['PPId'];
        var type = jparams['Type'];
        var kat  = jparams['Kat'];
        var ord = readValue('ordnungUpl' + kat);
        if (ord == '' ){
            alert('Bitte Kategorie angeben!');
            return;
        }   
        var bemerkung = readValue('bemerkungUpl' + kat);
        //console.log('uploadFiles PPId:' + ppid + '  Type:' + type + '  Kat:' +  kat + '  Ord:' + ord );
        var fd = new FormData(); 
        var elemFiles = '#fileUpl' + kat;
        var files = $(elemFiles).prop("files");
        //console.log (files);
        jQuery.each(jQuery(elemFiles)[0].files, function(i, file) {
                fd.append('file_'+i, file);
        });
        //fd.append('file', files);
        fd.append('ppid', ppid);
        fd.append('type', type);
        fd.append('kat', kat);
        fd.append('ord', ord);
        fd.append('bemerkung', bemerkung);
        console.log ('Before AjaxCall');
        //document.getElementById('messageUpl').style.display = 'inline';
        //closeUpload();
        openMessageNew(kat);
        $.ajax({ 
            url: '/uploadFilesNew', 
            type: 'post', 
            data: fd, 
            contentType: false, 
            processData: false, 
            success: function(response){ 
                if(response != 0){ 
                    console.log (response);
                    closeMessageNew(kat);
                    //console.log(response);
                    var html = response.view;
                    var kat = response.kat;
                    initFiles(html);
                    var activeDiv = document.getElementById('cont_' + kat);
                    activeDiv.classList.remove('hidden');
                    //alert ('https://tpt-dev.ad.targa.de/showNeu/'+ ppid + '/' + lang );
                    //window.location.href = 'https://tpt-dev.ad.targa.de/showNeu/'+ ppid + '/' + lang ;
                } 
                else{ 
                    alert('file not uploaded'); 
                } 
            }, 
        }); 
    }
</script>