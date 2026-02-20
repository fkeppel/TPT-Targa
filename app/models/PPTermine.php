<?php

class PPTermine extends Eloquent {
 
 	protected $table = 'PPTermine';
	public  $timestamps = True;
	protected $primaryKey = 'PPTermine_Id';
	
	protected $fillable = array(

'PPTermine_PPProduktpass_Id',
'PPTermine_DatumStart',
'PPTermine_DatumEnde',
'PPTermine_Header',
'PPTermine_Art',
'PPTermine_Typ',
'PPTermine_MAAnlage',
'PPTermine_MAZustaendigkeit',
'PPTermine_Status',
'PPTermine_Bemerkungen',
'created_at',
'updated_at',
'PPTermine_PPBoardSpalte_Id',
'PPTermine_History'

	);
}