 @foreach ( $data['files']['types'] as $type)
        @foreach($data['files']['subtypes'] as $kat)
            @if ($kat['ParentId'] == $type['Id'])
                <div class='FileContainer hidden' id='cont_{{ ServiceProvider::noBlanks($kat['Kategorie']) }}' style='border:none;'>
                    <div style='Border:1px solid lightgray;'>
                        <div style='width:calc(100% - 26px);padding:8px;background-color:lightgray;'><b>{{$type['Type']}}</b> [{{$kat['Kategorie']}}]</div>
                        <div style='width:calc(100% - 26px);padding:8px;'>
                        @if(isset($ord[$kat['Kategorie']]))
                            <div style="width:100%;border: 1px solid lightgray;padding:6px;border-radius:0px;">
                                <div style="border:2px solid dodgerblue;">
                                    <form action="#" method="post" enctype="multipart/form-data" style='width:100%;'>
                                         <?php 
                                            $param = array( 'PPId'    => $data['pp']->PPProduktpass_Id, 
                                                            'Kat'     => $kat['Kategorie'], 
                                                            'Type'    => $type['Type']
                                                        );
                                            $jParams = json_encode($param);
                                        ?>
                                        <div style='width:55%;border:4px solid lime;float:left;'>
                                            <div class='label'>{{ ServiceProvider::tl($lang,'Bemerkung') }}</div>
                                            <div class='valuep0'><textarea id='bemerkungUpl{{$kat['Kategorie']}}' style='width:calc(100% - 4px);height:100px;margin:0;border:none;padding:10px;' name="bemerkungUpl"></textarea></div>
                                            <div  class='label'>{{ ServiceProvider::tl($lang,'Kategorie') }}</div> 
                                            <div  class='valuep0'>
                                            {{$type['Type']}}</b> [{{$kat['Kategorie']}}]
                                            <select style='width:100%;height:30px;margin:0px;' name="ordnungUpl{{$kat['Kategorie']}}" id="ordnungUpl{{$kat['Kategorie']}}">
                                            <option value=''></option>
                                            @foreach($ord[$kat['Kategorie']] as $_kat)
                                                <option>{{$_kat}}</option>
                                            @endforeach
                                            </select>
                                            </div>
                                        </div>
                                         <div class='value cpcInput' style='width:40%;float:left; border:8px solid pink;'>
                                            <input style='height:300px;border:10px solid orange;' id="fileUpl{{$kat['Kategorie']}}" name="fileUpl{{$kat['Kategorie']}}[]" type="file" multiple/>
                                        </div>
                                        <div style='padding:10px;'><button type='button' onclick='uploadFiles({{$jParams}});' style='width:50%;height:40px;'><b>Upload</b></button></div>
                                        <div id='messageUpl{{$kat['Kategorie']}}' class='hidden' >Upload in progress ............</div>
                                    </form>
                                </div>
                                <div style='border:2px solid dodgerblue;text-align:center;'>
                                Filter: <select id="FilterOrdnung{{ServiceProvider::noBlanks($kat['Kategorie'])}}" name="Ordnung" style="width:380px;padding:4px;border:1px solid gray;">
                                            <option value='Alles'>{{ ServiceProvider::tl($lang, 'Alles')}}</option>
                                            @foreach ($ord[$kat['Kategorie']] as $o)
                                            <option value='{{ $o }}'>{{ ServiceProvider::tl($lang, $o )}}</option>
                                            @endforeach
                                        </select>
                                <button type="button" style="padding:6px;" onclick="filter('{{ServiceProvider::noBlanks($kat['Kategorie'])}}');"><b>{{ ServiceProvider::tl($lang, 'Filtern' )}}</b></button>
                                </div>
                            </div>
                        @endif
                        </div>
                    </div>
                    <div style='border:1px solid lightgray;overflow:auto;max-height: calc(100% - 120px);position:relative;'>
                        <div class='FileCompact' >
                            <div class='FileCompactHeader'>{{ ServiceProvider::tl($lang,'Dateiname')}}</div>
                            <div class='FileCompactHeader'>{{ ServiceProvider::tl($lang,'Hochgeladen')}}</div>
                            <!-- div class='FileCompactHeader'>{{ ServiceProvider::tl($lang,'Letzte Änderung SPO')}}</div -->
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
                                    $lc = $data['FilesLastChange'][$file['PPPPFiles_Name']];
                                }
                                //$dllogo = "/images/icon_xml.png";
                            ?>
                            @if ($file['PPPPFiles_Type'] == $type['Type'] and  $file['PPPPFiles_SubKat'] == $kat['Kategorie'])
                            <div id='File_{{$file['PPPPFiles_Id']}}' style='border:none;width:calc(100% - 4px);float:left;'>
                                <div name="{{ServiceProvider::noBlanks($file['PPPPFiles_SubKat'])}}_{{$file['PPPPFiles_Ordnung']}}" class='' style="border:none;padding-top:10px;padding-left:10px; margin-bottom: 10px;position:relative;">
                                    {{Form::open(array('url' => 'updateRemarkFiles', 'method' => 'POST', 'files' => 'true', 'data-ajax' => 'true'))}}
                                        <input type="hidden" name="fileid" id="fileid" value="{{$file['PPPPFiles_Id']}}">
                                        <input type="hidden" name="ppid" id="hiddenActivmainTab" value="{{$data['pp']['PPProduktpass_Id']}}">
                                        <!-- EDIT File Details -->
                                        <div id="FileDetails" style="border:none; ">
                                            @if (strlen($file['PPPPFiles_Link']) > 0 )
                                            <div><a href="{{ $file['PPPPFiles_Link'] }}" target="_blank">{{ $file['PPPPFiles_LinkName'] }}</a></div>
                                            @else 
                                            <div style="overflow:hidden;position:relative;">
                                                <div style='border:none;float:left;padding:0px;position:relative;overflow:hidden;width:calc(100% - 68px);'>
                                                    @if(strlen($file['PPPPFiles_SharePointLink'])>0)
                                                    <div style="border:none;padding:0px;padding-left:10px;margin-left:10px;font-size:0.9em;display:block;height:65px;width:calc(100% - 25px);">
                                                            <div style='font-size:0.5vw;border:none;font-weight:bold;height:auto;overflow: auto;overflow-wrap: anywhere;min-width:calc(100% - 25px);' title='{{ $file['PPPPFiles_Name'] }}'>{{ $file['PPPPFiles_Name'] }}</div>
                                                            <br><br>
                                                            <a href="{{ ViewController::getSpoLink($file['PPPPFiles_Id'], 2) }}" target="blank"><img src="{{url('/data/Icons/Download.jpg')}}" class='fileIcons'  title="{{ ServiceProvider::tl($lang,'DOWNLOAD')}}" /></a>
                                                            <a href="{{ ViewController::getSpoLink($file['PPPPFiles_Id'], 1) }}" target="blank"><img src="{{url('/data/Icons/OpenInBrowser.jpg')}}" class='fileIcons'  title="{{ ServiceProvider::tl($lang,'Öffnen im Browser')}}" /></a>
                                                            @if ($showEdit2)
                                                            <a href="{{ ViewController::getSpoLink($file['PPPPFiles_Id'], 3) }}" target="blank"><img src="{{url('/data/Icons/OpenInApp.jpg')}}" class='fileIcons'  title="{{ ServiceProvider::tl($lang,'Öffnen in App (wenn hinterlegt)')}}" /></a>
                                                            @endif
                                                            @if ($ext == 'xml')
                                                            <a href='{{url("/diffXML/".$data['pp']['PPProduktpass_Id']."/".$file['PPPPFiles_Id'])}}' target='_blank' style='color:gray;text-decoration:none;font-size:0.8em;'><img src="{{url('/data/Icons/Compare.jpg')}}" class='fileIcons'  title="{{ ServiceProvider::tl($lang,'Vergleichen')}}" /></a>
                                                            @endif
                                                            <a href="#"><img src="{{url('/data/Icons/delete.png')}}" class='fileIcons' title="{{ ServiceProvider::tl($lang,'Datei löschen!')}}"  onclick="deleteFile('{{$file['PPPPFiles_Id']}}');"  style='margin-left:28px;'/></a>
                                                    </div>
                                                    @else
                                                        @if ($type['Type'] == 'PPUpload')
                                                            {{ $file['PPPPFiles_Name'] }}
                                                        @else
                                                            <div style="border:none;padding:0px;padding-left:10px;margin-left:10px;font-size:0.9em;display:block;height:65px;width:calc(100% - 25px);">
                                                            <div style='font-size:0.5vw;border:none;font-weight:bold;height:auto;overflow: auto;overflow-wrap: anywhere;min-width:calc(100% - 25px);' title='{{ $file['PPPPFiles_Name'] }}'>{{ substr($file['PPPPFiles_Name'],7) }}</div>
                                                            <br><br>
                                                            <a href="#" onclick="plsWait('{{$data['pp']['PPProduktpass_Id']}}','{{$kat['Kategorie']}}');"><img src="{{url('/data/Icons/Download.jpg')}}" class='fileIcons'  title="{{ ServiceProvider::tl($lang,'DOWNLOAD')}}" /></a>
                                                            <a href="#" onclick="plsWait('{{$data['pp']['PPProduktpass_Id']}}','{{$kat['Kategorie']}}');"><img src="{{url('/data/Icons/OpenInBrowser.jpg')}}" class='fileIcons'  title="{{ ServiceProvider::tl($lang,'Öffnen im Browser')}}" /></a>
                                                            @if ($showEdit2)
                                                            <a href="#" onclick="plsWait('{{$data['pp']['PPProduktpass_Id']}}','{{$kat['Kategorie']}}');"><img src="{{url('/data/Icons/OpenInApp.jpg')}}" class='fileIcons'  title="{{ ServiceProvider::tl($lang,'Öffnen in App (wenn hinterlegt)')}}" /></a>
                                                            @endif
                                                            @if ($ext == 'xml')
                                                            <a href='{{url("/diffXML/".$data['pp']['PPProduktpass_Id']."/".$file['PPPPFiles_Id'])}}' target='_blank' style='color:gray;text-decoration:none;font-size:0.8em;'><img src="{{url('/data/Icons/Compare.jpg')}}" class='fileIcons'  title="{{ ServiceProvider::tl($lang,'Vergleichen')}}" /></a>
                                                            @endif
                                                            <!-- a href="#" onclick="plsWait('{{$data['pp']['PPProduktpass_Id']}}','{{$kat['Kategorie']}}');"><img src="{{url('/data/Icons/delete.png')}}" class='fileIcons' title="{{ ServiceProvider::tl($lang,'Datei löschen!')}}"  style='margin-left:28px;'/></a -->
                                                            <br>
                                                            <span style='color:green;font-size:0.5vw'>Datei wurde auf den lokalen Server geladen und wird in den nächsten Minuten zum Sharepoint Server übertragen</span>
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
                                                                        <img src="{{$server.'/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_TPTFilenameOld']}}" style="height:90%;width:auto;border:none;" />
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <div style="border:none;position:absolute; bottom:0px; left:0px;padding:0px;margin:0; overflow:hidden;height:28px;">
                                                            <form method="POST" action="/setProjectPic" accept-charset="UTF-8" data-ajax="true" style="border:none;margin:0;" enctype="multipart/form-data">
                                                                <input name="ppid" type="hidden" value="{{ $data['pp']['PPProduktpass_Id'] }}">
                                                                <input name="pppic" type="hidden" value="{{ $file['PPPPFiles_Name'] }}">
                                                                <input type="hidden" name="ActivmainTab" id="hiddenActivmainTab" value="#tabs-6">
                                                                <input type="hidden" name="ActivsubTabIndex" id="hiddenActivsubTabIndex" value="{{$data['tabs']['subTabIndex']}}">
                                                                <input type="hidden" name="ActivsubTabName" id="hiddenActivsubTabName" value="{{$data['tabs']['subTabName']}}">
                                                                <input type="hidden" name="ActivsubsubTabIndex" id="hiddenActivsubsubTabIndex" value="{{$data['tabs']['subsubTabIndex']}}">
                                                                <button style="margin-top:52px;border:none;width:74px;padding:10px;margin:0;opacity: 0.8;font-size:0.7rem;" type="submit" value="als Projektbild festlegen">{{ ServiceProvider::tl($lang,'Projektbild')}}</button>
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
                                                        @if ($ext == 'CodeLöschenxml')
                                                            <div style="width:64px; height:20px;text-align:center; position:absolute; bottom:0px; left:0; padding:0px; margin:0; border-top:1px solid lightgray;">
                                                                    <a href='{{url("/diffXML/".$data['pp']['PPProduktpass_Id']."/".$file['PPPPFiles_Id'])}}' target='_blank' style='color:gray;text-decoration:none;font-size:0.8em;'>vergleichen</a>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                            <div>{{date_format(date_create_from_format('Y-m-d H:i:s',$file['PPPPFiles_Date']),'d.m.Y')}} <br> @if (is_null($file['PPPPFiles_SharePointLink'])) NO-SPO @endif</div>
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
                                                <textarea name="TA" style="font-size:0.9em;border-radius:0px;border:none;width:100%;height:100%;padding:4px;" id="textarea-container_{{$file['PPPPFiles_Id']}}">{{$file['PPPPFiles_Description']}}</textarea>
                                                <div style='position:absolute;bottom:0;right:0;border:none;width:20px;height:16px;background-color:transparent;'>
                                                <a href='#' onclick="saveRemark({{$file['PPPPFiles_Id']}});"><img  src="{{url('/data/Icons/speichern.png')}}" class='fileIcons'  title="{{ ServiceProvider::tl($lang,'Speichern')}}"/></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ENDE EDIT File Details -->
                                    {{ Form::close() }}
                                </div>
                            </div>
                            @endif
                        @endforeach
                        <!-- **************************************************** -->
                        <!-- **************************************************** -->
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach