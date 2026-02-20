<?php

class PP8WMuster extends Eloquent {

    protected $primaryKey = 'PP8WMuster_Id';
    protected $table = 'PP8WMuster';
    public $timestamps = false;
    protected $fillable = [
        'PP8WMuster_Id',
        'PP8WMuster_Empfaenger',
        'PP8WMuster_Remark',
        'PP8WMuster_Art'
    ];

}
