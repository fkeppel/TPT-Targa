<style>
    .container
    {
        width: 530px;
        border:1px solid lightgray;
        text-align: center;
        margin: 0 auto;
    }


    .box
    {
        font-size: 1.25rem; /* 20 */
        background-color:rgba(246, 168, 40, 1);
        color:white;
        position: relative;
        padding: 10px;
    }
    .box.has-advanced-upload
    {
        outline: 2px dashed darkblue;
        outline-offset: -10px;

        -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
        transition: outline-offset .15s ease-in-out, background-color .15s linear;
    }
    .box.is-dragover
    {
        outline-offset: -20px;
        outline-color: #c8dadf;
        background-color: #fff;
    }
    .box__dragndrop,
    .box__icon
    {
        display: none;
    }
    .box.has-advanced-upload .box__dragndrop
    {
        display: inline;
    }
    .box.has-advanced-upload .box__icon
    {
        width: 200px;
        height: 80px;
        fill: #92b0b3;
        border:5px solid pink;
        display: block;
        margin-bottom: 40px;
    }

    .box.is-uploading .box__input,
    .box.is-success .box__input,
    .box.is-error .box__input
    {
        visibility: hidden;
    }

    .box__uploading,
    .box__success,
    .box__error
    {
        display: none;
    }
    .box.is-uploading .box__uploading,
    .box.is-success .box__success,
    .box.is-error .box__error
    {
        display: block;
        position: absolute;
        top: 50%;
        right: 0;
        left: 0;

        -webkit-transform: translateY( -50% );
        transform: translateY( -50% );
    }
    .box__uploading
    {
        font-style: italic;
    }
    .box__success
    {
        -webkit-animation: appear-from-inside .25s ease-in-out;
        animation: appear-from-inside .25s ease-in-out;
    }
    @-webkit-keyframes appear-from-inside
    {
        from	{ -webkit-transform: translateY( -50% ) scale( 0 ); }
        75%		{ -webkit-transform: translateY( -50% ) scale( 1.1 ); }
        to		{ -webkit-transform: translateY( -50% ) scale( 1 ); }
    }
    @keyframes appear-from-inside
    {
        from	{ transform: translateY( -50% ) scale( 0 ); }
        75%		{ transform: translateY( -50% ) scale( 1.1 ); }
        to		{ transform: translateY( -50% ) scale( 1 ); }
    }

    .box__restart
    {
        font-weight: 700;
    }
    .box__restart:focus,
    .box__restart:hover
    {
        color: #39bfd3;
    }

    .box__file
    {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }
    .box__file + .clxlabel
    {
        width:240px;
        height:50px;
        text-overflow: ellipsis;
        white-space: nowrap;
        cursor: pointer;
        display: inline-block;
        overflow: hidden;
    }
    .box__file + .clxlabel:hover strong,
    .box__file:focus + .clxlabel strong,
    .box__file.has-focus + .clxlabel strong
    {
        color: #39bfd3;
    }
    .box__file:focus + .clxlabel,
    .box__file.has-focus + .clxlabel
    {
        outline: 1px dotted #000;
        outline: -webkit-focus-ring-color auto 5px;
    }
    .box__file + .clxlabel *
    {
        /* pointer-events: none; */ /* in case of FastClick lib use */
    }
    .box__button
    {
        font-weight: 700;
        color: #e5edf1;
        background-color: #003049;
        display: block;
        padding: 8px 16px;
        margin: 40px auto 0;
    }
    .box__button:hover,
    .box__button:focus
    {
        background-color: #0f3c4b;
    }

    .box__input  label {
        text-align: left;
    }

</style>



<div style="width:1560px; height:877px;border:1px solid gray;border-radius:5px;position:relative;">

    @if (Auth::User()->PPMitarbeiter_Gruppe  != 'extern')
    <!-- div style="padding:10px;margin:0 auto;overflow: auto;display:none;">
        {{Form::open(array('url' => 'uploadFiles', 'method' => 'POST', 'files' => 'true', 'data-ajax' => 'true', 'name' => 'UplD'))}}﻿
            {{Form::hidden('ppid',$data['pp']['PPProduktpass_Id']);}}
        <div style="width: 420px;float: left; border:1px solid lightgray;height:150px;padding:10px;">
            {{Form::label('1. Schritt',Null,array('style'=>'background-color:#E9E9E9;width:400px;'))}}<br>
            {{Form::label('Dateiart:')}}{{Form::select('filetype', $data['files']['typesLB'],Null,array('style'=>'height:23px;width:260px;margin-top:3px;margin-left:12px;'))}}<br><br>
            {{Form::label('Kategorie:')}}{{Form::select('Kategorie', $data['files']['subtypesLB'],Null,array('style'=>'height:23px;width:260px;margin-top:3px;margin-left:12px;'))}}<br><br>
            {{Form::label('Datei:')}}
            {{Form::file('file',array('style'=>'width:260px;border:none;margin-top:-1px;'))}}<br>
        </div>
        <div style="width: 300px;float: left; border:1px solid lightgray;height:150px;padding:10px;margin-left:15px;margin-right:15px;">
            {{Form::label('2. Schritt',Null,array('style'=>'background-color:#E9E9E9;width:280px;'))}}<br>
            {{Form::label('Bemerkung:')}}<br>{{Form::textarea('bemerkung',NULL,array('style'=>'height:70px;width:280px;'))}}<br>
        </div>
        <div style="width: 200px;float: left; border:1px solid lightgray;height:150px;padding:10px;">
            {{Form::label('3. Schritt',Null,array('style'=>'background-color:#E9E9E9;width:180px;'))}}<br>
            <input type="submit" value="IMPORT" style="width:190px;height:100px;background-color:rgba(246, 168, 40, 1); " />
        </div>
        {{ Form::close()}}
    </div -->
    @endif


    <div id="tabContainer" style="border:1px solid gray;height:876px;overflow: auto;">
        <div id="tabs2">
            <ul>
                <?php $tbid      = 0; ?>
                @foreach ( $data['files']['types'] as $type)
                <li >
                    <a href="#{{$type['Type']}}" onclick="setSubCat('{{$type['Type']}}',{{$tbid++}});">{{$type['Type']}}</a>
                </li>
                @endforeach
                <li >
                    <a href="#RP" onclick="setSubCat('RP',{{$tbid++}});">RP</a>
                </li>

            </ul>
            <?php $tabid     = 3; ?>
            @foreach ( $data['files']['types'] as $type)
            <div id="{{$type['Type']}}" style="height:811px;overflow:hidden;border:none;">
                <?php $tabid++; ?>
                <div id="tabs{{$tabid}}">
                    <ul>
                        <?php $subcatndx = 0 ?>
                        @foreach($data['files']['subtypes'] as $kat)
                        @if ($kat['ParentId'] == $type['Id'])
                        <li>
                            <a href="#{{urlencode($kat['Kategorie'])}}"    onclick="setSubSubCat('{{$subcatndx++}}');">{{$kat['Kategorie']}}</a>
                        </li>
                        @endif
                        @endforeach
                    </ul>

                    @foreach($data['files']['subtypes'] as $kat)

                    @if ($kat['ParentId'] == $type['Id'])

                    <div id="{{urlencode($kat['Kategorie'])}}" style="float: left; width:1475px;border: none;">
                        <div style="width: 945px;border:none;height:770px; overflow: auto;float: left;">
                            <table style="font-family: 'Open sans', Tahoma, Arial;font-size: 11px;">
                                @foreach($data['files']['files'] as $file)
                                @if ($file['PPPPFiles_Type'] == $type['Type'] and $file['PPPPFiles_SubKat'] == $kat['Kategorie']  )
                                @include('projects.pp_files_sub')
                                @endif
                                @endforeach
                            </table>
                        </div>

                        <div class="container" role="main" style="margin:0 auto;float: left; width:528px;">
                            {{Form::open(array('url' => 'uploadFiles', 'method' => 'POST', 'files' => 'true', 'data-ajax' => 'true', 'name' => 'UplD' ,  'enctype'=>"multipart/form-data", 'class'=>'box has-advanced-upload', 'style' => 'margin:0 auto;' ))}}﻿
                            {{Form::hidden('ppid',$data['pp']['PPProduktpass_Id'])}}
                            {{Form::hidden('Kategorie',$kat['Kategorie'])}}
                            {{Form::hidden('filetype',$type['Type'])}}

                            <input type="hidden" name="hiddenActivmainTab" id="hiddenActivmainTab1" value="{{$data['tabs']['mainTab']}}">
                            <input type="hidden" name="hiddenActivsubTabIndex" id="hiddenActivsubTabIndex" value="{{$data['tabs']['subTabIndex']}}">
                            <input type="hidden" name="hiddenActivsubTabName" id="hiddenActivsubTabName" value="{{$data['tabs']['subTabName']}}">
                            <input type="hidden" name="hiddenActivsubsubTabIndex"  id="hiddenActivsubsubTabIndex" value="{{$data['tabs']['subsubTabIndex']}}">


                            <div class="box__input" style="background-color:transparent;">
                                <input type="file" name="file" id="file" class="box__file" data-multiple-caption="{count} files selected" multiple="">
                                <label class="clxlabel" for="file"><strong>Bitte Datei wählen</strong><span class="box__dragndrop"> oder hier ablegen</span>.</label><br>
                                <!-- div style="text-align:left;color:white;background-color: transparent;padding-left:58px;padding-top: 10px;font-size: 12px;">Bemerkung: <input type="text" name="bemerkung" id="bemerkungId" style="width: 253px;padding: 8px;" /></div -->
                                <label for="KreditorId">Bemerkung</label><input type="text" name="bemerkung" id="bemerkungId" />
                                <label for="KreditorId">Kreditor</label><input type="text" name="Kreditor" id="KreditorId" />
                                <label for="BelegNrId">Belegnummer</label><input type="text" name="BelegNr" id="BelegNrId" />
                                <label for="BelegDatumId">Belegdatum</label><input type="text" name="Belegdatum" id="BelegdatumId" />
                                <label for="BetragId">Betrag</label><input type="text" name="Betrag" id="BetragId" style="width:295px;" /><input type="text" name="Wsmy" id="WsmyId" style="width:50px;" />
                                <div style="background-color: transparent;color:white;" id="UplMessageId"></div>
                                <button type="submit" class="box__button">Upload</button>
                                <br>
                            </div>
                            <div class="box__uploading">Lade Datei auf den Server…</div>
                            <div class="box__success">Erledigt! </div>
                            <div class="box__error">Error! <span></span>. Try again!</div>

                            <input type="hidden" name="ajax" value="1">
                            {{Form::close()}}
                        </div>

                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endforeach
            <div id="RP" style="height:811px;overflow:hidden;border:none;">
                <div id="tabs2345">
                    <ul>
                        <?php $subcatndx = 0 ?>
                        @foreach($data['files']['subtypes'] as $kat)
                        @if ($kat['ParentId'] == 47)
                        <li>
                            <a href="#X{{urlencode($kat['Kategorie'])}}"    onclick="setSubSubCat('{{$subcatndx++}}');">{{$kat['Kategorie']." (".$kat['Id'].")"}}</a>
                        </li>
                        @endif
                        @endforeach
                    </ul>

                    @foreach($data['files']['subtypes'] as $kat)

                    @if ($kat['ParentId'] == 47)

                    <div id="X{{urlencode($kat['Kategorie'])}}" style="float: left; width:1475px;border: none;">

                        <div style="width:720px;border:none;height:750px; overflow: auto;float: left;padding:10px;">
                            <table style="font-family:Arial;font-size: 14px; border-collapse: collapse;width:715px;">
                                <tr>
                                    <th style="border:1px solid darkblue; text-align:left; width:120px;background-color: darkblue; color:white;padding:8px;">Kreditor
                                    <th  style="border:1px solid darkblue;text-align:left; width:100px; background-color: darkblue; color:white;padding:8px;">RG-Nr</th>
                                    <th  style="border:1px solid darkblue;text-align:left; background-color: darkblue; color:white;padding:8px;">Datum</th>
                                    <th  style="border:1px solid darkblue;text-align:left; width:120px; background-color: darkblue; color:white;padding:8px;">Betrag</th>
                                    <th  style="border:1px solid darkblue;text-align:center; background-color: darkblue; color:white;padding:8px;">Aktion</th>
                                </tr>
                                @foreach($data['rp'] as $rp)
                                @if ($rp->PPFileTypes_Id == $kat['Id'])
                                <tr>
                                    <td style="padding:8px;border:1px solid darkblue;">{{$rp->Kreditor}}</td>
                                    <td  style="padding:8px;border:1px solid darkblue;">{{$rp->Rechnungsnummer}}</td>
                                    <td  style="padding:8px;border:1px solid darkblue;">{{$rp->Rechnungsdatum}}</td>
                                    <td  style="padding:8px;border:1px solid darkblue;">{{$rp->Währung}} {{number_format($rp->Betrag_netto,2,',','.')}}</td>
                                    <td  style="padding:8px;border:1px solid darkblue;text-align:center; ">
                                        <form action="/setRPinaktiv" method="POST">
                                            <input type="hidden" name="Nummer_id" value="{{$rp->Nummer_Id}}">
                                            <input type="hidden" name="rp_ppid" value="{{$data['pp']['PPProduktpass_Id']}}">
                                            <input type="submit" style="width:70px;" value="löschen">
                                        </form>
                                    </td>

                                </tr>
                                @endif
                                @endforeach
                            </table>
                        </div>

                        <div class="container" role="main" style="margin-left:10px; float: left;padding:10px; width:690px; height:750px; ">
                            <iframe src="{{$kat['iframe']}}" style="width:685px; height:745px;"></iframe>
                        </div>

                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    'use strict';
    function setCat(cat){

    //document.getElementById('hiddenActivmainTab').value = cat;
    }

    function setSubCat(cat, catndx){

    //alert(cat+" " +catndx);
    var inp = $('input[id="hiddenActivsubTabIndex"]');
    inp.val(catndx);
    var inp = $('input[id="hiddenActivsubTabName"]');
    inp.val(cat);
    }


    function setSubSubCat(catndx){
    var inp = $('input[id="hiddenActivsubsubTabIndex"]');
    inp.val(catndx);
    }
    function activateTabsAfterUpload (){

    var maintab = document.getElementById('hiddenActivmainTab1').value;
    var subtabIndex = document.getElementById('hiddenActivsubTabIndex').value;
    var subtabName = document.getElementById('hiddenActivsubTabName').value;
    var subsubtabIndex = document.getElementById('hiddenActivsubsubTabIndex').value;
    $("#tabs").tabs({disabled: 0});
    $("#tabs").tabs({active: maintab});
    var mainTabName = "#tabs-" + maintab;
    $(mainTabName).tabs({disabled: 0}); //subtract one because zero-based
    $(mainTabName).tabs({active: subtabIndex}); //subtract one because zero-based
    var sT = "#" + subtabName;
    $(sT).tabs({disabled: 0}); //subtract one because zero-based
    //alert(subsubtabIndex );
    $(sT).tabs({active: subsubtabIndex}); //subtract one because zero-based
    }

    $(function() {
    activateTabsAfterUpload ();
    });
    (function (document, window, index)
    {
    // feature detection for drag&drop upload
    var isAdvancedUpload = function ()
    {
    var div = document.createElement('div');
    return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
    }();
    // applying the effect for every form
    var forms = document.querySelectorAll('.box');
    Array.prototype.forEach.call(forms, function (form)
    {
    var input = form.querySelector('input[type="file"]'),
            label = form.querySelector('label'),
            errorMsg = form.querySelector('.box__error span'),
            restart = form.querySelectorAll('.box__restart'),
            droppedFiles = false,
            showFiles = function (files)
            {
            label.textContent = files.length > 1 ? (input.getAttribute('data-multiple-caption') || '').replace('{count}', files.length) : files[ 0 ].name;
            },
            triggerFormSubmit = function ()
            {
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
    input.addEventListener('change', function (e)
    {
    showFiles(e.target.files);
    // triggerFormSubmit();


    });
    // drag&drop files if the feature is available
    if (isAdvancedUpload)
    {
    form.classList.add('has-advanced-upload'); // letting the CSS part to know drag&drop is supported by the browser

    ['drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop'].forEach(function (event)
    {
    form.addEventListener(event, function (e)
    {
    // preventing the unwanted behaviours
    e.preventDefault();
    e.stopPropagation();
    });
    });
    ['dragover', 'dragenter'].forEach(function (event)
    {
    form.addEventListener(event, function ()
    {
    form.classList.add('is-dragover');
    });
    });
    ['dragleave', 'dragend', 'drop'].forEach(function (event)
    {
    form.addEventListener(event, function ()
    {
    form.classList.remove('is-dragover');
    });
    });
    form.addEventListener('drop', function (e)
    {
    droppedFiles = e.dataTransfer.files; // the files that were dropped
    showFiles(droppedFiles);
    // triggerFormSubmit();

    });
    }


    // if the form was submitted
    form.addEventListener('submit', function (e)
    {
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
    if (droppedFiles)
    {
    Array.prototype.forEach.call(droppedFiles, function (file)
    {
    ajaxData.append(input.getAttribute('name'), file);
    });
    }

    // ajax request
    var ajax = new XMLHttpRequest();
    ajax.open(form.getAttribute('method'), form.getAttribute('action'), true);
    ajax.onload = function ()
    {
    form.classList.remove('is-uploading');
    var data = JSON.parse(ajax.responseText);
    if (ajax.status >= 200 && ajax.status < 400)
    {
    label.textContent = "";
    document.getElementById("bemerkungId").value = "";
    document.getElementById('UplMessageId').innerHTML = "Datei hochgeladen!";
    //form.classList.add(data.success == true ? 'is-success' : 'is-error');
    if (!data.success){
    errorMsg.textContent = data.error;
    }
    var nLD = JSON.parse(data.tabs);
    var link = "/showAfterUpload/" + nLD.ppid + "/6/" + nLD.subTabName + "/" + nLD.subTabIndex + "/" + nLD.subsubTabIndex;
    //console.log (link);
    window.location.href = link;
    } else{

    alert('Error. Please, contact  Webadmin');
    }
    };
    ajax.onerror = function ()
    {
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
    iframe.addEventListener('load', function ()
    {
    var data = JSON.parse(iframe.contentDocument.body.innerHTML);
    form.classList.remove('is-uploading')
            form.classList.add(data.success == true ? 'is-success' : 'is-error')
            form.removeAttribute('target');
    if (!data.success){
    errorMsg.textContent = data.error;
    }
    iframe.parentNode.removeChild(iframe);
    });
    }
    });
    // restart the form if has a state of error/success
    Array.prototype.forEach.call(restart, function (entry)
    {
    entry.addEventListener('click', function (e)
    {
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
</script>
