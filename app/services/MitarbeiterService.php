<?php
class MitarbeiterService
{
    public function getAuswahlliste(
        $part = '',
        $first = '--'
    ) {
        $mitarbeiter = PPMitarbeiter::aktiv()
            ->taetigkeit($part)
            ->orderBy('PPMitarbeiter_Kuerzel')
            ->get();
        $liste = array();
        if ($first !== null) {
            $liste[''] = $first;
        }
        foreach ($mitarbeiter as $mitarbeiterItem) {
            $liste[$mitarbeiterItem->PPMitarbeiter_Id]
                = $mitarbeiterItem->PPMitarbeiter_Kuerzel;
        }
        return $liste;
    }
}