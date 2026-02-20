

<div style="width:800px;height:600px;border:1px solid red;">
    <h1>EAN Nummernvergabe</h1>

<?php $ean=$data['ean'] ?>    
{{ Form::open( array('url'=>'EAN/store/'.$ean['EAN_Nummern_Id'], 'class'=>'form-signin')) }}


    <fieldset>
    
        <ul>
            <li>
                {{ Form::label('Basisnummer') }}{{ Form::text('EAN_Nummern_EAN_Basisnummer_Id', $ean['EAN_Nummern_EAN_Basisnummer_Id']) }}
            </li>
            <li>
                {{ Form::label('EAN-Nummer') }}{{ Form::text($ean['EAN_Nummern_EAN']) }}
            </li>
        </ul>
    </fieldset>
    
    {{ Form::submit('speichern', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;'))}}
    
{{ Form::close()}}
    
</div>