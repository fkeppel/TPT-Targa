<?php

class PPLieferavis_Container extends Eloquent {
 
 	protected $table = 'PPLieferavis_Container';
	public  $timestamps = False;
	protected $primaryKey = 'PPLieferavis_Container_Id';
	
	protected $fillable = array(
		'PPLieferavis_Container_PPLieferavis_Id', 
		'PPLieferavis_Container_ContainerId', 
		'PPLieferavis_Container_Art', 
		'PPLieferavis_Container_PalCon', 
		'PPLieferavis_Container_BOLNr',
		'PPLieferavis_Container_PPLieferavis_BOL_Id'
			);
}