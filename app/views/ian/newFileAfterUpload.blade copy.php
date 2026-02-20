 @foreach ( $data['files']['types'] as $type) 
        @foreach($data['files']['subtypes'] as $kat)
            @if ($kat['ParentId'] == $type['Id'])
                <div class='FileContainer hidden' id='cont_{{ ServiceProvider::noBlanks($kat['Kategorie']) }}' style='overflow:hidden;'>
                    <div style='width:calc(100% - 10px);max-height:430px;position:relative;border:none;overflow:auto;'>
                        <div style='width:calc(100% - 26px);padding:8px;background-color:lightgray;'><b>{{ ServiceProvider::tl($lang,$type['Type'])}}</b> [{{ServiceProvider::tl($lang,$kat['Kategorie'])}}]</div>
                        <div id='ovUpload1' class='' style='width:calc(100% - 12px); border:1px solid lightgray;'> 
                            <div style='width:calc(100% - 26px);padding:8px;'>
                                <div style='padding:0px;color:darkgray;border:1px solid gray; width:95%;'>
                                    <form action="/uploadFilesNew" method="post" enctype="multipart/form-data" style='width:100%;'>
                                        <input type='hidden' id='ppidUpl{{ServiceProvider::noBlanks($kat['Kategorie'])}}' value="{{ $data['pp']->PPProduktpass_Id }}">
                                        <input type='hidden' id='typeUpl{{ServiceProvider::noBlanks($kat['Kategorie'])}}'  value="{{ $type['Type'] }}">
                                        <input type='hidden' id='katUpl{{ServiceProvider::noBlanks($kat['Kategorie'])}}'  value= "{{ $kat['Kategorie'] }}">
                                        <input type='hidden' name="versioning" id="verUpl{{ServiceProvider::noBlanks($kat['Kategorie'])}}" value='0'>
                                        <div style="color:black;font-size:1.2em;font-weight:bold;text-align:left;padding-left:10px;padding-top:6px;padding-bottom:6px;">
                                            <span>Upload</span>
                                        </div>
                                        <table class='UplTable'>
                                            <tr>
                                                <td>1. {{ ServiceProvider::tl($lang,'Dateien auswählen')}}</td>
                                                <td>
                                                        <div id="dropZone{{ServiceProvider::noBlanks($kat['Kategorie'])}}">{{ ServiceProvider::tl($lang,'Dateien hierher ziehen oder klicken!!!')}}</div>
                                                        <input type="file" id="fileUpl{{ServiceProvider::noBlanks($kat['Kategorie'])}}" name="fileUpl{{ServiceProvider::noBlanks($kat['Kategorie'])}}[]" multiple>
                                                </td>
                                                <td style="width:20%;">2. {{ ServiceProvider::tl($lang,'Kategorie eingeben')}}</td>
                                                <td>
                                                    <select class='s2' name="ordnungUpl{{ServiceProvider::noBlanks($kat['Kategorie'])}}" id="ordnungUpl{{ServiceProvider::noBlanks($kat['Kategorie'])}}" >
                                                        <option class='02'  value=''> </option>
                                                        @if(isset($ord[$kat['Kategorie']]))
                                                            @foreach ($ord[$kat['Kategorie']] as $o)
                                                                <option class='02' value='{{ $o }}'>{{ ServiceProvider::tl($lang, $o )}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="background-color:white;"><div id="preview{{ServiceProvider::noBlanks($kat['Kategorie'])}}"></div></td>
                                            </tr>
                                            @if (strpos(Auth::user()->PPMitarbeiter_Role,'INTERN') !== false )
                                            <tr>
                                                <td>3. {{ ServiceProvider::tl($lang,'Bemerkung erfassen')}}</td>
                                                <td>
                                                    <textarea class='s2' id='bemerkungUpl{{ServiceProvider::noBlanks($kat['Kategorie'])}}' name="bemerkungUpl{{ServiceProvider::noBlanks($kat['Kategorie'])}}"></textarea>
                                                </td>
                                                <td >4. {{ ServiceProvider::tl($lang,'Dateien extern verfügbar')}}</td>
                                                <td style='padding:0px;'>
                                                    <div style="position:relative;">
                                                        <input type="checkbox" style="width:40px;height:40px;margin-top:5px; margin-left:20px;"   id='isExternUpl{{ServiceProvider::noBlanks($kat['Kategorie'])}}' name="isExternUpl{{ServiceProvider::noBlanks($kat['Kategorie'])}}" value='1' />
                                                    </div>
                                                </td>
                                            </tr>
                                             <tr>
                                                <td colspan="4" style="background-color:white;padding:0px;"><div style="height:10px;">&nbsp;</div></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td  >5. {{ ServiceProvider::tl($lang,'Dateien hochladen')}}</td>
                                                <td>
                                                    <div style="position:relative;">
                                                        <div id='messageUpl{{ServiceProvider::noBlanks($kat['Kategorie'])}}' class='hidden' style='width:calc(100% - 20px);height:47px;padding:10px;padding-top:12px; position:absolute;top:0;left:0; z-index:1000;text-align:center;vertical-align:middle;'></div>
                                                        <button type='button' id='btn_upload1' onclick="upl('{{ServiceProvider::noBlanks($kat['Kategorie'])}}');"  style="width:100%;height:66px;padding:10px;" ><b>{{ ServiceProvider::tl($lang,'Dateien hochladen')}}</b></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td>3. {{ ServiceProvider::tl($lang,'Bemerkung erfassen')}}</td>
                                                <td>
                                                    <textarea class='s2' id='bemerkungUpl{{ServiceProvider::noBlanks($kat['Kategorie'])}}' name="bemerkungUpl{{ServiceProvider::noBlanks($kat['Kategorie'])}}"></textarea>
                                                </td>
                                                <td  >4. {{ ServiceProvider::tl($lang,'Dateien hochladen')}}</td>
                                                <td>
                                                    <div style="position:relative;">
                                                        <input type="hidden" style="width:40px;height:40px;margin-top:5px; margin-left:20px;"   id='isExternUpl{{ServiceProvider::noBlanks($kat['Kategorie'])}}' name="isExternUpl{{ServiceProvider::noBlanks($kat['Kategorie'])}}" value='1' />
                                                        <div id='messageUpl{{ServiceProvider::noBlanks($kat['Kategorie'])}}' class='hidden' style='width:calc(100% - 20px);height:47px;padding:10px;padding-top:12px; position:absolute;top:0;left:0; z-index:1000;text-align:center;vertical-align:middle;'></div>
                                                        <button type='button' id='btn_upload1' onclick="upl('{{ServiceProvider::noBlanks($kat['Kategorie'])}}');"  style="width:100%;height:66px;padding:10px;" ><b>{{ ServiceProvider::tl($lang,'Dateien hochladen')}}</b></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style='Border:none;'>
                            @if(isset($ord[$kat['Kategorie']]))
                                <div style="width:calc(100% - 10px);border: 1px solid lightgray;padding:6px;border-radius:0px;">
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
                                </div>
                            @endif
                    </div>
                    <div style='border:1px solid lightgray;overflow:auto;height: calc(100% - 120px); max-height:600px;min-height:400px; position:relative;'>
                        <div class='FileCompact'>
                            <div class='FileCompactHeader'>{{ ServiceProvider::tl($lang,'Dateiname')}}</div>
                            <div class='FileCompactHeader'>{{ ServiceProvider::tl($lang,'Hochgeladen')}}</div>
                            <div class='FileCompactHeader'>{{ ServiceProvider::tl($lang,'Kategorie')}}</div>
                            <div class='FileCompactHeader'>{{ ServiceProvider::tl($lang,'Bemerkung')}}</div>
                        </div>
                        <div id='newFileUpload_{{$type['Type']}}_{{$kat['Kategorie']}}' class='hidden'>{{$type['Type']}}<br>{{$kat['Kategorie']}}</div>
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
                                    $lc = 'SPO: ' .  $data['FilesLastChange'][$file['PPPPFiles_Name']];
                                }
                                $externColor = 'darkblue';
                                $classCHN = 'MoveShow';
                                $classINT = 'MoveHide';
                                if ($file['PPPPFiles_IsExtern']){
                                    $externColor = 'red';
                                    $classCHN = 'MoveHide';
                                    $classINT = 'MoveShow';
                                }
                            ?>
                            @if ($file['PPPPFiles_Type'] == $type['Type'] and  $file['PPPPFiles_SubKat'] == $kat['Kategorie'])
                            <div id='File_{{$file['PPPPFiles_Id']}}' style='border:none;width:calc(100% - 4px);float:left;'>
                                <div name="{{ServiceProvider::noBlanks($file['PPPPFiles_SubKat'])}}_{{$file['PPPPFiles_Ordnung']}}" class='' style="border:none;padding-top:10px;padding-left:10px; margin-bottom: 10px;position:relative;font-size:0.9em;">
                                    <form method="POST" action="/updateRemarkFiles" accept-charset="UTF-8" data-ajax="true" enctype="multipart/form-data">
                                        <input type="hidden" name="fileid" id="fileid" value="{{$file['PPPPFiles_Id']}}">
                                        <input type="hidden" name="ppid" id="hiddenActivmainTab" value="{{$data['pp']['PPProduktpass_Id']}}">
                                        <div id="FileDetails" style="border:none; ">
                                            @if (strlen($file['PPPPFiles_Link']) > 0 )
                                            <div><a id="Link1_{{ $file['PPPPFiles_Link'] }}"  href="{{ $file['PPPPFiles_Link'] }}" target="_blank">{{ $file['PPPPFiles_LinkName'] }}</a></div>
                                            @else 
                                            <div style="overflow:hidden;position:relative;">
                                                <div style='border:none;float:left;padding:0px;position:relative;overflow:hidden;width:calc(100% - 68px);'>
                                                    @if(strlen($file['PPPPFiles_SharePointLink'])>0)
                                                    <div style="border:none;padding:0px;padding-left:10px;margin-left:10px;font-size:0.9em;display:block;height:65px;width:calc(100% - 25px);">
                                                            <div id='fnBox_{{$file['PPPPFiles_Id']}}' style='font-size:0.5vw;border:none;font-weight:bold;height:auto;overflow: auto;overflow-wrap: anywhere;min-width:calc(100% - 25px);color:{{$externColor}};' title='{{ $file['PPPPFiles_Name'] }}'>
                                                               {{ $file['PPPPFiles_Name'] }}</div>
                                                            <br><br>
                                                            <a id="Link2_{{ $file['PPPPFiles_Id'] }}" href="{{ ViewController::getSpoLink($file['PPPPFiles_Id'], 2) }}" target="_blank"><img src="{{url('/data/Icons/Download.jpg')}}" class='fileIcons'  title="{{ ServiceProvider::tl($lang,'DOWNLOAD')}}" ></a>
                                                            <a id="Link3_{{ $file['PPPPFiles_Id'] }}" href="{{ ViewController::getSpoLink($file['PPPPFiles_Id'], 1) }}" target="_blank"><img src="{{url('/data/Icons/OpenInBrowser.jpg')}}" class='fileIcons'  title="{{ ServiceProvider::tl($lang,'Oeffnen im Browser')}}" ></a>
                                                            @if ($showEdit2)
                                                            <a id="Link4_{{ $file['PPPPFiles_Id'] }}"  href="{{ ViewController::getSpoLink($file['PPPPFiles_Id'], 3) }}" target="_blank"><img src="{{url('/data/Icons/OpenInApp.jpg')}}" class='fileIcons'  title="{{ ServiceProvider::tl($lang,'Oeffnen in App (wenn hinterlegt)')}}"></a>
                                                            @endif
                                                            @if ($ext == 'xml')
                                                            <a href='{{url("/diffXML/".$data['pp']['PPProduktpass_Id']."/".$file['PPPPFiles_Id'])}}' target='_blank' style='color:gray;text-decoration:none;font-size:0.8em;'><img src="{{url('/data/Icons/Compare.jpg')}}" class='fileIcons'  title="{{ ServiceProvider::tl($lang,'Vergleichen')}}"></a>
                                                             @if (Auth::user()->PPMitarbeiter_Kuerzel == 'MM_admin' or Auth::user()->PPMitarbeiter_Kuerzel == 'FKE' )
                                                                <a href='{{url("/mailCompare/".$data['pp']['PPProduktpass_Id']."/".$file['PPPPFiles_Id'])}}' target='_blank' style='color:gray;text-decoration:none;font-size:0.8em;'>[MAIL]</a>
                                                            @endif
                                                            @endif
                                                            <a href="#"><img src="{{url('/data/Icons/delete.png')}}" class='fileIcons' title="{{ ServiceProvider::tl($lang,'Datei loeschen!')}}"  onclick="deleteFile('{{$file['PPPPFiles_Id']}}');"  style='margin-left:28px;'></a>
                                                            @if (strpos(Auth::user()->PPMitarbeiter_Role,'TESTER') !== false)
                                                                    <a class='{{$classINT}}' id="LinkMoveCHN_{{ $file['PPPPFiles_Id'] }}"  href="#"><img src="{{url('/data/Icons/MakeAvailExternal_blue.png')}}" class='fileIcons'  onclick="moveFileSPO('{{$file['PPPPFiles_Id']}}', 'CHN');" title="{{ ServiceProvider::tl($lang,'Nach intern verschieben')}}"></a>
                                                                    <a class='{{$classCHN}}' id="LinkMoveDE_{{ $file['PPPPFiles_Id'] }}" href="#"><img src="{{url('/data/Icons/MakeAvailExternal_red.png')}}" class='fileIcons'  onclick="moveFileSPO('{{$file['PPPPFiles_Id']}}', 'DE');" title="{{ ServiceProvider::tl($lang,'Extern verfügbar machen')}}"></a>
                                                            @endif
                                                    </div>
                                                    @else
                                                        @if ($type['Type'] == 'PPUpload')
                                                            {{ $file['PPPPFiles_Name'] }}
                                                        @else
                                                            <div style="border:none;padding:0px;padding-left:10px;margin-left:10px;font-size:0.9em;display:block;height:65px;width:calc(100% - 25px);">
                                                            <div style='font-size:0.5vw;border:none;font-weight:bold;height:auto;overflow: auto;overflow-wrap: anywhere;min-width:calc(100% - 25px);' title='{{ $file['PPPPFiles_Name'] }}'>{{ substr($file['PPPPFiles_Name'],7) }}</div>
                                                            <br><br>
                                                            <a href="#" onclick="plsWait('{{$data['pp']['PPProduktpass_Id']}}','{{$kat['Kategorie']}}');"><img src="{{url('/data/Icons/Download.jpg')}}" class='fileIcons'  title="{{ ServiceProvider::tl($lang,'DOWNLOAD')}}"></a>
                                                            <a href="#" onclick="plsWait('{{$data['pp']['PPProduktpass_Id']}}','{{$kat['Kategorie']}}');"><img src="{{url('/data/Icons/OpenInBrowser.jpg')}}" class='fileIcons'  title="{{ ServiceProvider::tl($lang,'Oeffnen im Browser')}}"></a>
                                                            @if ($showEdit2)
                                                            <a href="#" onclick="plsWait('{{$data['pp']['PPProduktpass_Id']}}','{{$kat['Kategorie']}}');"><img src="{{url('/data/Icons/OpenInApp.jpg')}}" class='fileIcons'  title="{{ ServiceProvider::tl($lang,'Oeffnen in App (wenn hinterlegt)')}}"></a>
                                                            @endif
                                                            @if ($ext == 'xml')
                                                            <a href='{{url("/diffXML/".$data['pp']['PPProduktpass_Id']."/".$file['PPPPFiles_Id'])}}' target='_blank' style='color:gray;text-decoration:none;font-size:0.8em;'><img src="{{url('/data/Icons/Compare.jpg')}}" class='fileIcons'  title="{{ ServiceProvider::tl($lang,'Vergleichen')}}"></a>
                                                            @endif
                                                            <br>
                                                            <span style='color:green;font-size:0.5vw'>{{ServiceProvider::tl($lang,'Datei wurde auf den lokalen Server geladen und wird in den naechsten Minuten zum Sharepoint Server uebertragen')}}</span>
                                                            <button type='button' onclick="refreshFiles('{{$data['pp']['PPProduktpass_Id']}}','{{$kat['Kategorie']}}');">Refresh</button>
                                                    </div>
                                                        @endif<br>
                                                    @endif
                                                </div>
                                                <div style='padding:0px;overflow:hidden;position:absolute;top:0;right:0;'>
                                                    @if (strtoupper(substr($file['PPPPFiles_Name'],-4)) == '.JPG' || strtoupper(substr($file['PPPPFiles_Name'],-5)) == '.JPEG' || strtoupper(substr($file['PPPPFiles_Name'],-4)) == '.PNG'|| strtoupper(substr($file['PPPPFiles_Name'],-4)) == '.GIF' )
                                                        <div style="border:none;padding:0px;height:calc(100% - 4px); ">
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
                                                                        <img src="{{$server.'/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_TPTFilenameOld']}}" style="height:90%;width:auto;border:none;">
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <div style="border:none;position:absolute; bottom:0px; left:0px;padding:0px;margin:0; overflow:hidden;height:28px;">
                                                            <form method="POST" action="/updateProjektPicAjax" accept-charset="UTF-8" data-ajax="true" style="border:none;margin:0;" enctype="multipart/form-data">
                                                                <button style="margin-top:52px;border:none;width:74px;padding:10px;margin:0;opacity: 0.8;font-size:0.7rem;" type="button" onclick="updateProjectPic({{ $data['pp']['PPProduktpass_Id'] }},  {{$file['PPPPFiles_Id']}});" value="als Projektbild festlegen">{{ ServiceProvider::tl($lang,'Projektbild')}}</button>
                                                            </form>
                                                        </div>
                                                    @else
                                                        @if ($type['Type'] == 'PPUpload')
                                                            <a href="{{ViewController::getSpoLink($file['PPPPFiles_Id'],1)}}" target="_blank" download="{{$file['PPPPFiles_Name']}}">
                                                        @else
                                                            <a href="{{ViewController::getSpoLink($file['PPPPFiles_Id'],1)}}" target="_blank" download="{{substr($file['PPPPFiles_Name'],7)}}">
                                                        @endif
                                                        @if (strlen($dllogo)> 10)
                                                            <img src="{{$dllogo}}" alt="Datei" style="height:80%;border:none;">
                                                        @else
                                                            {{substr($file['PPPPFiles_Name'],7)}}
                                                        @endif
                                                        </a>
                                                        @if ($ext == 'CodeLOeschenxml')
                                                            <div style="width:64px; height:20px;text-align:center; position:absolute; bottom:0px; left:0; padding:0px; margin:0; border-top:1px solid lightgray;">
                                                                    <a href='{{url("/diffXML/".$data['pp']['PPProduktpass_Id']."/".$file['PPPPFiles_Id'])}}' target='_blank' style='color:gray;text-decoration:none;font-size:0.8em;'>{{ServiceProvider::tl($lang,'vergleichen')}}</a>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                            <div style='font-size:0.9em;'>{{date_format(date_create_from_format('Y-m-d H:i:s',$file['PPPPFiles_Date']),'d.m.Y')}} <br> @if (is_null($file['PPPPFiles_SharePointLink'])) NO-SPO @else {{ $lc }} @endif</div>
                                            <div>
                                                @if(isset($ord[$kat['Kategorie']]))
                                                    <select id="OrdnungSub_{{ $file['PPPPFiles_Id'] }}" name="OrdnungSub" style="width:calc(100% - 5px);;padding:4px;margin-left:0px;">
                                                        @foreach ($ord[$kat['Kategorie']] as $o)
                                                        <option @if( trim($file['PPPPFiles_Ordnung']) == trim($o) ) selected @endif value='{{ $o }}'>{{ ServiceProvider::tl($lang, $o )}}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                            <div style="padding:0px;position:relative;height:calc(100% + 14px);">
                                                <textarea name="TA" style="font-size:0.9em;border-radius:0px;border:none;width:100%;height:100%;padding:4px;" id="textarea-container_{{$file['PPPPFiles_Id']}}">{{ ServiceProvider::tl($lang,$file['PPPPFiles_Description'])}}</textarea>
                                                <div style='position:absolute;bottom:0;right:0;border:none;width:20px;height:16px;background-color:transparent;'>
                                                <a href='#' onclick="saveRemark({{$file['PPPPFiles_Id']}});"><img  src="{{url('/data/Icons/speichern.png')}}" class='fileIcons'  title="{{ ServiceProvider::tl($lang,'Speichern')}}"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach
