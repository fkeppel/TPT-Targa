<?php

class PPListBoxes extends Eloquent {
 
 	protected $table = 'PPListBoxes';
	public  $timestamps = True;
	protected $primaryKey = 'PPListBoxes_Id';
	
	protected $fillable = array(
	  	'PPListBoxes_Type', 
		'PPListBoxes_Ident', 
		'PPListBoxes_Value' 
	);
}