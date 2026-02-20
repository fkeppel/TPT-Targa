<?php

class PPProjekte extends Eloquent {
 
 	protected $table = 'PPProjekte';
	public  $timestamps = false;
	protected $primaryKey = 'PPProjekte_Id';
	
	protected $fillable = array(
		'PPProjekte_Bezeichnung',
		'PPProjekte_AnlageDatum',
		'PPProjekte_Verantwortlich'
	);
}