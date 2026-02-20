<?php
class PPMeetingprotokollTeilnehmer extends Eloquent {
    protected $table = 'PPMeetingprotokollTeilnehmer';
	public  $timestamps = false;
	protected $primaryKey = 'PPMeetingprotokollTeilnehmer_Id';
	protected $guarded = array();
}
