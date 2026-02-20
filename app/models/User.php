<?php

class User extends Eloquent {
	
	protected $table = 'BISUser';
	public  $timestamps = false;
	protected $primaryKey = 'BISUser_Id';
 
 		protected $fillable = array(
				'BISUser_Name', 
				'BISUser_Vorname', 
				'BISUser_password', 
				'BISUser_email', 
				'BISUser_username');

	
}
