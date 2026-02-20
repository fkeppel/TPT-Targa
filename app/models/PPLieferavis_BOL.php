<?php

class PPLieferavis_BOL extends Eloquent {
 
 	protected $table = 'PPLieferavis_BOL';
	public  $timestamps = false;
	protected $primaryKey = 'PPLieferavis_BOL_Id';
	
	protected $fillable = array(
		'PPLieferavis_BOL_Id', 
		'PPLieferavis_BOL_BOLNr', 
		'PPLieferavis_BOL_Brutto', 
		'PPLieferavis_BOL_Netto'
	);
}