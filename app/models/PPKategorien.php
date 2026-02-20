<?php

class PPKategorien extends Eloquent {
  
    protected $table = 'PPKategorien';
	public  $timestamps = True;
	protected $primaryKey = 'PPKategorien_Id';
	
	protected $guarded = array();
}
