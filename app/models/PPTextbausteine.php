<?php

class PPTextbausteine extends Eloquent {
 
 	protected $table = 'PPTextbausteine';
	public  $timestamps = FALSE;
	protected $primaryKey = 'PPTextbausteine_Id';
	
	protected $fillable = array(
	  'PPTextbausteine_Art',
	  'PPTextbausteine_Text'
	);
}