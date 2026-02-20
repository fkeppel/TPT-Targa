<?php

class PPPPFiles extends Eloquent {
 
 	protected $table = 'PPPPFiles';
	public  $timestamps = True;
	protected $primaryKey = 'PPPPFiles_Id';
	
	protected $fillable = array(
		'PPPPFiles_PPProduktpass_Id',
		'PPPPFiles_Type',
		'PPPPFiles_Date',
		'PPPPFiles_Description',
		'PPPPFiles_SubKat',
		'PPPPFiles_Pfad'	);
	}
	