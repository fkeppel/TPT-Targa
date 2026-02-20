<?php
class login_attempt extends Eloquent {
    protected $table = 'login_attempt';
    public $timestamps = True;
    protected $primaryKey = 'login_attempt_Id';
    protected $guarded = [];
}
