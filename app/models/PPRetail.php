<?php

class PPRetail extends Eloquent {

    protected $primaryKey = 'PPRetail_Id';
    protected $table = 'PPRetail';
    public $timestamps = false;
    protected $fillable = [
        'PPRetail_Code',
        'PPRetail_CustMemoText1',
        'PPRetail_CustMemoText3',
        'PPRetail_Name'];

}
