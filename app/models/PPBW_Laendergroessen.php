<?php

class PPBW_Laendergroessen extends Eloquent {
 
 	protected $table = 'PPBW_Laendergroessen';
	public  $timestamps = false;
	protected $primaryKey = 'PPBW_Laendergroessen_Id';
	
	protected $fillable = array(
	'PPBW_Laendergroessen_Id', 'PPBW_Laendergroessen_Land',
	'PPBW_Laendergroessen_Groesse', 'PPBW_Laendergroessen_Bett_Laenge', 
	'PPBW_Laendergroessen_Bett_Breite', 'PPBW_Laendergroessen_Anz_Kissen', 
	'PPBW_Laendergroessen_Kissen_Laenge', 'PPBW_Laendergroessen_Kissen_Breite'
	);
}
