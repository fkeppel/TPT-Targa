<style>
    .dtk_container {

        border: none;

        display: table;
        font-size: 14px;

    }
    .dtk_row {
        display:table-row;
        border:none;

    }
    .dtk_cell {
        border: 1px solid lightgray;

        display: table-cell;
        padding: 4px;
    }


    .dtk_cellr {
        border: 1px solid lightgray;

        display: table-cell;
        text-align: right;
        padding: 4px;
    }

    .dtk_cellNoInp {
        border: 1px solid #e76b1f;
        display: table-cell;
        padding: 4px;

    }
    .dtk_cellNoInpr {
        border: 1px solid #e76b1f;
        display: table-cell;
        padding: 4px;
        text-align: right;

    }
    .dtk_labelcell {

        border: 1px solid #e76b1f;
        border-radius: 0px;
        width: 100px;
        display: table-cell;
        padding-left: 5px;
        background-color: orange;
        font-weight: bold;
    }
    .dtk_labelcellr {

        border: 1px solid #e76b1f;
        border-radius: 0px;
        width: 100px;
        display: table-cell;
        padding-right: 5px;
        background-color: orange;
        font-weight: bold;
        text-align:right;
    }

    .dtk_container_input {
        border:none;
        width: 110px;
        height: 22px;
        padding-left:4px;
        background-color: #99cc00;
        font-size: 14px;
        margin:0;
    }

    .inputr{
        border:1px solid red;
        text-align: right;
        padding-right:5px;
    }

    .dtk_container select {
        border: none;
        height: 22px;
        width: 110px;
        background-color: #99cc00;
        margin:0px ;

    }

    .dtk_container form {
        border: none;
        margin:0px ;
    }


    .dtk_arrow {
        border: none;
        margin:0px ;
        padding:0px;
        width:20px;
        background-color: orange;
    }
    .dtk_header{
        float:left;
        background-color: orange;
        border:none;
        padding:0px;
        margin:0px;
        border-radius: 0px;
    }

    .dtk_header2{
        float:left;
        background-color: transparent;
        border:none;
        padding:0px;
        height: 17px;
        margin:0px;
        border-radius: 0px;
        width:44px;
        overflow: hidden;
        margin-left:8px;
    }
    .dtk_header3{
        float:left;
        background-color: transparent;
        border:none;
        padding:0px;
        margin:0px;
        border-radius: 0px;
        width:20px;
        overflow: hidden;
    }
    .dtk_header2 input{
        width:20px;
        height:15px;
        float:left;
    }

</style>
<?php
$up = "&#11205;";
$down = "&#11206;"
?>

<div style = "width:1610px;padding:20px;text-align:left;margin:0 auto;border:1px solid blueviolet; height:930px;overflow: auto;">
    {{Form::open(array('url' => '/showUngedeckt', 'method' => 'POST'))}}﻿
    {{Form::text('search_ausmusterung', $data['inp']['search_ausmusterung'])}}
    {{Form::text('search', $data['inp']['search'])}}
    {{ Form::submit('select', array('class'=>'dtk_submit'))}}
    {{ Form::close()}}
    <div class="dtk_container" style="width:1600px;padding:20px;">
        <div class="dtk_row">
            <div class="dtk_labelcell" style="width:100px;">
                <div class="dtk_header">
                    IAN
                </div>
                <div  class="dtk_header2">
                    <div class="dtk_header3">
                        {{Form::open(array('url' => '/showUngedeckt', 'method' => 'POST'))}}﻿
                        {{Form::hidden('sort_key','ian')}}
                        {{Form::hidden('sort_dir','asc')}}
                        {{Form::hidden('search',$data['inp']['search'])}}
                        {{Form::hidden('search_ausmusterung',$data['inp']['search_ausmusterung'])}}
                        {{ Form::submit($up, array('class'=>'dtk_arrow'))}}
                        {{ Form::close()}}
                    </div>
                    <div class="dtk_header3">
                        {{Form::open(array('url' => '/showUngedeckt', 'method' => 'POST'))}}﻿
                        {{Form::hidden('sort_key','ian')}}
                        {{Form::hidden('sort_dir','desc')}}
                        {{Form::hidden('search_ausmusterung',$data['inp']['search_ausmusterung'])}}
                        {{Form::hidden('search',$data['inp']['search'])}}
                        {{ Form::submit($down, array('class'=>'dtk_arrow'))}}
                        {{ Form::close()}}
                    </div>
                </div>
            </div>
            <div class="dtk_labelcell" style="width:100px;">
                <div  class="dtk_header">
                    <div class="dtk_header">
                        Ausm.
                    </div>
                    <div  class="dtk_header2">
                        <div class="dtk_header3">
                            {{Form::open(array('url' => '/showUngedeckt', 'method' => 'POST'))}}﻿
                            {{Form::hidden('sort_key','ausmusterung')}}
                            {{Form::hidden('sort_dir','asc')}}
                            {{Form::hidden('search',$data['inp']['search'])}}
                            {{Form::hidden('search_ausmusterung',$data['inp']['search_ausmusterung'])}}
                            {{ Form::submit($up, array('class'=>'dtk_arrow'))}}
                            {{ Form::close()}}
                        </div>
                        <div class="dtk_header3">
                            {{Form::open(array('url' => '/showUngedeckt', 'method' => 'POST'))}}﻿
                            {{Form::hidden('sort_key','ausmusterung')}}
                            {{Form::hidden('sort_dir','desc')}}
                            {{Form::hidden('search_ausmusterung',$data['inp']['search_ausmusterung'])}}
                            {{Form::hidden('search',$data['inp']['search'])}}
                            {{ Form::submit($down, array('class'=>'dtk_arrow'))}}
                            {{ Form::close()}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="dtk_labelcell" style="width:250px;">
                <div class="dtk_header">
                    Supplier
                </div>
                <div  class="dtk_header2">
                    <div class="dtk_header3">
                        {{Form::open(array('url' => '/showUngedeckt', 'method' => 'POST'))}}﻿
                        {{Form::hidden('sort_key','supplier')}}
                        {{Form::hidden('sort_dir','asc')}}
                        {{Form::hidden('search',$data['inp']['search'])}}
                        {{Form::hidden('search_ausmusterung',$data['inp']['search_ausmusterung'])}}
                        {{ Form::submit($up, array('class'=>'dtk_arrow'))}}
                        {{ Form::close()}}
                    </div>
                    <div class="dtk_header3">
                        {{Form::open(array('url' => '/showUngedeckt', 'method' => 'POST'))}}﻿
                        {{Form::hidden('sort_key','supplier')}}
                        {{Form::hidden('sort_dir','desc')}}
                        {{Form::hidden('search_ausmusterung',$data['inp']['search_ausmusterung'])}}
                        {{Form::hidden('search',$data['inp']['search'])}}
                        {{ Form::submit($down, array('class'=>'dtk_arrow'))}}
                        {{ Form::close()}}
                    </div>
                </div>
            </div>
            <div class="dtk_labelcell" style="width:250px;">
                <div class="dtk_header">
                    Artikel
                </div>
                <div  class="dtk_header2">
                    <div class="dtk_header3">
                        {{Form::open(array('url' => '/showUngedeckt', 'method' => 'POST'))}}﻿
                        {{Form::hidden('sort_key','artikelbezeichnung')}}
                        {{Form::hidden('sort_dir','asc')}}
                        {{Form::hidden('search',$data['inp']['search'])}}
                        {{Form::hidden('search_ausmusterung',$data['inp']['search_ausmusterung'])}}
                        {{ Form::submit($up, array('class'=>'dtk_arrow'))}}
                        {{ Form::close()}}
                    </div>
                    <div class="dtk_header3">
                        {{Form::open(array('url' => '/showUngedeckt', 'method' => 'POST'))}}﻿
                        {{Form::hidden('sort_key','artikelbezeichnung')}}
                        {{Form::hidden('sort_dir','desc')}}
                        {{Form::hidden('search_ausmusterung',$data['inp']['search_ausmusterung'])}}
                        {{Form::hidden('search',$data['inp']['search'])}}
                        {{ Form::submit($down, array('class'=>'dtk_arrow'))}}
                        {{ Form::close()}}
                    </div>
                </div>
            </div>
            <div class="dtk_labelcellr" style="width:100px;">
                <div class="dtk_header">
                    LT
                </div>
                <div  class="dtk_header2">
                    <div class="dtk_header3">
                        {{Form::open(array('url' => '/showUngedeckt', 'method' => 'POST'))}}﻿
                        {{Form::hidden('sort_key','lt')}}
                        {{Form::hidden('sort_dir','asc')}}
                        {{Form::hidden('search',$data['inp']['search'])}}
                        {{Form::hidden('search_ausmusterung',$data['inp']['search_ausmusterung'])}}
                        {{ Form::submit($up, array('class'=>'dtk_arrow'))}}
                        {{ Form::close()}}
                    </div>
                    <div class="dtk_header3">
                        {{Form::open(array('url' => '/showUngedeckt', 'method' => 'POST'))}}﻿
                        {{Form::hidden('sort_key','lt')}}
                        {{Form::hidden('sort_dir','desc')}}
                        {{Form::hidden('search_ausmusterung',$data['inp']['search_ausmusterung'])}}
                        {{Form::hidden('search',$data['inp']['search'])}}
                        {{ Form::submit($down, array('class'=>'dtk_arrow'))}}
                        {{ Form::close()}}
                    </div>
                </div></div>
            <div class="dtk_labelcell" style="width:60px;">   <div class="dtk_header">Kurs cal</div></div>
            <div class="dtk_labelcell" style="width:90px;">   <div class="dtk_header">EK-Wert</div></div>
            <div class="dtk_labelcell" style="width:90px;">   <div class="dtk_header">Gedeckt</div></div>
            <div class="dtk_labelcell" style="width:90px;">  <div class="dtk_header">Offen</div></div>
            <div class="dtk_labelcell" style="width:120px;"> <div class="dtk_header">DTK</div> </div>
        </div>
        @foreach ($data['overview'] as $ov)
        <div class="dtk_row">
            <div class="dtk_cell" style="background-color:lightgray;">
                {{Form::open(array('url' => '/show/'.$ov->PPProduktpass_Id, 'method' => 'GET'))}}﻿
                {{Form::hidden('id',$ov->PPProduktpass_Id)}}
                {{ Form::submit($ov->PPProduktpass_IAN, array('class'=>'dtk_submit', 'style' => 'width:70px;'))}}
                {{ Form::close()}}</div>
            <div class="dtk_cell" style=""> {{substr($ov->PPProduktpass_Ausmusterungnummer,0,4)}}</div>
            <div class="dtk_cell" style=""> {{$ov->PPPurchase_Supplier}}</div>
            <div class="dtk_cell" style=""> {{$ov->PPProduktpass_Artikelbezeichnung}}</div>
            <div class="dtk_cell" style="text-align: center;"> {{$ov->PPProduktpass_LieferterminJahr}}/{{$ov->PPProduktpass_Liefertermin}}</div>
            <div class="dtk_cellr" style=""> {{number_format($ov->KursKalk,4,',','.')}}</div>
            <div class="dtk_cellr" style=""> {{number_format($ov->PO_Wert,2,',','.')}}</div>
            <div class="dtk_cellr" style=""> {{number_format($ov->Gedeckt,2,',','.')}}</div>
            <?php
            if (($ov->PO_Wert - $ov->Gedeckt) > 0) {
                $color = 'color:red;';
            } else {
                $color = 'color:green;';
            }
            ?>
            <div class="dtk_cellr" style="{{$color}}">{{number_format($ov->PO_Wert - $ov->Gedeckt,2,',','.')}}</div>
            <div class="dtk_cell" style="">
                @if (isset($data['assigns'][$ov->PPProduktpass_Id] ))
                @foreach ($data['assigns'][$ov->PPProduktpass_Id] as $ass)
                {{Form::open(array('url' => '/showDTK', 'method' => 'POST'))}}﻿
                {{Form::hidden('id',$ass['id'])}}
                {{ Form::submit($ass['ref'], array('style'=>'height:20px;width:100px;'))}}
                {{ Form::close()}}
                @endforeach
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

