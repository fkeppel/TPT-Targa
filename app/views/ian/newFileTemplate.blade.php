 <?php 
    $dllogo = '/images/newFile.png';
?>
<div id='File_Neu' style='border:4px solid green;width:calc(100% - 4px);float:left;'>
    <div name="{{ServiceProvider::noBlanks($file['PPPPFiles_SubKat'])}}_{{$file['PPPPFiles_Ordnung']}}" class='' style="border:none;padding-top:10px;padding-left:10px; margin-bottom: 10px;position:relative;">
        {{Form::open(array('url' => 'updateRemarkFiles', 'method' => 'POST', 'files' => 'true', 'data-ajax' => 'true'))}}
            <input type="hidden" name="fileid" id="fileid" value="{{$file['PPPPFiles_Id']}}">
            <input type="hidden" name="ppid" id="hiddenActivmainTab" value="{{$data['pp']['PPProduktpass_Id']}}">
            <!-- EDIT File Details -->
            <div id="FileDetails" style="border:none; ">
                <div style="overflow:hidden;position:relative;">
                    <div style='border:none;float:left;padding:0px;position:relative;overflow:hidden;'>
                            @if ($type['Type'] == 'PPUpload')
                                {{ $file['PPPPFiles_Name'] }}
                            @else
                                {{ substr($file['PPPPFiles_Name'],7) }}
                            @endif<br>
                    </div>
                    <div style='padding:0px;overflow:hidden;position:absolute;top:0;right:0;'>
                        @if (strtoupper(substr($file['PPPPFiles_Name'],-4)) == '.JPG' || strtoupper(substr($file['PPPPFiles_Name'],-5)) == '.JPEG' || strtoupper(substr($file['PPPPFiles_Name'],-4)) == '.PNG'|| strtoupper(substr($file['PPPPFiles_Name'],-4)) == '.GIF' )
                            <div style="border:none;padding:0px;height:calc(100% - 4px); ">
                                    @if ($type['Type'] == 'PPUpload')
                                        <a href="{{$server.'/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_TPTFilenameOld']}}" download="{{$file['PPPPFiles_TPTFilenameOld']}}" target="_blank">
                                            <img src="url($spo_file)" style="height:90%;width:auto;border:none;">
                                        </a>
                                    @else
                                        <a href="{{$server.'/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_TPTFilenameOld']}}" download="{{substr($file['PPPPFiles_TPTFilenameOld'],7)}}" target="_blank">
                                            <img src="{{$server.'/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_TPTFilenameOld']}}" style="height:90%;width:auto;border:none;" />
                                        </a>
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
                            @if ($ext == 'xml')
                                <div style="width:64px; height:20px;text-align:center; position:absolute; bottom:0px; left:0; padding:0px; margin:0; border-top:1px solid lightgray;">
                                        <a href='{{url("/diffXML/".$data['pp']['PPProduktpass_Id']."/".$file['PPPPFiles_Id'])}}' target='_blank' style='color:gray;text-decoration:none;font-size:0.8em;'>vergleichen</a>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                <div>{{date_format(date_create_from_format('Y-m-d H:i:s',$file['PPPPFiles_Date']),'d.m.Y')}} <br> @if (is_null($file['PPPPFiles_SharePointLink'])) NO-SPO @endif</div>
                <!-- div>{{$lc}}</div -->
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