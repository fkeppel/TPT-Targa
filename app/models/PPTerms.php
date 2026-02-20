<?php

class PPTerms extends Eloquent {
 
 	protected $table = 'PPTerms';
	public  $timestamps = True;
	protected $primaryKey = 'PPTerms_Id';
	
	protected $fillable = array(
	  'PPTerms_MC',
	  'PPTerms_Text',
	  'PPTerms_Art',
	);
}