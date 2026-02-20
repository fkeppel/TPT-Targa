<?php

class Rechnungsprufung extends Eloquent {

    protected $primaryKey = 'Nummer_Id';
    protected $table      = 'Rechnungsprüfung';
    public $timestamps    = false;
    protected $guarded    = [];

}
