<?php

class PPLieferavis_Container_Content extends Eloquent {
 
 	protected $table = 'PPLieferavis_Container_Content';
	public  $timestamps = false;
	protected $primaryKey = 'PPLieferavis_Container_Content_Id';
	
	protected $fillable = array(
		'PPLieferavis_MARM_SATNR', 
		'PPLieferavis_MARM_Laenge', 
		'PPLieferavis_MARM_Breite', 
		'PPLieferavis_MARM_Hoehe', 
		'PPLieferavis_MARM_Brutto', 
		'PPLieferavis_MARM_Netto'
	);
}