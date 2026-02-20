<?php

class table extends Eloquent {
 
 	protected $table = 'table';
	public  $timestamps = True;
	protected $primaryKey = 'table_Id';
	
	protected $fillable = array(
	  '<table>_<filed>',
	);
}