<?php

class PPDiff extends Eloquent {
 
 	protected $table = 'PPDiff';
	public  $timestamps = true;
	protected $primaryKey = 'PPDiff_Id';
	
	protected $fillable = array(
	  'PPDiff_Art', 
	  'PPDiff_ObjectId', 
	  'PPDiff_ItemId', 
	  'PPDiff_Value'
	);
	
	static function getMaxRev($id){
		$row = DB::table('PPDiff')
		-> select(DB::raw('max(PPDiff_Rev) as MaxRev'))
		-> where ('PPDiff_ObjectId', '=',$id) 
        ->first();
		
		return $row->MaxRev;
		
	}
	
	
}