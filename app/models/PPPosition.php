<?php

class PPPosition extends Eloquent {
 
 	protected $primaryKey = 'PositionIdent';
	protected $table = 'PPPosition';
	public  $timestamps = false;
	
	
	public function ppkopf()
	{
		return $this->belongs_to('PPKopf', 'PPKopf_RefNumber','RefNumber');
	}
 
}
