@if (strlen($file['PPPPFiles_Name']) > 0)
<tr>
    <td style="width:200px;vertical-align: top;padding:5px;border:1px solid gray;">{{$file['PPPPFiles_Type']}}</td>

    <td style="width:200px;vertical-align: top;padding:5px;border:1px solid gray;">
        {{Form::open(array('url' => 'updateRemarkFiles', 'method' => 'POST', 'files' => 'true', 'data-ajax' => 'true'))}}
        <textarea name="TA">{{$file['PPPPFiles_Description']}}</textarea>
        {{Form::hidden('fileid',$file['PPPPFiles_Id']);}}
        {{Form::hidden('ppid',$data['pp']['PPProduktpass_Id']);}}
        {{Form::submit('Bemerkung speichern',array('style'=>'width:200px;'));}}
        {{ Form::close() }}
    </td>
    <?php
    $fileparts = explode('.', $file['PPPPFiles_Name']);
    $ext       = $fileparts[count($fileparts) - 1];
    $dllogo    = "/images/" . strtolower($ext) . ".png";
    //$dllogo = "/images/icon_xml.png";
    ?>
    @if (strtoupper(substr($file['PPPPFiles_Name'],-4)) == '.JPG' || strtoupper(substr($file['PPPPFiles_Name'],-5)) == '.JPEG' || strtoupper(substr($file['PPPPFiles_Name'],-4)) == '.PNG'|| strtoupper(substr($file['PPPPFiles_Name'],-4)) == '.GIF' )

    <td style="width:150px;vertical-align: top;padding:0px;border:1px solid gray;">
        <a href="{{'/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_Name']}}" target="_blank">
            <img src="{{'/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_Name']}}" style="width:100px;border:1px solid gray;">
        </a>
    </td>
    @else
    <td style="width:150px;vertical-align: top;padding:5px;border:1px solid gray;">

        <a href="{{'/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_Name']}}" target="_blank">
            @if (strlen($dllogo)> 10)
            <img src="{{$dllogo}}" alt="Datei" style="width:60px;border:1px solid gray;">
            @else
            {{substr($file['PPPPFiles_Name'],7)}}
            @endif
        </a>
    </td>
    @endif
    <td style="width:80px;vertical-align: top;padding:5px;border:1px solid gray;"> {{date_format(date_create_from_format('Y-m-d H:i:s',$file['PPPPFiles_Date']),'d.m.Y')}}</td>
    <td style="width:50px;vertical-align: top;padding:5px;border:1px solid gray;">
        {{Form::open(array('url' => 'deleteFiles/'.$file['PPPPFiles_Id'], 'method' => 'POST', 'files' => 'true', 'data-ajax' => 'true'))}}﻿
        {{Form::hidden('ppid',$data['pp']['PPProduktpass_Id']);}}
        <input type="hidden" name="delActivmainTab" id="hiddenActivmainTab" value="#tabs-6">
        <input type="hidden" name="delActivsubTabIndex" id="hiddenActivsubTabIndex" value="{{$data['tabs']['subTabIndex']}}">
        <input type="hidden" name="delActivsubTabName" id="hiddenActivsubTabName" value="{{$data['tabs']['subTabName']}}">
        <input type="hidden" name="delActivsubsubTabIndex"  id="hiddenActivsubsubTabIndex" value="{{$data['tabs']['subsubTabIndex']}}">
        {{Form::hidden('ppid',$data['pp']['PPProduktpass_Id']);}}
        {{Form::submit('löschen',array('style'=>'width:80px;'));}}
        {{ Form::close() }}
        @if ($ext == 'xml')
        {{Form::open(array('url' => 'compareXML', 'method' => 'POST', 'files' => 'true', 'data-ajax' => 'true'))}}﻿
        {{Form::hidden('ppid',$data['pp']['PPProduktpass_Id']);}}
        {{Form::hidden('filecompare', $file['PPPPFiles_Id'])}}
        {{Form::submit('Vergleichen',array('style'=>'width:80px;'));}}
        {{ Form::close() }}
        @endif
        {{Form::open(array('url' => 'setProjectPic', 'method' => 'POST', 'files' => 'true', 'data-ajax' => 'true'))}}﻿
        {{Form::hidden('ppid',$data['pp']['PPProduktpass_Id']);}}
        {{Form::hidden('pppic',$file['PPPPFiles_Name']);}}
        {{Form::submit('Projektbild',array('style'=>'width:80px;'));}}
        {{ Form::close() }}
    </td>
</tr>
@endif


