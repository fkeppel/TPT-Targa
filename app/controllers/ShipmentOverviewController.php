<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
class ShipmentOverviewController extends BaseController
{
    protected $service;
    public function __construct()
    {
        $this->service = new MitarbeiterService();
    }
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
        //cpcDebug::cpc_debug('ShipmentOverviewController.showShip Neu','-SO');
        $data = array();
        $data['title'] = 'Shipment Overview';
        $data['pageTitle'] = 'Shipment Overview';
        $data['ppData'] = $this->getDataNeu($filter);  
        $data['logMa'] = $this->service->getAuswahlliste('LOG');
        //$data['labels'] = $this->getAttributes();  
        $viewName = 'ShipmentOverview.Dashboard_DEV2';
        return View::make($viewName)->with('data', $data);
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
            'PPShipment_Incoterm' => 'Incoterm',
            'PPShipment_LT' => 'LT',
            'PPShipment_MS_30PSI' => '30% PSI#d',
            'PPShipment_MS_EUG' => 'EUG#d',
            'PPShipment_MS_PSI' => '100% PSI#d',
            'PPShipment_POA' => 'POA',
            'PPShipment_POD' => 'POD',
            'PPShipment_SaleUnit' => 'SaleUnit',
            'PPShipment_Supplier' => 'Supplier',
            'PPShipment_Quantity' => 'Quantity',
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
    private function getDataNeu($filter = null, $complete = false)
    {
        $params = preg_split('/-/', (string)$filter);
        $whereAusmusterung = (isset($params[0]) && $params[0] != '') ? $params[0] : '25%';
        if (isset($params[1]) && $params[1] == 'Alle') {
            $whereStatus = '%';
        } else {
            $whereStatus = isset($params[1]) ? $params[1] : '%';
        }
        if ($complete) {
            $whereComplete = 1;
        } else {
            $whereComplete = 0;
        }
        $kopf = DB::table('v_ShipmentoverviewKopf')
            ->where('Ausmusterung', 'like', $whereAusmusterung.'%')
            ->where('TargaStatus', 'like', $whereStatus)
            ->where('Complete', $whereComplete)
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
        $json = Input::json();
        $data = $json
            ? $json->all()
            : Input::all();
        /*
        * 1. Whitelist und Datentypen
        */
        $TYPE_MAP = array(
            'PPShipment_Lot'                            => 'text',
            'PPShipment_POD'                            => 'text',
            'PPShipment_POA'                            => 'text',
            'PPShipment_Forwarder'                      => 'text',
            'PPShipment_Carrier'                        => 'text',
            'PPShipment_Vessel'                         => 'text',
            'PPShipment_Voyage'                         => 'text',
            'PPShipment_ENS'                            => 'date',
            'PPShipment_CYClosing'                      => 'date',
            'PPShipment_CRDGiven'                       => 'date',
            'PPShipment_CRDOpeningCalc'                 => 'date',
            'PPShipment_CRDClosingCalc'                 => 'date',
            'PPShipment_20ftGP'                         => 'number',
            'PPShipment_40ftGP'                         => 'number',
            'PPShipment_40ftHQ'                         => 'number',
            'PPShipment_LCLCBM'                         => 'number',
            'PPShipment_ETD'                            => 'date',
            'PPShipment_ETA'                            => 'date',
            'PPShipment_CurrentStatus'                  => 'text',
            'PPShipment_BLForm'                         => 'text',
            'PPShipment_ShipRelease'                    => 'date',
            'PPShipment_OceanFreight'                   => 'number',
            'PPShipment_Incoterm'                       => 'text',
            'PPShipment_MS_30PSI'                       => 'date',
            'PPShipment_MS_EUG'                         => 'date',
            'PPShipment_MS_PSI'                         => 'date',
            'PPShipment_Quantity'                       => 'number',
            'PPShipment_Flag_OS'                        => 'number',
            'PPShipment_Flag_EUService'                 => 'number',
            'PPShipment_Flag_Critical'                  => 'number',
            'PPShipment_Flag_Producer_booking'          => 'number',
            'PPShipment_Flag_Shipment_Release'          => 'number',
            'PPShipment_Flag_SO'                        => 'number',
            'PPShipment_Flag_BL'                        => 'number',
            'PPShipment_Flag_Inv'                       => 'number',
            'PPShipment_Flag_PL'                        => 'number',
            'PPShipment_Flag_CoO'                       => 'number',
            'PPShipment_Flag_Declaration_of_Fumigation' => 'number',
            'PPShipment_Flag_Ocean_Freight'             => 'number',
            'PPShipment_Flag_PL_sent_to_MaWi'           => 'number',
            'PPShipment_Flag_CLP_sent'                  => 'number',
            'PPShipment_Flag_Sea_freight_invoice'       => 'number',
            'PPShipment_Flag_Transport_invoice'         => 'number',
            'PPShipment_Flag_Unloading_invoice'         => 'number',
            'PPShipment_Flag_Other_logistical_costs'    => 'number',
            'PPShipment_Flag_CCC_sent'                  => 'number',
            'PPShipment_Flag_customs_invoice'           => 'number',
            /*
            * In der Blade-View ist dieses Feld ein Textfeld.
            */
            'PPShipment_MasterCartonContents'            => 'text',
            'PPShipment_ShipReleaseGiven'               => 'date',
            'PPShipment_ShipReleaseCalc'                => 'date',
            'PPShipment_UnloadingReportDate'            => 'date',
            'PPShipment_20ftGPCalc'                     => 'number',
            'PPShipment_40ftGPCalc'                     => 'number',
            'PPShipment_40ftHQCalc'                     => 'number',
            'PPShipment_LCOA'                           => 'text',
            'PPShipment_SeaFreightInvoice'              => 'text',
            'PPShipment_TransportInvoice'               => 'text',
            'PPShipment_UnloadingInvoice'               => 'text',
            'PPShipment_OtherLogisticalCosts'            => 'text',
            'PPShipment_CustomsDeclared'                => 'date',
            'PPShipment_HSCode'                         => 'text',
            'PPShipment_ProjektCount'                   => 'number',
            'PPShipment_TEU'                            => 'number',
            'PPShipment_VKStk'                          => 'number',
            'PPShipment_VKSumme'                        => 'number',
            'PPShipment_DistancePort2Port'              => 'number',
            'PPShipment_BatteryType'                    => 'text',
            'PPShipment_ATAInlandsterminal'             => 'date',
            'PPShipment_ShipmentStatus'                 => 'text',
            'PPShipment_ZipCodeFactory'                 => 'text'
        );
        $ALLOWED_FIELDS = array_keys($TYPE_MAP);
        /*
        * 2. Validierung
        */
        $rules = array(
            'PPProduktpass_Id' => 'required',
            'PPShipment_Id'    => 'sometimes'
        );
        foreach ($TYPE_MAP as $key => $type) {
            if ($type === 'text') {
                $rules[$key] = 'sometimes|max:255';
            } else {
                $rules[$key] = 'sometimes';
            }
        }
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return Response::json(array(
                'ok'     => false,
                'errors' => $validator->messages()->toArray()
            ), 422);
        }
        /*
        * Zahlen normalisieren.
        *
        * Unterstützt:
        * 2540
        * 2540,50
        * 2.540,50
        * 2540.50
        */
        $normNumber = function ($value) {
            if ($value === null) {
                return null;
            }
            $value = trim((string) $value);
            if ($value === '') {
                return null;
            }
            $hasComma = strpos($value, ',') !== false;
            $hasDot   = strpos($value, '.') !== false;
            /*
            * Deutsches Format: 2.540,50
            */
            if ($hasComma && $hasDot) {
                $value = str_replace('.', '', $value);
                $value = str_replace(',', '.', $value);
            } elseif ($hasComma) {
                /*
                * Deutsches Dezimalformat: 2540,50
                */
                $value = str_replace(',', '.', $value);
            }
            return is_numeric($value)
                ? (float) $value
                : null;
        };
        /*
        * Datum normalisieren.
        */
        $normDate = function ($value) {
            if ($value === null) {
                return null;
            }
            $value = trim((string) $value);
            if ($value === '') {
                return null;
            }
            $timestamp = strtotime($value);
            if ($timestamp === false) {
                return null;
            }
            return date('Y-m-d', $timestamp);
        };
        $now = date('Y-m-d H:i:s');
        /*
        * 3. Datenbank-Payload erzeugen
        */
        $payload = array(
            'PPShipment_PPProduktpass_Id' => $data['PPProduktpass_Id'],
            'updated_at'                  => $now
        );
        foreach ($ALLOWED_FIELDS as $field) {
            if (!array_key_exists($field, $data)) {
                continue;
            }
            if ($TYPE_MAP[$field] === 'number') {
                $payload[$field] = $normNumber($data[$field]);
            } elseif ($TYPE_MAP[$field] === 'date') {
                $payload[$field] = $normDate($data[$field]);
            } else {
                $payload[$field] = trim((string) $data[$field]) === ''
                    ? null
                    : $data[$field];
            }
        }
        $table = 'PPShipment';
        try {
            /*
            * UPDATE:
            * Sobald die PPShipment_Id vorhanden ist, darf kein INSERT
            * mehr ausgeführt werden.
            */
            if (
                isset($data['PPShipment_Id']) &&
                trim((string) $data['PPShipment_Id']) !== ''
            ) {
                $shipmentId = $data['PPShipment_Id'];
                $affectedRows = DB::table($table)
                    ->where('PPShipment_Id', $shipmentId)
                    ->update($payload);
                return Response::json(array(
                    'ok'             => true,
                    'mode'           => 'update',
                    'affected_rows'  => $affectedRows,
                    'PPShipment_Id'  => $shipmentId
                ));
            }
            /*
            * INSERT
            */
            $payload['created_at'] = $now;
            $payload['PPShipment_Status'] = 1;
            /*
            * Wichtig bei Laravel 4:
            *
            * Der Primärschlüssel heißt PPShipment_Id und nicht id.
            * Deshalb muss er insertGetId ausdrücklich angegeben werden.
            */
            $newId = DB::table($table)->insertGetId(
                $payload,
                'PPShipment_Id'
            );
            if (empty($newId)) {
                throw new Exception(
                    'Nach dem INSERT wurde keine PPShipment_Id zurückgegeben.'
                );
            }
            //$this->setShipmentStatus($newId);
            return Response::json(array(
                'ok'            => true,
                'mode'          => 'insert',
                'PPShipment_Id' => $newId
            ));
        } catch (Exception $e) {
            cpcDebug::cpc_debug(
                'ShipmentOverviewController.saveLot DB error',
                '-SO'
            );
            cpcDebug::cpc_debug(
                $e->getMessage(),
                '-SO'
            );
            return Response::json(array(
                'ok'      => false,
                'error'   => 'DB error',
                'message' => $e->getMessage()
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
    public function showShipFlat($filter = null)
    {
        cpcDebug::cpc_debug('ShipmentOverviewController.showShipFlat', '-SO');
        $data = array();
        $data['title'] = 'Shipment Overview [Flatview]';
        $data['pageTitle'] = 'Shipment Overview [Flatview]';
        $data['isArchive'] = false;
        $data['ppData'] = $this->getDataNeu($filter);
        $data['labels'] = $this->getAttributes();
        return View::make('ShipmentOverview.Dashboard_Flat')->with('data', $data);
    }
    public function showShipArchive($filter = null)
    {
        cpcDebug::cpc_debug('ShipmentOverviewController.showShipArchive', '-SO');
        $data = array();
        $data['title'] = 'Shipment Overview [Archive]';
        $data['pageTitle'] = 'Shipment Overview [Archive]';
        $data['isArchive'] = true;
        $data['ppData'] = $this->getDataNeu($filter, true);
        $data['labels'] = $this->getAttributes();
        return View::make('ShipmentOverview.Dashboard_Flat')->with('data', $data);
    }
    private function getShipmentMap ()
    {
        $EXCEL_SHIPMENT_MAP = array(
            'N'  => 'PPShipment_MasterCartonContents',
            'O'  => 'PPShipment_Quantity',
            'P'  => 'PPShipment_BatteryType',
            'Q'  => 'PPShipment_Incoterm',
            'R'  => 'PPShipment_Forwarder',
            'S'  => 'PPShipment_Carrier',
            'T'  => 'PPShipment_POD',
            'U'  => 'PPShipment_POA',
            'V'  => 'PPShipment_Lot',
            'W'  => 'PPShipment_Vessel',
            'X'  => 'PPShipment_Voyage',
            'Y'  => 'PPShipment_ENS',
            'Z'  => 'PPShipment_CYClosing',
            'AA' => 'PPShipment_ETD',
            'AB' => 'PPShipment_ETA',
            'AC' => 'PPShipment_ATAInlandsterminal',
            'AD' => 'PPShipment_MS_EUG',
            'AE' => 'PPShipment_MS_30PSI',
            'AF' => 'PPShipment_MS_PSI',
            'AG' => 'PPShipment_ShipReleaseGiven',
            'AH' => 'PPShipment_ShipReleaseCalc',
            'AI' => 'PPShipment_CRDGiven',
            'AJ' => 'PPShipment_CRDOpeningCalc',
            'AK' => 'PPShipment_CRDClosingCalc',
            'AL' => 'PPShipment_UnloadingReportDate',
            'AM' => 'PPShipment_20ftGP',
            'AN' => 'PPShipment_40ftGP',
            'AO' => 'PPShipment_40ftHQ',
            'AP' => 'PPShipment_LCLCBM',
            'AQ' => 'PPShipment_20ftGPCalc',
            'AR' => 'PPShipment_40ftGPCalc',
            'AS' => 'PPShipment_40ftHQCalc',
            'AT' => 'PPShipment_CurrentStatus',
            'AU' => 'PPShipment_BLForm',
            'AV' => 'PPShipment_LCOA',
            'AW' => 'PPShipment_Flag_Producer_booking',
            'AX' => 'PPShipment_Flag_Shipment_Release',
            'AY' => 'PPShipment_Flag_SO',
            'AZ' => 'PPShipment_Flag_BL',
            'BA' => 'PPShipment_Flag_Inv',
            'BB' => 'PPShipment_Flag_PL',
            'BC' => 'PPShipment_Flag_CoO',
            'BD' => 'PPShipment_Flag_Declaration_of_Fumigation',
            'BE' => 'PPShipment_Flag_Ocean_Freight',
            'BF' => 'PPShipment_Flag_PL_sent_to_MaWi',
            'BG' => 'PPShipment_Flag_CLP_sent',
            'BH' => 'PPShipment_SeaFreightInvoice',
            'BI' => 'PPShipment_TransportInvoice',
            'BJ' => 'PPShipment_UnloadingInvoice',
            'BK' => 'PPShipment_OtherLogisticalCosts',
            'BL' => 'PPShipment_Flag_CCC_sent',
            'BM' => 'PPShipment_Flag_customs_invoice',
            'BN' => 'PPShipment_CustomsDeclared',
            'BO' => 'PPShipment_HSCode',
            'BP' => 'PPShipment_ProjektCount',
            'BQ' => 'PPShipment_TEU',
            'BR' => 'PPShipment_VKStk',
            'BS' => 'PPShipment_VKSumme',
            'BT' => 'PPShipment_ShipmentStatus',
            'BU' => 'PPShipment_DistancePort2Port',
        );
        return $EXCEL_SHIPMENT_MAP;
    }
    public function importShipment()
    {
        $filename = '/var/www/targa/tmp/ShipOhneFormat.xlsx';
        $spreadsheet = IOFactory::load($filename);
        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = $sheet->getHighestRow();
        $ok = 0;
        $errors = array();
        for ($row = 2; $row <= $highestRow; $row++) {
            try {
                if ($this->importRow($sheet, $row)) {
                    $ok++;
                }
            } catch (Exception $e) {
                $errors[] = 'Zeile '.$row.': '.$e->getMessage();
            }
        }
        echo "Importiert: ".$ok."<br>";
        if (!empty($errors)) {
            echo "<pre>";
            print_r($errors);
            echo "</pre>";
        }
    }
    private function importRow($sheet, $row)
    {
        $highestColumn = $sheet->getHighestColumn();
        $values = $sheet->rangeToArray(
            'A'.$row.':'.$highestColumn.$row,
            null,
            true,
            true,
            true
        );
        $values = $values[$row];
        //echo "<pre>";         print_r($values);        echo "</pre>";
        // Projektnummer
        $projectNumber = trim((string)$values['C']);
        if ($projectNumber == '') {
            return false;
        }
        /**
         * Beispiel:
         * 345678_2301
         */
        $parts = explode('_', $projectNumber, 2);
        $ian = trim($parts[0]);
        $ausmusterung = isset($parts[1]) ? trim($parts[1]) : '';
        // Produktpass suchen
        $produktpass = PPProduktpass::where('PPProduktpass_IAN', $ian)->where('PPProduktpass_Ausmusterungnummer','like', $ausmusterung.'%')->first();
        if (!$produktpass) {
            throw new Exception("Produktpass nicht gefunden: ".$ian.'_'.$ausmusterung);
        }
        $data = array();
        $data['PPShipment_PPProduktpass_Id'] = $produktpass->PPProduktpass_Id;
        $data['PPShipment_IAN'] = $ian;
        $data['PPShipment_Ausmusterungnummer'] = $ausmusterung;
        foreach ($this->getShipmentMap() as $excelColumn => $dbField) {
            $value = isset($values[$excelColumn])
                ? $values[$excelColumn]
                : null;
            $data[$dbField] = $this->normalizeShipmentValue(
                $dbField,
                $value
            );
        }
        // Test
        //echo "<pre>";         print_r($data);        echo "</pre>";
        $shipment = new PPShipment();
        foreach ($data as $field => $value) {
            $shipment->$field = $value;
        }
        $shipment->save();
        return true;
    }
    private function normalizeShipmentValue($field, $value)
    {
        if (is_string($value)) {
            $value = trim($value);
            if ($value == '#N/A') {
                return '';
            }
        }
        if ($value === '') {
            return null;
        }
        if ($this->isDateField($field)) {
            return $this->normalizeDate($value);
        }
        if ($this->isNumberField($field)) {
            //return $this->normalizeNumber($value);
        }
        if ($this->isYesNoField($field)) {
            return $this->normalizeYesNo($value);
        }
        return $value;
    }
    private function isDateField($field)
    {
        return in_array($field, array(
            'PPShipment_ENS',
            'PPShipment_CYClosing',
            'PPShipment_ETD',
            'PPShipment_ETA',
            'PPShipment_MS_EUG',
            'PPShipment_MS_30PSI',
            'PPShipment_MS_PSI',
            'PPShipment_ShipReleaseGiven',
            'PPShipment_ShipReleaseCalc',
            'PPShipment_CRDGiven',
            'PPShipment_CRDOpeningCalc',
            'PPShipment_CRDClosingCalc',
            'PPShipment_UnloadingReportDate',
            'PPShipment_CustomsDeclared',
            'PPShipment_ATAInlandsterminal',  
        ));
    }
    private function normalizeDate($value)
    {
        if ($value == null || $value == '') {
            return null;
        }
        if (is_numeric($value)) {
            return Date::excelToDateTimeObject($value)
                ->format('Y-m-d');
        }
        $time = strtotime($value);
        return $time
            ? date('Y-m-d', $time)
            : null;
    }
    private function isNumberField($field)
    {
        return in_array($field, array(
            'PPShipment_Quantity',
            'PPShipment_20ftGP',
            'PPShipment_40ftGP',
            'PPShipment_40ftHQ',
            'PPShipment_LCLCBM',
            'PPShipment_20ftGPCalc',
            'PPShipment_40ftGPCalc',
            'PPShipment_40ftHQCalc',
            'PPShipment_ProjektCount',
            'PPShipment_TEU',
            'PPShipment_VKStk',
            'PPShipment_VKSumme',
            'PPShipment_DistancePort2Port',
        ));
    }
    private function normalizeNumber($value)
    {
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);
        return is_numeric($value)
            ? $value
            : null;
    }
    private function isYesNoField($field)
    {
        return strpos($field, 'PPShipment_Flag_') === 0;
    }
    private function normalizeYesNo($value)
    {
        $value = strtolower(trim($value));
        return in_array($value, array(
            'x',
            'ja',
            'yes',
            '1',
            'true'
        )) ? 1 : 0;
    }
    private function getLogMitarbeiter (){
        $logMa = PPMitarbeiter::where('PPMitarbeiter_Role', 'like',  '%LOGISTIK%')->get();
        if($logMa->isEmpty()){
            return false;
        }
        return $logMa;
    }
    public function shipmentArchive (){
        $ppid = Input::get('PPProduktpass_Id');
        try{
            $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->first();
            if(!$pp){
                return false;   
            }
            $pp->PPProduktpass_ShipmentComplete = 1;
            $pp->save();
        }
        catch(Exception $e){
            return false;
        }
        return true;
    }
    public function shipmentRestore (){
        $ppid = Input::get('PPProduktpass_Id');
        try{
            $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->first();
            if(!$pp){
                return false;   
            }
            $pp->PPProduktpass_ShipmentComplete = 0;
            $pp->save();
        }
        catch(Exception $e){
            return false;
        }
        return true;
    }
}