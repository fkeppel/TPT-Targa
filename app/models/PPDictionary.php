<?php

class PPDictionary extends Eloquent {

    protected $primaryKey = 'PPDictionary_Id';
    protected $table = 'PPDictionary';
    public $timestamps = false;
    protected $fillable = [
        'PPDictionary_Language', 'PPDictionary_Eintrag', 'PPDictionary_Uebersetzung'
    ];

}
