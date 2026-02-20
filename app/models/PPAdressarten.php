<?php

class PPAdressarten extends Eloquent {
 
 	protected $table = 'PPAdressarten';
	public  $timestamps = True;
	protected $primaryKey = 'PPAdressarten_Id';
	
	protected $fillable = array(
	  'PPAdressarten_Art',
	  'PPAdressarten_Bezeichnung'
	);
}