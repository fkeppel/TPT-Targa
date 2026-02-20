<?php
class PPLog extends Eloquent {
    protected $primaryKey = 'PPLog_Id';
    protected $table = 'PPLog';
    public $timestamps = false;
    protected $guarded = [];
}
