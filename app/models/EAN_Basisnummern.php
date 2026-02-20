<?php

class EAN_Basisnummern extends Eloquent {
 
 	protected $table = 'EAN_Basisnummern';
	public  $timestamps = false;
	protected $primaryKey = 'EAN_Basisnummern_Id';
	
	protected $fillable = array(
	  'EAN_Basisnummern_Kd',
      'EAN_Basisnummern_Nummer',
      'EAN_Basisnummern_Max',	  
	);
}