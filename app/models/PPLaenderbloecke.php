<?php

class PPLaenderbloecke extends Eloquent {
 
 	protected $table = 'PPLaenderbloecke';
	public  $timestamps = True;
	protected $primaryKey = 'PPLaenderbloecke_Id';
	
	protected $fillable = array(
	'PPLaenderbloecke_Land', 
	'PPLaenderbloecke_Block',
	'PPLaenderbloecke_Hafen1',
	'PPLaenderbloecke_Hafen2'
		);
	}
	