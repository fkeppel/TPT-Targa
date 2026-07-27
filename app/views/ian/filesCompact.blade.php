<script>
    $(function() {
        $("#menu").menu();
    });
    $(function() {
        $("#menuFiles").menu();
    });
</script>
<style>
    .ui-menu {
        width: 189px;
    }
    .FileContainer {
        float: left;
        width: calc(100% - 10px);
        border: none;
        --height: 95%;
        overflow: auto;
    }
    .hidden {
        display: none;
    }
    #FileDetails {
        display: grid;
        grid-template-columns: minmax(600px, 55%) minmax(90px, 8%) minmax(120px, 12%) minmax(180px, 20%);
    }
    .FileCompact {
        display: grid;
        grid-template-columns: minmax(600px, 55%) minmax(90px, 8%) minmax(120px, 12%) minmax(180px, 20%);
    }
    #FileDetails div {
        border: 1px solid lightgray;
        padding: 8px;
        height: calc(100% - 2px);
        display: inline-block;
        white-space: nowrap;
    }
    .fileIcons {
        margin-left: 5px;
        height: 20px;
    }
    .fileLabel {
        border: 1px solid darkgray;
        background-color: lightgray;
        font-weight: bold;
    }
    #ovUpload {
        position: fixed;
        /* Sit on top of the page content */
        width: 100%;
        /* Full width (cover the whole page) */
        height: 100%;
        /* Full height (cover the whole page) */
        top: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 0.5);
        /* Black background with opacity */
        z-index: 2;
        /* Specify a stack order in case you're using a different order for other elements */
        cursor: pointer;
        /* Add a pointer on hover */
        padding: 10%;
    }
    #ovUpload .tbl {
        border-collapse: collapse;
        width: 100%;
    }
    #ovUpload .value {
        border: 1px solid lightgray;
        padding: 8px;
        width: 50%;
    }
    #ovUpload .label {
        border: 1px solid lime;
        background-color: lightgray;
        color: darkblue;
        padding: 8px;
        vertical-align: top;
        width: 35%;
        float: left;
    }
    #ovUpload .valuep0 {
        border: 1px solid red;
        padding: 0px;
        width: 50%;
        float: left;
    }
    .c1 .l1 {
        border: 1px solid darkgray;
        background-color: lightgray;
        color: darkblue;
        padding: 8px;
        vertical-align: top;
        width: 25%;
        height: 100%;
        float: left;
    }
    .c1 .v1 {
        border: 1px solid lightgray;
        padding: 0px;
        width: 60%;
        xheight: calc(100% + 16px);
        float: left;
    }
    .v1 textarea {
        background-color: transparent;
        padding: 8px;
        width: 100%;
        height: calc(100% - 14px);
        border: 1px solid lightgray;
        border-radius: 0px !important;
        margin-top: 10px;
    }
    .c1 {
        border: 1px solid dodgerblue;
        padding: 0px;
        height: 280px;
        overflow: hidden;
        display: flex;
    }
    .s2 {
        all: unset;
        border: 1px solid gray;
        width: calc(100% - 18px);
        appearance: menulist-button;
        padding: 8px;
        border-radius: 0px;
        color: black;
    }
    .o2 {
        all: unset;
    }
    .s1o1 {
        background-color: #88fa41;
        color: blue;
        padding: 0px;
        border-radius: 0px !important;
    }
    .s1o2 {
        background-color: #fa6541;
        color: red;
        padding: 10px;
        border-radius: 0px !important;
    }
    .FileCompactHeader {
        border: 1px solid lightgray;
        background-color: #bbbbbb;
        padding: 4px;
        padding-left: 10px;
    }
    /************************************************/
    .cpcInput input[type="file"] {
        position: relative;
        width: 100%;
        height: 180px;
    }
    .cpcInput input[type="file"]::file-selector-button {
        width: 380px;
        height: 250px;
        border: 4px solid pink;
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
        border: 4px solid red;
    }
    #FileProtokollTable {
        font-size: 0.9em;
        margin: 20px;
    }
    #FileProtokollTable th {
        text-align: left;
        padding: 8px;
        border: 1px solid darkgray;
        background-color: lightgray;
    }
    #FileProtokollTable td {
        text-align: left;
        padding: 8px;
        border: 1px solid darkgray;
    }
    /* Style the tab */
    .hover {
        background-color: green;
        border-color: darkgreen;
    }
    .dragover {
        background-color: green;
        border-color: darkgreen;
    }
    .preview-item {
        max-width: 800px;
        max-height: 80px;
        border: 1px solid #ccc;
        padding: 5px;
        overflow: hidden;
    }
    .preview-item img {
        width: 100%;
        height: 100%;
        max-width: 100px;
        max-height: 100px;
        display: block;
    }
    .preview-item p {
        font-size: 12px;
        word-break: break-word;
    }
    /* Style the tab */
    .UplTable {
        border: none;
        padding: 8px;
        width: 100%;
        border-collapse: collapse;
    }
    .UplTable td {
        vertical-align: top;
        border: 1px solid lightgray;
        padding: 6px;
    }
    .UplTable td:nth-child(1) {
        width: 15%;
        background-color: lightgray;
    }
    .UplTable td:nth-child(2) {
        width: 30%;
    }
    .UplTable td:nth-child(3) {
        width: 15%;
        background-color: lightgray;
    }
    .UplTable td:nth-child(4) {
        width: 30%;
    }
    .msgGreen {
        color: white;
        background-color: green;
    }
    .msgWhite {
        background-color: rgba(53, 53, 53, 0.9);
        color: white;
    }
    .msgRed {
        color: white;
        background-color: red;
    }
    .MoveShow {
        display:inline;
    }
    .MoveHide {
        display:none;
    }
    @include('ian.inc_fileCompactStyle');
</style>
<?php
    $lang = $data['lang'];
    $ord = $data['Kategorien'];
    $ordText = [];
    foreach ($ord as $ok => $ot) {
        foreach ($ot as $oo) {
            $ordText[$ok][] = ServiceProvider::tl($lang, $oo);
        }
    }
    $compactView = '';
    $komplettView = 'display:none;';
    $viewId = 1;
    $fgWidth = 'width:50%;';
    if (!$data['tabs']['compactView']) {
        $compactView = 'display:none;';
        $komplettView = '';
        $viewId = 1;
        $fgWidth = 'width:72%;';
    }
    $img = '\\data\\Icons\\download.png';
    $dlSymbol = '<div style="float:left; border: none;margin-right:5px;"><img style="height:18px;" src="' . $img . '" /></div>';
    $isSharepoint = $data['pp']['PPProduktpass_Transferd2Sharepoint'] > 0;
    $countFiles = $data['files']['TOTAL'];
    $transferdFiles = $data['files']['TRANSFERD'];
    $server = 'https://tpt-dev.ad.targa.de';
    $showEdit2 = true;
?>
<div style='float:left;'>
    <ul id="menuFiles">
        @foreach ($data['files']['types'] as $type)
            <li>
                <div class='parent' id='{{ $type['Type'] }}'>{{ ServiceProvider::tl($lang, $type['Type']) }}</div>
                <ul>
                    @foreach ($data['files']['subtypes'] as $kat)
                        @if ($kat['ParentId'] == $type['Id'])
                            <li>
                                <div class="child" onclick='_activate("{{ ServiceProvider::noBlanks($kat["Kategorie"]) }}");' id="{{ ServiceProvider::noBlanks($kat["Kategorie"]) }}">
                                    {{ ServiceProvider::tl($lang, $kat['Kategorie']) }}
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
        @endforeach
        @if (ServiceProvider::AuthUserHasRole('INTERN') or ServiceProvider::AuthUserHasRole('EXTERN')) 
        <li>
            <div class='child' id='Datei-Protokoll'>{{ ServiceProvider::tl($lang, 'Datei-Protokoll') }}</div>
        </li>
        @endif
    </ul>
</div>
<div id="FilesParent" style='float:left;border:1px solid lightgray;width:87%;min-height:600px;overflow:auto;height: calc(100% - 50px);'>
    @include ('ian.newFileAfterUpload')
    <div class='FileContainer hidden' id='cont_Datei-Protokoll'
        style='border:none; padding-left:20px; width:calc(100% - 50px);border:1px solid gray; '>
        <h3>{{ ServiceProvider::tl($lang,'Datei-Protokoll')}}</h3>
        <table id="FileProtokollTable" style="border-collapse:collapse;padding:15px;">
            <tr>
                <th>{{ ServiceProvider::tl($lang, 'Datei') }}</th>
                <th>{{ ServiceProvider::tl($lang, 'Hochgeladen am') }}</th>
                <th>{{ ServiceProvider::tl($lang, 'Hochgeladen von') }}</th>
                <th>{{ ServiceProvider::tl($lang, 'Letzte Änderung') }}</th>
                <th>{{ ServiceProvider::tl($lang, 'Gelöscht von') }}</th>
            </tr>
            @if (isset($data['FileProtokoll']) and count($data['FileProtokoll']) > 0)
                @foreach ($data['FileProtokoll'] as $p)
                    <?php
                        $dateC = date_format(date_create($p->created_at), 'd.m.y [H:i:s]');
                        $dateU = date_format(date_create($p->updated_at), 'd.m.y [H:i:s]');
                        $colorStyle = '';
                        if ($p->PPPPFiles_Status == 0){
                            $colorStyle = "style='color:red;'";
                        }
                    ?>
                    <tr>
                        <td {{ $colorStyle}}>{{ $p->PPPPFiles_Name }}</td>
                        <td {{ $colorStyle}}>{{ $dateC }}</td>
                        <td {{ $colorStyle}}>{{ $p->CreateUser }}</td>
                        <td {{ $colorStyle}}>{{ $dateU }}</td>
                        <td {{ $colorStyle}}>
                            @if ($p->PPPPFiles_Status == 0)
                                {{ $p->DeleteUser }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
</div>
<script>
    var lang = "{{ $data['lang'] }}";
    var delFile = 'Datei wirklich löschen?';
    var datensatzGespeichert = 'Datensatz gespeichert';
    var Projektbild = 'Projektbild gesetzt!';
    var datensatzGeloescht = 'Datensatz gelöscht!';
    var keineKategorie = 'Keine Kategorie ausgewählt!';
    var keineDatei = 'Keine Datei ausgewählt!';
    var dateienUeberschreiben = 'Dateien werden überschrieben!';
    var dateienVersionieren = 'Dateien werden versioniert!';
    var dateienNichtHochgeladen = 'Dateien werden NICHT hochgeladen!';
    var bitteKategorie = 'Bitte Kategorie auswählen!';
    var dateiHochladen = 'Datei wird hochgeladen';
    var dateienHochladen = 'Dateien werden hochgeladen';
    var dateiWurdeHochgeladen = 'Datei wurde hochgeladen!';
    var dateienVorhanden = 'Dateien sind schon vorhanden. Überschreiben?';
    var neueVersion = 'Neue Version?';
    var yes = 'Ja';
    var no = 'Nein';
    var fileInput = new Array();
    var dropZone = new Array();
    var preview = new Array();
    var selectedFiles = new Array();
    var kats = new Array();
    var fileInputActive = new Array();
    if (!fileClickHandlers) var fileClickHandlers = {};
    if (lang == 'EN') {
        delFile = 'Really delete this File?';
        datensatzGespeichert = 'Record saved' ;
        datensatzGeloescht = 'Record deleted!' ;
        keineKategorie = 'No Category selected!';
        keineDatei = 'No File selected!';
        dateienUeberschreiben = 'Files will be overwritten!';
        dateienVersionieren = 'Files will be versioned!';
        dateienNichtHochgeladen = 'Files will NOT be uploaded!';
        bitteKategorie = 'Please select Category!';
        dateiHochladen = 'File is uploading';
        dateienHochladen = 'Files are uploading';
        dateiWurdeHochgeladen = 'File was uploaded!';
        dateienVorhanden = 'Files are already existing. Overwrite?';
        yes = 'Yes';
        no = 'No';
        neueVersion = 'New Version?';
        Projektbild = 'Projectpicture set!';
    }
    $('.parent').click(function(evt) {})
    $('.child').click(function(evt) {
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
        alert('Neue Datei Type:' + type + ' Kat:' + kat);
        elem = document.getElementById('newFileUpload_' + type + '_' + kat);
        elem.classList.remove('hidden');
    }
    function updateHTML(html) {
        elem = document.getElementById('FilesParent');
        elem.innerHTML = '<div style="border:5px solid red;">' + html + '</div>';
    }
    function hideAll() {
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
        var elems2 = document.getElementsByClassName('fileSub_' + kat);
        for (var i = 0; i <= elems2.length; i++) {
            if (elems2[i] != undefined) {
                //console.log(elems2[i]);
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
        var elems = document.querySelectorAll("[name^='" + kat + "']");
        //console.log('_hide');
        //console.log(elems);
        for (var i = 0; i <= elems.length; i++) {
            //console.log(elems[i].name);
            if (elems[i] != undefined) {
                elems[i].classList.add("hidden");
            }
        }
    }
    function _show(kat) {
        //alert(kat);
        var elems = document.querySelectorAll("[name^='" + kat + "']");
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
        var elemX = '#FilterOrdnung' + kat; // Option um den Wert zu erhalten
        var filter_elem = $(elemX).val();
        //alert('Filter: ' + filter_elem);
        if (filter_elem == 'Alles') {
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
        var viewId = 1; //document.getElementById('viewId').value;
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
        for (i = L; i >= 0; i--) {
            selectElement.remove(i);
        }
    }
    function openUpload(jParams) {
        var ppid = jParams.PPId;
        var kat = jParams.Kat;
        var type = jParams.Type;
        var Ordnung1 = jParams.Ordnung;
        var OrdnungText = jParams.OrdnungText;
        var selectO = Ordnung1[kat];
        var selectV = OrdnungText[kat];
        var elem = document.getElementById('ovUpload');
        elem.classList.remove("hidden");
        var selectElement = document.getElementById('ordnungUpl');
        removeOptions(selectElement);
        selectElement.add(new Option(''));
        for (var k in selectO) {
            selectElement.add(new Option(selectV[k], selectO[k]));
        }
        var ppidElement = document.getElementById('ppidUpl');
        var typeElement = document.getElementById('typeUpl');
        var katElement = document.getElementById('katUpl');
        katElement.value = kat;
        typeElement.value = type;
        ppidElement.value = ppid;
    }
    function readValue(id) {
        //console.log('readValue: ' + id);
        var elem = document.getElementById(id);
        if (elem) {
            var ret = 0;
            console.log(elem.type);
            if (elem.type === "checkbox") {
                // Checkbox → 1 wenn checked, sonst 0
                ret = elem.checked ? (elem.value || "1") : "0";
            } else {
                ret = elem.value;
            }
            console.log("Return: " + ret)
            return ret;
        }
        //console.log('Kein Wert');
        return '';
    }
    function closeUpload() {
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
    function clearElem(elem) {
        var elem1 = document.getElementById(elem);
        if (elem1) {
            elem1.value = '';
        }
    }
    function closeMessageNew(kat) {
        clearElem('fileUpl' + kat);
        clearElem('bemerkungUpl' + kat);
        clearElem('ordnungUpl' + kat);
        var msg = document.getElementById('messageUpl' + kat);
        if (msg) {
            msg.classList.add('hidden');
        }
    }
    function closeMessage() {
        var elem = document.getElementById('messageUpl');
        elem.classList.add("hidden");
    }
    function openMessage() {
        var elem = document.getElementById('messageUpl');
        elem.classList.remove("hidden");
    }
    function openMessageNew(kat) {
        var elem = document.getElementById('messageUpl' + kat);
        elem.classList.remove("hidden");
    }
    function validatedelete() {
        if (confirm(delFile) == true) {
            return true;
        }
        return false;
    }
    function saveRemark(fid) {
        //console.log('File_Id: ' + fid);
        var url = '/updateRemarkFilesAjax';
        var remark = $('#textarea-container_' + fid).val();
        var OrdnungSub = $('#OrdnungSub_' + fid).val();
        var data = {
            fileid: fid,
            remark: remark,
            OrdnungSub: OrdnungSub
        };
        //console.log (data);
        $.ajax({
            url: url, //the page containing php script
            type: "post", //request type,
            dataType: 'json',
            data: data,
            success: function(data) {
                //console.log(data);
                alert(datensatzGespeichert);
            }
        });
    }
    function updateProjectPic(ppid, fid) {
        //console.log('File_Id: ' + fid);
        var url = '/updateProjektPicAjax';
        var data = {
            fileid: fid,
            ppid: ppid
        };
        //console.log (data);
        $.ajax({
            url: url, //the page containing php script
            type: "post", //request type,
            dataType: 'json',
            data: data,
            success: function(data) {
                //console.log(data);
                alert(Projektbild);
            }
        });
    }
    function deleteFile(fid) {
        if (!validatedelete()) {
            return;
        }
        //console.log('File_Id: ' + fid);
        var url = '/deleteFileNeu';
        var data = {
            fileid: fid
        };
        $.ajax({
            url: url, //the page containing php script
            type: "post", //request type,
            dataType: 'json',
            data: data,
            success: function(data) {
                //console.log(data);
                alert(datensatzGeloescht);
                var delElem = document.getElementById('File_' + fid);
                delElem.classList.add('hidden');
                //window.location.href('https://tpt-dev.ad.targa.de/showNeu/'+ ppid + '/' + lang + '#Dateien');
            }
        });
    }
    function initFiles_X() {
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
                //console.log('Return: ' + tabid);
                //console.log(data);
                var t = '#' + tabid;
                $(t).html(data);
            }
        });
    }
    function initFiles(html) {
        var elem = document.getElementById('FilesParent');
        //elem.innerHTML = JSON.stringify(html);
        elem.innerHTML = html;
    }
    function refreshFiles(ppid, kat) {
        //alert('Refresh PPId: '+ ppid + ' Kategorie:' + kat);
        var data = {
            ppid: ppid,
            kat: kat
        };
        console.log (data);
        $.ajax({
            url: "/refreshFiles",
            type: "post",
            dataType: 'json',
            data: data,
            success: function(response) {
                console.log ('refresh');
                var html = response.view;
                var kat = response.kat;
                kat = kat.replace(/ /g, "_");
                initFiles(html);
                var activeDiv = document.getElementById('cont_' + kat);
                if (activeDiv) {
                    activeDiv.classList.remove('hidden');
                }
                _activate(kat);
            }
        });
    }
    function plsWait(ppid, kat) {
        var wait = 'Bitte warten bis die Datei auf dem Sharepoint-Server verfügbar ist!';
        var lang1 = '{{ $data['lang'] }}';
        //alert('Sprache:' + lang1);
        if (lang1 != 'DE') {
            wait = 'Please wait until File is transferd to Your Sharepoint-Server!';
        }
        alert(wait);
        refreshFiles(ppid, kat);
    }
    /************************************************/
    function validateUpload(id) {
        if (_validateUpload(id)) {
            var frm = document.getElementById('form_' + id);
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
                alert(keineKategorie);
                return false;
            }
        }
        if (file_elem.value == "") {
            if (link_elem.value == "") {
                alert(keineDatei);
                return false;
            }
        }
        if (link_elem.value == "") {
            if (file_elem.value == "") {
                alert(keineDatei);
                return false;
            }
        }
        uploadDouble(id);
        if (document.getElementById('verUpl').value > 0) {
            return true;
        }
        return false;
    }
    function uploadDouble_test(kat) {
        alert('uploadDouble(' + kat + ')');
        var id = 'fileUpl';
        const fileInput = document.getElementById(id);
        var ppidElem = document.getElementsByName('ppid')[0];
        var ppid = ppidElem.value;
        const selectedFiles = fileInput.files;
        //console.log(fileInput);
        alert('uploadDouble Console?');
        var f = [];
        for (let i = 0; i < selectedFiles.length; i++) {
            f.push(selectedFiles[i].name);
        }
        alert('uploadDouble Ajax:' + kat);
        $.ajax({
            async: false,
            type: 'POST',
            url: '/existFilesSharepoint',
            data: {
                'files': f,
                'ppid': ppid
            },
            success: function(result) {
                alert('Return');
                if (result.error == "true") {
                    alert("An error occurred: " & result.errorMessage);
                    document.getElementById('verUpl').value = 0;
                    return;
                } else {
                    var r = JSON.parse(result);
                    //console.log (r);
                    alert('Zurück');
                }
            }
        });
        return;
        //document.getElementById('testDbl'+kat).value =  'E'; 
    }
    function uploadDouble(kat) {
        //console.log('UploadDouble: ' + kat);
        var id = 'fileUpl' + kat;
        //console.log('fileUpl: ' + id);
        const fileInput = document.getElementById(id);
        //console.log(fileInput);
        var ppidElem = document.getElementById('ppidUpl' + kat);
        //console.log(ppidElem);
        var ppid = ppidElem.value;
        //const selectedFiles = fileInput.files;
        //console.log('Vor F: ' + kat);
        //console.log(selectedFiles);
        var f = [];
        for (let i = 0; i < selectedFiles.length; i++) {
            f.push(selectedFiles[i].name);
        }
        const verUpl = 'verUpl' + kat;
        $.ajax({
            async: false,
            type: 'POST',
            url: '/existFilesSharepoint',
            data: {
                'files': f,
                'ppid': ppid
            },
            success: function(result) {
                //console.log(result);
                if (result.error == "true") {
                    alert("An error occurred: " & result.errorMessage);
                    document.getElementById(verUpl).value = 0;
                    return;
                } else {
                    var r = JSON.parse(result);
                    var retval = r['ReturnValue'];
                    var listFiles = r['FilesExists'];
                    var kats = r['Kats'];
                    if (retval) {
                        var fns = '';
                        for (let i = 0; i < listFiles.length; i++) {
                            fns = fns + listFiles[i] + '  [' + kats[i]['Kat'] + '/' + kats[i]['SubKat'] +
                                ']\n';
                        }
                        fns = fns + '\n' + dateienVorhanden;
                        var answer = window.confirm(fns, yes, no);
                        if (answer) {
                            alert(dateienUeberschreiben);
                            document.getElementById(verUpl).value = 1;
                            return;
                        } else {
                            var answer2 = window.confirm(neueVersion);
                            if (answer2) {
                                var verid = verUpl;
                                //var idver = document.getElementById(verid);
                                alert(dateienVersionieren);
                                //idver.value = 99;
                                document.getElementById(verUpl).value = 2;
                                return;
                            } else {
                                alert(dateienNichtHochgeladen);
                                document.getElementById(verUpl).value = 0;
                                return;
                            }
                        }
                    } else {
                        document.getElementById(verUpl).value = 1;
                    }
                }
            }
        });
        return;
    }
    function upl(kat) {
        //console.log('Upload in progress!' + kat);
        var fd = new FormData();
        var fileId = '#fileUpl' + kat;
        var files = selectedFiles;
        //console.log('Files Upl: ');
        //console.log(files );
        var countFiles = 0;
        for (let i = 0; i < selectedFiles.length; i++) {
            fd.append('file_' + i, selectedFiles[i]);
            countFiles++;
        }
        var ppid = readValue('ppidUpl' + kat);
        var type = readValue('typeUpl' + kat);
        var kategorie = readValue('katUpl' + kat);
        var bemerkung = readValue('bemerkungUpl' + kat);
        var ord = readValue('ordnungUpl' + kat);
        if (ord == '') {
            alert(bitteKategorie);
            return;
        }
        var isExtern = readValue('isExternUpl' + kat);
        console.log('Params : ' + ppid + ', ' + type + ', '+ kat+ ', ' + ord+ ', ' + isExtern );
        uploadDouble(kat);
        var ver = readValue('verUpl' + kat);
        if (ver == 0) {
            //console.log('Kein Upload');
            return false;
        }
        var strMsg = dateiHochladen;
        if (countFiles > 1) {
            strMsg = dateienHochladen;
        } 
        showMessage(kat, strMsg, 0, 'msgWhite');
        //console.log('After showMessage');
        fd.append('ppid', ppid);
        fd.append('type', type);
        fd.append('kat', kategorie);
        fd.append('ord', ord);
        fd.append('bemerkung', bemerkung);
        fd.append('versioning', ver);
        fd.append('isExtern', isExtern);
        //document.getElementById('messageUpl').style.display = 'inline';
        //console.log("Ajax Call");
        //console.log(fd);
        $.ajax({
            url: '/uploadFilesNew',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log('Upload Response:');
                var html = response.view;
                var kat = response.kat;
                console.log('Kategorie: ' + kat);
                initFiles(html);
                var activeDiv = document.getElementById('cont_' + kat);
                activeDiv.classList.remove('hidden');
                _activate(kat);
                showMessage(kat, dateiWurdeHochgeladen, 2000, 'msgGreen');
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error:', xhr.responseText);
                console.log('Status:', status);
                console.log('Error:', error);
            }
        });
    }
    function init(kat) {
        fileInput[kat] = document.getElementById('fileUpl' + kat);
        dropZone[kat] = document.getElementById('dropZone' + kat);
        preview[kat] = document.getElementById('preview' + kat);
        fileInputActive[kat] = 0;
    }
    function _activateFileClick(kat) {
        console.log('_activateFileClick Start: ' + kat);
        if (fileClickHandlers[kat]) {
            dropZone[kat].removeEventListener('click', fileClickHandlers[kat]);
        }
        fileClickHandlers[kat] = () => {
            fileInput[kat].click();
            console.log('_activateFileClick click: ' + kat);
        };
        try {
            dropZone[kat].removeEventListener('click', fileClickHandlers[kat]);
            dropZone[kat].addEventListener('click', fileClickHandlers[kat], { once: true });
        } catch (err) {
            console.log('Error: '  + err);
            console.log('Kat: '  + kat);
        }
    }
    function _activate(kat, parent = '') {
        init(kat);
        console.log('_activate XX: ' + kat);
        try {
            _activateFileClick(kat);
            dropZone[kat].addEventListener('dragover', (e) => {
                console.log('dragover');
                e.preventDefault();
                dropZone[kat].classList.add('hover');
            });
            dropZone[kat].addEventListener('dragleave', (e) => {
                console.log('dragleave');
                dropZone[kat].classList.remove('hover');
            });
            dropZone[kat].addEventListener('drop', (e) => {
                //console.log('drop');
                e.preventDefault();
                dropZone[kat].classList.remove('hover');
                handleFiles(e.dataTransfer.files, kat);
            });
            fileInput[kat].addEventListener('change', (e) => {
                handleFiles(fileInput[kat].files, kat);
            });
        } catch (err) {
            //console.log('Error: '  + err);
            //console.log('Kat: '  + kat);
        }
    }
    function handleFiles(files, kat) {
        console.log(files);
        preview[kat].innerHTML = ""; // Alte Vorschau löschen
        Array.from(files).forEach(file => {
            console.log('File: ' + file.name + ' Type: ' + file.type);
            const item = document.createElement('div');
            item.className = 'preview-item';
            if (file.type.startsWith("image/")) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    item.innerHTML = `<img src="${e.target.result}" alt="${file.name}">`;
                    preview[kat].appendChild(item);
                };
                //console.log('item');
                //console.log(item);
                reader.readAsDataURL(file);
            } else {
                //console.log('No Image');
                item.innerHTML = `<p>${file.name}</p>`;
                preview[kat].appendChild(item);
            }
        });
        _activateFileClick(kat);
        selectedFiles = Array.from(files);
        //console.log(selectedFiles);
    }
    function activate() {
        kats.push("Protokoll");
        kats.push("Produktdetails");
        kats.push("Verträge");
        kats.push("Projektplan");
        kats.push("Rechnungen");
        kats.push("Kalkulation");
        kats.push("Patente");
        kats.push("Stellungnahmen");
        kats.push("Angebote");
        kats.push("Verschiffungsplan");
        kats.push("Verschiffungsdokumente");
        kats.push("Haupt");
        kats.push("LIDL_Labor");
        kats.push("TARGA_Labor");
        kats.push("Dokumente");
        kats.push("Megastep");
        kats.push("TC_intern");
        kats.push("TARGA_QC");
        kats.push("Handbuch");
        kats.push("Verpackung");
        kats.push("Transportkarton");
        kats.push("Label");
        kats.push("CGI");
        kats.push("Techpack");
        //kats.push("Diverses3");
        kats.push("CSR-Dokumente");
        kats.push("Produktpass");
        kats.push("PDFs");
        kats.push("Projektbild");
        //kats.push("Diverses2");
        kats.push("Upload");
        for (var i = 0; i < kats.length; i++) {
            _activate(kats[i]);
        }
    }
    //activate();
    function showMessage(kat, message, ti = 2000, colMessage = 'msgWhite') {
        console.log('showMessage: ' + kat + ' => ' + message + ' ti: ' + ti + ' c: ' + colMessage);
        var msg = document.getElementById('messageUpl' + kat);
        //console.log(msg);
        msg.classList.add(colMessage);
        msg.classList.remove('hidden');
        //console.log(msg.classList);
        msg.innerHTML = message;
        if (ti > 0) {
            setTimeout(function() {
                hideMessage(kat);
            }, ti);
        }
        console.log('showMessage Ende');
    }
    function hideMessage(kat) {
        //console.log('hideMessage: '+kat);
        var msg = document.getElementById('messageUpl' + kat);
        msg.classList.add('hidden');
        msg.innerHTML = '';
    }
    function moveFileSPO(fileId, fromSPO){
        var confMsg = "Soll die Datei wirklich in den externen Bereich verschoben werden?";
        var clr = 'red';
        if (fromSPO == 'CHN'){
            confMsg = "Soll die Datei wirklich in den internen Bereich verschoben werden?";
            clr = 'darkblue';
        } 
        if (!confirm(confMsg)) {
            return; // Abbrechen
        }
        $.ajax({
            url: '/moveFileFrom',     // Datei, die deine PHP-Funktion ausführt
            type: 'POST',
            data: {
                    ppfileId: fileId,
                    from: fromSPO
            },
            success: function(response) {
                //console.log("Server-Antwort:", response);
                const elem = document.getElementById('fnBox_' + fileId);
                swapStorage('Link2_' + fileId);
                swapStorage('Link3_' + fileId);
                swapStorage('Link4_' + fileId);
                if(elem){
                    elem.style.color = clr;
                }
                if(clr == 'red'){
                    showButton('DE', fileId);
                } else {
                    showButton('CHN', fileId );
                }
            },
            error: function(xhr, status, error) {
                //console.error("AJAX Fehler:", error);
            }
        });
    }
    function showButton(origin, fileId){
        let idShow, idHide;
        if (origin === 'DE') {
            idShow = 'LinkMoveCHN_' + fileId;
            idHide = 'LinkMoveDE_' + fileId;
        } else if (origin === 'CHN') {
            idShow = 'LinkMoveDE_' + fileId;
            idHide = 'LinkMoveCHN_' + fileId;
        } else {
            //console.error("Unbekannter origin:", origin);
            return;
        }
        const elemShow = document.getElementById(idShow);
        if (elemShow){
            elemShow.classList.remove("MoveHide");
            elemShow.classList.add("MoveShow");
        } 
        const elemHide = document.getElementById(idHide);
        if (elemHide){
            elemHide.classList.remove("MoveShow");
            elemHide.classList.add("MoveHide");
        } 
        hideLock(origin, fileId );
    }
    function hideLock(origin, fileId){
        console.log('hide Lock: ' + origin + ' FileId: ' + fileId );
        let idLockShow, idLockHide;
        if (origin === 'CHN') {
            idLockShow = 'LockCHN_' + fileId;
            idLockHide = 'LockINT_' + fileId;
        } else if (origin === 'DE') {
            idLockHide = 'LockCHN_' + fileId;
            idLockShow = 'LockINT_' + fileId;
        } else {
            //console.error("Unbekannter origin:", origin);
            return;
        }
        const elemShow = document.getElementById(idLockShow);
        if (elemShow){
            elemShow.classList.remove("MoveHide");
            elemShow.classList.add("MoveShow");
        } 
        const elemHide = document.getElementById(idLockHide);
        if (elemHide){
            elemHide.classList.remove("MoveShow");
            elemHide.classList.add("MoveHide");
        } 
    }
    function swapStorage(linkId){
        const link = document.getElementById(linkId);
        if (!link) return;
        let href = link.href;
        if (href.includes("/TPTStorageChina/")) {
            href = href.replace('/TPTStorageChina/', '/TPTStorage/');
        } else if (href.includes("/TPTStorage/")) {
            href = href.replace('/TPTStorage/', '/TPTStorageChina/');
        }
        link.href = href;
    }
</script>
