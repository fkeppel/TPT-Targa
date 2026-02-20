<?php

class PPAbgangshafen extends Eloquent {
 
 	protected $table = 'PPAbgangshafen';
	public  $timestamps = false;
	protected $primaryKey = 'PPAbgangshafen_Id';
	
	protected $fillable = array(
	  'PPAbgangshafen_Hafen',
	);
}