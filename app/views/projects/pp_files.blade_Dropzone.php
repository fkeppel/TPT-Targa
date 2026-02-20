<div style="width:1560px; height:860px;border:1px solid gray;border-radius:5px;position:relative;">

	<div style="position: absolute;top:0; padding:10px;margin:0 auto;overflow: auto;">
		{{Form::open(array('url' => 'uploadFiles', 'method' => 'POST', 'files' => 'true', 'data-ajax' => 'true'))}}﻿
			{{Form::hidden('ppid',$data['pp']['PPProduktpass_Id']);}}
			<div style="width: 500px;float: left; border:1px solid lightgray;height:150px;padding:10px;">
				{{Form::label('1. Schritt',Null,array('style'=>'background-color:#E9E9E9;width:480px;'))}}<br>
				{{Form::label('Dateiart:')}}{{Form::select('filetype', $data['files']['types'],Null,array('style'=>'height:23px;width:344px;margin-top:3px;margin-left:12px;'))}}<br><br>
				{{Form::label('Kategorie:')}}{{Form::text('Kategorie', Null,array('style'=>'height:23px;width:344px;margin-top:3px;margin-left:12px;'))}}<br><br>
				{{Form::label('Datei:')}}
				{{Form::file('file',array('style'=>'width:355px;border:none;margin-top:-1px;'))}}<br>
			</div>

			<div style="width: 400px;float: left; border:1px solid lightgray;height:150px;padding:10px;margin-left:15px;margin-right:15px;">
				{{Form::label('2. Schritt',Null,array('style'=>'background-color:#E9E9E9;width:380px;'))}}<br>
				{{Form::label('Bemerkung:')}}<br>{{Form::textarea('bemerkung',NULL,array('style'=>'height:70px;width:392px;'))}}<br>
			</div>

			<div style="width: 300px;float: left; border:1px solid lightgray;height:150px;padding:10px;">
				{{Form::label('3. Schritt',Null,array('style'=>'background-color:#E9E9E9;width:280px;'))}}<br>
				<input type="submit" value="IMPORT" style="width:290px;height:100px;background-color:rgba(246, 168, 40, 1); " />
			</div>
			<div style="clear: both;">&nbsp;</div>				
		{{ Form::close() }}
	</div>
		
	<div style="border:1px solid gray;position: relative;top:200px;height:649px;overflow: auto;">
		<div id="filetabs">
			<ul>
				<li>
					<a href="#ft_Docs">Dokumente</a>
				</li>
				<li>
					<a href="#ft_PPUpload">autom. PP Upload</a>
				</li>
	
				<li>
					<a href="#ft_Artwork">Artwork</a>
				</li>
				<li>
					<a href="#ft_Designs">Designs</a>
				</li>
				<li>
					<a href="#ft_NonFood">NonFood</a>
				</li>
	
				<li>
					<a href="#ft_QS">QS</a>
				</li>
				<li>
					<a href="#ft_Labor">Labor</a>
				</li>
				<li>
					<a href="#ft_Diverse">Diverse</a>
				</li>


			</ul>
			<div id="ft_Docs" style="height:550px;overflow:auto;border:none;">
				<div id="filesubtabsDokumente">
				<ul>
					<?php 
							$subkats = array();
							foreach($data['files']['files'] as $file ){
								if ($file['PPPPFiles_Type'] == 'Dokumente'){
									$subkats[$file['PPPPFiles_SubKat']] = $file['PPPPFiles_SubKat']; 
								}
							}
					
					?>
					@foreach($subkats as $kat)
							<li>
								<a href="#{{$kat}}">{{$kat}}</a>
							</li>
					@endforeach

				</ul>
					@foreach($subkats as $kat)
						<div id="{{$kat}}">
							<table style="font-family: 'Open sans', Tahoma, Arial;font-size: 11px;">
								@foreach($data['files']['files'] as $file)
									@if ($file['PPPPFiles_Type'] == 'Dokumente' and $file['PPPPFiles_SubKat'] == $kat  )
										@include('projects.pp_files_sub')
									@endif
								@endforeach
							</table>
						</div>
					@endforeach


				</div>
			</div>
			<div id="ft_PPUpload" style="height:550px;overflow:auto;border:none;">
				<table style="font-family: 'Open sans', Tahoma, Arial;font-size: 11px;">
				@foreach($data['files']['files'] as $file)
				@if ($file['PPPPFiles_Type'] == 'PPUpload')
					@include('projects.pp_files_sub')
				@endif
				@endforeach
				</table>

			</div>		


			<div id="ft_Artwork" style="height:550px;overflow:auto;border:none;">
				<table style="font-family: 'Open sans', Tahoma, Arial;font-size: 11px;">
				@foreach($data['files']['files'] as $file)
				@if ($file['PPPPFiles_Type'] == 'Artwork')
					@include('projects.pp_files_sub')
				@endif
				@endforeach
				</table>
			</div>
			<div id="ft_Designs" style="height:550px;overflow:auto;border:none;">
				<table style="font-family: 'Open sans', Tahoma, Arial;font-size: 11px;">
				@foreach($data['files']['files'] as $file)
				@if ($file['PPPPFiles_Type'] == 'Designs')
					@include('projects.pp_files_sub')
				@endif
				@endforeach
				</table>

			</div>
			<div id="ft_NonFood" style="height:550px;overflow:auto;border:none;">
				<table style="font-family: 'Open sans', Tahoma, Arial;font-size: 11px;">
				@foreach($data['files']['files'] as $file)
				@if ($file['PPPPFiles_Type'] == 'NonFood')
					@include('projects.pp_files_sub')
				@endif
				@endforeach
				</table>

			</div>
	
			<div id="ft_QS" style="height:550px;overflow:auto;border:none;">
				<table style="font-family: 'Open sans', Tahoma, Arial;font-size: 11px;">
				@foreach($data['files']['files'] as $file)
				@if ($file['PPPPFiles_Type'] == 'QS')
					@include('projects.pp_files_sub')
				@endif
				@endforeach
				</table>
			</div>		
			<div id="ft_Labor" style="height:550px;overflow:auto;border:none;">
				<div id="filesubtabsLabor">
				<ul>
					<?php 
							$subkats = array();
							foreach($data['files']['files'] as $file ){
								if ($file['PPPPFiles_Type'] == 'Labor'){
									$subkats[$file['PPPPFiles_SubKat']] = $file['PPPPFiles_SubKat']; 
								}
							}
					
					?>
					@foreach($subkats as $kat)
							<li>
								<a href="#{{$kat}}">{{$kat}}</a>
							</li>
					@endforeach

				</ul>
					@foreach($subkats as $kat)
						<div id="{{$kat}}">
							<table style="font-family: 'Open sans', Tahoma, Arial;font-size: 11px;">
								@foreach($data['files']['files'] as $file)
									@if ($file['PPPPFiles_Type'] == 'Labor' and $file['PPPPFiles_SubKat'] == $kat  )
										@include('projects.pp_files_sub')
									@endif
								@endforeach
							</table>
						</div>
					@endforeach


				</div>			
			</div>		
			<div id="ft_Diverse" style="height:550px;overflow:auto;border:none;">
					<div id="filesubtabsDiverse">
				<ul>
					<?php 
							$subkats = array();
							foreach($data['files']['files'] as $file ){
								if ($file['PPPPFiles_Type'] == 'Diverse'){
									$subkats[$file['PPPPFiles_SubKat']] = $file['PPPPFiles_SubKat']; 
								}
							}
					
					?>
					@foreach($subkats as $kat)
							<li>
								<a href="#{{$kat}}">{{$kat}}</a>
							</li>
					@endforeach

				</ul>
					@foreach($subkats as $kat)
						<div id="{{$kat}}">
							<table style="font-family: 'Open sans', Tahoma, Arial;font-size: 11px;">
								@foreach($data['files']['files'] as $file)
									@if ($file['PPPPFiles_Type'] == 'Diverse' and $file['PPPPFiles_SubKat'] == $kat  )
										@include('projects.pp_files_sub')
									@endif
								@endforeach
							</table>
						</div>
					@endforeach


				</div>			
			</div>		
		
		</div>
	</div>
</div>
