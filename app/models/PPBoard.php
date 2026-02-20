<?php

class PPBoard extends Eloquent {
 
 	protected $table = 'PPBoard';
	public  $timestamps = True;
	protected $primaryKey = 'PPBoard_Id';
	
	protected $fillable = array(
	  'PPBoard_Bezeichnung',
	);
}