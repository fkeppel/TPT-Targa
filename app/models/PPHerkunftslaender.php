<?php

class PPHerkunftslaender extends Eloquent {
 
 	protected $table = 'PPHerkunftslaender';
	public  $timestamps = false;
	protected $primaryKey = 'PPHerkunftslaender_Id';
	
	protected $fillable = array(
	  'PPHerkunftslaender_Land',
	);
}