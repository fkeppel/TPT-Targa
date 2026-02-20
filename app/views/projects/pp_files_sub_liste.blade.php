@if (strlen($file['PPPPFiles_Name']) > 0)
    <?PHP
        $fileparts = explode('.', $file['PPPPFiles_Name']);
        $ext       = $fileparts[count($fileparts) - 1];
        $dllogo    = "/images/" . strtolower($ext) . ".png";
    ?>

<style>
    #FileDetails {
        display: grid;
        grid-template-columns: 150px 360px;
        border-collapse: collapse;
        border: none;
    }

    #FileDetails div {
        padding: 5px;
        border: 1px solid darkgray;
    }

    #FileDetails textarea {
        border: none;
        min-height: 64px;
        width: 99%;
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

    .wrapper {
        display: grid;
        width: 1184px;
        grid-template-columns: 150px 180px 650px /*450px*/ 100px 100px;
        
        grid-column-gap: 0px;
        grid-row-gap: 0px;
        margin:0px;
        padding:0px;
        border:none!important;
        
        grid-template-rows: max-content;
        
    }

    .cell {
    
        border:1px solid lightgray!important;
    }

   .btn {
        padding:0px!important;
        padding-top:-10px!important;
        border:none;
        width:100%;
        height:28px;
   }

  
</style>

<Form action="/updateFilesCompact", method ='POST'>
    <input type="hidden" name="fileid" id="fileid" value="{{$file['PPPPFiles_Id']}}">
    <input type="hidden" name="ppid" id="hiddenActivmainTab" value="{{$data['pp']['PPProduktpass_Id']}}">
    <input type="hidden" name="ActivmainTab" id="hiddenActivmainTab" value="#tabs-6">
    <input type="hidden" name="ActivsubTabIndex" id="hiddenActivsubTabIndex" value="{{$data['tabs']['subTabIndex']}}">
    <input type="hidden" name="ActivsubTabName" id="hiddenActivsubTabName" value="{{$data['tabs']['subTabName']}}">
    <input type="hidden" name="ActivsubsubTabIndex"  id="hiddenActivsubsubTabIndex" value="{{$data['tabs']['subsubTabIndex']}}">
    <input type="hidden" name="filecompare" value="{{$file['PPPPFiles_Id']}}">
    
    <div  class="wrapper">
        <div class="cell">{{date_format(date_create_from_format('Y-m-d H:i:s',$file['PPPPFiles_Date']),'d.m.Y H:i:s')}}</div>
        <div class="cell">@if(isset($ord[$kat['Kategorie']]))
        
            <select id="Ordnung{{ $kat['Kategorie'] }}" name="Ordnung" style="width:100%;margin:0px;outline:none;border:1px solid lightgray;border-radius:0px;font-weight:bolder;padding:4px;">
                @foreach ($ord[$kat['Kategorie']] as $o)
                <option @if($file['PPPPFiles_Ordnung']==trim($o)) selected @endif>{{ $o }}</option>
                @endforeach
            </select>
            @endif
        </div>
        <div class="cell"><div style="padding:5px;border:1px solid lightgray;">@if(strlen($file['PPPPFiles_LinkName'])>0)
                                <a href="{{ $file['PPPPFiles_Link'] }}" target="_blank">{{ $file['PPPPFiles_LinkName'] }}</a>
                            @else
                                @if ($type['Type'] == 'PPUpload')
                                    <a href="{{url('/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_Name'])}}" download="{{$file['PPPPFiles_Name']}}" target="_blank" title="{{$file['PPPPFiles_Description']}}">{{$file['PPPPFiles_Name']}}</a>
                                @else
                                    <a href="{{url('/data/'.$file['PPPPFiles_Pfad'].'/'.$file['PPPPFiles_Name'])}}" download="{{substr($file['PPPPFiles_Name'],7)}}" target="_blank" title="{{$file['PPPPFiles_Description']}}">{{substr($file['PPPPFiles_Name'],7)}}</a>
                                @endif
                            @endif</div>
                            <textarea style="margin:0px;width:100%;height:60px;border:1px solid lightgray; border-top:none; border-radius:0px;outline-style:none;" name="TA" id="textarea-container_{{$file['PPPPFiles_Id']}}">{{$file['PPPPFiles_Description']}}</textarea>
        </div>
        <!--div style="padding:0px;"></div-->
        <div class="cell"><button class="btn" name="btn" type="submit" value="speichern"><b>speichern</b></button></div>
        <div class="cell" ><button class="btn" name="btn" type="submit" value="löschen"><b>löschen</b></button></div>
        <!--div><button name="btn" type="submit" value="vergleichen"><b>Vergleichen</b></button></div -->

    </div>
</Form>
@endif