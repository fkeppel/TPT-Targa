<style>
	td{
		border:1px solid gray;
		padding:4px;
	}
</style>
<div style="background: #FFF;margin:0 auto;margin:20px;width:1610px;">
	<table style="font-family: Tahoma;font-size:12px;text-align: left;border-collapse: collapse;">
		
		<tr>
			<!--td style="width:80px;text-align: center;background-color: #d0d0d0;">Id</td-->
			<td style="width:100px;background-color: #d0d0d0;">Name</td>
			<td style="width:100px;background-color: #d0d0d0;">Vorname</td>
			<td style="width:100px;background-color: #d0d0d0;">Kürzel</td>
			<td style="width:100px;background-color: #d0d0d0;">Anmeldename</td>
			<td style="width:100px;background-color: #d0d0d0;">Gruppe</td>
			<td style="width:100px;background-color: #d0d0d0;">Aktion</td>
		</tr>
		
		
		@foreach ($mas as $ma)
	    <tr>
			<!--td style="text-align: center;"> {{ $ma->PPMitarbeiter_Id }}</td-->
			<td> {{ $ma->PPMitarbeiter_Name }}</td>
			<td> {{ $ma->PPMitarbeiter_Vorname }}</td>
			<td> {{ $ma->PPMitarbeiter_Kuerzel }}</td>
			<td> {{ $ma->username }}</td>
			<td> {{ $ma->PPMitarbeiter_Gruppe }}</td>
			<td>
				{{ Form::open(array('url'=>'mitarbeiter/show/'.$ma->PPMitarbeiter_Id, 'class'=>'form-signin')) }}
					{{ Form::submit('ansehen', array('class'=>'btn btn-large btn-primary btn-block'))}}
				{{ Form::close() }}
			</td>
	    </tr>
		@endforeach
		
		
	</table>
	<div style="text-align: left;margin:0 auto;padding-top:10px;">
			{{ Form::open(array('url'=>'mitarbeiter/create')) }}
				{{ Form::submit('Neuer Mitarbeiter')}}
			{{ Form::close() }}
	
	</div>

</div>
