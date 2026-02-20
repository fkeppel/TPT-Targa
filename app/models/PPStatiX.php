<?php

class PPStatiX extends Eloquent {
 
 	protected $table = 'PPStatiX';
	public  $timestamps = FALSE;
	protected $primaryKey = 'PPStati_Id';
	
	protected $fillable = array(
		'PPStati_Status', 
		'PPStati_Art'
		);
}