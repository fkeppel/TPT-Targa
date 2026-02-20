<?php


class DiffController extends BaseController {

	
	private function vd($var, $ex = true){
		echo('<pre>'); var_dump($var);echo('</pre>');
		if ($ex) exit;
	}


	public function getDiff($id){
		
		
		//var_dump($id);exit;
		$idn = $id;
		$ppn = PPProduktpass::find($id)->toArray();
		
		if (PPProduktpass::where ('PPProduktpass_IAN','=',$ppn['PPProduktpass_VorIAN'])->exists()){
				$idv = PPProduktpass::where ('PPProduktpass_IAN','=',$ppn['PPProduktpass_VorIAN'])->get()->first()->toArray()['PPProduktpass_Id'];
		} else {
				$data['content'] = "Keine Vorversion!";
				return View::make('main', $data);
		}
		
		$diffPP = $this->_getDiffPP($idv,$idn);
		//$this->vd($diffPP);
		$data['content'] = View::make('projects.diff')->with('diffs', $diffPP);
		$data['messages'] = "Unterschiede werden angezeigt!";
		
		return View::make('main', $data);
	
	}
	
	public function getDiffRevision($id){
		
		$idn = $id;
		$ppn = PPProduktpass::find($id)->toArray();
		
		$revakt = $ppn['PPProduktpass_RevisionAktuell']-1;
		
		
		if (PPProduktpass::where ('PPProduktpass_RevisionVon_PPProduktpass_Id','=',$id)->exists()){
				$idv = PPProduktpass::where ('PPProduktpass_RevisionVon_PPProduktpass_Id','=',$id)
				->where ('PPProduktpass_Revisionsnummer','=',$revakt)
				->get()->first()->toArray()['PPProduktpass_Id'];
		} else {
				$data['content'] = "Keine Vorversion!";
				return View::make('main', $data);
		}
		
		$diffPP = $this->_getDiffPP($idv,$idn);
		//$this->vd($diffPP);
		$data['content'] = View::make('projects.diff')->with('diffs', $diffPP);
		$data['messages'] = "Unterschiede werden angezeigt!";
		
		return View::make('main', $data);
	
	}
	
	
	private function _getObjectArray ($name, $id)
	{
		
		$idfield = $name.'_PPProduktpass_Id';
		if ($name == 'PPProduktpass') 		$idfield = 'PPProduktpass_Id';
		if ( $name::where ($idfield,'=',$id)->count() > 1 ) return $this->_getObjectArrays ($name, $id);
		
		$ret_array[0] = $name::where ($idfield,'=',$id)->get()->first()->toArray();
		
		return $ret_array;
		
		
	}
	
	private function _getObjectArrays ($name, $id)
	{
		
		$idfield = $name.'_PPProduktpass_Id';
		
		$values = $name::where ($idfield,'=',$id)->orderby($name."_Id")->get();
		$ret_array = array();
		$i=0;
		foreach ($values as $value){
			//$this->vd($value, false);
			$ret_array[$i] = $value->toArray();
			$i++;
		}
		
		return $ret_array;
	}
	
	private function _diffArray ($av, $an)
	{
		$ret = array();
		
			// Alle Arrays vergleichen!!!
		$lastpos = count($av);
		//$this->vd($lastpos."<br>",false);
		//$this->vd($av,true);
		
		
		for ($i=0; $i < $lastpos; $i++) { 
			foreach ($av[$i] as $key => $value) {
				//$this->vd("<b>$key</b><br>",false);
				//$this->vd($value,false);
				if ($value != $an[$i][$key]) {
					if (stripos($key, '_ID') === false){
						$ret[$i][$key]['old'] = $av[$i][$key];
						$ret[$i][$key]['new'] = $an[$i][$key];
					}
				} 
			}
		}		
	
		return $ret;
	}
	
	private function _getDiffPP($idv, $idn){
		
		$objects = array('PPProduktpass'=>'PPProduktpass','PPProduktpass_Menge'=>'Menge','PPProduktpass_Sortierung'=>'Sortierung','PPProduktpass_Qualitaet'=>'Qualität', 'PPPurchase'=>'Purchase', 'PPAB'=>"AB");
		foreach ($objects as $key => $value) {
			/*
			echo("<h1>$value</h1><br>");	
			$this->vd($this->_getObjectArray($value, $idv),false);
			$this->vd($this->_getObjectArray($value, $idn),false);
			echo("-------------------------------------<br><br>");
			*/	
			$ret[$value] = $this->_diffArray($this->_getObjectArray($key, $idv), $this->_getObjectArray($key, $idn));
		}
		//$this->vd($ret);
		return $ret;
	}

	
}

