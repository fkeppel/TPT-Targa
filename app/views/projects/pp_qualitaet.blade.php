<style>
    .qinp1{
        margin:0px;
        border:none;
        border-radius: 0px;
        background-color:#FFF;
        width:200px;
    }  
    .qinp2{
        margin:0px;
        width:200px;
        border:none;
        border-radius: 0px;
        background-color:#FFF;
    }
    .qinprev{
        margin:0px;
        width:200px;
        border:none;
        border-radius: 0px;
        background-color:#d0d0d0;
    }
    .qheader1 {
        width:205px;
        border: 1px solid #d0d0d0;
        background-color:#FFF;
    }
    .qheader2 {
        width:205px;
        border: 1px solid #d0d0d0;
        background-color:#f0f0f0;
    }
    .qrow{
        margin:0px;
        height:20px;
        border: 1px solid #d0d0d0;
    }
    .qrowrev{
        margin:0px;
        height:20px;
        border: 1px solid #d0d0d0;
        background-color:#d0d0d0;
    }
</style>
<div style="overflow: auto; border:1px solid lightgray;margin:0 auto;position: relative;text-align: left;">

    {{ Form::open(array('url' => 'updateq')) }}

    {{ Form::hidden('ppqid', $data['pp']->PPProduktpass_Id) }}
    @if (!$data['pp']['PPProduktpass_IsRevision'])
    <div style="margin:0 auto;text-align:center;width:110px;position:absolute;top:10px;right:18; z-index: 100;padding-top:8px;border-top:none;">
        @if (Auth::User()->PPMitarbeiter_Gruppe  != 'extern')
        {{ Form::submit('speichern', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;'))}}
        @endif
    </div>
    @endif
    <div style="width:1420px;margin:0 auto; padding: 0px;overflow:auto;height:840px;margin-left:0px;">

        <table style="border:1px solid grey;border-collapse: collapse;font-family: 'Open Sans',Tahoma, Arial, Helvetica, sans-serif;font-size: 11px;margin-top: 10px;" >

            <?php
            $ndx = -1;
            $extend = false;
            ?>
            @foreach ($data['qualitaet'] as $row)
            @if ($ndx == -1)
            <tr>
                <td class="qheader1">Type</td>
                <td class="qheader2">Style 1</td>
                <td class="qheader2">Style 2</td>
                <td class="qheader2">Style 3</td>
                <td class="qheader2">Style 4</td>
                <td class="qheader2">Style 5</td>
                @if (!is_null($row['PPProduktpass_Qualitaet_Value06']) and strlen($row['PPProduktpass_Qualitaet_Value06'])>1)
                <?php $extend = true; ?>
                <td class="qheader2">Style 6</td>
                <td class="qheader2">Style 7</td>
                <td class="qheader2">Style 8</td>
                <td class="qheader2">Style 9</td>
                <td class="qheader2">Style 10</td>
                <td class="qheader2">Style 11</td>
                <td class="qheader2">Style 12</td>
                @endif
            </tr>
            @endif
            <?php $ndx++; ?>
            <tr>
                <td class="qrow">
                    @if (is_numeric(substr($row['PPProduktpass_Qualitaet_Header'],0,1)))
                    <b>
                        @else
                        &nbsp;&nbsp;&nbsp;
                        @endif
                        {{ Form::text("inp[".$row['PPProduktpass_Qualitaet_Id']."][PPProduktpass_Qualitaet_Header]", $row['PPProduktpass_Qualitaet_Header'],array('class'=>'qinp1')) }} </b>
                </td>
                <td  class="qrow">{{ Form::text("inp[".$row['PPProduktpass_Qualitaet_Id']."][PPProduktpass_Qualitaet_Value01]", $row['PPProduktpass_Qualitaet_Value01'],array('class'=>'qinp2'))}}</td>
                <td  class="qrow">{{ Form::text("inp[".$row['PPProduktpass_Qualitaet_Id']."][PPProduktpass_Qualitaet_Value02]", $row['PPProduktpass_Qualitaet_Value02'],array('class'=>'qinp2')) }}</td>
                <td  class="qrow">{{ Form::text("inp[".$row['PPProduktpass_Qualitaet_Id']."][PPProduktpass_Qualitaet_Value03]", $row['PPProduktpass_Qualitaet_Value03'],array('class'=>'qinp2')) }}</td>
                <td  class="qrow">{{ Form::text("inp[".$row['PPProduktpass_Qualitaet_Id']."][PPProduktpass_Qualitaet_Value04]", $row['PPProduktpass_Qualitaet_Value04'],array('class'=>'qinp2')) }}</td>
                <td  class="qrow">{{ Form::text("inp[".$row['PPProduktpass_Qualitaet_Id']."][PPProduktpass_Qualitaet_Value05]", $row['PPProduktpass_Qualitaet_Value05'],array('class'=>'qinp2')) }}</td>
                @if ($extend)
                <td  class="qrow">{{ Form::text("inp[".$row['PPProduktpass_Qualitaet_Id']."][PPProduktpass_Qualitaet_Value06]", $row['PPProduktpass_Qualitaet_Value06'],array('class'=>'qinp2')) }}</td>
                <td  class="qrow">{{ Form::text("inp[".$row['PPProduktpass_Qualitaet_Id']."][PPProduktpass_Qualitaet_Value07]", $row['PPProduktpass_Qualitaet_Value07'],array('class'=>'qinp2')) }}</td>
                <td  class="qrow">{{ Form::text("inp[".$row['PPProduktpass_Qualitaet_Id']."][PPProduktpass_Qualitaet_Value08]", $row['PPProduktpass_Qualitaet_Value08'],array('class'=>'qinp2')) }}</td>
                <td  class="qrow">{{ Form::text("inp[".$row['PPProduktpass_Qualitaet_Id']."][PPProduktpass_Qualitaet_Value09]", $row['PPProduktpass_Qualitaet_Value09'],array('class'=>'qinp2')) }}</td>
                <td  class="qrow">{{ Form::text("inp[".$row['PPProduktpass_Qualitaet_Id']."][PPProduktpass_Qualitaet_Value10]", $row['PPProduktpass_Qualitaet_Value10'],array('class'=>'qinp2')) }}</td>
                <td  class="qrow">{{ Form::text("inp[".$row['PPProduktpass_Qualitaet_Id']."][PPProduktpass_Qualitaet_Value11]", $row['PPProduktpass_Qualitaet_Value11'],array('class'=>'qinp2')) }}</td>
                <td  class="qrow">{{ Form::text("inp[".$row['PPProduktpass_Qualitaet_Id']."][PPProduktpass_Qualitaet_Value12]", $row['PPProduktpass_Qualitaet_Value12'],array('class'=>'qinp2')) }}</td>
                <td  class="qrow">{{ Form::text("inp[".$row['PPProduktpass_Qualitaet_Id']."][PPProduktpass_Qualitaet_Value13]", $row['PPProduktpass_Qualitaet_Value13'],array('class'=>'qinp2')) }}</td>
                <td  class="qrow">{{ Form::text("inp[".$row['PPProduktpass_Qualitaet_Id']."][PPProduktpass_Qualitaet_Value14]", $row['PPProduktpass_Qualitaet_Value14'],array('class'=>'qinp2')) }}</td>
                <td  class="qrow">{{ Form::text("inp[".$row['PPProduktpass_Qualitaet_Id']."][PPProduktpass_Qualitaet_Value15]", $row['PPProduktpass_Qualitaet_Value15'],array('class'=>'qinp2')) }}</td>
                @endif
            </tr>
            @if ($data['ShowDiff'])
            <?php
            $row_rev = $data['qualitaet_rev'][$ndx];
            $show = false;
            if ($row['PPProduktpass_Qualitaet_Value01'] != $row_rev['PPProduktpass_Qualitaet_Value01'])
                $show = true;
            if ($row['PPProduktpass_Qualitaet_Value02'] != $row_rev['PPProduktpass_Qualitaet_Value02'])
                $show = true;
            if ($row['PPProduktpass_Qualitaet_Value03'] != $row_rev['PPProduktpass_Qualitaet_Value03'])
                $show = true;
            if ($row['PPProduktpass_Qualitaet_Value04'] != $row_rev['PPProduktpass_Qualitaet_Value04'])
                $show = true;
            if ($row['PPProduktpass_Qualitaet_Value05'] != $row_rev['PPProduktpass_Qualitaet_Value05'])
                $show = true;
            if ($row['PPProduktpass_Qualitaet_Value06'] != $row_rev['PPProduktpass_Qualitaet_Value06'])
                $show = true;
            if ($row['PPProduktpass_Qualitaet_Value07'] != $row_rev['PPProduktpass_Qualitaet_Value07'])
                $show = true;
            if ($row['PPProduktpass_Qualitaet_Value08'] != $row_rev['PPProduktpass_Qualitaet_Value08'])
                $show = true;
            ?>
            @if ($show)
            <tr >
                <td class="qrow" style="background-color:#cacaca;">
                    @if (is_numeric(substr($row_rev['PPProduktpass_Qualitaet_Header'],0,1)))
                    <b>
                        @else
                        &nbsp;&nbsp;&nbsp;
                        @endif
                        <?php
                        $color = 'red';
                        if ($row['PPProduktpass_Qualitaet_Header'] == $row_rev['PPProduktpass_Qualitaet_Header']) {
                            $color = '#000';
                        }
                        ?>
                        {{ Form::text("x", "REV: ".$row_rev['PPProduktpass_Qualitaet_Header'],array('class'=>'qinp1', 'style' => 'color:'.$color.';background-color:#cacaca;')) }} </b>
                </td>
                <?php
                $color = 'red';
                $value = $row_rev['PPProduktpass_Qualitaet_Value01'];
                if ($row['PPProduktpass_Qualitaet_Value01'] == $row_rev['PPProduktpass_Qualitaet_Value01']) {
                    $color = '#000';
                    $value = "";
                }
                ?>
                <td  class="qrowrev">{{ Form::text("x", $value ,array('class'=>'qinprev', 'style' => 'color:'.$color.';'))}}</td>
                <?php
                $color = 'red';
                $value = $row_rev['PPProduktpass_Qualitaet_Value02'];
                if ($row['PPProduktpass_Qualitaet_Value02'] == $row_rev['PPProduktpass_Qualitaet_Value02']) {
                    $color = '#000';
                    $value = "";
                }
                ?>
                <td  class="qrowrev">{{ Form::text("x", $value ,array('class'=>'qinprev', 'style' => 'color:'.$color.';'))}}</td>
                <?php
                $color = 'red';
                $value = $row_rev['PPProduktpass_Qualitaet_Value03'];
                if ($row['PPProduktpass_Qualitaet_Value03'] == $row_rev['PPProduktpass_Qualitaet_Value03']) {
                    $color = '#000';
                    $value = "";
                }
                ?>
                <td  class="qrowrev">{{ Form::text("x", $value ,array('class'=>'qinprev', 'style' => 'color:'.$color.';'))}}</td>
                <?php
                $color = 'red';
                $value = $row_rev['PPProduktpass_Qualitaet_Value04'];
                if ($row['PPProduktpass_Qualitaet_Value04'] == $row_rev['PPProduktpass_Qualitaet_Value04']) {
                    $color = '#000';
                    $value = "";
                }
                ?>
                <td  class="qrowrev">{{ Form::text("x", $value ,array('class'=>'qinprev', 'style' => 'color:'.$color.';'))}}</td>
                <?php
                $color = 'red';
                $value = $row_rev['PPProduktpass_Qualitaet_Value05'];
                if ($row['PPProduktpass_Qualitaet_Value05'] == $row_rev['PPProduktpass_Qualitaet_Value05']) {
                    $color = '#000';
                    $value = "";
                }
                ?>
                <td  class="qrowrev">{{ Form::text("x", $value ,array('class'=>'qinprev', 'style' => 'color:'.$color.';'))}}</td>
                @if ($extend)
                <?php
                $color = 'red';
                $value = $row_rev['PPProduktpass_Qualitaet_Value06'];
                if ($row['PPProduktpass_Qualitaet_Value06'] == $row_rev['PPProduktpass_Qualitaet_Value06']) {
                    $color = '#000';
                    $value = "";
                }
                ?>
                <td  class="qrowrev">{{ Form::text("x", $value ,array('class'=>'qinprev', 'style' => 'color:'.$color.';'))}}</td>
                <?php
                $color = 'red';
                $value = $row_rev['PPProduktpass_Qualitaet_Value07'];
                if ($row['PPProduktpass_Qualitaet_Value07'] == $row_rev['PPProduktpass_Qualitaet_Value07']) {
                    $color = '#000';
                    $value = "";
                }
                ?>
                <td  class="qrowrev">{{ Form::text("x", $value ,array('class'=>'qinprev', 'style' => 'color:'.$color.';'))}}</td>
                <?php
                $color = 'red';
                $value = $row_rev['PPProduktpass_Qualitaet_Value08'];
                if ($row['PPProduktpass_Qualitaet_Value08'] == $row_rev['PPProduktpass_Qualitaet_Value08']) {
                    $color = '#000';
                    $value = "";
                }
                ?>
                <td  class="qrowrev">{{ Form::text("x", $value ,array('class'=>'qinprev', 'style' => 'color:'.$color.';'))}}</td>
                <?php
                $color = 'red';
                $value = $row_rev['PPProduktpass_Qualitaet_Value09'];
                if ($row['PPProduktpass_Qualitaet_Value09'] == $row_rev['PPProduktpass_Qualitaet_Value09']) {
                    $color = '#000';
                    $value = "";
                }
                ?>
                <td  class="qrowrev">{{ Form::text("x", $value ,array('class'=>'qinprev', 'style' => 'color:'.$color.';'))}}</td>
                <?php
                $color = 'red';
                $value = $row_rev['PPProduktpass_Qualitaet_Value10'];
                if ($row['PPProduktpass_Qualitaet_Value10'] == $row_rev['PPProduktpass_Qualitaet_Value10']) {
                    $color = '#000';
                    $value = "";
                }
                ?>
                <td  class="qrowrev">{{ Form::text("x", $value ,array('class'=>'qinprev', 'style' => 'color:'.$color.';'))}}</td>
                <?php
                $color = 'red';
                $value = $row_rev['PPProduktpass_Qualitaet_Value11'];
                if ($row['PPProduktpass_Qualitaet_Value11'] == $row_rev['PPProduktpass_Qualitaet_Value11']) {
                    $color = '#000';
                    $value = "";
                }
                ?>
                <td  class="qrowrev">{{ Form::text("x", $value ,array('class'=>'qinprev', 'style' => 'color:'.$color.';'))}}</td>
                <?php
                $color = 'red';
                $value = $row_rev['PPProduktpass_Qualitaet_Value12'];
                if ($row['PPProduktpass_Qualitaet_Value12'] == $row_rev['PPProduktpass_Qualitaet_Value12']) {
                    $color = '#000';
                    $value = "";
                }
                ?>
                <td  class="qrowrev">{{ Form::text("x", $value ,array('class'=>'qinprev', 'style' => 'color:'.$color.';'))}}</td>
                <?php
                $color = 'red';
                $value = $row_rev['PPProduktpass_Qualitaet_Value13'];
                if ($row['PPProduktpass_Qualitaet_Value13'] == $row_rev['PPProduktpass_Qualitaet_Value13']) {
                    $color = '#000';
                    $value = "";
                }
                ?>
                <td  class="qrowrev">{{ Form::text("x", $value ,array('class'=>'qinprev', 'style' => 'color:'.$color.';'))}}</td>
                <?php
                $color = 'red';
                $value = $row_rev['PPProduktpass_Qualitaet_Value14'];
                if ($row['PPProduktpass_Qualitaet_Value14'] == $row_rev['PPProduktpass_Qualitaet_Value14']) {
                    $color = '#000';
                    $value = "";
                }
                ?>
                <td  class="qrowrev">{{ Form::text("x", $value ,array('class'=>'qinprev', 'style' => 'color:'.$color.';'))}}</td>
                <?php
                $color = 'red';
                $value = $row_rev['PPProduktpass_Qualitaet_Value15'];
                if ($row['PPProduktpass_Qualitaet_Value15'] == $row_rev['PPProduktpass_Qualitaet_Value15']) {
                    $color = '#000';
                    $value = "";
                }
                ?>
                <td  class="qrowrev">{{ Form::text("x", $value ,array('class'=>'qinprev', 'style' => 'color:'.$color.';'))}}</td>
                @endif
            </tr>
            @endif

            @endif


            @endforeach
        </table>

    </div>

    {{ Form::close()}}
</div>