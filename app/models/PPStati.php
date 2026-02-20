<?php

class PPStati extends Eloquent {
 
 	protected $table = 'PPStati';
	public  $timestamps = FALSE;
	protected $primaryKey = 'PPStati_Id';
	
	protected $fillable = array(
		'PPStati_Status', 
		'PPStati_Color', 
		'PPStati_Background'
	);
}