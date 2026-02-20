<?php

class Reports extends Eloquent {

    protected $primaryKey = 'Reports_Id';
    protected $table      = 'Reports';
    public $timestamps    = false;
    protected $guarded    = [];

    public static function getreports($use) {


        $reps = Reports::where("Reports_Id", ">", 0)->where('Reports_Use' . $use, 1)->get();
        return $reps;
    }

}
