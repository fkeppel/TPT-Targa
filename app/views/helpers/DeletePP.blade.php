<div style="width:600px;height:400px;border: 1px solid; padding:50px;text-align: left;margin:0 auto;margin-top:50px;">
    {{Form::open(array('url' => '/deleteIAN', 'method' => 'POST'))}}
    <h1>IAN löschen</h1><br>
    <table>
    <tr>
    <td>IAN:</td><td>{{Form::text('delete_ian','', array('style'=> 'padding:10px;'))}}</td>
    </tr><tr>
    <td>Ausmusterung:</td><td> {{Form::text('delete_ausm','', array('style'=> 'padding:10px;'))}}</td>
    </tr>
    <tr>
    <td colspan=2 style='padding:10px;'>{{ Form::submit('unwiderruflich löschen', array('style'=>'height:36px;width:100%;background-color:dodgerblue; color:white;font-weight:bold;'))}}</td>
    </tr>
    </table>
    {{ Form::close()}}
</div>