<?php

class EAN_Nummern extends Eloquent {
 
 	protected $table = 'EAN_Nummern';
	public  $timestamps = false;
	protected $primaryKey = 'EAN_Nummern_Id';
	
	protected $fillable = array(
        'EAN_Nummern_EAN',  
        'EAN_Nummern_IAN',  
        'EAN_Nummern_EAN_Basisnummer_Id', 
        'EAN_Nummern_Status',  
        'EAN_Nummern_MA',  
        'EAN_Nummern_LetzteAenderung',
    );
}