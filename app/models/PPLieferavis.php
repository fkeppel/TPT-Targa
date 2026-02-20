<?php

class PPLieferavis extends Eloquent {
 
 	protected $table = 'PPLieferavis';
	public  $timestamps = false;
	protected $primaryKey = 'PPLieferavis_Id';
	
	protected $fillable = array(
	 
  	'PPLieferavis_ETD',
	'PPLieferavis_ETA', 
  	'PPLieferavis_POL', 
  	'PPLieferavis_POD', 
  	'PPLieferavis_SupplierId', 
  	'PPLieferavis_FrachtfuehrerId', 
  	'PPLieferavis_SpediteurId', 
	'PPLieferavis_SeaAir', 
  	'PPLieferavis_Schiffsnummer', 
  	'PPLieferavis_AvisNr', 
	'PPLieferavis_Incoterm', 
  	'PPLieferavis_Incoterm2', 
  	'PPLieferavis_Abgangsland', 
 	'PPLieferavis_Remark'
 		 
	);
}