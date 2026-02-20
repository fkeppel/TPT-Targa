<?php

class Project extends Eloquent {
	protected $fillable = [];
	
	  
	public function user_profile()
    {
        return $this->has_one('PPkof');
    }
	
	
}