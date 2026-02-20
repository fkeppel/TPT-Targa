<style>
	.diffh{
		background-color:lightgray; border:1px solid black;width:150px;
	}
	.diffr{
		border: 1px solid black; width: 150px;
	}
	.diffh, .diffr {
		padding:5px;
	}
</style>
<div style="width:1500px; border:1px solid green;text-align: left;margin:25px;padding:10px;min-height:800px;">
	


<table style="font-size: 11px;">
	<tr>
		<td class="diffh">Tabelle</td>
		<td class="diffh">Attribut</td>
		<td class="diffh">Wert Vorversion</td>
		<td class="diffh">Wert Aktuell</td>
	</tr>
	@foreach ($diffs as $table => $diff)
		@foreach ($diffs[$table] as $key => $changes)
			@foreach ($changes as $attr => $value)
				<tr>
					<td class="diffr"><b>{{$table}}</b></td>
					<td class="diffr">{{$attr}}</td>
					<td class="diffr">{{$value['old']}}</td>
					<td class="diffr">{{$value['new']}}</td>
				</tr>
			@endforeach
		@endforeach
	@endforeach
</table>
	
	
</div>