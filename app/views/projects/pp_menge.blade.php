<?php $bgcolor2 = "#e78f08"; ?>
<?php $bgcolor1 = "#f6a828"; ?>

<style>
    .minp1 {
        background-color:#FFF;
        width:80px;
        border: none;
        text-align: right;
    }



    #tblContainer {
        border: none;
        height:842px;
        margin:0 auto;
        position: relative;
        text-align:left;
        overflow: hidden;
        border-radius: 0px;

    }

    #tblMenge {
        overflow:auto;
        height:796px;
        border-radius: 0px;
        padding: 0 4 0 4px;
    }


    #tblMenge table { border:1px solid red;
                      border-collapse: collapse;
                      font-family: 'Open Sans',Tahoma, Arial, Helvetica, sans-serif;
                      font-size: 11px;
                      table-layout: fixed;
    }

    #tblMenge th{
        border:1px solid gray;
        padding:4px;
        background-color: lightgray;
        position: sticky;
        top:-1;

    }

    #tblContainer form {
        border:1px solid gray;
        border-radius: 0px;
        text-align:left;
    }

    #tblContainer input[type='submit']{
        border:1px solid gray;
        border-radius: 0px;
        height:30px;
        padding:8px;
        font-weight: bold;
        width:80px;
        background-color: orange;
    }

</style>

<div id="tblContainer" >
    {{ Form::open(array('url' => 'updatem')) }}
    @if (!$data['pp']['PPProduktpass_IsRevision'])
    <div style='width:115px;padding:5px;float: left;'>
        {{ Form::submit('speichern')}}
    </div>
    @endif
    @if ($data['MengeFinal'])<div style="padding:6px;border:none;"><b>Finale Mengen eingelesen</b></div>@endif
    {{ Form::hidden('ppqid', $data['pp']->PPProduktpass_Id) }}
    <!--div style="float: left; width:190px;vertical-align: middle;height:30px;margin-top: 7px;">
        <span style="color:black;display: inline-block;margin-top: 5px;"><b>Datum WE:</b></span>
        <input style="width:100px; border:1px solid gray;border-radius: 0px;" />

    </div>
    <div style="float: left; width:300px;vertical-align: middle;height:30px;margin-top: 7px;">
        <span style="color:black;display: inline-block;margin-top: 5px;"><b>Menge:</b></span>
        <input style="width:100px; border:1px solid gray;border-radius: 0px;" />

    </div -->
    <div style="clear:both;"></div>
    <div id="tblMenge" >
        <table >

            <tr>
                <th style="width:50px;">CB</th>
                <th style="width:50px;">Country</th>
                <th style="width:60px;text-align: right;">Cartons</th>
                <th style="width:50px;text-align: right;">Sales Unit</th>
                <th style="width:60px;text-align: right;">Quantity</th>
                <!-- th style="width:60px;text-align: right;">Delivered</th -->
                <!--th style="width:60px;text-align: right;">EK (USD)</th-->
                <!--th style="width:40px;">PM</th-->
                <th style="width:60px;">LT</th>

                <th style="width:60px;text-align: right;">LT 1 Quantity</th>
                <th style="width:60px;">LT 1</th>
                <th style="width:40px;text-align: right;">LT 2 Quantity</th>
                <th style="width:60px;">LT 2</th>
                <th style="width:40px;text-align: right;">LT 3 Quantity</th>
                <th style="width:60px;">LT 3</th>
                <th style="width:120px;text-align: left">Article-Info</th>

                <th style="width:120px;text-align: left">Ländergrössen</th>
                <th style="width:60px;text-align: left">Stückgewicht (g)</th>

                <th style="width:120px;text-align: left">cnt size</th>
                <th style="width:60px;text-align: left">pcs/cnt</th>
                <th style="width:60px;text-align: left">ctn/pal</th>
                <th style="width:60px;text-align: left">trucks</th>
            </tr>


            <?php $total    = 0 ?>
            <?php $total_c  = 0 ?>
            <?php $qty_c    = 0 ?>
            <?php $cb       = $data['menge']->first()->PPProduktpass_Menge_CountryBlock ?>
            <?php $cb_qty   = 0 ?>

            <?php $ndx      = -1; ?>
            @foreach ($data['menge'] as $row)
            <?php $ndx++; ?>
            @if ($row->PPProduktpass_Menge_CountryBlock==$cb )
            <?php $cb_qty   = $cb_qty + $row->PPProduktpass_Menge_Quantity ?>
            @else
            <tr>
                <td style="border:1px solid grey;padding:4px;background-color:{{$bgcolor1}};">{{ $cb }}</td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;text-align: right;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;text-align: right;background-color: {{$bgcolor1}};padding-right:8px;"><b>{{ number_format($cb_qty,0,',','.') }}</b></td>
                <!--td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};">
                        {{ Form::text("cbek[".$cb."]",  number_format($data['laenderBloecke'][$cb]['CBEK'],3,',','.') ,array('class'=>'minp1', 'style'=>'background-color:'.$bgcolor1))}}
                </td-->
                <!--td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td-->
                <!-- Delivered td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td -->
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <!--td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td-->
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
            </tr>
            <?php $cb_qty   = $row->PPProduktpass_Menge_Quantity ?>
            <?php $cb       = $row->PPProduktpass_Menge_CountryBlock ?>
            @endif

            <?php $total    = $total + $row->PPProduktpass_Menge_Quantity ?>
            @if ($row->PPProduktpass_Menge_Kolli <> 0)
            <?php $qty_c    = $row->PPProduktpass_Menge_Quantity / $row->PPProduktpass_Menge_Kolli ?>
            @else
            <?php $qty_c    = 0 ?>
            @endif
            <?php $total_c  = $total_c + $qty_c ?>

            <tr>
                <td style="border:1px solid grey;padding:4px;">
                    {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_CountryBlock]", $row->PPProduktpass_Menge_CountryBlock,array('class'=>'minp1','style'=>'width:40px;'))}}
                </td>
                <td style="border:1px solid grey;padding:8px;;text-align: center;padding-top:9px;">{{ $row->PPProduktpass_Menge_Country }}  </td>
                <td style="border:1px solid grey;padding:8px;text-align: right;padding-top:9px;">{{ number_format($qty_c,0,',','.') }}</td>
                <td style="border:1px solid grey;padding:4px;text-align: right;">{{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_Kolli]",  number_format($row->PPProduktpass_Menge_Kolli,0,',','.') ,array('class'=>'minp1','style'=>'width:50px;'))}}</td>
                <td style="border:1px solid grey;padding:4px;text-align: right;">
                    {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_Quantity]",  number_format($row->PPProduktpass_Menge_Quantity,0,',','.') ,array('class'=>'minp1','style'=>'width:50px;'))}}
                    <br>
                    <?php
                    $cx       = "green";
                    if (isset($data['MengeFinal'][$row->PPProduktpass_Menge_Country]->PPProduktpass_Menge_Quantity) and $data['MengeFinal'][$row->PPProduktpass_Menge_Country]->PPProduktpass_Menge_Quantity != $row->PPProduktpass_Menge_Quantity) {
                        $cx = "red";
                    }
                    ?>
                    <p style="color:{{$cx}};padding-right:7px;margin-top:-4px;">{{isset($data['MengeFinal'][$row->PPProduktpass_Menge_Country]->PPProduktpass_Menge_Quantity)?(number_format($data['MengeFinal'][$row->PPProduktpass_Menge_Country]->PPProduktpass_Menge_Quantity, 0, ",", ".")):""}}</p>
                </td>
                <!--td style="border:1px solid grey;padding:4px;text-align: right;">
                        {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_EKUSD]",  number_format($row->PPProduktpass_Menge_EKUSD,3,',','.') ,array('class'=>'minp1'))}}
                </td-->
                <!-- td style="border:1px solid grey;padding:0px;text-align: right;"><input style='width:60px;border:1px solid darkblue;border-radius: 0px;text-align: right;' /></td -->
                <!--td style="border:1px solid grey;padding:4px;text-align: center;">{{ $row->PPProduktpass_Menge_PackingMethod }} </td-->
                <td style="border:1px solid grey;padding:4px;">
                    {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_DeliveryWeek]",  $row->PPProduktpass_Menge_DeliveryWeek ,array('class'=>'minp1','style'=>'width:50px;'))}}
                    <br>
                    <?php
                    $cx = "green";
                    if (isset($data['MengeFinal'][$row->PPProduktpass_Menge_Country]->PPProduktpass_Menge_DeliveryWeek) and $data['MengeFinal'][$row->PPProduktpass_Menge_Country]->PPProduktpass_Menge_DeliveryWeek != $row->PPProduktpass_Menge_DeliveryWeek) {
                        $cx = "red";
                    }
                    ?>
                    <p style="color:{{$cx}};padding-right:7px;padding-left:20px;margin-top:-4px;">{{isset($data['MengeFinal'][$row->PPProduktpass_Menge_Country]->PPProduktpass_Menge_DeliveryWeek)?($data['MengeFinal'][$row->PPProduktpass_Menge_Country]->PPProduktpass_Menge_DeliveryWeek):""}}</p>

                </td>

                <td style="border:1px solid grey;padding:4px;">
                    {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_LT1Menge]", number_format($row->PPProduktpass_Menge_LT1Menge,0,",",".")   ,array('class'=>'minp1','style'=>'width:60px;'))}}
                    <br>
                    <?php
                    $cx = "green";
                    if (isset($data['MengeFinal'][$row->PPProduktpass_Menge_Country]->PPProduktpass_Menge_LT1Menge) and $data['MengeFinal'][$row->PPProduktpass_Menge_Country]->PPProduktpass_Menge_LT1Menge != $row->PPProduktpass_Menge_LT1Menge) {
                        $cx = "red";
                    }
                    ?>
                    <p style="color:{{$cx}};margin-top:-4px;text-align: right;padding-right:4px;">{{isset($data['MengeFinal'][$row->PPProduktpass_Menge_Country]->PPProduktpass_Menge_LT1Menge)?(number_format($data['MengeFinal'][$row->PPProduktpass_Menge_Country]->PPProduktpass_Menge_LT1Menge, 0, ",", ".")):""}}</p>
                </td>
                <td style="border:1px solid grey;padding:4px;">
                    {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_LT1]",  $row->PPProduktpass_Menge_LT1 ,array('class'=>'minp1','style'=>'width:50px;'))}}
                    <br>
                    <?php
                    $cx = "green";
                    if (isset($data['MengeFinal'][$row->PPProduktpass_Menge_Country]->PPProduktpass_Menge_LT1) and $data['MengeFinal'][$row->PPProduktpass_Menge_Country]->PPProduktpass_Menge_LT1 != $row->PPProduktpass_Menge_LT1) {
                        $cx = "red";
                    }
                    ?>
                    <p style="color:{{$cx}};text-align: center;padding-left:2px;margin-top:-4px;">{{isset($data['MengeFinal'][$row->PPProduktpass_Menge_Country]->PPProduktpass_Menge_LT1)?($data['MengeFinal'][$row->PPProduktpass_Menge_Country]->PPProduktpass_Menge_LT1):""}}</p>
                </td>
                <td style="border:1px solid grey;padding:4px;">
                    {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_LT2Menge]",  number_format($row->PPProduktpass_Menge_LT2Menge,0,',','.')  ,array('class'=>'minp1','style'=>'width:40px;'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;">
                    {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_LT2]",  $row->PPProduktpass_Menge_LT2 ,array('class'=>'minp1','style'=>'width:50px;'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;">
                    {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_LT3Menge]", number_format($row->PPProduktpass_Menge_LT3Menge,0,',','.')   ,array('class'=>'minp1','style'=>'width:40px;'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;">
                    {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_LT3]",  $row->PPProduktpass_Menge_LT3 ,array('class'=>'minp1','style'=>'width:50px;'))}}
                </td>
                <!--td style="border:1px solid grey;padding:4px;text-align: right;">
                        {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_Rotterdam]",  number_format($row->PPProduktpass_Menge_Rotterdam,0,',','.') ,array('class'=>'minp1','style'=>'width:60px;'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;text-align: right;">
                        {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_Koper]",  number_format($row->PPProduktpass_Menge_Koper,0,',','.') ,array('class'=>'minp1','style'=>'width:60px;'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;text-align: right;">
                        {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_Barcelona]",  number_format($row->PPProduktpass_Menge_Barcelona,0,',','.') ,array('class'=>'minp1','style'=>'width:60px;'))}}
                </td-->
                <td style="border:1px solid grey;padding:4px;text-align: right;">
                    {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_ArtikelInfo]",  $row->PPProduktpass_Menge_ArtikelInfo ,array('class'=>'minp1','style'=>'width:115px;text-align:left;'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;text-align: right;">
                    {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_Countrysizes]",  $row->PPProduktpass_Menge_Countrysizes ,array('class'=>'minp1','style'=>'width:115px;text-align:left;'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;text-align: right;">
                    {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_CountryGSM]",  number_format($row->PPProduktpass_Menge_CountryGSM,0,',','.') ,array('class'=>'minp1','style'=>'width:55px;text-align:right;'))}}
                </td>

                <td style="border:1px solid grey;padding:4px;text-align: right;">
                    {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_CartonSize]",  $row->PPProduktpass_Menge_CartonSize ,array('class'=>'minp1','style'=>'width:115px;text-align:right;'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;text-align: right;">
                    {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_PcsPerCarton]",  number_format($row->PPProduktpass_Menge_PcsPerCarton,0,',','.') ,array('class'=>'minp1','style'=>'width:55px;text-align:right;'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;text-align: right;">
                    {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_CartonPerPal]",  number_format($row->PPProduktpass_Menge_CartonPerPal,0,',','.') ,array('class'=>'minp1','style'=>'width:55px;text-align:right;'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;text-align: right;">
                    {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_Trucks]",  number_format($row->PPProduktpass_Menge_Trucks,1,',','.') ,array('class'=>'minp1','style'=>'width:55px;text-align:right;'))}}
                </td>
            </tr>

            @if ($data['ShowDiff'])
            <?php
            $hasdata = false;
            if (isset($data['mengen_rev'][$ndx])) {
                $hasdata = true;
                $row_rev = $data['mengen_rev'][$ndx];
            }
            $show  = false;
            if ($row_rev->PPProduktpass_Menge_CountryBlock != $row->PPProduktpass_Menge_CountryBlock)
                $show  = true;
            if ($row_rev->PPProduktpass_Menge_Country != $row->PPProduktpass_Menge_Country)
                $show  = true;
            if ($row_rev->PPProduktpass_Menge_Kolli != $row->PPProduktpass_Menge_Kolli)
                $show  = true;
            if ($row_rev->PPProduktpass_Menge_DeliveryWeek != $row->PPProduktpass_Menge_DeliveryWeek)
                $show  = true;
            if ($row_rev->PPProduktpass_Menge_Quantity != $row->PPProduktpass_Menge_Quantity)
                $show  = true;
            if ($row_rev->PPProduktpass_Menge_LT1Menge != $row->PPProduktpass_Menge_LT1Menge)
                $show  = true;
            if ($row_rev->PPProduktpass_Menge_LT1 != $row->PPProduktpass_Menge_LT1)
                $show  = true;
            if ($row_rev->PPProduktpass_Menge_LT2Menge != $row->PPProduktpass_Menge_LT2Menge)
                $show  = true;
            if ($row_rev->PPProduktpass_Menge_LT2 != $row->PPProduktpass_Menge_LT2)
                $show  = true;
            if ($row_rev->PPProduktpass_Menge_LT3Menge != $row->PPProduktpass_Menge_LT3Menge)
                $show  = true;
            if ($row_rev->PPProduktpass_Menge_LT3 != $row->PPProduktpass_Menge_LT3)
                $show  = true;
            if ($row_rev->PPProduktpass_Menge_Rotterdam != $row->PPProduktpass_Menge_Rotterdam)
                $show  = true;
            if ($row_rev->PPProduktpass_Menge_Koper != $row->PPProduktpass_Menge_Koper)
                $show  = true;
            if ($row_rev->PPProduktpass_Menge_Barcelona != $row->PPProduktpass_Menge_Barcelona)
                $show  = true;
            if ($row_rev->PPProduktpass_Menge_ArtikelInfo != $row->PPProduktpass_Menge_ArtikelInfo)
                $show  = true;
            if ($row_rev->PPProduktpass_Menge_Countrysizes != $row->PPProduktpass_Menge_Countrysizes)
                $show  = true;
            if ($row_rev->PPProduktpass_Menge_CountryGSM != $row->PPProduktpass_Menge_CountryGSM)
                $show  = true;
            ?>
            @endif
            @if ($data['ShowDiff'] and $hasdata and $show)
            <tr>
                <td style="border:1px solid grey;padding:4px; background-color: #d0d0d0;">
                    <?php
                    $color = 'red';
                    if ($row_rev->PPProduktpass_Menge_CountryBlock == $row->PPProduktpass_Menge_CountryBlock) {
                        $color = '#000';
                    }
                    ?>
                    {{ Form::text("x", "REV: ",array('class'=>'minp1','style'=>'width:40px;background-color: #d0d0d0;color:'.$color.';'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;;text-align: center;background-color: #d0d0d0;">{{ $row_rev->PPProduktpass_Menge_Country }} </td>

                <td style="border:1px solid grey;padding:4px;text-align: right;background-color: #d0d0d0;">
                    <?php
                    $color = 'red';
                    $value = number_format($row_rev->PPProduktpass_Menge_Kolli, 0, ',', '.');
                    if ($row_rev->PPProduktpass_Menge_Kolli == $row->PPProduktpass_Menge_Kolli) {
                        $color = '#000';
                        $value = "";
                    }
                    ?>
                    {{ Form::text("x", $value  ,array('class'=>'minp1','style'=>'width:50px;background-color: #d0d0d0;color:'.$color.';'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;text-align: right;background-color: #d0d0d0;"></td>
                <td style="border:1px solid grey;padding:4px;text-align: right;background-color: #d0d0d0;"></td>
                <td style="border:1px solid grey;padding:4px;text-align: right;background-color: #d0d0d0;">
                    <?php
                    $color = 'red';
                    $value = number_format($row_rev->PPProduktpass_Menge_Quantity, 0, ',', '.');
                    if ($row_rev->PPProduktpass_Menge_Quantity == $row->PPProduktpass_Menge_Quantity) {
                        $color = '#000';
                        $value = "";
                    }
                    ?>
                    {{ Form::text("x",  $value ,array('class'=>'minp1','style'=>'width:50px;background-color: #d0d0d0;color:'.$color.';'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;background-color: #d0d0d0;">
                    <?php
                    $color = 'red';
                    $value = $row_rev->PPProduktpass_Menge_DeliveryWeek;
                    if ($row_rev->PPProduktpass_Menge_DeliveryWeek == $row->PPProduktpass_Menge_DeliveryWeek) {
                        $color = '#000';
                        $value = "";
                    }
                    ?>
                    {{ Form::text("x",  $value,array('class'=>'minp1','style'=>'width:50px;background-color: #d0d0d0;color:'.$color.';'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;background-color: #d0d0d0;">
                    <?php
                    $color = 'red';
                    $value = number_format($row_rev->PPProduktpass_Menge_LT1Menge, 0, ',', '.'); {
                        $color = '#000';
                        $value = "";
                    }
                    ?>
                    {{ Form::text("x",  $value   ,array('class'=>'minp1','style'=>'width:40px;background-color: #d0d0d0;color:'.$color.';'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;background-color: #d0d0d0;">
                    <?php
                    $color = 'red';
                    $value = $row_rev->PPProduktpass_Menge_LT1;
                    if ($row_rev->PPProduktpass_Menge_LT1 == $row->PPProduktpass_Menge_LT1) {
                        $color = '#000';
                        $value = "";
                    }
                    ?>
                    {{ Form::text("x",  $value ,array('class'=>'minp1','style'=>'width:50px;background-color: #d0d0d0;color:'.$color.';'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;background-color: #d0d0d0;">
                    <?php
                    $color = 'red';
                    $value = number_format($row_rev->PPProduktpass_Menge_LT2Menge, 0, ',', '.');
                    if ($row_rev->PPProduktpass_Menge_LT2Menge == $row->PPProduktpass_Menge_LT2Menge) {
                        $color = '#000';
                        $value = "";
                    }
                    ?>
                    {{ Form::text("x", $value  ,array('class'=>'minp1','style'=>'width:40px;background-color: #d0d0d0;color:'.$color.';'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;background-color: #d0d0d0;">
                    <?php
                    $color = 'red';
                    $value = $row_rev->PPProduktpass_Menge_LT2;
                    if ($row_rev->PPProduktpass_Menge_LT2 == $row->PPProduktpass_Menge_LT2) {
                        $color = '#000';
                        $value = "";
                    }
                    ?>
                    {{ Form::text("x", $value ,array('class'=>'minp1','style'=>'width:50px;background-color: #d0d0d0;color:'.$color.';'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;background-color: #d0d0d0;">
                    <?php
                    $color = 'red';
                    $value = number_format($row_rev->PPProduktpass_Menge_LT3Menge, 0, ',', '.');
                    if ($row_rev->PPProduktpass_Menge_LT3Menge == $row->PPProduktpass_Menge_LT3Menge) {
                        $color = '#000';
                        $value = "";
                    }
                    ?>
                    {{ Form::text("x", $value   ,array('class'=>'minp1','style'=>'width:40px;background-color: #d0d0d0;color:'.$color.';'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;background-color: #d0d0d0;">
                    <?php
                    $color = 'red';
                    $value = $row_rev->PPProduktpass_Menge_LT3;
                    if ($row_rev->PPProduktpass_Menge_LT2 == $row->PPProduktpass_Menge_LT3) {
                        $color = '#000';
                        $value = "";
                    }
                    ?>
                    {{ Form::text("x",  $value, array('class'=>'minp1','style'=>'width:50px;background-color: #d0d0d0;color:'.$color.';'))}}
                </td>
                <!--td style="border:1px solid grey;padding:4px;text-align: right;background-color: #d0d0d0;">
                <?php
                $color = 'red';
                $value = number_format($row_rev->PPProduktpass_Menge_Rotterdam, 0, ',', '.');
                if ($row_rev->PPProduktpass_Menge_Rotterdam == $row->PPProduktpass_Menge_Rotterdam) {
                    $color = '#000';
                    $value = "";
                }
                ?>
                        {{ Form::text("x", $value  ,array('class'=>'minp1','style'=>'width:60px;background-color: #d0d0d0;color:'.$color.';'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;text-align: right;background-color: #d0d0d0;">
                <?php
                $color = 'red';
                $value = number_format($row_rev->PPProduktpass_Menge_Koper, 0, ',', '.');
                if ($row_rev->PPProduktpass_Menge_Koper == $row->PPProduktpass_Menge_Koper) {
                    $color = '#000';
                    $value = "";
                }
                ?>
                        {{ Form::text("x",  $value ,array('class'=>'minp1','style'=>'width:60px;background-color: #d0d0d0;color:'.$color.';'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;text-align: right;background-color: #d0d0d0;">
                <?php
                $color = 'red';
                $value = number_format($row_rev->PPProduktpass_Menge_Barcelona, 0, ',', '.');
                if ($row_rev->PPProduktpass_Menge_Barcelona == $row->PPProduktpass_Menge_Barcelona) {
                    $color = '#000';
                    $value = "";
                }
                ?>
                        {{ Form::text("x",  $value,array('class'=>'minp1','style'=>'width:60px;background-color: #d0d0d0;color:'.$color.';'))}}
                </td-->
                <td style="border:1px solid grey;padding:4px;text-align: right;background-color: #d0d0d0;">
                    <?php
                    $color = 'red';
                    $value = $row_rev->PPProduktpass_Menge_ArtikelInfo;
                    if ($row_rev->PPProduktpass_Menge_ArtikelInfo == $row->PPProduktpass_Menge_ArtikelInfo) {
                        $color = '#000';
                        $value = "";
                    }
                    ?>
                    {{ Form::text("x", $value ,array('class'=>'minp1','style'=>'width:115px;text-align:left;background-color: #d0d0d0;color:'.$color.';'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;text-align: right;background-color: #d0d0d0;">
                    <?php
                    $color = 'red';
                    $value = $row_rev->PPProduktpass_Menge_Countrysizes;
                    if ($row_rev->PPProduktpass_Menge_Countrysizes == $row->PPProduktpass_Menge_Countrysizes) {
                        $color = '#000';
                        $value = "";
                    }
                    ?>
                    {{ Form::text("x", $value  ,array('class'=>'minp1','style'=>'width:115px;text-align:left;background-color: #d0d0d0;color:'.$color.';'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;text-align: right;background-color: #d0d0d0;">
                    <?php
                    $color = 'red';
                    $value = $row_rev->PPProduktpass_Menge_CountryGSM;
                    if ($row_rev->PPProduktpass_Menge_CountryGSM == $row->PPProduktpass_Menge_CountryGSM) {
                        $color = '#000';
                        $value = "";
                    }
                    ?>
                    {{ Form::text("x",  $value ,array('class'=>'minp1','style'=>'width:115px;text-align:left;background-color: #d0d0d0;color:'.$color.';'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;text-align: right;background-color: #d0d0d0;">
                    <?php
                    $color = 'red';
                    $value = $row_rev->PPProduktpass_Menge_CountryGSM;
                    if ($row_rev->PPProduktpass_Menge_CountryGSM == $row->PPProduktpass_Menge_CountryGSM) {
                        $color = '#000';
                        $value = "";
                    }
                    ?>
                    {{ Form::text("x",  $value ,array('class'=>'minp1','style'=>'width:115px;text-align:left;background-color: #d0d0d0;color:'.$color.';'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;text-align: right;background-color: #d0d0d0;">
                    <?php
                    $color = 'red';
                    $value = $row_rev->PPProduktpass_Menge_CountryGSM;
                    if ($row_rev->PPProduktpass_Menge_CountryGSM == $row->PPProduktpass_Menge_CountryGSM) {
                        $color = '#000';
                        $value = "";
                    }
                    ?>
                    {{ Form::text("x",  $value ,array('class'=>'minp1','style'=>'width:115px;text-align:left;background-color: #d0d0d0;color:'.$color.';'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;text-align: right;background-color: #d0d0d0;">
                    <?php
                    $color = 'red';
                    $value = $row_rev->PPProduktpass_Menge_CountryGSM;
                    if ($row_rev->PPProduktpass_Menge_CountryGSM == $row->PPProduktpass_Menge_CountryGSM) {
                        $color = '#000';
                        $value = "";
                    }
                    ?>
                    {{ Form::text("x",  $value ,array('class'=>'minp1','style'=>'width:115px;text-align:left;background-color: #d0d0d0;color:'.$color.';'))}}
                </td>
                <td style="border:1px solid grey;padding:4px;text-align: right;background-color: #d0d0d0;">
                    <?php
                    $color = 'red';
                    $value = $row_rev->PPProduktpass_Menge_CountryGSM;
                    if ($row_rev->PPProduktpass_Menge_CountryGSM == $row->PPProduktpass_Menge_CountryGSM) {
                        $color = '#000';
                        $value = "";
                    }
                    ?>
                    {{ Form::text("x",  $value ,array('class'=>'minp1','style'=>'width:115px;text-align:left;background-color: #d0d0d0;color:'.$color.';'))}}
                </td>
            </tr>
            @endif
            @endforeach
            <tr>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};">{{ $cb }}</td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;text-align: right;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>

                <td style="border:1px solid grey;padding:4px;text-align: right;background-color: {{$bgcolor1}};"><b>{{ number_format($cb_qty,0,',','.') }}</b></td>
                <!--td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};">
                        {{ Form::text("cbek[".$cb."]",  number_format($data['laenderBloecke'][$cb]['CBEK'],3,',','.') ,array('class'=>'minp1', 'style'=>'background-color:'.$bgcolor1))}}
                </td-->
                <!--td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td -->
                <!--td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td-->
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <!--td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td-->
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor1}};"></td>
            </tr>
            <tr>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};">Total</td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td>
                <td style="border:1px solid grey;padding:4px;text-align: right;background-color: {{$bgcolor2}};"><b>{{ number_format($total_c,0,',','.') }}</b></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td>


                <td style="border:1px solid grey;padding:4px;text-align: right;background-color: {{$bgcolor2}};"><b> {{ number_format($total,0,',','.') }}</b></td>
                <!--td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td-->
                <!--td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td-->
                <!-- td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td -->
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td>
                <!--td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td-->
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td>
                <td style="border:1px solid grey;padding:4px;background-color: {{$bgcolor2}};"></td>
            </tr>

        </table>
    </div>
    {{ Form::close()}}
</div>
