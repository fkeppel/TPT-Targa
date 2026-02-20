@if (strlen($file['PPPPFiles_Name']) > 0)
    <?PHP
        $fileparts = explode('.', $file['PPPPFiles_Name']);
        $ext       = $fileparts[count($fileparts) - 1];
        $dllogo    = "/images/" . strtolower($ext) . ".png";
        //$dllogo = "/images/icon_xml.png";
    ?>
    <!--div>{{$file['PPPPFiles_Type']}}<br>{{ $kat['Kategorie']}}</div -->
<style>
    #FileDetails {
        display:grid; grid-template-columns: 150px 360px;
        border-collapse: collapse;
        border: none;
    }
    #FileDetails div {
        padding:5px;
        border: 1px solid darkgray;
    }
    #FileDetails  textarea {
        border:none;
        min-height:60px;
        width:99%;
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
</style>
        <div   style="border:none;padding:0px; border-bottom: 2px solid darkgray;margin-bottom: 10px;">
            {{Form::open(array('url' => 'updateRemarkFiles', 'method' => 'POST', 'files' => 'true', 'data-ajax' => 'true'))}}
                <input type="hidden" name="fileid" id="fileid" value="{{$file['PPPPFiles_Id']}}">
                <input type="hidden" name="ppid" id="hiddenActivmainTab" value="{{$data['pp']['PPProduktpass_Id']}}">
                <input type="hidden" name="ActivmainTab" id="hiddenActivmainTab" value="#tabs-6">
                <input type="hidden" name="ActivsubTabIndex" id="hiddenActivsubTabIndex" value="{{$data['tabs']['subTabIndex']}}">
                <input type="hidden" name="ActivsubTabName" id="hiddenActivsubTabName" value="{{$data['tabs']['subTabName']}}">
                <input type="hidden" name="ActivsubsubTabIndex"  id="hiddenActivsubsubTabIndex" value="{{$data['tabs']['subsubTabIndex']}}">
                <div id="FileDetails" style="border:none;">
                    <div style="background-color:lightgray ;font-weight:bold;">Hochgeladen am:</div>
                    <div>{{date_format(date_create_from_format('Y-m-d H:i:s',$file['PPPPFiles_Date']),'d.m.Y H:i:s')}}</div>
                    <div style="background-color:lightgray ;font-weight:bold;">Kategorie:</div>
                    <div>
                    @if(isset($ord[$kat['Kategorie']]))
                        <select id="OrdnungSub{{ $kat['Kategorie'] }}" name="OrdnungSub" style="width:220px;padding:4px;margin-left:0px;" >
                            @foreach ($ord[$kat['Kategorie']] as $o)
                                <option @if(trim($file['PPPPFiles_Ordnung']) == trim($o)) selected @endif>{{ $o }}</option>
                            @endforeach
                        </select>
                    @endif
                    </div>
                    @if (strlen($file['PPPPFiles_Link']) > 0 )
                    <div style="background-color:lightgray ;font-weight:bold;">Link: </div>
                    <div><a href="{{ $file['PPPPFiles_Link'] }}" target="_blank">{{ $file['PPPPFiles_LinkName'] }}</a></div>
                    @else 
                    <div style="background-color:lightgray ;font-weight:bold;">Dateiname: </div>
                    <div>
                    @if ($type['Type'] == 'PPUpload')
                    {{ $file['PPPPFiles_Name'] }}
            @else
            {{ substr($file['PPPPFiles_Name'],7) }}
            @endif    
                    </div>
                    @endif
                    <div style="background-color:lightgray ;font-weight:bold;">Bemerkung:</div>
                    <div style="padding:0px;"><textarea name="TA" id="textarea-container_{{$file['PPPPFiles_Id']}}" >{{$file['PPPPFiles_Description']}}</textarea></div>
                    <script>
                        var $textArea = $("#textarea-container_{{$file['PPPPFiles_Id']}}");
                        resizeTextArea($textArea);
                        function resizeTextArea($element) {
                            $element.height($element[0].scrollHeight);
                        }
                    </script>
                    <div> <span>Datei auswählen:</span> <input style="border:2px solid darkblue;width:20px;height:20px;" type="checkbox" class="selectableFiles" id="{{$file['PPPPFiles_Id']}}" value="1" /></div>
                    <div><button style="width:100%;padding:10px;" type="submit" value="Bemerkung ändern"><b>Änderungen speichern</b></button></div>
                </div>
            {{ Form::close() }}
        </div>
        @if (strlen($file['PPPPFiles_Link']) > 0 )
        <div style="position:relative;border-bottom: 2px solid darkgray;margin-bottom: 10px;"></div>
        @else     
    @if (strtoupper(substr($file['PPPPFiles_Name'],-4)) == '.JPG' || strtoupper(substr($file['PPPPFiles_Name'],-5)) == '.JPEG' || strtoupper(substr($file['PPPPFiles_Name'],-4)) == '.PNG'|| strtoupper(substr($file['PPPPFiles_Name'],-4)) == '.GIF' )
    <div style="position:relative;border-bottom: 2px solid darkgray;margin-bottom: 10px;">
        <div style="border:none;">
        @if ($type['Type'] == 'PPUpload')
            <a href="{{url('/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_Name'])}}"  download="{{$file['PPPPFiles_Name']}}" target="_blank"><img src="{{url('/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_Name'])}}" style="width:100%;border:1px solid gray;"></a>
        @else 
            <a href="{{url('/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_Name'])}}"  download="{{substr($file['PPPPFiles_Name'],7)}}" target="_blank"><img src="{{url('/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_Name'])}}" style="width:100%;border:1px solid gray;"></a>
        @endif
        </div> 
        <div style="border: none;position: absolute; bottom:0px;">
            <form method="POST" action="/setProjectPic" data-ajax="true" style="border:none;" enctype="multipart/form-data">
                <form method="POST" action="/setProjectPic" accept-charset="UTF-8" data-ajax="true" style="border:none;" enctype="multipart/form-data">
                    <input name="ppid" type="hidden" value="{{ $data['pp']['PPProduktpass_Id'] }}">
                    <input name="pppic" type="hidden" value="{{ $file['PPPPFiles_Name'] }}">
                    <input type="hidden" name="ActivmainTab" id="hiddenActivmainTab" value="#tabs-6">
                    <input type="hidden" name="ActivsubTabIndex" id="hiddenActivsubTabIndex" value="{{$data['tabs']['subTabIndex']}}">
                    <input type="hidden" name="ActivsubTabName" id="hiddenActivsubTabName" value="{{$data['tabs']['subTabName']}}">
                    <input type="hidden" name="ActivsubsubTabIndex"  id="hiddenActivsubsubTabIndex" value="{{$data['tabs']['subsubTabIndex']}}">
                    <button style="width:100%;padding:10px;" type="submit" value="als Projektbild festlegen">als Projektbild festlegen</button>
            </form>
        </div>
    </div>
    @else
        <div style="border-bottom: 2px solid darkgray;margin-bottom: 10px; ">
        <div style="margin:0 auto;width:60%">
            @if ($type['Type'] == 'PPUpload')
                <a href="{{url('/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_Name'])}}" target="_blank"  download="{{$file['PPPPFiles_Name']}}">
            @else
                <a href="{{url('/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_Name'])}}" target="_blank"  download="{{substr($file['PPPPFiles_Name'],7)}}">
            @endif
                @if (strlen($dllogo)> 10)
                <img src="{{$dllogo}}" alt="Datei" style="width:100%;border:1px solid gray;">
                @else
                {{substr($file['PPPPFiles_Name'],7)}}
                @endif
            </a>
        </div>
        </div>
    @endif
@endif
        <div style="position: relative;border-bottom: 2px solid darkgray;margin-bottom: 10px;">    
            <div style="position: absolute;bottom:0px;">
            <form action="/deleteFiles/{{$file['PPPPFiles_Id']}}" method="POST" style="border: none;" onsubmit="return validatedelete();" >
              {{Form::hidden('ppid',$data['pp']['PPProduktpass_Id']);}}
              <input type="hidden" name="ActivmainTab" id="hiddenActivmainTab" value="#tabs-6">
              <input type="hidden" name="ActivsubTabIndex" id="hiddenActivsubTabIndex" value="{{$data['tabs']['subTabIndex']}}">
              <input type="hidden" name="ActivsubTabName" id="hiddenActivsubTabName" value="{{$data['tabs']['subTabName']}}">
              <input type="hidden" name="ActivsubsubTabIndex"  id="hiddenActivsubsubTabIndex" value="{{$data['tabs']['subsubTabIndex']}}">
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
        </div>
@endif
