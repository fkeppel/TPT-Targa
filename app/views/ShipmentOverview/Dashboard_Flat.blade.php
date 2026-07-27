{{-- app/views/ShipmentOverview/Dashboard_Flat.blade.php --}}
<style>
    :root {
        --bg-color: rgb(225, 235, 245);
        --bg-colorHigh: rgb(200, 220, 240);
        --header-bg: #f7f7f7;
        --cell-bg: #ffffff;
        --border-color: #dddddd;
        --grid-color: #eeeeee;
        --sticky-shadow: rgba(0, 0, 0, 0.12);
    }
    html, body {
        height: 100%;
        margin: 0;
    }
    .container {
        padding: 20px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 1em;
        height: 100dvh;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
    }
    .top-actions {
        display: flex;
        gap: 10px;
        align-items: center;
        margin: 0 0 12px 0;
        flex-wrap: wrap;
        flex: 0 0 auto;
    }
    .table-wrap {
        flex: 1 1 auto;
        min-height: 0;
        overflow: auto;
        border: 1px solid var(--border-color);
        background: #fff;
        position: relative;
        isolation: isolate;
    }
    .big-table {
        border-collapse: separate;
        border-spacing: 0;
        min-width: 2600px;
        width: max-content;
        font-size: 12px;
        table-layout: fixed;
    }
    .big-table th,
    .big-table td {
        padding: 8px 10px;
        border-right: 1px solid var(--grid-color);
        border-bottom: 1px solid var(--grid-color);
        white-space: nowrap;
        vertical-align: top;
        background: var(--cell-bg);
        box-sizing: border-box;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .big-table thead th {
        position: sticky;
        top: 0;
        z-index: 20;
        background: var(--header-bg) !important;
        border-bottom: 1px solid var(--border-color);
        text-align: left;
    }
    .big-table thead th[data-sort] {
        cursor: pointer;
        user-select: none;
    }
    .big-table thead th.sort-asc::after {
        content: " ▲";
        font-size: 11px;
        color: #666;
    }
    .big-table thead th.sort-desc::after {
        content: " ▼";
        font-size: 11px;
        color: #666;
    }
  .big-table tbody tr td {
        background-color: #fff;
    }
    .big-table tbody tr:hover td {
        filter: brightness(0.98);
    }
    .flat-row {
        --marker-eu: transparent;
        --marker-os: transparent;
        --marker-kritisch: transparent;
    }
    .flat-row.flag-eu {
        --marker-eu: #ff9800;
    }
    .flat-row.flag-os {
        --marker-os: #380694;
    }
    .flat-row.flag-kritisch {
        --marker-kritisch: #f44336;
    }
    .flat-row.shipment-done td{
        background:#dff5df !important;
    }
    .flat-row.shipment-done td.sticky-left,
    .flat-row.shipment-done td.sticky-left-2,
    .flat-row.shipment-done td.sticky-left-3,
    .flat-row.shipment-done td.sticky-left-4,
    .flat-row.shipment-done td.sticky-left-5,
    .flat-row.shipment-done td.sticky-left-6,
    .flat-row.shipment-done td.sticky-left-7{
        background:#dff5df !important;
    }
    .flat-row td:first-child {
        box-shadow:
            inset 8px 0 0 var(--marker-eu),
            inset 16px 0 0 var(--marker-os),
            inset 24px 0 0 var(--marker-kritisch);
            padding-left: 36px;
    }
    .muted {
        color: #777;
        font-size: 12px;
    }
    .center {
        text-align: center;
    }
    .btn {
        padding: 8px 10px;
        border: 1px solid #d0d0d0;
        background: #fff;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        text-decoration: none;
        color: #000;
        display: inline-block;
    }
    .btn:hover {
        background: #f7f7f7;
    }
    .col-sep {
        border-left: 2px solid #cfcfcf !important;
    }
    .head-cell {
        font-weight: 600;
    }
    .big-table td.col-text-sm,
    .big-table th.col-text-sm {
        width: 130px;
        min-width: 130px;
        max-width: 130px;
    }
    .big-table td.col-text-md,
    .big-table th.col-text-md {
        width: 140px;
        min-width: 140px;
        max-width: 140px;
    }
    .big-table td.col-text-lg,
    .big-table th.col-text-lg {
        width: 180px;
        min-width: 180px;
        max-width: 180px;
    }
    .big-table td.col-wide,
    .big-table th.col-wide {
        width: 220px;
        min-width: 220px;
        max-width: 220px;
    }
    .big-table td.col-status,
    .big-table th.col-status {
        width: 200px;
        min-width: 200px;
        max-width: 200px;
    }
    .big-table td.col-number,
    .big-table th.col-number {
        width: 95px;
        min-width: 95px;
        max-width: 95px;
    }
    .big-table td.col-number-lg,
    .big-table th.col-number-lg {
        width: 120px;
        min-width: 120px;
        max-width: 120px;
    }
    .big-table td.col-date,
    .big-table th.col-date {
        width: 135px;
        min-width: 135px;
        max-width: 135px;
    }
    .sticky-left,
    .sticky-left-2,
    .sticky-left-3,
    .sticky-left-4,
    .sticky-left-5,
    .sticky-left-6,
    .sticky-left-7 {
        position: sticky;
        background-clip: padding-box;
        padding: 0;
    }
    .sticky-cell-inner {
        display: block;
        width: 100%;
        padding: 8px 10px;
        box-sizing: border-box;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .sticky-left {
        left: 0;
        width: 150px !important;
        min-width: 250px !important;
        max-width: 250px !important;
    }
   .sticky-left-2 {
        left: 150px;
        width: 110px !important;
        min-width: 110px !important;
        max-width: 110px !important;
    }
    .sticky-left-3 {
        left: 260px;
        width: 220px !important;
        min-width: 220px !important;
        max-width: 220px !important;
    }
    .sticky-left-4 {
        left: 480px;
        width: 160px !important;
        min-width: 160px !important;
        max-width: 160px !important;
    }
    .sticky-left-5 {
        left: 640px;
        width: 110px !important;
        min-width: 110px !important;
        max-width: 110px !important;
    }
    .sticky-left-6 {
        left: 750px;
        width: 110px !important;
        min-width: 110px !important;
        max-width: 110px !important;
    }
    .sticky-left-7 {
        left: 860px;
        width: 110px !important;
        min-width: 110px !important;
        max-width: 110px !important;
        box-shadow:
            1px 0 0 #ddd,
            4px 0 6px -2px var(--sticky-shadow);
    }
    tbody .sticky-left   { z-index: 14; }
    tbody .sticky-left-2 { z-index: 13; }
    tbody .sticky-left-3 { z-index: 12; }
    tbody .sticky-left-4 { z-index: 11; }
    tbody .sticky-left-5 { z-index: 10; }
    tbody .sticky-left-6 { z-index: 9; }
    tbody .sticky-left-7 { z-index: 8; }
    thead .sticky-left   { z-index: 34 !important; }
    thead .sticky-left-2 { z-index: 33 !important; }
    thead .sticky-left-3 { z-index: 32 !important; }
    thead .sticky-left-4 { z-index: 31 !important; }
    thead .sticky-left-5 { z-index: 30 !important; }
    thead .sticky-left-6 { z-index: 29 !important; }
    thead .sticky-left-7 { z-index: 28 !important; }
    .big-table thead .sticky-left,
    .big-table thead .sticky-left-2,
    .big-table thead .sticky-left-3,
    .big-table thead .sticky-left-4,
    .big-table thead .sticky-left-5,
    .big-table thead .sticky-left-6,
    .big-table thead .sticky-left-7 {
        background: var(--header-bg) !important;
    }
    .th-label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .th-filter {
        width: 100%;
        min-width: 70px;
        box-sizing: border-box;
        padding: 6px 8px;
        border: 1px solid #d0d0d0;
        border-radius: 4px;
        font-size: 11px;
        background: #fff;
    }
    .th-filter:focus {
        outline: none;
        border-color: #999;
    }
    .big-table td.col-ian,
    .big-table th.col-ian {
        width: 250px;
        min-width: 250px;
        max-width: 250px;
    }
    .big-table td.col-YesNo{
        text-align:center;
        font-weight:bold;
    }
    .big-table td.col-YesNo.yes{
        background:#b8efb8 !important;
        color:#056005;
    }
    .big-table td.col-YesNo.no{
        background:#ffb3b3 !important;
        color:#900;
    }
    .btn-restore {
        margin-left: 10px;
        padding: 4px 6px;
        border: 1px solid #d0d0d0;
        background: #fff;
        border-radius: 4px;
        cursor: pointer;
        font-size: 10px;
        text-decoration: none;
        color: #000;
        display: inline-block;
    }
    .page-title{
        margin:0 0 4px;
        font-size:22px;
        font-weight:500;
        color:#34495e;
        letter-spacing:.3px;
    }
</style>
<?php
    $ppData = $data['ppData'] ?? array();
    $isArchive = $data['isArchive'] ?? false;
    $projekts  = (is_array($ppData) && isset($ppData['kopf'])) ? $ppData['kopf'] : array();
    $shipments = (is_array($ppData) && isset($ppData['ship'])) ? $ppData['ship'] : array();
    $masterKey = 'PPProduktpass_Id';
    $detailKey = 'PPProduktpass_Id';
    $BASE_FIELDS = array(
            array('key' => 'IAN',                'label' => 'IAN',                'type' => 'text', 'class' => 'sticky-left col-ian'),
            array('key' => 'Ausmusterung',       'label' => 'Ausmusterung',       'type' => 'text', 'class' => 'sticky-left-2 col-text-sm'),
            array('key' => 'Artikelbezeichnung', 'label' => 'Artikelbezeichnung', 'type' => 'text', 'class' => 'sticky-left-3 col-wide'),
            array('key' => 'TargaStatus',        'label' => 'Status',             'type' => 'text', 'class' => 'sticky-left-4'),
            array('key' => 'PMAdmin',            'label' => 'PM',                 'type' => 'text', 'class' => 'col-text-sm'),
            array('key' => 'TCAdmin',            'label' => 'TC',                 'type' => 'text', 'class' => 'col-text-sm'),
            array('key' => 'PJMAdmin',           'label' => 'PJM',                'type' => 'text', 'class' => 'col-text-sm'),
            array('key' => 'LogAdmin',           'label' => 'Logistik',           'type' => 'text', 'class' => 'col-text-sm'),
        );
    $SHIP_FIELDS = array(
        array('key' => 'PPShipment_Lot',                                'label' => 'Lot',                           'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_Quantity',                           'label' => 'Quantity',                      'type' => 'number',    'class' => 'col-number'),
        array('key' => 'PPShipment_BatteryType',                        'label' => 'BatteryType',                   'type' => 'text',      'class' => 'col-text-md'),
        array('key' => 'PPShipment_MasterCartonContents',               'label' => 'Master Carton Contents',        'type' => 'text',      'class' => 'col-text-lg'),
        array('key' => 'PPShipment_Incoterm',                           'label' => 'Incoterm',                      'type' => 'text',      'class' => 'col-text-md'),
        array('key' => 'PPShipment_Forwarder',                          'label' => 'Forwarder',                     'type' => 'text',      'class' => 'col-text-md'),
        array('key' => 'PPShipment_Carrier',                            'label' => 'Carrier',                       'type' => 'text',      'class' => 'col-text-md'),
        array('key' => 'PPShipment_POD',                                'label' => 'POD',                           'type' => 'textCombo', 'class' => 'col-text-md'),
        array('key' => 'PPShipment_POA',                                'label' => 'POA',                           'type' => 'textCombo', 'class' => 'col-text-lg'),
        array('key' => 'PPShipment_Vessel',                             'label' => 'Vessel',                        'type' => 'text',      'class' => 'col-text-lg'),
        array('key' => 'PPShipment_Voyage',                             'label' => 'Voyage',                        'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_ENS',                                'label' => 'ENS',                           'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_CYClosing',                          'label' => 'CY Closing',                    'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_ETD',                                'label' => 'ETD',                           'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_ETA',                                'label' => 'ETA',                           'type' => 'date',      'class' =>'col-date'),
        array('key' => 'PPShipment_ATAInlandsterminal',                 'label' => 'ATA Inlandsterminal',           'type' => 'date',      'class' =>'col-date'),
        array('key' => 'PPShipment_MS_EUG',                             'label' => 'EUG',                           'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_MS_30PSI',                           'label' => '30% PSI',                       'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_MS_PSI',                             'label' => '100% PSI',                      'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_ShipReleaseGiven',                   'label' => 'ShipReleaseGiven',              'type' => 'date',           'class' => 'col-date'),
        array('key' => 'PPShipment_ShipReleaseCalc',                    'label' => 'ShipReleaseCalc',               'type' => 'date',           'class' => 'col-date'),
        array('key' => 'PPShipment_CRDGiven',                           'label' => 'CRD Given',                     'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_CRDOpeningCalc',                     'label' => 'CRD Opening Calc',              'type' => 'date',    'class' => 'col-date'),
        array('key' => 'PPShipment_CRDClosingCalc',                     'label' => 'CRD Closing Calc',              'type' => 'date',    'class' => 'col-date'),
        array('key' => 'PPShipment_UnloadingReportDate',                'label' => 'UnloadingReportDate',           'type' => 'date',           'class' => 'col-date'),
        array('key' => 'PPShipment_20ftGP',                             'label' => '20ft GP',                       'type' => 'number',    'class' => 'col-number'),
        array('key' => 'PPShipment_40ftGP',                             'label' => '40ft GP',                       'type' => 'number',    'class' => 'col-number'),
        array('key' => 'PPShipment_40ftHQ',                             'label' => '40ft HQ',                       'type' => 'number',    'class' => 'col-number'),
        array('key' => 'PPShipment_LCLCBM',                             'label' => 'LCL / CBM',                     'type' => 'number',    'class' => 'col-number'),
        array('key' => 'PPShipment_20ftGPCalc',                         'label' => '20ftGPCalc',                    'type' => 'number',         'class' => 'col-number'),
        array('key' => 'PPShipment_40ftGPCalc',                         'label' => '40ftGPCalc',                    'type' => 'number',         'class' => 'col-number'),
        array('key' => 'PPShipment_40ftHQCalc',                         'label' => '40ftHQCalc',                    'type' => 'number',         'class' => 'col-number'),
        array('key' => 'PPShipment_CurrentStatus',                      'label' => 'Current Status',                'type' => 'text',      'class' => 'col-status'),
        array('key' => 'PPShipment_BLForm',                             'label' => 'BL Form',                       'type' => 'textCombo', 'class' => 'col-text-md'),
        array('key' => 'PPShipment_LCOA',                               'label' => 'LCOA',                          'type' => 'textCombo',           'class' => 'col-text-sm'),
        array('key' => 'PPShipment_Flag_Producer_booking',              'label' => 'Producer booking',              'type' => 'col_YesNo',      'class' => 'col-YesNo'),
        array('key' => 'PPShipment_Flag_Shipment_Release',              'label' => 'Ship Release',                  'type' => 'col_YesNo',      'class' => 'col-YesNo'),
        array('key' => 'PPShipment_Flag_SO',                            'label' => 'SO',                            'type' => 'col_YesNo',      'class' => 'col-YesNo'),
        array('key' => 'PPShipment_Flag_BL',                            'label' => 'BL',                            'type' => 'col_YesNo',      'class' => 'col-YesNo'),
        array('key' => 'PPShipment_Flag_Inv',                           'label' => 'Inv',                           'type' => 'col_YesNo',      'class' => 'col-YesNo'),
        array('key' => 'PPShipment_Flag_PL',                            'label' => 'PL',                            'type' => 'col_YesNo',      'class' => 'col-YesNo'),
        array('key' => 'PPShipment_Flag_CoO',                           'label' => 'CoO',                           'type' => 'col_YesNo',      'class' => 'col-YesNo'),
        array('key' => 'PPShipment_Flag_Declaration_of_Fumigation',     'label' => 'Declaration of Fumigation',     'type' => 'col_YesNo',      'class' => 'col-YesNo'),
        array('key' => 'PPShipment_Flag_Ocean_Freight',                 'label' => 'Ocean Freight',                 'type' => 'col_YesNo',      'class' => 'col-YesNo'),
        array('key' => 'PPShipment_Flag_PL_sent_to_MaWi',               'label' => 'PL sent to MaWi',               'type' => 'col_YesNo',      'class' => 'col-YesNo'),
        array('key' => 'PPShipment_Flag_CLP_sent',                      'label' => 'CLP sent',                      'type' => 'col_YesNo',      'class' => 'col-YesNo'),
        array('key' => 'PPShipment_SeaFreightInvoice',                  'label' => 'SeaFreightInvoice',             'type' => 'text',           'class' => 'col-text-sm'),
        array('key' => 'PPShipment_TransportInvoice',                   'label' => 'TransportInvoice',              'type' => 'text',           'class' => 'col-text-sm'),
        array('key' => 'PPShipment_UnloadingInvoice',                   'label' => 'UnloadingInvoice',              'type' => 'text',           'class' => 'col-text-sm'),
        array('key' => 'PPShipment_OtherLogisticalCosts',               'label' => 'OtherLogisticalCosts',          'type' => 'text',           'class' => 'col-text-sm'),
        array('key' => 'PPShipment_Flag_CCC_sent',                      'label' => 'CCC sent',                      'type' => 'col_YesNo',      'class' => 'col-YesNo'),
        array('key' => 'PPShipment_Flag_customs_invoice',               'label' => 'Customs invoice',               'type' => 'col_YesNo',      'class' => 'col-YesNo'),
        array('key' => 'PPShipment_CustomsDeclared',                    'label' => 'CustomsDeclared',               'type' => 'date',           'class' => 'col-date'),
        array('key' => 'PPShipment_HSCode',                             'label' => 'HSCode',                        'type' => 'text',           'class' => 'col-text-sm'),
        array('key' => 'PPShipment_ProjektCount',                       'label' => 'ProjektCount',                  'type' => 'number',         'class' => 'col-number'),
        array('key' => 'PPShipment_TEU',                                'label' => 'TEU',                           'type' => 'number',         'class' => 'col-number'),
        array('key' => 'PPShipment_VKStk',                              'label' => 'VKStk',                         'type' => 'number',         'class' => 'col-number'),
        array('key' => 'PPShipment_VKSumme',                            'label' => 'VKSumme',                       'type' => 'number',         'class' => 'col-number'),
        array('key' => 'PPShipment_ShipmentStatus',                     'label' => 'Status',                        'type' => 'text',           'class' => 'col-text-sm'),
        array('key' => 'PPShipment_DistancePort2Port',                  'label' => 'DistancePort2Port',             'type' => 'number',         'class' => 'col-number'),
        array('key' => 'PPShipment_ZipCodeFactory',                     'label' => 'ZipCodeFactory',               'type' => 'text',           'class' => 'col-text-sm')
    );
    function so_flat_value($shipment, $key, $type = 'text')
    {
        if (!$shipment) {
            return '';
        }
        $raw = is_array($shipment)
            ? (isset($shipment[$key]) ? $shipment[$key] : null)
            : (isset($shipment->$key) ? $shipment->$key : null);
        if ($raw === null || $raw === '') {
            return '';
        }
        if ($type === 'date') {
            $ts = strtotime($raw);
            return $ts ? date('Y-m-d', $ts) : '';
        }
        if ($type === 'col_YesNo') {
            return !empty($raw) ? 'Yes' : '';
        }
        return (string)$raw;
    }
    $flatRows = array();
    $prevIan = null;
    $bgVar = '--bg-colorHigh';
    foreach ($projekts as $projekt) {
        $masterVal = isset($projekt->{$masterKey}) ? $projekt->{$masterKey} : null;
        $projektShipments = array_values(array_filter($shipments, function ($s) use ($masterVal, $detailKey) {
            if ($masterVal === null || $masterVal === '') return false;
            if (!is_object($s) || !isset($s->{$detailKey})) return false;
            return (string)$s->{$detailKey} === (string)$masterVal;
        }));
        $curIan = isset($projekt->IAN) ? (string)$projekt->IAN : '';
        if ($prevIan === null) {
            $prevIan = $curIan;
        }
        if ($curIan !== $prevIan) {
            $bgVar = ($bgVar === '--bg-colorHigh') ? '--bg-color' : '--bg-colorHigh';
            $prevIan = $curIan;
        }
        if (count($projektShipments) > 0) {
            foreach ($projektShipments as $shipment) {
                $flatRows[] = array(
                    'projekt'  => $projekt,
                    'shipment' => $shipment,
                    'bgVar'    => $bgVar,
                );
            }
        } else {
            $flatRows[] = array(
                'projekt'  => $projekt,
                'shipment' => null,
                'bgVar'    => $bgVar,
            );
        }
    }
?>
<h1 class='page-title'>{{ $data['title'] }} </h1>
<div class="container">
    <div class="top-actions">
        <button type="button" class="btn" id="filter-reset">Reset Filter</button>
        <a href="{{ URL::to('/ship') }}" class="btn">Edit View</a>
        <a href="{{ URL::to('/shipArchive') }}" class="btn">Archive</a>
        <div class="muted" id="filter-count" aria-live="polite"></div>
    </div>
    <div class="table-wrap">
        <table class="big-table" aria-label="Shipment Overview Flat" id="projekts-table">
            <thead>
                <tr>
                    @foreach($BASE_FIELDS as $index => $field)
                        <th
                            class="{{ e($field['class']) }}"
                            data-sort="{{ $index }}"
                            data-type="text"
                        >
                            <span class="th-label">{{ $field['label'] }}</span>
                            <input
                                type="text"
                                class="th-filter"
                                data-col="{{ $index }}"
                                placeholder="Filter..."
                                onclick="event.stopPropagation();"
                            >
                        </th>
                    @endforeach
                    @foreach($SHIP_FIELDS as $index => $field)
                        <?php
                            $colIndex = count($BASE_FIELDS) + $index;
                            $sortType = ($field['type'] === 'number')
                                ? 'number'
                                : (($field['type'] === 'date') ? 'date' : 'text');
                            $thClass = ($index === 0 ? 'col-sep ' : '') . ($field['class'] ?? '');
                        ?>
                        <th
                            class="{{ e(trim($thClass)) }}"
                            data-sort="{{ $colIndex }}"
                            data-type="{{ $sortType }}"
                        >
                            <span class="th-label">{{ $field['label'] }}</span>
                            <input
                                type="text"
                                class="th-filter"
                                data-col="{{ $colIndex }}"
                                placeholder="Filter..."
                                onclick="event.stopPropagation();"
                            >
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($flatRows as $row)
                    <?php
                        $projekt = $row['projekt'];
                        $shipment = $row['shipment'];
                        $rowBgVar = $row['bgVar'];
                        $rowBgStyle = 'background-color: var(' . $rowBgVar . ');';
                        $euFlag = $shipment && !empty($shipment->PPShipment_Flag_EUService);
                        $osFlag = $shipment && !empty($shipment->PPShipment_Flag_OS);
                        $kritFlag = $shipment && !empty($shipment->PPShipment_Flag_Critical);
                        $done =    $shipment &&    strtolower(trim($shipment->PPShipment_ShipmentStatus ?? '')) === 'erledigt';
                    ?>
                   <tr class="flat-row
                        {{ $euFlag ? 'flag-eu' : '' }}
                        {{ $osFlag ? 'flag-os' : '' }}
                        {{ $kritFlag ? 'flag-kritisch' : '' }}
                        {{ $done ? 'shipment-done' : '' }}">
                        <td class="sticky-left head-cell col-ian" style="{{ $rowBgStyle }}">
                            <div class="sticky-cell-inner">
                                <span>{{ $projekt->IAN ?? '' }}</span>
                                @if ($data['isArchive'])
                                    <button type="button"
                                        class="btn-restore"
                                        data-produktpass-id="{{ $projekt->PPProduktpass_Id }}"
                                        title="Projekt wiederherstellen">
                                    RESTORE
                                    </button>
                                @endif
                            </div>
                        </td>
                        <td class="sticky-left-2 col-text-sm" style="{{ $rowBgStyle }}">
                            <div class="sticky-cell-inner">{{ $projekt->Ausmusterung ?? '' }}</div>
                        </td>
                        <td class="sticky-left-3 col-wide" style="{{ $rowBgStyle }}">
                            <div class="sticky-cell-inner">{{ $projekt->Artikelbezeichnung ?? '' }}</div>
                        </td>
                        <td class="sticky-left-4" style="{{ $rowBgStyle }}">
                            <div class="sticky-cell-inner">{{ $projekt->TargaStatus ?? '' }}</div>
                        </td>
                        <td class="col-text-sm" style="{{ $rowBgStyle }}">
                            <div class="sticky-cell-inner">{{ $projekt->PMAdmin ?? '' }}</div>
                        </td>
                        <td class="col-text-sm" style="{{ $rowBgStyle }}">
                            <div class="sticky-cell-inner">{{ $projekt->TCAdmin ?? '' }}</div>
                        </td>
                        <td class="col-text-sm" style="{{ $rowBgStyle }}">
                            <div class="sticky-cell-inner">{{ $projekt->PJMAdmin ?? '' }}</div>
                        </td>
                        <td class="col-text-sm" style="{{ $rowBgStyle }}">
                            <div class="sticky-cell-inner">{{ $projekt->LogAdmin ?? '' }}</div>
                        </td>
                        @foreach($SHIP_FIELDS as $index => $field)
                            <?php
                                $value = so_flat_value($shipment, $field['key'], $field['type']);
                                $cellClass = ($index === 0 ? 'col-sep ' : '') . ($field['class'] ?? '');
                                if ($field['type'] === 'col_YesNo') {
                                    $cellClass .= ($value === 'Yes') ? ' yes' : ' no';
                                }
                            ?>
                        <td class="{{ e(trim($cellClass)) }}" style="{{ $rowBgStyle }}"   title="{{ e($value) }}">
                            {{ $value }}
                        </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($BASE_FIELDS) + count($SHIP_FIELDS) }}" class="muted center">
                            Keine Projekte vorhanden.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<script>
(function () {
    var table = document.getElementById("projekts-table");
    if (!table) return;
    var tbody = table.querySelector("tbody");
    var resetBtn = document.getElementById("filter-reset");
    var countEl = document.getElementById("filter-count");
    var headers = table.querySelectorAll("thead th[data-sort]");
    var filterInputs = table.querySelectorAll(".th-filter");
    var currentSort = {
        index: null,
        direction: "asc"
    };
    function norm(s) {
        return (s || "").toString().toLowerCase().trim();
    }
    function getDataRows() {
        return Array.prototype.slice.call(tbody.querySelectorAll("tr")).filter(function (row) {
            return !row.querySelector(".center");
        });
    }
    function updateCount() {
        var rows = getDataRows();
        var visible = rows.filter(function (row) {
            return row.style.display !== "none";
        }).length;
        if (countEl) {
            countEl.textContent = visible + " / " + rows.length + " Zeilen";
        }
    }
    function getCellValue(row, index) {
        var cell = row.children[index];
        if (!cell) return "";
        return (cell.textContent || "").trim();
    }
    function applyFilters() {
        var filters = {};
        Array.prototype.forEach.call(filterInputs, function (input) {
            var value = norm(input.value);
            var col = parseInt(input.getAttribute("data-col"), 10);
            if (value !== "") {
                filters[col] = value;
            }
        });
        getDataRows().forEach(function (row) {
            var show = true;
            Object.keys(filters).forEach(function (colIndex) {
                if (!show) return;
                var filter = filters[colIndex];
                var cellValue = norm(getCellValue(row, parseInt(colIndex, 10)));
                // = filtert leere Zellen
                if (filter === "!") {
                    if (cellValue !== "") {
                        show = false;
                    }
                }
                // ! filtert gefüllte Zellen
                else if (filter === "!") {
                    if (cellValue === "") {
                        show = false;
                    }
                }
                // normaler Textfilter
                else {
                    if (cellValue.indexOf(filter) === -1) {
                        show = false;
                    }
                }
            });
            row.style.display = show ? "" : "none";
        });
        updateCount();
    }
    function parseByType(value, type) {
        var v = (value || "").trim();
        if (v === "") {
            if (type === "number") return Number.NEGATIVE_INFINITY;
            if (type === "date") return "";
            return "";
        }
        if (type === "number") {
            var normalized = v.replace(/\./g, "").replace(",", ".");
            var parsed = parseFloat(normalized);
            return isNaN(parsed) ? Number.NEGATIVE_INFINITY : parsed;
        }
        if (type === "date") {
            if (/^\d{4}-\d{2}-\d{2}$/.test(v)) {
                return v;
            }
            return "";
        }
        return v.toLowerCase();
    }
    function compareRows(a, b, index, type, direction) {
        var aVal = parseByType(getCellValue(a, index), type);
        var bVal = parseByType(getCellValue(b, index), type);
        var result = 0;
        if (aVal < bVal) result = -1;
        if (aVal > bVal) result = 1;
        return direction === "asc" ? result : result * -1;
    }
    function updateHeaderState(activeIndex, direction) {
        Array.prototype.forEach.call(headers, function (th) {
            th.classList.remove("sort-asc", "sort-desc");
            var idx = parseInt(th.getAttribute("data-sort"), 10);
            if (idx === activeIndex) {
                th.classList.add(direction === "asc" ? "sort-asc" : "sort-desc");
            }
        });
    }
    function sortTableByColumn(index, type) {
        var rows = getDataRows();
        var direction = "asc";
        if (currentSort.index === index) {
            direction = currentSort.direction === "asc" ? "desc" : "asc";
        }
        rows.sort(function (a, b) {
            return compareRows(a, b, index, type, direction);
        });
        rows.forEach(function (row) {
            tbody.appendChild(row);
        });
        currentSort.index = index;
        currentSort.direction = direction;
        updateHeaderState(index, direction);
        applyFilters();
    }
    Array.prototype.forEach.call(filterInputs, function (input) {
        input.addEventListener("input", applyFilters);
        input.addEventListener("keydown", function (event) {
            event.stopPropagation();
        });
        input.addEventListener("click", function (event) {
            event.stopPropagation();
        });
    });
    if (resetBtn) {
        resetBtn.addEventListener("click", function () {
            Array.prototype.forEach.call(filterInputs, function (input) {
                input.value = "";
            });
            applyFilters();
        });
    }
    Array.prototype.forEach.call(headers, function (th) {
        th.addEventListener("click", function () {
            var index = parseInt(th.getAttribute("data-sort"), 10);
            var type = th.getAttribute("data-type") || "text";
            sortTableByColumn(index, type);
        });
    });
    applyFilters();
    })();
    document.addEventListener('click', function (e) {
        var b = e.target.closest('.btn-restore');
        if (!b) {
            return;
        }
        if (!confirm('Projekt wiederherstellen?')) {
            return;
        }
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ URL::to("/shipmentRestore") }}', true);
        xhr.setRequestHeader(
            'Content-Type',
            'application/x-www-form-urlencoded'
        );
        xhr.onreadystatechange = function () {
            if (xhr.readyState !== 4) {
                return;
            }
            if (xhr.status >= 200 && xhr.status < 300) {
                location.reload();
            } else {
                alert('Restore fehlgeschlagen.');
                console.log(xhr.responseText);
            }
        };
        xhr.send(
            '_token={{ csrf_token() }}'
            + '&PPProduktpass_Id='
            + encodeURIComponent(
                b.getAttribute('data-produktpass-id')
            )
        );
    });
</script>