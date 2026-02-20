<div style="text-align: left;padding:30px;">
	
{{ Form::open(array('url'=>'users/create', 'class'=>'form-signup')) }}
	<h2 class="form-signup-heading">Benutzer anlegen/ändern</h2>

	<ul>
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>

	{{Form::label('Vorname')}}{{ Form::text('Vorname', $user->BISUser_Vorname, array('class'=>'input-block-level', 'placeholder'=>'Vorame')) }}<br>
	{{Form::label('Name')}}{{ Form::text('Nachname', $user->BISUser_Name, array('class'=>'input-block-level', 'placeholder'=>'Nachname')) }}<br>
	{{Form::label('E-Mail')}}{{ Form::text('E-Mail', $user->BISUser_email, array('class'=>'input-block-level', 'placeholder'=>'E-Mail Adresse')) }}<br>
	{{Form::label('Benutzername')}}{{ Form::text('Benutzername', $user->BISUser_username, array('class'=>'input-block-level', 'placeholder'=>'Benutzername')) }}<br>
	{{Form::label('Gruppe')}}{{ Form::select('Gruppe',  array('admin'=>'Administrator', 'user'=>'Benutzer'), $user->BISUser_group, array('class'=>'input-block-level', 'placeholder'=>'Gruppe')) }}<br>
	{{Form::label('Passwort')}}{{ Form::password('password', array('class'=>'input-block-level', 'placeholder'=>'Password')) }}<br>
	{{Form::label('Passwort Bestätigung')}}{{ Form::password('password_confirmation', array('class'=>'input-block-level', 'placeholder'=>'Password wiederholen')) }}<br><br>

	{{ Form::submit('anlegen', array('class'=>'btn btn-large btn-primary btn-block'))}}
{{ Form::close() }}

</div>
