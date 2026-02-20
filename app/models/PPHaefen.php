<?php

class PPHaefen extends Eloquent {
 
 	protected $table = 'PPHaefen';
	public  $timestamps = True;
	protected $primaryKey = 'PPHaefen_Id';
	
	protected $fillable = array(
	  'PPHaefen_Nr',
	  'PPHaefen_Name',
	);
}