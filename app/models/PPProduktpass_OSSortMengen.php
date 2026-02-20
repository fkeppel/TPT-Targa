<?php

class PPProduktpass_OSSortMengen extends Eloquent {

 	protected $table = 'PPProduktpass_OSSortMengen';
	public  $timestamps = false;
	protected $primaryKey = 'PPProduktpass_OSSortMengen_id';

	protected $fillable = array(
	  	'PPProduktpass_OSSortMengen_id',
		'PPProduktpass_OSSortMengen_OSLand',
		'PPProduktpass_OSSortMengen_OSMengeSize01',
		'PPProduktpass_OSSortMengen_OSMengeSize02',
		'PPProduktpass_OSSortMengen_OSMengeSize03',
		'PPProduktpass_OSSortMengen_OSMengeSize04',
		'PPProduktpass_OSSortMengen_OSMengeSize05',
		'PPProduktpass_OSSortMengen_OSMengeSize06',
		'PPProduktpass_OSSortMengen_OSMengeSize07',
		'PPProduktpass_OSSortMengen_OSMengeSize08',
		'PPProduktpass_OSSortMengen_OSMengeSize09',
		'PPProduktpass_OSSortMengen_OSMengeSize10',
		'PPProduktpass_OSSortMengen_Sortierung_id'
	);
}