 <div style="background-color: #FFF; border:1px solid gray;border-radius: 5px; width:1638px;height:895px;text-align: left;padding:30px; font-family: Tahoma; font-size: 14px;">
    <h1>Produktpass Upload Shipping AVIS </h1>


    <div style="width:600px;float:left;border:4px solid lightgray;padding:20px;height:550px;">
        <h2>Excel-Import</h2>
        {{Form::open(array('url' => 'uploadAvis', 'method' => 'POST', 'files' => 'true'))}}﻿

        <div style="width:500px;height:200px;border: 1px solid lightgray;padding:10px;margin-top: 15px;">
            <h3> Importieren</h3>
            <div style="margin-top:20px;"><input type="file" name="file" style="font-size:20px;margin-top: 15px;width:400px;height: 30px;"/></div>
            <input type="submit" value="IMPORTIEREN" style="width:400px;margin-top:20px;font-size:20px;height:40px;"/>
        </div>
        {{ Form::close() }}
        
        <p>{{$data['message']}}</p>
        
    </div>
</div>
