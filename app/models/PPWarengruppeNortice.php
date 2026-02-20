<?php

class PPWarengruppeNotice extends Eloquent {

 	protected $table = 'PPWarengruppeNotice';
	public  $timestamps = false;
	protected $primaryKey = 'PPWarengruppeNotice_Id';

	protected $fillable = array(
		'PPWarengruppeNotice_WGRP',
		'PPWarengruppeNotice_Notice'
	);
}

