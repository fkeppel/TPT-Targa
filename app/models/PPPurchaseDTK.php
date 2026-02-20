<?php

class PPPurchaseDTK extends Eloquent {

    protected $table = 'PPPurchaseDTK';
    public $timestamps = false;
    protected $primaryKey = 'PPPurchaseDTK_Id';
    protected $fillable = array(
        'PPPurchaseDTK_PPProduktpass_id',
        'PPPurchaseDTK_PPDevisenTerminKauf_Id',
        'PPPurchaseDTK_Betrag'
    );

}
