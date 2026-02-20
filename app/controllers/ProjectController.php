<?php
class ProjectController extends BaseController {
	/**
	 * Display a listing of the resource.
	 * GET /project
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		//$projects=PPKopf::all();
		//$project=PPKopf::find(123);
		//echo("Supplier:".$project->Supplier);
		//return View::make('projects')->with('projects', $projects);
		//foreach ($project->positions as $position) {
		//	echo("<pre>");echo($position->Article);echo("</pre><br><br>");
		//	$position->Article = "ABB-4711";
		//	$position->save();
		//}			
	$status['anab'] = 'login';
	$status['link'] = 'users/login';
	$status['user'] = 'nn';
	$params = array();
	$params['name']="Franky";
	$params['userstatus']="Happy";
	/*	
	if (Auth::attempt(array('username' => 'fkeppel', 'password' =>  'hallo'))){
    	// The passwords match...
		$user = User::find(1);
		$status['user'] = $user->username;
    	$status['anab'] = 'abmelden';
		$status['link'] = 'users/logout';
	}
	*/
	$params['content']=View::make('users.login',$params);
	return View::make('main', $params);	
	}
	/**
	 * Show the form for creating a new resource.
	 * GET /project/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}
	/**
	 * Store a newly created resource in storage.
	 * POST /project
	 *
	 * @return Response
	 */
	public function save($ref)
	{
		//
		$project=PPKopf::find($ref);
		//echo("ID".$ref."<br><br> <a href='http://belotex.local'>back</a>");
		dd(Input::all());exit;
		$inputs=Input::all();
		//$project->update(Input::all()); 
		$project->Supplier = $inputs['Supplier']; 
		$project->save();
		//var_dump($_POST);
		return $this->index();
	}
	public function store()
	{
		//
	}
	/**
	 * Display the specified resource.
	 * GET /project/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
		//
		//echo Form::model($user, array('route' => array('user.update', $user->id)));
		$project=PPKopf::find(123);
		return View::make('frmProjects')->with('project',$project);
	}
	/**
	 * Show the form for editing the specified resource.
	 * GET /project/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}
	/**
	 * Update the specified resource in storage.
	 * PUT /project/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}
	/**
	 * Remove the specified resource from storage.
	 * DELETE /project/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	function outputPDF ($id){
		Fpdf::AddPage();
        Fpdf::SetFont('Arial','B',16);
        Fpdf::Cell(40,10,'Hello World!');
        Fpdf::Output();
	}
}