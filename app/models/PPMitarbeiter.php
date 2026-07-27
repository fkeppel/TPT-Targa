<?php
class PPMitarbeiter extends \Eloquent {
    protected $table      = 'PPMitarbeiter';
    public $timestamps    = false;
    protected $primaryKey = 'PPMitarbeiter_Id';
    protected $guarded    = array();
    public function scopeAktiv($query)
    {
        return $query->where('PPMitarbeiter_Status', '>=', 1);
    }
    public function scopeTaetigkeit($query, $part)
    {
        if ($part === '') {
            return $query;
        }
        return $query->where(
            'PPMitarbeiter_Taetigkeit',
            'LIKE',
            '%' . $part . '%'
        );
    }
}