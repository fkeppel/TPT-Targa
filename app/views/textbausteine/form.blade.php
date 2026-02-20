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
    <h1 style="color:#27408B"> Verwaltung Textbausteine</h1>
    
{{ Form::open(array('url'=>'textbausteine/edit', 'class'=>'form-signin')) }}
    
    

    <fieldset>
    <legend style="font-size: 18px;">Textbausteine</legend> 

 <ul>
      <li>{{ Form::label('Textbaustein')}}{{ Form::select('PPTextbausteine_Art',  $txtbss['Arten'], $txtbss['Art']) }} {{ Form::submit('anzeigen', array('name'=>'submit_button','style'=>'width:100px;','class'=>'btn btn-large btn-primary btn-block'))}}
</li>
      <!--li>{{ Form::label('Id') }}{{ Form::text('PPMitarbeiter_Id') }}</li-->
      
      <li>{{ Form::label('Text') }}{{ Form::textarea('PPTextbausteine_Text',$txtbss['Text'],array('style'=>'overflow:auto;font-family:Tahoma;font-size:14px;padding:20px;width:600px;height:300px;')) }}</li>
      <li>{{ Form::label('Bild') }}{{ Form::text('PPTextbausteine_Picture',$txtbss['Picture']) }}</li>
<li>{{ Form::label('Bild Position')}}{{ Form::select('PPTextbausteine_PicturePos',  $txtbss['PicturePoss'], $txtbss['PicturePos']) }} </li>
    <li>{{ Form::label('') }}{{ Form::submit('speichern', array('name'=>'submit_button','class'=>'btn btn-large btn-primary btn-block', 'style'=>'margin-top:15px;height:40px;width:600px;'))}}</li>
</ul>
</fieldset>

    
    
    
    {{ Form::close() }}

</div>

    
</div>