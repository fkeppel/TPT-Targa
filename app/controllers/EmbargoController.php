<?php
class EmbargoController extends BaseController {
    public function getEmbargo($id) {
        cpcDebug::cpc_debug("getEmbargo: $id", '@Embargo');
        $embargo = array();
        $embargo['Russia Emb.']  = 0;
        $embargo['EUDR']             = 0;
        $embargo['CBAM']             = 0;
        $embargo['10 Jahre Reparaturartikel']             = 0;
        $pp = tPPProduktpass::find($id);
        if (!$pp) {
            cpcDebug::cpc_debug("Produktpass not found for ID: $id", '@Embargo');
            return $embargo;
        }
        cpcDebug::cpc_debug($pp->PPProduktpass_IAN, '@Embargo');
        cpcDebug::cpc_debug($pp->PPProduktpass_Zolltarif, '@Embargo');
        $zolltarif = $pp->PPProduktpass_Zolltarif;
        if (strlen($zolltarif) < 4) {
            cpcDebug::cpc_debug("Zolltarif too short: $zolltarif", '@Embargo');
            return $embargo; // Zolltarif must be at least 8 characters long
        }
        $shortZT = substr($zolltarif, 0, 4); // Use only the first 4 characters of the Zolltarif
        cpcDebug::cpc_debug("Zolltarif: $zolltarif, ShortZT: $shortZT", '@Embargo');
        $embargo = array();
        $embargo['Russia Emb.']  = $this->getEmbargoType($shortZT, 'RusslandEmbargo');
        $embargo['EUDR']             = $this->getEmbargoType($shortZT, 'EUDR');
        $embargo['CBAM']             = $this->getEmbargoType($shortZT, 'CBAM');
        $embargo['10 Jahre Reparaturartikel']             = $this->getEmbargoType($zolltarif, '10 Jahre Reparaturartikel');
        cpcDebug::cpc_debug($embargo, '@Embargo');
        return $embargo;
    }
    private function getEmbargoType($zt, $type) {
        $embargo = RestrictedZolltarif::where('RestrictedZolltarif_Restriction', $type)->where('RestrictedZolltarif_Zolltarifnummer', 'like', $zt.'%')->get()->first();
        if ($embargo) { 
            return 1;
        } else {
            return -1;
        }
    }
}