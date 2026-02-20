<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <title>
   Laravel
  </title>
 </head>
 <body>
  
  	<div>
  		{{$project->RefNumber}}
  	</div>
  	
	
	{{Form::model($project, ['url' => array('formsubmit', $project->RefNumber) ])}}



  	{{ Form::label('lbSupplier','Supplier',array('id'=>'','class'=>'')) }}
	
	{{ Form::input('text', 'Supplier', null, null )}}
	{{ Form::input('text', 'currency', null, null )}}
	{{ Form::input('text', 'LCNumber', null, null )}}
	{{ Form::input('text', 'ResOffice', null, null )}}
	{{ Form::input('text', 'Remark', null, null )}}

	{{ Form::submit('Save') }}

  	
  {{ Form::close() }}
 </body>
</html>