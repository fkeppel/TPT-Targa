<?php

class JsonController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function getIndex(){
		
		return "JsonController";
	}	
	
	public function anyStati($art)
	{
		$ppstati = PPStati::where('PPStati_Art','=',$art)->get();
		return $ppstati->toJson();
	}


	public function getLizenzen()
	{

		$liz =array();
		$liz[] =array('id' => 1, 'name' => 'Keppel');
		$liz[] =array('id' => 2, 'name' => 'Meier');
		$liz[] =array('id' => 3, 'name' => 'Schulze');
		$liz[] =array('id' => 5, 'name' => 'Grümpel');
		

		
   		return json_encode($liz);

	}
}
