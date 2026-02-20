<div style="width:900px;height:400px;border: 1px solid; padding:50px;text-align: left;margin:0 auto;margin-top:50px;">
    {{Form::open(array('url' => '/deleteIAN', 'method' => 'POST'))}}
    <div style="width:800px;"> <b>{{$pp->PPProduktpass_IAN}}  [{{substr( $pp->PPProduktpass_Ausmusterungnummer,0,4 )}}]</b><br><br>
        {{$pp->PPProduktpass_Artikelbezeichnung}}</div>
    {{Form::hidden('delete_ian_confirm','1')}}
    {{Form::hidden('delete_ian_id',$pp->PPProduktpass_Id)}}
    {{Form::hidden('delete_ian_ian',$pp->PPProduktpass_IAN)}}
    <br>
    <b>IAN wirklich löschen?</b><br><br>
    {{ Form::submit('unwiderruflich löschen', array('style'=>'height:36px;padding:10px;background-color:dodgerblue;color:white;font-weight:bold;width:180px;font-size:14px;'))}}
    {{ Form::close()}}
</div>