<?php

class PPLieferavis_MARM extends Eloquent {
 
 	protected $table = 'PPLieferavis_MARM';
	public  $timestamps = False;
	protected $primaryKey = 'PPLieferavis_MARM_Id';
	
	protected $fillable = array(
	'PPLieferavis_MARM_SATNR', 
	'PPLieferavis_MARM_Laenge', 
	'PPLieferavis_MARM_Breite', 
	'PPLieferavis_MARM_Hoehe', 
	'PPLieferavis_MARM_Brutto', 
	'PPLieferavis_MARM_Netto'
	);
}