<style>
    label, input, textarea, select { 
 	    display: inline-block; vertical-align: top; margin:2px;
    }
    label {width:250px;}
    input{width:300px;}
    ul {list-style-type: none;}
    div {
        font-family: Tahoma; 
	    font-size:12px;
    }
    #mitarbeiterDaten {
        border:none;
        font-size: 0.9rem;
        text-align: left;
        border-radius: 0px;
        padding: 50px;
    }
    #mitarbeiterDaten ul {
        list-style-type: none;
    }
    #mitarbeiterDaten fieldset {
        width: 575px;
    }
    #mitarbeiterDaten label {
        font-weight: bold;
        padding-top: 8px;
        width: 170px;
    }
    #mitarbeiterDaten input, select {
        border:1px solid rgb(7, 156, 49);
        padding:8px;
        width:300px;
    }
    .cpcbtn {
        width: 600px !important;
        font-weight: bold;
        height: 40px;
    }
</style>
<?php 
    $lang =  isset($ma['PPMitarbeiter_Language'])?$ma['PPMitarbeiter_Language']:'DE';
    $tatigkeiten = ViewController::getTaetigkeiten();
?>
<div id="mitarbeiterDaten">
{{ Form::model($ma, array('url'=>'mitarbeiter/store/'.$ma['PPMitarbeiter_Id'], 'class'=>'form-signin')) }}
	<input type="'hidden" name="delid" value="{{$ma['PPMitarbeiter_Id'] }}">
	<fieldset>
    <legend>Mitarbeiter</legend> 
 <ul>
      <!--li>{{ Form::label('Id') }}{{ Form::text('PPMitarbeiter_Id') }}</li-->
      <li><label>Name</label> <input name="PPMitarbeiter_Name"  value="{{isset($ma['PPMitarbeiter_Name'])?$ma['PPMitarbeiter_Name']:'' }}" /></li>
      <li><label>Vorname</label> <input name="PPMitarbeiter_Vorname"  value="{{isset($ma['PPMitarbeiter_Vorname'])?$ma['PPMitarbeiter_Vorname']:'' }}" /></li>
      <li><label>Kürzel</label> <input name="PPMitarbeiter_Kuerzel"  value="{{isset($ma['PPMitarbeiter_Kuerzel'])?$ma['PPMitarbeiter_Kuerzel']:'' }}" /> </li>
      <li><label>e-mail</label> <input name="PPMitarbeiter_email"  value="{{isset($ma['PPMitarbeiter_email'])?$ma['PPMitarbeiter_email']:'' }}" /> </li>
        <li><label>Sprache</label>
        <select name="PPMitarbeiter_Language"> 
            <option @if($lang == 'DE') selected @endif >DE</option> 
            <option @if($lang == 'EN') selected @endif >EN</option> 
            <option @if($lang == 'FI') selected @endif >FI</option> 
            <option @if($lang == 'NL') selected @endif >NL</option> 
        </select>
        </li>
	  <li><label>Gruppe</label> 
        <select name="PPMitarbeiter_Gruppe">
            <option value="user" @if($ma['PPMitarbeiter_Gruppe'] == 'user') selected="selected" @endif>Benutzer</option>
            <option value="admin"  @if($ma['PPMitarbeiter_Gruppe'] == 'admin') selected="selected" @endif>Administrator</option>
            <option value="extern"  @if($ma['PPMitarbeiter_Gruppe'] == 'extern') selected="selected" @endif>Externe</option>
        </select>
  </li>
  <li><label>Tätigkeit</label> 
    <select name="PPMitarbeiter_Taetigkeit">
        <option value="" @if(isset($ma['PPMitarbeiter_Taetigkeit']) and $ma['PPMitarbeiter_Taetigkeit'] == '') selected="selected" @endif>N.N.</option>
        @foreach($tatigkeiten as $id => $taet)
            <option value="{{$taet}}" @if(isset($ma['PPMitarbeiter_Taetigkeit']) and $ma['PPMitarbeiter_Taetigkeit'] == $taet) selected="selected" @endif>{{$taet}}</option>
        @endforeach
        <!-- option value="XPJM" @if(isset($ma['PPMitarbeiter_Taetigkeit']) and $ma['PPMitarbeiter_Taetigkeit'] == 'PJM') selected="selected" @endif>PJM</option>
        <option value="XPM" @if(isset($ma['PPMitarbeiter_Taetigkeit']) and $ma['PPMitarbeiter_Taetigkeit'] == 'PM') selected="selected" @endif>PM</option>
        <option value="XTC"  @if(isset($ma['PPMitarbeiter_Taetigkeit']) and $ma['PPMitarbeiter_Taetigkeit'] == 'TC') selected="selected" @endif>TC</option -->
    </select>
</li>
<li><label>Master</label> 
        <input type="hidden" value="0" name="isMaster">
        <input type="checkbox" value="1" name="isMaster"  @if($ma['isMaster'] == 1) checked @endif>
    </li>
<li><label title='Folgende Rollen sind bisher implementiert: PUB, PPIMP, ZOLL  Kombinierbar mit @ Bsp.: PUB@PPIMP'>Rollen</label> <input name="PPMitarbeiter_Role" value="{{isset($ma['PPMitarbeiter_Role'])?$ma['PPMitarbeiter_Role']:'PUB' }}"  title='Folgende Rollen sind bisher implementiert: PUB, PPIMP, ZOLL  Kombinierbar mit @ Bsp.: PUB@PPIMP' /></li>
<li><label>Anmeldename</label> <input name="username" value="{{isset($ma['username'])?$ma['username']:'' }}" /></li>
<li><label>Passwort</label>  <input id="pwd" type="password" name="1password"  /></li>
<li><label></label><button  style="margin-left: 6px; margin-top: 6px;" type="button" onclick="showPW();">Show Password</button>
             <button  style="margin-left: 6px; margin-top: 6px;" type="submit"  name='submit' value='unlock'>entsperren Fails:{{ isset($login_attempts)?$login_attempts:0; }}</button></li>      
</ul>
</fieldset>
<input type="submit" name="submit" value="speichern" class="cpcbtn"/>
<input type="submit" name="submit" value="löschen" onclick="return confirm('Mitarbeiter wirklich löschen?');" class="cpcbtn"/>
	{{ Form::close() }}
</div>
<script>
    function showPW ( )  {
        var x = document.getElementById("pwd");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>