<style>
    @import url(https://fonts.googleapis.com/css?family=Open+Sans);
    label, input, textarea, select {
        display: inline-block; vertical-align: top; margin:2px;
    }
    div {
        background-color:#FFF;
        font-family: 'Open Sans', Tahoma, sans-serif;
        border-radius: 5px;
    }
    form{
        font-family: 'Open Sans', Tahoma, sans-serif;
        font-size: 12px;
    }
    label {width:150px;}
    input{width:150px;}
    ul {list-style-type: none;}
</style>
<div style="width:1590px;height:400px;padding:30px;text-align:left;font-family: ">
    {{ Form::open(array('url'=>'showlist', 'class'=>'form-signin')) }}
    <ul>
        <li>{{ Form::label('IAN') }}{{ Form::text('qPPProduktpass_IAN') }}</li>
        <li>{{ Form::label('Artikelbezeichnung') }}{{ Form::text('qPPProduktpass_Artikelbezeichnung') }}</li>
        <li>{{ Form::label('Ausmusterung') }}{{ Form::text('qPPProduktpass_Ausmusterung') }}</li>
    </ul>
    {{ Form::submit('suchen', array('class'=>'btn btn-large btn-primary btn-block', 'style'=>'margin-left:195px;'))}}
    {{ Form::close() }}
</div>
