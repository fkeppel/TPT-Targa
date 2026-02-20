<style>
    .inp1 {
        border:1px solid darkblue;
        border-radius: 0px;
        height:50px;
        width:280px;
        vertical-align: text-top;
        padding:4px;
    }
    .inp2 {
        border:1px solid lightgray;
        border-radius: 0px;
        height:50px;
        width:280px;
        vertical-align: text-top;
        padding:4px;
    }

    #style textarea {
        width:300px;
        height:100px;
        border: 1px solid lightgray;
        padding:8px;
        border-radius:0px;
    }

</style>

<div style="border: 1px solid gray; border:none;margin:0 auto;">
    {{ Form::open(array('url' => 'updatestyle')) }}
    {{ Form::hidden('ppid', $data['pp']->PPProduktpass_Id) }}

    <div style="position: relative;height:20px;">
        @if (!$data['pp']['PPProduktpass_IsRevision'])
        <div style="margin:0 auto;width:110px;position:absolute;top:0px;left:18; z-index: 100;padding:8px;border:none;">
            @if (Auth::User()->PPMitarbeiter_Gruppe  != 'extern')
            {{ Form::submit('speichern', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;'))}}
            @endif
        </div>
        @endif
    </div>
    <div  id='style' style="padding-top: 40px;overflow: auto;">
        <table style="border:1px solid grey;border-collapse: collapse;font-family: 'Open Sans',Tahoma, Arial, Helvetica, sans-serif;font-size: 11px; " >

            <tr>
                <td style="border:1px solid grey;padding:5px;background-color: lightgray;">Style</td>
                <td style="border:1px solid grey;padding:5px;background-color: lightgray;">Zolltarif</td>
                <td style="border:1px solid grey;padding:5px;background-color: lightgray;">Artikelbezeichnung</td>
                <td style="border:1px solid grey;padding:5px;background-color: lightgray;">Produktbeschreibung I</td>
                <td style="border:1px solid grey;padding:5px;background-color: lightgray;">Produktbeschreibung II</td>
                <td style="border:1px solid grey;padding:5px;background-color: lightgray;">Produktbeschreibung III</td>
                <td style="border:1px solid grey;padding:5px;background-color: lightgray;">Bild für PO</td>
            </tr>

            <?php $ndx     = -1 ?>
            @foreach ($data['style'] as $row)
            <?php $ndx++ ?>
            <tr>
                <td style="border:1px solid grey;padding:5px;background-color: #FFF;vertical-align: top;">
                    {{$row['PPProduktpass_Style_Header']}}
                </td>
                <td style="border:1px solid grey;padding:5px;">
                    {{ Form::text("style[".$row['PPProduktpass_Style_Id']."][PPProduktpass_Style_Zolltarifnummer]", $row['PPProduktpass_Style_Zolltarifnummer'] ,array('class'=>'minp1', 'style'=>'text-align:left;width:120px;background-color:#FFF;border:1px solid lightgray;'))}}
                </td>
                <td style="border:1px solid grey;padding:5px;">
                    <textarea>{{ $row['PPProduktpass_Style_Value01'] }}</textarea>
                    {{-- Form::textarea("style[".$row['PPProduktpass_Style_Id']."][PPProduktpass_Style_Value01]",$row['PPProduktpass_Style_Value01'],array('class'=>'inp1')) --}}
                    {{ Form::textarea("style[".$row['PPProduktpass_Style_Id']."][PPProduktpass_Style_Value01_Translation]", $row['PPProduktpass_Style_Value01_Translation'] ,array('class'=>'inp2'))}}
                </td>
             
                <td style="border:1px solid grey;padding:5px;">
                    <textarea>{{ $row['PPProduktpass_Style_Value03'] }}</textarea>
                    {{-- Form::text("style[".$row['PPProduktpass_Style_Id']."][PPProduktpass_Style_Value03]",$row['PPProduktpass_Style_Value03'],array('class'=>'inp2')) --}}
                    {{ Form::textarea("style[".$row['PPProduktpass_Style_Id']."][PPProduktpass_Style_Value03_Translation]", $row['PPProduktpass_Style_Value03_Translation'] ,array('class'=>'inp2'))}}
                </td>
                <td style="border:1px solid grey;padding:5px;">
                    <textarea>{{ $row['PPProduktpass_Style_Value04'] }}</textarea>
                    {{-- Form::text("style[".$row['PPProduktpass_Style_Id']."][PPProduktpass_Style_Value04]",$row['PPProduktpass_Style_Value04'],array('class'=>'inp2')) --}}
                    {{ Form::textarea("style[".$row['PPProduktpass_Style_Id']."][PPProduktpass_Style_Value04_Translation]", $row['PPProduktpass_Style_Value04_Translation'] ,array('class'=>'inp2'))}}
                </td>
                <td style="border:1px solid grey;padding:5px;">
                    <textarea>{{ $row['PPProduktpass_Style_Value02'] }}</textarea>
                    {{-- Form::textarea("style[".$row['PPProduktpass_Style_Id']."][PPProduktpass_Style_Value02]",$row['PPProduktpass_Style_Value02'],array('class'=>'inp2')) --}}
                    {{ Form::textarea("style[".$row['PPProduktpass_Style_Id']."][PPProduktpass_Style_Value02_Translation]", $row['PPProduktpass_Style_Value02_Translation'] ,array('class'=>'inp2'))}}
                </td>
              
                <td style="border:1px solid grey;padding:5px;">

                    @if ($row['PPProduktpass_Style_PPPPFiles_Id'] != 0)

                    <div>
                        <img src="/data/uploads/{{$data['styleimagesarray'][$row['PPProduktpass_Style_PPPPFiles_Id']]}}" style="width:100px;border:1px solid gray;"-->
                    </div>

                    @endif


                    @if (count($data['styleimages']) <= 1 )
                    Bitte erst Design Bilder hochladen!
                    @else
                    {{ Form::select("style[".$row['PPProduktpass_Style_Id']."][PPProduktpass_Style_PPPPFiles_Id]",$data['styleimages'],$row['PPProduktpass_Style_PPPPFiles_Id'],array('style'=>'width:200px;height:25px;') )}}
                    @endif
                </td>
            </tr>
            @if ($data['ShowDiff'] )
            <?php
            $row_rev = $data['style_rev'][$ndx];
            $show    = false;
            if ($row_rev['PPProduktpass_Style_Header'] != $row['PPProduktpass_Style_Header'])
                $show    = true;
            if ($row_rev['PPProduktpass_Style_Value01'] != $row['PPProduktpass_Style_Value01'])
                $show    = true;
            if ($row_rev['PPProduktpass_Style_Value02'] != $row['PPProduktpass_Style_Value02'])
                $show    = true;
            if ($row_rev['PPProduktpass_Style_Value03'] != $row['PPProduktpass_Style_Value03'])
                $show    = true;
            if ($row_rev['PPProduktpass_Style_Value04'] != $row['PPProduktpass_Style_Value04'])
                $show    = true;
            ?>
            @if($show)
            <tr>
                <?php
                $color   = "red";
                if ($row_rev['PPProduktpass_Style_Header'] == $row['PPProduktpass_Style_Header']) {
                    $color = "#000";
                }
                ?>
                <td style="border:1px solid grey;padding:5px;background-color: #d0d0d0;vertical-align: top;color:{{$color}};">
                    REV: {{$row_rev['PPProduktpass_Style_Header']}}
                </td>
                <?php
                $color = "red";
                $value = $row_rev['PPProduktpass_Style_Value01'];
                if ($row_rev['PPProduktpass_Style_Value01'] == $row['PPProduktpass_Style_Value01']) {
                    $color = "#000";
                    $value = "";
                }
                ?>
                <td style="border:1px solid grey;padding:5px;background-color: #d0d0d0;">&nbsp;
                    {{ Form::textarea("x", $value ,array('class'=>'minp1', 'style'=>'text-align:left;width:500px;background-color:#d0d0d0;color:'.$color.';'))}}
                </td>
                <?php
                $color = "red";
                $value = $row_rev['PPProduktpass_Style_Value02'];
                if ($row_rev['PPProduktpass_Style_Value02'] == $row['PPProduktpass_Style_Value02']) {
                    $color = "#000";
                    $value = "";
                }
                ?>
                <td style="border:1px solid grey;padding:5px;background-color: #d0d0d0;">&nbsp;
                    {{ Form::textarea("x", $value ,array('class'=>'minp1', 'style'=>'text-align:left;width:120px;background-color:#d0d0d0;color:'.$color.';'))}}
                </td>
                <?php
                $color = "red";
                $value = $row_rev['PPProduktpass_Style_Value03'];
                if ($row_rev['PPProduktpass_Style_Value03'] == $row['PPProduktpass_Style_Value03']) {
                    $color = "#000";
                    $value = "";
                }
                ?>
                <td style="border:1px solid grey;padding:5px;background-color: #d0d0d0;">&nbsp;
                    {{ Form::textarea("x", $value ,array('class'=>'minp1', 'style'=>'text-align:left;width:120px;background-color:#d0d0d0;color:'.$color.';'))}}
                </td>
                <?php
                $color = "red";
                $value = $row_rev['PPProduktpass_Style_Value04'];
                if ($row_rev['PPProduktpass_Style_Value04'] == $row['PPProduktpass_Style_Value04']) {
                    $color = "#000";
                    $value = "";
                }
                ?>
                <td style="border:1px solid grey;padding:5px;background-color: #d0d0d0;">&nbsp;
                    {{ Form::textarea("x", $value ,array('class'=>'minp1', 'style'=>'text-align:left;width:120px;background-color:#d0d0d0;color:'.$color.';'))}}
                </td>
            </tr>
            @endif
            @endif

            @endforeach
        </table>

    </div>

    {{Form::close()}}

</div>