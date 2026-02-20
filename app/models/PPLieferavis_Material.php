<?php

class PPLieferavis_Material extends Eloquent {
 
 	protected $table = 'PPLieferavis_Material';
	public  $timestamps = False;
	protected $primaryKey = 'PPLieferavis_Material_Id';
	
	protected $fillable = array(
		'PPLieferavis_Material_PPLieferavis_Id', 
		'PPLieferavis_Material_Materialnummer', 
		'PPLieferavis_Material_Menge', 
		'PPLieferavis_Material_OrderNr', 
		'PPLieferavis_Material_OrderPosNr', 
		'PPLiefveravis_Material_OrderGTIN',
		'PPLiefveravis_Material_AvisPosNr'
		
	);
}