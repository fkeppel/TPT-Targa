<?php

class BISUser extends Eloquent {
	
	protected $table = 'BISUser';
	public  $timestamps = false;
	protected $primaryKey = 'id';
 
 		protected $fillable = array(
				'BISUser_Name', 
				'BISUser_Vorname', 
				'BISUser_password', 
				'BISUser_email', 
				'BISUser_username');

	
}
