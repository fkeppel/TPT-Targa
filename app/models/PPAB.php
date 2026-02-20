<?php

class PPAB extends Eloquent {

	 
 	protected $primaryKey = 'PPAB_Id';
	protected $table = 'PPAB';
	public  $timestamps = false;
	
	
	protected $fillable  = [
		'PPAB_VKEUR',
		'PPAB_CD11', 
		'PPAB_CD12', 
		'PPAB_CD13', 
		'PPAB_CD21', 
		'PPAB_CD22', 
		'PPAB_CD23', 
		'PPAB_CD31', 
		'PPAB_CD32', 
		'PPAB_CD33', 
		'PPAB_UZ', 
		'PPAB_Produktionsstaette_Id', 
		'PPAB_Produktionsstaette', 
		'PPAB_Herkunftsland', 
		'PPAB_Masse', 
		'PPAB_Abgangshafen', 
		'PPAB_LB1Proz', 
		'PPAB_LB2Proz', 
		'PPAB_LB3Proz', 
		'PPAB_LB4Proz', 
		'PPAB_LBloecke',
		'PPAB_PPProduktpass_Id',
		'PPAB_KatonMasse',
		'PPAB_Palettenfaktor',
		'PPAB_Aufteilung_Rotterdam_FR', 
		'PPAB_Aufteilung_Barcelona_FR', 
		'PPAB_Aufteilung_Barcelona_IT', 
		'PPAB_Aufteilung_Koper_IT',
		'PPAB_Produktionsstaette_LidlId',
		'PPAB_Anmerkung',
		'PPAB_IsBWAuftrag', 'PPAB_BWGroesse',
                'PPAB_UZRS'

    ];
	
}
