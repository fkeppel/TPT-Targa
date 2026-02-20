<style>
    label, input, textarea, select {
    display: inline-block; vertical-align: top; margin:2px;
}

label {width:250px;}
input{width:300px;}
ul {list-style-type: none;}
div {font-family: Tahoma;
    font-size:12px;}
</style>




<div style="border: 1px solid gray; border-radius: 5px; width:1000px;height:600px;padding:20px;text-align:left;padding:50px;margin: 0 auto;">
    <h1 style="color:#27408B"> Verwaltung Warengruppen Notizen</h1>

{{ Form::open(array('url'=>'warengruppen/edit', 'class'=>'form-signin')) }}



<fieldset>
    <legend style="font-size: 18px;">Warengruppen-Notizen</legend>

 <ul>
	<li>{{ Form::label('Warengruppen Notiz')}}{{ Form::select('PPWarengruppeNotice_WGRP',  $notes['lb'], $notes['notice']['PPWarengruppeNotice_WGRP']) }} {{ Form::submit('anzeigen', array('name'=>'submit_button','style'=>'width:100px;','class'=>'btn btn-large btn-primary btn-block'))}}
	{{ Form::text('PPWarengruppeNotice_WGRP_Neu',  null, array("style"=>"width:100px;")) }} {{ Form::submit('neu', array('name'=>'submit_button','style'=>'width:100px;','class'=>'btn btn-large btn-primary btn-block'))}}
	</li>
    <li>{{ Form::label('Text') }}{{ Form::textarea('PPWarengruppeNotice_Notice',$notes['notice']['PPWarengruppeNotice_Notice'],array('style'=>'overflow:auto;font-family:Tahoma;font-size:14px;padding:20px;width:600px;height:400px;')) }}</li>
    <li>{{ Form::label('') }}{{ Form::submit('speichern', array('name'=>'submit_button','class'=>'btn btn-large btn-primary btn-block', 'style'=>'margin-top:15px;height:40px;width:600px;'))}}</li>
</ul>
</fieldset>




    {{ Form::close() }}

</div>


</div>