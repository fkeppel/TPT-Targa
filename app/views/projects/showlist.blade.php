<style>
	@import url(https://fonts.googleapis.com/css?family=Open+Sans);
	.cpcTable, .cpcTh, .cpcTd {text-align:left;}
	.cpcTh,.cpcTd{border:1px solid lightgray; padding:3px;}
	.cpcTh {background-color:#d9d9d9}
	.cpcTd{
		background-color:#FFF;
		padding:5px;
	}
	.cpcDiv {
		background-color:#FFF;
		font-family: 'Open Sans', Tahoma, sans-serif;
		border-radius: 5px;
		font-size: 5px;
		padding: 10px;
	}
	.cpcTable {
		background-color:#FFF;
		font-family: 'Open Sans', Tahoma, sans-serif;
		font-size: 11px;
		border-collapse: collapse;
	}
</style>
	<div class="cpcDiv" style="width:1630px;">
{{ Form::open(array('url'=>'setsearch', 'class'=>'form-signin')) }}
		<?php $q = $data['queries'];?>
		<table class="cpcTable" style="font-family:'Open Sans', Tahoma, Arial;font-size:11px;width: 100%;table-layout: fixed;">
			<tr class="cpcTr">
				<th class="cpcTh" style="width:5%;">{{ Form::text('queries[PPProduktpass_PPProjekte_Projekt]',$q['PPProduktpass_PPProjekte_Projekt'],array('style'=>'width:80px;')) }}</th>
				<th class="cpcTh" style="width:10%;">{{ Form::text('queries[PPProduktpass_IAN]',$q['PPProduktpass_IAN'],array('style'=>'width:130px;')) }}</th>
				<th class="cpcTh" style="width:5%;">{{ Form::text('queries[PPProduktpass_Status]',$q['PPProduktpass_Status'],array('style'=>'width:75px;') ) }}</th>
				<th class="cpcTh" style="width:30%;">{{ Form::text('queries[PPProduktpass_Artikelbezeichnung]',$q['PPProduktpass_Artikelbezeichnung'],array('style'=>'width:330px;') ) }}</th>
				<th class="cpcTh" style="width:25%;">{{ Form::text('queries[PPProduktpass_Ausmusterung]',$q['PPProduktpass_Ausmusterung'],array('style'=>'width:300px;') ) }}</th>
				<th class="cpcTh" style="width:9%;">{{ Form::text('queries[PPProduktpass_Warengruppe]',$q['PPProduktpass_Warengruppe'],array('style'=>'width:130px;') ) }}</th>
				<th class="cpcTh" style="width:8%;">{{ Form::text('queries[PPProduktpass_WAWIArtikelnummer]',$q['PPProduktpass_WAWIArtikelnummer'],array('style'=>'width:85px;') ) }}</th>
				<th class="cpcTh" style="width:8%;">{{ Form::submit('Filtern', array('name' => 'action', 'style' => 'width:60px;font-size:9px;'))  }}{{ Form::submit('ohne Filter', array('name' => 'action', 'style' => 'width:60px;font-size:9px;'))  }}</th>
				<!--th class="cpcTh" style="width:80px;">Aktion</th-->
			</tr>
		</table>		
{{Form::close()}}		
		<table class="cpcTable" style="font-family:'Open Sans', Tahoma, Arial;font-size:11px;width: 100%;table-layout: fixed;">
			<tr class="cpcTr">
				<th class="cpcTh" style="width:5%;">Projekt <a href="/showlist/1U" style="text-decoration: none;">&#9650;</a> <a href="/showlist/1D" style="text-decoration: none;">&#9660;</a></th>
				<th class="cpcTh" style="width:10%;">IAN  <a href="/showlist/2U" style="text-decoration: none;">&#9650;</a> <a href="/showlist/2D" style="text-decoration: none;">&#9660;</a></th>
				<th class="cpcTh" style="width:5%;">Status  <a href="/showlist/3U" style="text-decoration: none;">&#9650;</a> <a href="/showlist/3D" style="text-decoration: none;">&#9660;</a></th>
				<th class="cpcTh" style="width:30%;">Artikelbezeichnung  <a href="/showlist/4U" style="text-decoration: none;">&#9650;</a> <a href="/showlist/4D" style="text-decoration: none;">&#9660;</a></th>
				<th class="cpcTh" style="width:25%;">Ausmusterung  <a href="/showlist/5U" style="text-decoration: none;">&#9650;</a> <a href="/showlist/5D" style="text-decoration: none;">&#9660;</a></th>
				<th class="cpcTh" style="width:9%;">Warengruppe  <a href="/showlist/6U" style="text-decoration: none;">&#9650;</a> <a href="/showlist/6D" style="text-decoration: none;">&#9660;</a></th>
				<th class="cpcTh" style="width:8%;">WAWI  <a href="/showlist/7U" style="text-decoration: none;">&#9650;</a> <a href="/showlist/7D" style="text-decoration: none;">&#9660;</a></th>
				<!--th class="cpcTh" style="width:80px;">Aktion</th-->
				<th class="cpcTh" style="width:8px;">Aktion</th>
			</tr>
			@foreach ($data['projects'] as $project)
		    <tr>
				<td class="cpcTd">{{$project->PPProduktpass_PPProjekte_Projekt}}</td>
				<td class="cpcTd">{{$project->PPProduktpass_IAN}}</td>
				<td class="cpcTd">{{$project->PPProduktpass_Status}}</td>
				<td class="cpcTd">{{$project->PPProduktpass_Artikelbezeichnung}}</td>
				<td class="cpcTd">{{$project->PPProduktpass_Ausmusterung}}</td>
				<td class="cpcTd">{{$project->PPProduktpass_Warengruppe}}</td>
				<td class="cpcTd">{{$project->PPProduktpass_WAWIArtikelnummer}}</td>
				<!--td class="cpcTd">
					{{ Form::open(array('url'=>'newProjekt/'.$project->PPProduktpass_Id, 'class'=>'form-signin')) }}
					{{ Form::hidden($project->PPProduktpass_Id) }}
					{{ Form::submit('Termine', array('class'=>'btn btn-large btn-primary btn-block','style'=>'width:80px;height:20px;font-size:11px;'))}}
					{{ Form::close() }}
				</td-->
				<td class="cpcTd">
					{{ Form::open(array('url'=>'showp/'.$project->PPProduktpass_Id, 'class'=>'form-signin')) }}
					{{ Form::hidden($project->PPProduktpass_Id) }}
					{{ Form::submit('ansehen', array('class'=>'btn btn-large btn-primary btn-block','style'=>'width:80px;height:20px;font-size:11px;'))}}
					{{ Form::close() }}
					{{ Form::open(array('url'=>'deletep/'.$project->PPProduktpass_Id, 'class'=>'form-signin')) }}
					{{ Form::hidden($project->PPProduktpass_Id) }}
					{{ Form::submit('löschen', array('class'=>'btn btn-large btn-primary btn-block','style'=>'width:80px;height:20px;font-size:11px;'))}}
					{{ Form::close() }}
				</td>
		    </tr>
		    @endforeach
		</table>
</div>