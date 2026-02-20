<div style="border: 1px solid gray;overflow: auto; border:0px solid red;margin:0 auto;">
    {{ Form::open(array('url' => 'updatesort')) }}
    {{ Form::hidden('ppid', $data['pp']->PPProduktpass_Id) }}

    <div style="position: relative;">
        @if (!$data['pp']['PPProduktpass_IsRevision'])
        <div style="margin:0 auto;text-align:center;width:110px;position:absolute;top:0px;right:18; z-index: 100;padding-top:8px;border-top:none;">
            {{ Form::submit('speichern', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;'))}}
        </div>
        @endif

        <table style="border:1px solid grey;border-collapse: collapse;font-family: 'Open Sans',Tahoma, Arial, Helvetica, sans-serif;font-size: 11px;" >


            <?php $ndx = -1 ?>
            <?php $lb = "Start" ?>
            @foreach ($data['sortierung'] as $row)
            {{ Form::hidden("sort[".$row['PPProduktpass_Sortierung_Id']."][LB]", $row['PPProduktpass_Sortierung_Laenderblock'])}}

            @if ($lb != $row['PPProduktpass_Sortierung_Laenderblock'])
            <?php $lb = $row['PPProduktpass_Sortierung_Laenderblock'] ?>

            <tr>
                <td style="border:1px solid grey;padding:5px;background-color: lightgray;width:80px;">Länderblock {{$row['PPProduktpass_Sortierung_Laenderblock']}}</td>
                <td style="border:1px solid grey;padding:5px;background-color: lightgray;width:280px;">Type</td>
                <td style="border:1px solid grey;padding:5px;background-color: lightgray;width:70px;">
                    {{ Form::text("sort[".$row['PPProduktpass_Sortierung_Id']."][PPProduktpass_Sortierung_Size01]", $data['designSort'][$row['PPProduktpass_Sortierung_Id']]['SIZE'][1] ,array('class'=>'minp1', 'style'=>'background-color:#FFF;'))}}
                </td>
                <td style="border:1px solid grey;padding:5px;background-color: lightgray;width:70px;">
                    {{ Form::text("sort[".$row['PPProduktpass_Sortierung_Id']."][PPProduktpass_Sortierung_Size02]", $data['designSort'][$row['PPProduktpass_Sortierung_Id']]['SIZE'][2] ,array('class'=>'minp1', 'style'=>'background-color:#FFF;'))}}
                </td>
                <td style="border:1px solid grey;padding:5px;background-color: lightgray;width:70px;">
                    {{ Form::text("sort[".$row['PPProduktpass_Sortierung_Id']."][PPProduktpass_Sortierung_Size03]", $data['designSort'][$row['PPProduktpass_Sortierung_Id']]['SIZE'][3] ,array('class'=>'minp1', 'style'=>'background-color:#FFF;'))}}
                </td>
                <td style="border:1px solid grey;padding:5px;background-color: lightgray;width:70px;">
                    {{ Form::text("sort[".$row['PPProduktpass_Sortierung_Id']."][PPProduktpass_Sortierung_Size04]", $data['designSort'][$row['PPProduktpass_Sortierung_Id']]['SIZE'][4] ,array('class'=>'minp1', 'style'=>'background-color:#FFF;'))}}
                </td>
                <td style="border:1px solid grey;padding:5px;background-color: lightgray;width:70px;">
                    {{ Form::text("sort[".$row['PPProduktpass_Sortierung_Id']."][PPProduktpass_Sortierung_Size05]", $data['designSort'][$row['PPProduktpass_Sortierung_Id']]['SIZE'][5] ,array('class'=>'minp1', 'style'=>'background-color:#FFF;'))}}
                </td>
                <td style="border:1px solid grey;padding:5px;background-color: lightgray;width:70px;">
                    {{ Form::text("sort[".$row['PPProduktpass_Sortierung_Id']."][PPProduktpass_Sortierung_Size06]", $data['designSort'][$row['PPProduktpass_Sortierung_Id']]['SIZE'][6] ,array('class'=>'minp1', 'style'=>'background-color:#FFF;'))}}
                </td>
            </tr>
            <tr>
                <td colspan="8"><?php echo(substr(str_replace("CB", "<br>CB", $lb), 4, 10000)); ?></td>
            </tr>
            @endif

            <tr>
                <td style="border:1px solid grey;padding:5px;background-color: #FFF;">
                    {{ Form::text("sort[".$row['PPProduktpass_Sortierung_Id']."][PPProduktpass_Sortierung_Header]", $row['PPProduktpass_Sortierung_Header'] ,array('class'=>'minp1', 'style'=>'background-color:#FFF;width:200px;text-align:left;'))}}
                </td>
                <td style="border:1px solid grey;padding:5px;">
                    {{ Form::textarea("sort[".$row['PPProduktpass_Sortierung_Id']."][PPProduktpass_Sortierung_Value01]", $row['PPProduktpass_Sortierung_Value01'] ,array('class'=>'minp1', 'style'=>'text-align:left;width:270px;height:25px;background-color:#FFF;'))}}
                </td>
                <td style="border:1px solid grey;padding:5px;">
                    {{ Form::text("sort[".$row['PPProduktpass_Sortierung_Id']."][PPProduktpass_Sortierung_Value02]", $row['PPProduktpass_Sortierung_Value02'] ,array('class'=>'minp1', 'style'=>'background-color:#FFF;'))}}
                </td>
                <td style="border:1px solid grey;padding:5px;">
                    {{ Form::text("sort[".$row['PPProduktpass_Sortierung_Id']."][PPProduktpass_Sortierung_Value03]", $row['PPProduktpass_Sortierung_Value03'] ,array('class'=>'minp1', 'style'=>'background-color:#FFF;'))}}
                </td>
                <td style="border:1px solid grey;padding:5px;">
                    {{ Form::text("sort[".$row['PPProduktpass_Sortierung_Id']."][PPProduktpass_Sortierung_Value04]", $row['PPProduktpass_Sortierung_Value04'] ,array('class'=>'minp1', 'style'=>'background-color:#FFF;'))}}
                </td>
                <td style="border:1px solid grey;padding:5px;">
                    {{ Form::text("sort[".$row['PPProduktpass_Sortierung_Id']."][PPProduktpass_Sortierung_Value05]", $row['PPProduktpass_Sortierung_Value05'] ,array('class'=>'minp1', 'style'=>'background-color:#FFF;'))}}
                </td>
                <td style="border:1px solid grey;padding:5px;">
                    {{ Form::text("sort[".$row['PPProduktpass_Sortierung_Id']."][PPProduktpass_Sortierung_Value06]", $row['PPProduktpass_Sortierung_Value06'] ,array('class'=>'minp1', 'style'=>'background-color:#FFF;'))}}
                </td>
                <td style="border:1px solid grey;padding:5px;">
                    {{ Form::text("sort[".$row['PPProduktpass_Sortierung_Id']."][PPProduktpass_Sortierung_Value07]", $row['PPProduktpass_Sortierung_Value07'] ,array('class'=>'minp1', 'style'=>'background-color:#FFF;'))}}
                </td>
            </tr>
            @if ($data['ShowDiff'] )
            <?php
            $ndx++;
            $row_rev = $data['sortierung_rev'][$ndx];
            $show = false;
            if ($row_rev['PPProduktpass_Sortierung_Header'] != $row['PPProduktpass_Sortierung_Header'])
                $show = true;
            if ($row_rev['PPProduktpass_Sortierung_Value01'] != $row['PPProduktpass_Sortierung_Value01'])
                $show = true;
            if ($row_rev['PPProduktpass_Sortierung_Value02'] != $row['PPProduktpass_Sortierung_Value02'])
                $show = true;
            if ($row_rev['PPProduktpass_Sortierung_Value03'] != $row['PPProduktpass_Sortierung_Value03'])
                $show = true;
            if ($row_rev['PPProduktpass_Sortierung_Value04'] != $row['PPProduktpass_Sortierung_Value04'])
                $show = true;
            if ($row_rev['PPProduktpass_Sortierung_Value05'] != $row['PPProduktpass_Sortierung_Value05'])
                $show = true;
            if ($row_rev['PPProduktpass_Sortierung_Value06'] != $row['PPProduktpass_Sortierung_Value06'])
                $show = true;
            if ($row_rev['PPProduktpass_Sortierung_Value07'] != $row['PPProduktpass_Sortierung_Value07'])
                $show = true;
            ?>

            @if ($show)


            <tr>
                <?php
                $color = "red";
                if ($row_rev['PPProduktpass_Sortierung_Header'] == $row['PPProduktpass_Sortierung_Header']) {
                    $color = "#000";
                }
                ?>
                <td style="border:1px solid grey;padding:5px;background-color: #d0d0d0;">
                    REV: {{$row_rev['PPProduktpass_Sortierung_Header']}}
                </td>
                <?php
                $color = "red";
                $value = $row_rev['PPProduktpass_Sortierung_Value01'];
                if ($row_rev['PPProduktpass_Sortierung_Value01'] == $row['PPProduktpass_Sortierung_Value01']) {
                    $color = "#000";
                    $value = "";
                }
                ?>
                <td style="border:1px solid grey;padding:5px;background-color: #d0d0d0;">
                    {{ Form::textarea("x", $value ,array('class'=>'minp1', 'style'=>'text-align:left;width:270px;height:25px;background-color:#d0d0d0;color:'.$color.';'))}}
                </td>
                <?php
                $color = "red";
                $value = $row_rev['PPProduktpass_Sortierung_Value02'];
                if ($row_rev['PPProduktpass_Sortierung_Value02'] == $row['PPProduktpass_Sortierung_Value02']) {
                    $color = "#000";
                    $value = "";
                }
                ?>
                <td style="border:1px solid grey;padding:5px;background-color: #d0d0d0;">
                    {{ Form::text("x", $value ,array('class'=>'minp1', 'style'=>'background-color:#d0d0d0;color:'.$color.';'))}}
                </td>
                <?php
                $color = "red";
                $value = $row_rev['PPProduktpass_Sortierung_Value03'];
                if ($row_rev['PPProduktpass_Sortierung_Value03'] == $row['PPProduktpass_Sortierung_Value03']) {
                    $color = "#000";
                    $value = "";
                }
                ?>
                <td style="border:1px solid grey;padding:5px;background-color: #d0d0d0;">
                    {{ Form::text("x", $value ,array('class'=>'minp1', 'style'=>'background-color:#d0d0d0;color:'.$color.';'))}}
                </td>
                <?php
                $color = "red";
                $value = $row_rev['PPProduktpass_Sortierung_Value04'];
                if ($row_rev['PPProduktpass_Sortierung_Value04'] == $row['PPProduktpass_Sortierung_Value04']) {
                    $color = "#000";
                    $value = "";
                }
                ?>
                <td style="border:1px solid grey;padding:5px;background-color: #d0d0d0;">
                    {{ Form::text("x", $value ,array('class'=>'minp1', 'style'=>'background-color:#d0d0d0;color:'.$color.';'))}}
                </td>
                <?php
                $color = "red";
                $value = $row_rev['PPProduktpass_Sortierung_Value05'];
                if ($row_rev['PPProduktpass_Sortierung_Value05'] == $row['PPProduktpass_Sortierung_Value05']) {
                    $color = "#000";
                    $value = "";
                }
                ?>
                <td style="border:1px solid grey;padding:5px;background-color: #d0d0d0;">
                    {{ Form::text("x", $value ,array('class'=>'minp1', 'style'=>'background-color:#d0d0d0;color:'.$color.';'))}}
                </td>
                <?php
                $color = "red";
                $value = $row_rev['PPProduktpass_Sortierung_Value06'];
                if ($row_rev['PPProduktpass_Sortierung_Value06'] == $row['PPProduktpass_Sortierung_Value06']) {
                    $color = "#000";
                    $value = "";
                }
                ?>
                <td style="border:1px solid grey;padding:5px;background-color: #d0d0d0;">
                    {{ Form::text("x", $value ,array('class'=>'minp1', 'style'=>'background-color:#d0d0d0;color:'.$color.';'))}}
                </td>
                <?php
                $color = "red";
                $value = $row_rev['PPProduktpass_Sortierung_Value07'];
                if ($row_rev['PPProduktpass_Sortierung_Value07'] == $row['PPProduktpass_Sortierung_Value07']) {
                    $color = "#000";
                    $value = "";
                }
                ?>
                <td style="border:1px solid grey;padding:5px;background-color: #d0d0d0;">
                    {{ Form::text("x", $value ,array('class'=>'minp1', 'style'=>'background-color:#d0d0d0;color:'.$color.';'))}}
                </td>
            </tr>
            @endif
            @endif

            @endforeach
        </table>

    </div>

    {{Form::close()}}

</div>