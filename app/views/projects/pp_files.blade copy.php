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
</style>


<?PHP

$ord = array ();
$ord ['Product details'] = array('pass','quote','photo', 'video');
$ord ['Contracts'] = array('PO', 'Purchase Agreement','AB', 'LC' );
$ord ['Project Plan'] = array('MP Plan', 'Overview', 'serial number');
$ord ['Invoice'] = array('VDE', 'TÜV S', 'TÜV R', 'SLG', 'OWIM', 'Supplier', 'TARGA', 'Other');
$ord ['Statements'] = array( 'EUG', 'SER', 'PSI', 'QS', 'Musterung' );
$ord ['Offer'] = array('PLAN', 'FIX', 'Musterung' );

?>


<div style="width:100%; height:877px;border:1px solid gray;border-radius:5px;position:relative;">

      <div id="tabContainer" style="border:1px solid gray;height:875px;overflow: auto;">
        <div id="tabs2">
            <ul>
                <?php $tbid      = 0; ?>
                @foreach ( $data['files']['types'] as $type)
                <li>
                    <a href="#{{$type['Type']}}" onclick="setSubCat('{{$type['Type']}}',{{$tbid++}});">{{$type['Type']}}</a>
                </li>
                @endforeach
            </ul>
            <?php $tabid     = 3; ?>
            @foreach ( $data['files']['types'] as $type)
            <div id="{{$type['Type']}}" style="height:830px;overflow:hidden;border:none;">
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

                    <div id="{{urlencode($kat['Kategorie'])}}" style="float: left; width:1475px;border: none;height: 780px; overflow: hidden;">
                        <div style="width: 960px;border:2px solid rgb(11, 161, 181);overflow: auto;float: left;height: 770px;">
                            <table style="font-family: 'Open sans', Tahoma, Arial;font-size: 11px;">
                                @foreach($data['files']['files'] as $file)
                                @if ($file['PPPPFiles_Type'] == $type['Type'] and $file['PPPPFiles_SubKat'] == $kat['Kategorie'] )
                                    @include('projects.pp_files_sub')
                                @endif
                                @endforeach
                            </table>
                        </div>
                        <div style="margin:0 auto;float: left; width:460px;border:1px solid gray;height:780px;position: relative;">
                            @if(isset($ord[$kat['Kategorie']]))
                            <div>
                               
                               <div style="width: 450px;padding:10px;height:350px;"> <h3>Filterfunktionen</h3>
                                    <form>
                                    
                                       <fieldset> <label>Kategorie:
                                            <select name="Ordnung" style="width:380px;padding:4px;">
                                                @foreach ($ord[$kat['Kategorie']] as $o)
                                                <option>{{ $o }}</option>
                                                @endforeach
                                            </select>
                                        </label><br>
                                        <label><button type="submit" style="padding:10px;width:380px;"><b>Filtern</b></button></label></fieldset>
                                    </form>
                                </div>
                            </div>
                            @endif
                            <div style="position: absolute; bottom: 10px;border:none;width: 450px;padding:10px;">
                                <h3>Upload</h3>
                            {{Form::open(array('id' => $kat['Kategorie'], 'url' => 'uploadFiles', 'method' => 'POST', 'files' => 'true', 'name' => 'UplD' , 'enctype'=>"multipart/form-data", 'style' => 'margin:0 auto;' ))}}
                            {{Form::hidden('ppid',$data['pp']['PPProduktpass_Id'])}}
                            {{Form::hidden('Kategorie',$kat['Kategorie'])}}
                            {{Form::hidden('filetype',$type['Type'])}}
                            <input type="hidden" name="hiddenActivmainTab" id="hiddenActivmainTab1" value="{{$data['tabs']['mainTab']}}">
                            <input type="hidden" name="hiddenActivmainTabIndex" id="hiddenActivmainTabIndex" value="{{$data['tabs']['mainTabIndex']}}">
                            <input type="hidden" name="hiddenActivsubTabIndex" id="hiddenActivsubTabIndex" value="{{$data['tabs']['subTabIndex']}}"> {{-- {{$data['tabs']['subTabIndex']}} --}}
                            <input type="hidden" name="hiddenActivsubTabName" id="hiddenActivsubTabName" value="{{$data['tabs']['subTabName']}}"> {{-- {{$data['tabs']['subTabName']}} --}}
                            <input type="hidden" name="hiddenActivsubsubTabIndex" id="hiddenActivsubsubTabIndex" value="{{$data['tabs']['subsubTabIndex']}}"> {{-- {{$data['tabs']['subsubTabIndex']}} --}}

                            {{--  Type:{{  $type['Type']  }}<br>
                            Kat: {{ $kat['Kategorie'] }}<br>
                            Pid: {{ $data['pp']['PPProduktpass_Id'] }}<br>
                            --}}


                            <fieldset>
                                @if(isset($ord[$kat['Kategorie']]))
                                <label>Kategorie:
                                    <select name="Ordnung" style="width:380px;padding:4px;">
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
                                <label>Datei Auswahl:
                                    <input type="file" name="file" id="file" style="display: inline; width:380px;font-size: 10px;">
                                </label><br>
                                <label><button type="submit" style="padding:10px;width:380px;"><b>Upload</b></button></label>
                                
                            </fieldset>
                            {{Form::close()}}
                        </div><br>
                        
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>


<script>

    'use strict';
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
   
    function activateTabsAfterUpload() {

        
        var maintab = document.getElementById('hiddenActivmainTab1').value;
        var maintabIndex = document.getElementById('hiddenActivmainTabIndex').value;
        var subtabIndex = document.getElementById('hiddenActivsubTabIndex').value;
        var subtabName = document.getElementById('hiddenActivsubTabName').value;
        var subsubtabIndex = document.getElementById('hiddenActivsubsubTabIndex').value;

        if (maintab == 0){
            return;
        }

        console.log("main:" + maintab + " mainindex:" + maintabIndex + " SubIndex:" + subtabIndex + " Subname:" +     subtabName + " SubSubIndex:" +     subsubtabIndex);
        $("#tabs").tabs({ disabled: 0 });
        $("#tabs").tabs({ active: maintabIndex });
        var mainTabName = "#tabs-" + maintab;
        console.log("maintab:"  + mainTabName);
        $(mainTabName).tabs({ disabled: 0 }); //subtract one because zero-based
        $(mainTabName).tabs({ active: subtabIndex }); //subtabIndex  subtract one because zero-based
        var sT = "#" + subtabName;
        console.log("sT:"  + sT);
        $(sT).tabs({ disabled: 0 }); //subtract one because zero-based
        console.log(subsubtabIndex );
        $(sT).tabs({ active: subsubtabIndex }); // subsubtabIndex subtract one because zero-based
    }

    $(function () {
        //alert("Ready");
        activateTabsAfterUpload();
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
</script>