<?php
class ShipmentOverviewController extends BaseController
{
    public function showSO($filter = null){
        cpcDebug::cpc_debug('ShipmentOverviewController.showSO Neu','-SO');
        $data = array();
        $data['title'] = 'Shipment Overview Dashboard';
        $data['pageTitle'] = 'Shipment Overview Dashboard';
        $data['ppData'] = $this->getData($filter);  
        $data['labels'] = $this->getAttributes();  
        return View::make('ShipmentOverview.Dashboard')->with('data', $data);
    }
    public function showShip($filter = null){
        cpcDebug::cpc_debug('ShipmentOverviewController.showSO Neu','-SO');
        $data = array();
        $data['title'] = 'Shipment Overview Dashboard';
        $data['pageTitle'] = 'Shipment Overview Dashboard';
        $data['ppData'] = $this->getDataNeu($filter);  
        $data['labels'] = $this->getAttributes();  
        return View::make('ShipmentOverview.Dashboard_Neu')->with('data', $data);
    }
    private function getAttributesProduktpass  (){
        $attributes = array(
            'PPProduktpass_Id' => '@ID',
            'PPProduktpass_IAN' => '@IAN',
            'PPProduktpass_Ausmusterungnummer' => '@Ausmusterungnummer',
            'PPProduktpass_Artikelbezeichnung' => '+Artikelbezeichnung',
            'PPProduktpass_Gesamtmenge' => 'Gesamtmenge',
            'PPProduktpass_Produkt_Laenge' => 'Laenge',
            'PPProduktpass_Produkt_Breite' => 'Breite',
            'PPProduktpass_Produkt_Hoehe' => 'Hoehe',
            'PPProduktpass_Produkt_GSM' => '+GSM',
            'PPProduktpass_Material' => 'Material',
            'PPProduktpass_Agentur' => 'Agentur',
            'PPProduktpass_Thema' => 'Thema',
            'PPProduktpass_Einkaeufer' => 'Einkaeufer',
            'PPProduktpass_Marke' => 'Marke',
            'PPProduktpass_Absagegrund' => 'Absagegrund'
        );
        return $attributes;
    }
    private function getAttributes(){
        $attributes= array(
            'PPProduktpass_Id' => '@ID',
            'Ausmusterung' => '@Ausmusterung',
            'IAN' => '@IAN',
            'TargaStatus' => 'Targa-Status',
            'LidlStatus' => 'Lidl-Status',
            'Artikelbezeichnung' => 'Artikelbezeichnung',
            'PMAdmin' => 'PM',
            'PJMAdmin' => 'PJM',
            'TCAdmin' => 'TC',
            'Lot' => '+Lot',
            'INCOTERM' => '+INCOTERM',
            'LotQuantity' => 'LotQuantity#n',
            'LT' => 'LT',
            'MS_30PSI' => '30% PSI#d',
            'MS_EUG' => 'EUG#d',
            'MS_PSI' => '100% PSI#d',
            'POD' => 'POD',
            'HSCode' => 'HSCode',
            'SaleUnit' => 'SaleUnit#n',
            'Supplier' => 'Supplier',
            'TotalQuantity' => 'TotalQuantity#n',
        );
        return $attributes;
    }
    private function getAttributes2(){
        $attributes= array(
            'PPProduktpass_Id' => '@ID',
            'Ausmusterung' => '@Ausmusterung',
            'IAN' => '@IAN',
            'TargaStatus' => 'Targa-Status',
            'LidlStatus' => 'Lidl-Status',
            'Artikelbezeichnung' => 'Artikelbezeichnung',
            'PMAdmin' => 'PM',
            'PJMAdmin' => 'PJM',
            'TCAdmin' => 'TC',
            'Lot' => '+Lot',
            'INCOTERM' => '+INCOTERM',
            'LotQuantity' => 'LotQuantity#n',
            'LT' => 'LT',
            'MS_30PSI' => '30% PSI#d',
            'MS_EUG' => 'EUG#d',
            'MS_PSI' => '100% PSI#d',
            'POA' => 'POA',
            'POD' => 'POD',
            'HSCode' => 'HSCode',
            'SaleUnit' => 'SaleUnit#n',
            'Supplier' => 'Supplier',
            'TotalQuantity' => 'TotalQuantity#n',
            'PPShipment_Id' => 'Shipment-Id',
            'PPShipment_Forwarder' => 'Forwarder',
            'PPShipment_Carrier' => 'Carrier',
            'PPShipment_Lot' =>'Lot#n',
            'PPShipment_Vessel' => '+Vessel',
            'PPShipment_Voyage' => '+Voyage',
            'PPShipment_ENS' => '+ENS#d',
            'PPShipment_CYClosing' => '+CYClosing#d',
            'PPShipment_ETD' => '+ETD#d',
            'PPShipment_ETA' => '+ETA#d',
            'PPShipment_ShipReleaseGiven' => '+ShipReleaseGiven#d',
            'PPShipment_ShipReleaseCalc' => '+ShipReleaseCalc#d',
            'PPShipment_CRDGiven' => 'CRDGiven#d',
            'PPShipment_CRDOpeningCalc' => 'CRDOpeningCalc#d',
            'PPShipment_CRDClosingCalc' => 'CRDClosingCalc#d',
            'PPShipment_UnloadingReportDate' => 'UnloadingReportDate#d',
            'PPShipment_20ftGP' =>'20ftGP#n', 
            'PPShipment_40ftGP' => '40ftGP#n',
            'PPShipment_40ftHQ' => '40ftHQ#n',
            'PPShipment_LCLCBM' => 'LCLCBM#n',
            'PPShipment_20ftGPCalc' => '20ftGPCalc#n',
            'PPShipment_40ftGPCalc' => '40ftGPCalc#n',
            'PPShipment_40ftHQCalc' => '40ftHQCalc#n',
            'PPShipment_CurrentStatus' => 'CurrentStatus#n',
            'PPShipment_BLForm' => 'BLForm#n',
            'PPShipment_LCOA' => 'LCOA#n',
            'PPShipment_ProducerBooking' => 'ProducerBooking#n',
            'PPShipment_ShipRelease' => 'ShipRelease#n',
            'PPShipment_SO' => 'SO',
            'PPShipment_BL' =>  'BL',
            'PPShipment_Invoce' =>  'Invoce',
            'PPShipment_PL' => 'PL',
            'PPShipment_CoO' =>  'CoO',
            'PPShipment_DeclarationFumigation' => 'DeclarationFumigation',
            'PPShipment_OceanFreight' => 'OceanFreight',
            'PPShipment_PL2MaWi' => 'PL2MaWi',
            'PPShipment_CLPSent' => 'CLPSent',
            'PPShipment_SeaFreightInvoice' => 'SeaFreightInvoice',
            'PPShipment_TransportInvoice' => 'TransportInvoice',
            'PPShipment_UnloadingInvoice' => 'UnloadingInvoice',
            'PPShipment_OtherLogisticalCosts' => 'OtherLogisticalCosts',
            'PPShipment_CCCsent' => 'CCCsent',
            'PPShipment_CustomsInvoice' =>  'CustomsInvoice',
            'PPShipment_CustomsDeclared' => 'CustomsDeclared#d',
            'PPShipment_HSCode' => 'HSCode#n',
            'PPShipment_ProjektCount' =>    'ProjektCount#n',
            'PPShipment_TEU' => 'TEU#n',
            'PPShipment_VKStk' =>   'VKStk#f',
            'PPShipment_VKSumme' => 'VKSumme#f',
            'PPShipment_DistancePort2Port' => 'DistancePort2Port#f',
            'PPShipment_INCOTERM' => 'INCOTERM',
            'PPShipment_LT' => 'LT',
            'PPShipment_MS_30PSI' => '30% PSI#d',
            'PPShipment_MS_EUG' => 'EUG#d',
            'PPShipment_MS_PSI' => '100% PSI#d',
            'PPShipment_POA' => 'POA',
            'PPShipment_POD' => 'POD',
            'PPShipment_SaleUnit' => 'SaleUnit',
            'PPShipment_Supplier' => 'Supplier'
        );
        return $attributes;
    }
    private function getAllowedUpdates(){
        foreach ($this->getAttributes() as $att => $label){
            if (substr($label,0,1) === '+'){
                $allowed[] = $att;
            }
        }   
        return $allowed;
    }
    private function getDataProduktpass (){
        $pp = tPPProduktpass::where('PPProduktpass_Ausmusterungnummer', 'like', '25%' )->where('PPProduktpass_IAN', 'like', '%ev%' )->orderBy('PPProduktpass_Ausmusterungnummer')->get();
        if($pp->isEmpty()){
            return false;
        }   
        return $pp;
    }
     private function getData ($filter = null){
        $params = preg_split('/-/', $filter);
        if(isset($params[0]) && $params[0] !=''){
            $whereAusmusterung = $params[0];
        } else {
            $whereAusmusterung = '2501';
        }
        $whereStatus = 'FIX';
        if (isset($params[1]) && $params[1] =='Alle'){
            $whereStatus = '%';
        } else {
            $whereStatus = $params[1] ?? '%';
        }
        $so = DB::table('v_Shipmentoverview')->where('Ausmusterung', 'like', $whereAusmusterung.'%' )->where('TargaStatus', 'like', $whereStatus )->orderBy('IAN')->get();
        if(empty($so)){
            return false;
        }   
        //echo(count($so).' Datensätze in Shipment Overview gefunden');
        //exit;
        return $so;
    }
    private function getDataNeu($filter = null)
    {
        $params = preg_split('/-/', (string)$filter);
        $whereAusmusterung = (isset($params[0]) && $params[0] != '') ? $params[0] : '25%';
        if (isset($params[1]) && $params[1] == 'Alle') {
            $whereStatus = '%';
        } else {
            $whereStatus = isset($params[1]) ? $params[1] : '%';
        }
        $kopf = DB::table('v_ShipmentoverviewKopf')
            ->where('Ausmusterung', 'like', $whereAusmusterung.'%')
            ->where('TargaStatus', 'like', $whereStatus)
            ->orderBy('IAN')
            ->get();
        // Laravel-4-sicher: count() statt isEmpty()
        if (!is_array($kopf) || count($kopf) === 0) {
            return false;
            return array('kopf' => array(), 'ship' => array());
        }
        $ship = DB::table('v_ShipmentoverviewShipments')->where('PPShipment_Status',  1)->get();
        if (!is_array($ship) || count($ship) === 0) {
            //return false;
            return array('kopf' => $kopf, 'ship' => array());
        }
        return array(
            'kopf' => $kopf,
            'ship' => $ship,
        );
    }
    public function cellUpdate(){
        $payload = Input::json()->all();
        cpcDebug::cpc_debug('ShipmentOverviewController.cellUpdate payload','-SO');
        cpcDebug::cpc_debug($payload,'-SO');
        $rowId = isset($payload['row_id']) ? (int)$payload['row_id'] : 0;
        $field = isset($payload['field']) ? $payload['field'] : null;
        $value = isset($payload['value']) ? $payload['value'] : null;
        // Whitelist: nur erlaubte Felder updatebar machen
        $allowed = $this->getAllowedUpdates();
        if (!$rowId || !in_array($field, $allowed, true)) {
            return Response::json(array('ok' => false, 'error' => 'invalid'), 400);
        }
        // Optional: Validierung je Feld
        // $rules = array($field => 'max:255'); ...
        DB::table('tPPProduktpass')
            ->where('PPProduktpass_Id', $rowId)
            ->update(array($field => $value));
        return Response::json(array('ok' => true));
    }
   /**
     * Speichert eine Shipment-Positionszeile.
     * Erwartet JSON oder Form-POST:
     * - PPProduktpass_Id (required)
     * - PPShipment_POD
     * - PPShipment_POA
     * - PPShipment_20ftGPCalc
     * - PPShipment_40ftGPCalc
     *
     * Optional:
     * - PPShipment_Id (wenn Update statt Insert)
     */
  public function saveLot()
{
    $data = Input::json() ? Input::json()->all() : Input::all();
    // 1) Whitelist + Typen
    $TYPE_MAP = array(
        'PPShipment_Lot'    => 'text',
        'PPShipment_POD'    => 'text',
        'PPShipment_POA'    => 'text',
        'PPShipment_20ftGP' => 'number',
        'PPShipment_40ftGP' => 'number',
        'PPShipment_Forwarder' => 'text',
        'PPShipment_Carrier' => 'text',
        'PPShipment_Vessel' => 'text',
        'PPShipment_Voyage' => 'text',
        'PPShipment_CRDGiven' => 'text',
        'PPShipment_CRDOpeningCalc' => 'number',
        'PPShipment_CRDClosingCalc' => 'number',
        'PPShipment_ETD' => 'date',
        'PPShipment_ETA' => 'date',
        'PPShipment_CurrentStatus' => 'text',
        'PPShipment_BLForm' => 'text',
        'PPShipment_ShipRelease' => 'text',
        'PPShipment_OceanFreight' => 'number',
        'PPShipment_INCOTERM' => 'text',
        'PPShipment_MS_30PSI' => 'date',
        'PPShipment_MS_EUG' => 'date',
        'PPShipment_MS_PSI' => 'date',
        // wenn du später ergänzt, NUR HIER erweitern:
        // 'PPShipment_Vessel' => 'text',
    );
    $ALLOWED_FIELDS = array_keys($TYPE_MAP);
    // 2) Validation dynamisch
    $rules = array(
        'PPProduktpass_Id' => 'required',
        'PPShipment_Id'    => 'sometimes',
    );
    foreach ($TYPE_MAP as $key => $type) {
        if ($type === 'text') {
            $rules[$key] = 'sometimes|max:255';
        } else {
            $rules[$key] = 'sometimes'; // number: normalisieren wir selbst
        }
    }
    $validator = Validator::make($data, $rules);
    if ($validator->fails()) {
        return Response::json(array(
            'ok' => false,
            'errors' => $validator->messages()->toArray(),
        ), 422);
    }
    $normNumber = function ($v) {
        if ($v === null) return null;
        $v = trim((string)$v);
        if ($v === '') return null;
        $v = str_replace('.', '', $v);
        $v = str_replace(',', '.', $v);
        return is_numeric($v) ? (float)$v : null;
    };
    $now = date('Y-m-d H:i:s');
    // 3) Payload dynamisch aus Whitelist
    $payload = array(
        'PPShipment_PPProduktpass_Id' => $data['PPProduktpass_Id'],
        'updated_at'                 => $now,
    );
    foreach ($ALLOWED_FIELDS as $k) {
        if (array_key_exists($k, $data)) {
            if ($TYPE_MAP[$k] === 'number') $payload[$k] = $normNumber($data[$k]);
            else $payload[$k] = ($data[$k] === '' ? null : $data[$k]);
        }
    }
    $table = 'PPShipment';
    try {
        if (!empty($data['PPShipment_Id'])) {
            $id = $data['PPShipment_Id'];
            DB::table($table)->where('PPShipment_Id', $id)->update($payload);
            return Response::json(array(
                'ok' => true,
                'mode' => 'update',
                'PPShipment_Id' => $id,
            ));
        }
        // Insert
        $payload['created_at'] = $now;
        $payload['PPShipment_Status'] = 1;
        $newId = DB::table($table)->insertGetId($payload);
        return Response::json(array(
            'ok' => true,
            'mode' => 'insert',
            'PPShipment_Id' => $newId,
        ));
    } catch (Exception $e) {
        return Response::json(array(
            'ok' => false,
            'error' => 'DB error',
            'message' => $e->getMessage(),
        ), 500);
    }
}
   public function deleteLot()
    {
        $data = Input::json() ? Input::json()->all() : Input::all();
        $validator = Validator::make($data, array(
            'PPShipment_Id' => 'required'
        ));
        if ($validator->fails()) {
            return Response::json(array(
                'ok' => false,
                'errors' => $validator->messages()->toArray()
            ), 422);
        }
        $id = $data['PPShipment_Id'];
        try {
            $now = date('Y-m-d H:i:s');
            DB::table('PPShipment')
                ->where('PPShipment_Id', $id)
                ->update(array(
                    'PPShipment_Status' => 0,
                    'updated_at'        => $now
                ));
            return Response::json(array(
                'ok' => true,
                'mode' => 'soft-delete',
                'PPShipment_Id' => $id
            ));
        } catch (Exception $e) {
            return Response::json(array(
                'ok' => false,
                'message' => $e->getMessage()
            ), 500);
        }
    }
}
