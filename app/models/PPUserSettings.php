<?php

class PPUserSettings extends Eloquent {
 
 	protected $table = 'PPUserSettings';
	public  $timestamps = false;
	protected $primaryKey = 'PPUserSettings_Id';
	
	protected $fillable = array(
	  'PPUserSettings_Setting',
	  'PPUserSettings_Type',
	  'PPUserSettings_Value',
	  'PPUserSettings_User',
	  'PPUserSettings_UserId'
	);
}