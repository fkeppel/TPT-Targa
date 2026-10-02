<?php
    /* Flat shipment overview: the existing sort order is retained across all projects. */
        $SHIP_FIELDS = array(
            array('key' => 'PPShipment_Lot',                                'label' => 'Lot',                           'type' => 'text',      'class' => 'col-lot'),
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
            array('key' => 'PPShipment_ZipCodeFactory',                     'label' => 'Zip-Code Factory',              'type' => 'text',           'class' => 'col-text-sm')
        );
        $SHIP_OPTIONS = array(
            'PPShipment_POA' => array(
                'ANR / MOE', 'BCN', 'BCN / KOP', 'BCN / MOE', 'BCN / OOS', 'BCN / WDF',
                'Budapest / KOP', 'Duisburg', 'Duisburg / RTM', 'Düsseldorf', 'Euro-Rijn',
                'FRA', 'HAM ', 'Hamburg', 'HH', 'KOP', 'KOP / RTM', 'KOP/RTM/OOS',
                'Martico', 'MOE', 'Ningbo', 'NOR', 'Rotterdam', 'RTM', 'RTM / BORN',
                'RTM / OOS', 'RTM / VEN', 'RTM / WVN', 'RTM // HAM', 'RTM // WHV',
                'RTM/Born', 'RTM/FRA', 'RTM/VEN', 'Transdanubia', 'VEN', 'WDF',
                'Wilhelmshaven', 'WVN', 'ZEEBRUEGGE'
            ),
            'PPShipment_POD' => array(
                'Beijiao', 'CHANGSHA', 'Chengdu', 'Chongqing', 'Da Chan Bay',
                'Ezhou Huahu International Airport', 'Guangzhou', 'Jiangmen', 'Jinhua',
                'Koper', 'Nanjing', 'Nansha', 'Ningbo', 'Qingdao', 'Rongqi', 'Rotterdam',
                'Shanghai', 'Shekou', 'Shenzhen', 'Taicang', 'Tianjin Xingang', 'Xiamen',
                'Xian', 'Yantian', 'Yiwu', 'Zhanjiang', 'Zhuhai'
            ),
            'PPShipment_BLForm' => array('Air Waybill','Original BL','Surrendered BL'),
            'PPShipment_LCOA'   => array('LC','OA', ''),
        );
    $read = function ($row, $key, $default = '') {
        if (is_array($row)) return isset($row[$key]) ? $row[$key] : $default;
        return is_object($row) && isset($row->$key) ? $row->$key : $default;
    };
    $esc = function ($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); };
    $json = function ($value) { return json_encode($value, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); };
    $projects = array();
    $projectRows = isset($data['projekts']) ? $data['projekts'] : (isset($data['ppData']['kopf']) ? $data['ppData']['kopf'] : array());
    $headFields = array('ian' => 'IAN', 'ausmusterung' => 'Ausmusterung', 'artikel' => 'Artikelbezeichnung', 'status' => 'TargaStatus', 'pm' => 'PMAdmin', 'tc' => 'TCAdmin', 'pjm' => 'PJMAdmin', 'log' => 'LogAdmin');
    $headLabels = array('ian' => 'IAN', 'ausmusterung' => 'Ausmusterung', 'artikel' => 'Artikelbezeichnung', 'status' => 'Status', 'pm' => 'PM', 'tc' => 'TC', 'pjm' => 'PJM', 'log' => 'LOG');
    foreach ($projectRows as $project) {
        $id = (string)$read($project, 'PPProduktpass_Id');
        if ($id === '') continue;
        $values = array('id' => $id);
        foreach ($headFields as $key => $field) $values[$key] = (string)$read($project, $field);
        $projects[$id] = $values;
    }
    $shipments = isset($data['shipments']) ? $data['shipments'] : (isset($data['ppData']['ship']) ? $data['ppData']['ship'] : array());
    $rows = array();
    $seen = array();
    foreach ($shipments as $shipment) {
        $shipId = (string)$read($shipment, 'PPShipment_Id');
        if ($shipId !== '' && isset($seen[$shipId])) continue;
        if ($shipId !== '') $seen[$shipId] = true;
        $masterId = (string)$read($shipment, 'ShipmentMasterId');
        if ($masterId === '') $masterId = (string)$read($shipment, 'PPShipment_PPProduktpass_Id');
        if ($masterId === '') $masterId = (string)$read($shipment, 'PPProduktpass_Id');
        if (!isset($projects[$masterId])) {
            $values = array('id' => $masterId);
            foreach ($headFields as $key => $field) $values[$key] = (string)$read($shipment, $field);
            $values['ian'] = (string)$read($shipment, 'PPProduktpass_IAN', $read($shipment, 'PPShipment_IAN', $values['ian']));
            $values['ausmusterung'] = (string)$read($shipment, 'PPProduktpass_Ausmusterungnummer', $read($shipment, 'PPShipment_Ausmusterungnummer', $values['ausmusterung']));
            $projects[$masterId] = $values;
        }
        // Joined metadata also covers shipments missing from the separate project list.
        foreach ($headFields as $key => $field) {
            $joined = $read($shipment, 'Project'.$field, null);
            if ($joined !== null) $projects[$masterId][$key] = (string)$joined;
        }
        $rows[] = array('shipment' => $shipment, 'master' => $masterId);
    }
    // Compact data is rendered once; table rows and editors are created only on demand.
    $records = array();
    foreach ($rows as $row) {
        $shipment = $row['shipment'];
        $values = array();
        foreach ($SHIP_FIELDS as $field) {
            $value = (string)$read($shipment, $field['key']);
            if ($field['type'] === 'date' && $value !== '') {
                $time = strtotime($value); $value = $time ? date('Y-m-d', $time) : '';
            }
            if ($field['type'] === 'col_YesNo') $value = ((int)$value === 1) ? 'Yes' : '';
            $values[] = $value;
        }
        $records[] = array('id' => (string)$read($shipment, 'PPShipment_Id'), 'master' => $row['master'], 'values' => $values,
            'flags' => array((int)(bool)$read($shipment, 'PPShipment_Flag_EUService'), (int)(bool)$read($shipment, 'PPShipment_Flag_OS'), (int)(bool)$read($shipment, 'PPShipment_Flag_Critical')));
    }
    $headWidths = array(44, 190, 100, 120, 260, 85, 85, 85, 85, 110);
    $fieldWidths = array();
    foreach ($SHIP_FIELDS as $field) {
        $widths = array('col-lot'=>90, 'col-number'=>100, 'col-number-lg'=>125, 'col-date'=>140, 'col-text-sm'=>120, 'col-text-md'=>145, 'col-text-lg'=>185, 'col-wide'=>225, 'col-status'=>205, 'col-YesNo'=>80);
        $fieldWidths[] = isset($widths[$field['class']]) ? $widths[$field['class']] : 145;
    }
    $tableWidth = array_sum($headWidths) + array_sum($fieldWidths);
    $logMa = isset($data['logMa']) && is_array($data['logMa']) ? $data['logMa'] : array();
?>
<style>
    #shipment-overview {
            --bg-color: rgba(105, 162, 241, 0.28);
            --bg-colorHigh: rgba(105, 162, 241, 0.14);
            --bg-colorSticky: rgba(218, 234, 255, 1);
            --bg-colorStickyHigh: rgba(235, 244, 255, 1);
            --active-row: rgba(105, 162, 241, 0.35);
            --active-border: #2264af;
            --flag-color-eu: #f59e0b;
            --flag-color-os: #22c55e;
            --flag-color-critical: #ef4444;
            --color-project-ready: #009747;
        }
    #shipment-overview .muted { color:#777; font-size: 12px; }
    #shipment-overview .center { text-align:center; }
    #shipment-overview .inner-table {
            border-collapse: separate;
            border-spacing: 0;
            width: max-content;
            min-width: 100%;
            font-size: 12px;
            margin-top: 8px;
        }
    #shipment-overview .inner-table th,
    #shipment-overview .inner-table td {
            padding: 4px 8px;
            border-right: 1px solid #eee;
            border-bottom: 1px solid #eee;
            white-space: nowrap;
            height: 26px;
            vertical-align: middle;
        }
    #shipment-overview .inner-table thead th {
            background: #f7f7f7;
            color: #1e5fb8;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 1;
            text-align: left;
        }
    #shipment-overview .filter-bar {
            display: flex;
            gap: 12px;
            align-items: end;
            margin: 0 0 12px 0;
            flex-wrap: wrap;
        }
    #shipment-overview .filter-field {
            display:flex;
            flex-direction:column;
            gap:6px;
        }
    #shipment-overview .filter-field label {
            font-size:12px;
            color:#444;
        }
    #shipment-overview .filter-field input {
            padding: 8px 10px;
            border: 1px solid #d0d0d0;
            border-radius: 6px;
            min-width: 220px;
            font-size: 12px;
        }
    #shipment-overview .filter-actions {
            display:flex;
            gap:10px;
        }
    #shipment-overview .btn {
            padding: 8px 10px;
            border: 1px solid #d0d0d0;
            background: #fff;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            color: #222;
            text-decoration: none;
            display: inline-block;
        }
    #shipment-overview .btn:hover { background:#f7f7f7; }
    #shipment-overview .btn-mini {
            padding: 2px 8px;
            font-size: 11px;
            line-height: 1.2;
            height: 22px;
        }
    #shipment-overview .inner-table td {
            overflow: hidden;
            text-overflow: ellipsis;
        }
    #shipment-overview .inner-table td input.js-ship-input {
            width: 100%;
            height: 22px;
            border: 1px solid #d0d0d0;
            background: #fff;
            font-size: 11px;
            line-height: 1.2;
            padding: 1px 4px;
            box-sizing: border-box;
        }
    #shipment-overview .inner-table td input.js-ship-input.is-dirty {
            outline: 2px solid #ffe08a;
            outline-offset: -2px;
            background: #fffdf3;
        }
    #shipment-overview .inner-table td input.js-ship-input:focus {
            outline-offset: -2px;
        }
    #shipment-overview .inner-table td.col-text-sm,
    #shipment-overview .inner-table th.col-text-sm { min-width: 110px; }
    #shipment-overview .inner-table td.col-lot,
    #shipment-overview .inner-table th.col-lot {
            min-width: 84px;
            max-width: 84px;
        }
    #shipment-overview .inner-table td.col-text-md,
    #shipment-overview .inner-table th.col-text-md { min-width: 140px; }
    #shipment-overview .inner-table td.col-text-lg,
    #shipment-overview .inner-table th.col-text-lg { min-width: 180px; }
    #shipment-overview .inner-table td.col-wide,
    #shipment-overview .inner-table th.col-wide { min-width: 220px; }
    #shipment-overview .inner-table td.col-status,
    #shipment-overview .inner-table th.col-status { min-width: 200px; }
    #shipment-overview .inner-table td.col-number,
    #shipment-overview .inner-table th.col-number { min-width: 95px; }
    #shipment-overview .inner-table td.col-number-lg,
    #shipment-overview .inner-table th.col-number-lg { min-width: 120px; }
    #shipment-overview .inner-table td.col-date,
    #shipment-overview .inner-table th.col-date { min-width: 135px; }
    #shipment-overview .inner-table td.col-date input.js-ship-input[type="date"] {
            min-width: 135px;
        }
    #shipment-overview tr.is-saving td { opacity: .6; }
    #shipment-overview tr.is-saved td { outline: 2px solid #9fe6b8; outline-offset: -2px; }
    #shipment-overview tr.is-error td { outline: 2px solid #ff9a9a; outline-offset: -2px; }
    #shipment-overview .inner-table tbody tr:hover td {
            background: rgba(0,0,0,0.02);
        }
    #shipment-overview .date-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
    #shipment-overview .date-wrapper input {
            padding-right: 26px;
        }
    #shipment-overview .date-icon {
            position: absolute;
            right: 6px;
            width: 14px;
            height: 14px;
            cursor: pointer;
            opacity: 0.6;
        }
    #shipment-overview .date-icon:hover {
            opacity: 1;
        }
    #shipment-overview .flag-cell {
            display:flex;
            align-items:center;
            gap:4px;
            white-space:nowrap;
        }
    #shipment-overview .filler-col {
            width: 100%;
            min-width: 200px;
        }
    #shipment-overview .lot-flag-cell {
            white-space:nowrap;
        }
    #shipment-overview .btn-lot-flag.is-active[data-flag="EU_Serviceware"] {
            background:var(--flag-color-eu);
            color:white;
        }
    #shipment-overview .btn-lot-flag.is-active[data-flag="OSProjekt"] {
            background:var(--flag-color-os);
            color:white;
        }
    #shipment-overview .btn-lot-flag.is-active[data-flag="KritischesProjekt"] {
            background:var(--flag-color-critical);
            color:white;
        }
    #shipment-overview .js-shipment-row.flag-eu td {
            background:var(--flag-color-eu);
        }
    #shipment-overview .js-shipment-row.flag-os td {
            background:var(--flag-color-os);
        }
    #shipment-overview .js-shipment-row.flag-kritisch td {
            background:var(--flag-color-critical);
        }
    #shipment-overview .js-shipment-row {
            --marker-eu: transparent;
            --marker-os: transparent;
            --marker-kritisch: transparent;
        }
    #shipment-overview .js-shipment-row.flag-eu {
            --marker-eu: var(--flag-color-eu);
        }
    #shipment-overview .js-shipment-row.flag-os {
            --marker-os: var(--flag-color-os);
        }
    #shipment-overview .js-shipment-row.flag-kritisch {
            --marker-kritisch: var(--flag-color-critical);
        }
    #shipment-overview .js-shipment-row.shipment-done td {
            background:var(--color-project-ready) !important;
        }
    #shipment-overview .js-shipment-row td[data-field="PPShipment_Lot"] {
            box-shadow:
                inset 8px 0 0 var(--marker-eu),
                inset 16px 0 0 var(--marker-os),
                inset 24px 0 0 var(--marker-kritisch);
            padding-left: 36px;
        }
    #shipment-overview .inner-table td.col-YesNo {
            padding: 0;
            min-width: 70px;
            max-width: 70px;
        }
    #shipment-overview .col-YesNo {
            width: 50px !important;
            min-width: 50px !important;
            max-width: 50px !important;
        }
    #shipment-overview .js-yesno {
            width: 100%;
            height: 100%;
            min-height: 26px;
            border: none;
            cursor: pointer;
            font-size: 11px;
            font-weight: bold;
        }
    #shipment-overview .js-yesno.is-yes {
            background: #b8efb8;
            color: #056005;
        }
    #shipment-overview .js-yesno.is-no {
            background: #ffb3b3;
            color: #900;
        }
    #shipment-overview .js-yesno.is-dirty {
            outline:2px solid #ffe08a;
            outline-offset:-2px;
        }
    #shipment-overview .btn-danger-icon {
            margin-top: 4px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            padding: 0;
            background: #dc3545;
            border: 1px solid #c82333;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color .2s;
        }
    #shipment-overview .btn-danger-icon:hover {
            background: #c82333;
        }
    #shipment-overview .btn-danger-icon:active {
            background: #bd2130;
        }
    #shipment-overview .btn-danger-icon:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(220,53,69,.3);
        }
    #shipment-overview .btn-danger-icon svg {
            display: block;
        }
    #shipment-overview .btn-complete-icon {
            margin-top: 4px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            padding: 0;
            background: #28a745;
            border: 1px solid #1f8a39;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color .2s;
        }
    #shipment-overview .btn-complete-icon:hover {
            background: #218838;
        }
    #shipment-overview .btn-complete-icon.is-open {
            background: #6c757d;
            border-color: #5a6268;
        }
    #shipment-overview .btn-complete-icon.is-open:hover {
            background: #5a6268;
        }
    #shipment-overview .btn-complete-icon:active {
            background: #1e7e34;
        }
    #shipment-overview .btn-complete-icon:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(40,167,69,.3);
        }
    #shipment-overview .btn-complete-icon svg {
            display: block;
        }
    #shipment-overview { padding:20px; margin-top:30px; font-family:Arial,Helvetica,sans-serif; }
    #shipment-overview h2 { margin:0 0 15px; font-size:22px; font-weight:500; color:#34495e; text-align:left; }
    #shipment-overview .shipment-sort-wrap { height:80vh; overflow:auto; border:1px solid #ccd8e5; background:white; }
    #shipment-overview .shipment-sort-table { width:max-content; min-width:100%; margin:0; background:white; }
    #shipment-overview .shipment-sort-table thead th { top:0; z-index:20; background:#e2ebf5; vertical-align:top; }
    #shipment-overview .th-label { display:block; margin-bottom:4px; }
    #shipment-overview .head-filter { width:100%; min-width:60px; padding:4px 6px; border:1px solid #d0d0d0; box-sizing:border-box; font-size:11px; }
    #shipment-overview .shipment-sort-row { --row-bg:var(--bg-colorStickyHigh); }
    #shipment-overview .shipment-sort-row.stripe-even { --row-bg:var(--bg-colorSticky); }
    #shipment-overview .shipment-sort-row td { background:var(--row-bg); }
    #shipment-overview .shipment-sort-row:hover td { background:#d9e9f7; }
    #shipment-overview .shipment-sort-table tbody tr.js-shipment-row:hover td { background:var(--row-bg); }
    #shipment-overview .shipment-sort-row.flag-eu { --row-bg:var(--flag-color-eu); }
    #shipment-overview .shipment-sort-row.flag-os { --row-bg:var(--flag-color-os); }
    #shipment-overview .shipment-sort-row.flag-kritisch { --row-bg:var(--flag-color-critical); }
    #shipment-overview .drag-cell { position:sticky; left:0; z-index:5; width:38px; min-width:38px; padding:0; text-align:center; }
    #shipment-overview thead .drag-cell { z-index:30; }
    #shipment-overview .drag-handle { display:block; padding:5px 0; font-size:18px; cursor:grab; user-select:none; color:#607d9b; }
    #shipment-overview .drag-handle:active { cursor:grabbing; }
    #shipment-overview .shipment-sort-table tr > :nth-child(-n+5) { position:sticky; z-index:5; }
    #shipment-overview .shipment-sort-table tr > :nth-child(1) { left:var(--frozen-left-1, 0px); }
    #shipment-overview .shipment-sort-table tr > :nth-child(2) { left:var(--frozen-left-2, 38px); }
    #shipment-overview .shipment-sort-table tr > :nth-child(3) { left:var(--frozen-left-3, 200px); }
    #shipment-overview .shipment-sort-table tr > :nth-child(4) { left:var(--frozen-left-4, 300px); }
    #shipment-overview .shipment-sort-table tr > :nth-child(5) { left:var(--frozen-left-5, 410px); border-right:2px solid #b8c9da; }
    #shipment-overview .shipment-sort-table thead tr > :nth-child(-n+5) { top:0; z-index:30; background:#e2ebf5; }
    #shipment-overview .shipment-sort-table .no-rows td { position:static; }
    #shipment-overview .sort-status { font-size:12px; margin-left:15px; }
    #shipment-overview .sort-status.saving { color:#6c757d; }
    #shipment-overview .sort-status.saved { color:#198754; }
    #shipment-overview .sort-status.error, #shipment-overview .row-message { color:#b91c1c; font-size:11px; }
    #shipment-overview .row-message { display:block; max-width:260px; white-space:normal; }
    #shipment-overview .js-date-hidden { position:absolute; width:1px; height:1px; opacity:0; pointer-events:none; }
    #shipment-overview .date-icon { padding:0; border:0; background:transparent; line-height:14px; }
    #shipment-overview .btn-complete-icon, #shipment-overview .btn-danger-icon { color:#fff; font-weight:bold; }
    #shipment-overview select { padding:4px; max-width:380px; border:1px solid #d0d0d0; font-size:12px; }
    #shipment-overview .js-log-admin-text { cursor:pointer; }
    #shipment-overview .filter-bar *, #shipment-overview table * { border-radius:0 !important; }
    #shipment-overview [hidden] { display:none !important; }
    #shipment-overview button:disabled { opacity:.5; cursor:default; }
    #shipment-overview .no-rows td { padding:20px; text-align:center; color:#777; }
    #shipment-overview .shipment-sort-wrap { overflow-anchor:none; }
    #shipment-overview .shipment-sort-table { table-layout:fixed; border-collapse:separate; border-spacing:0; }
    #shipment-overview .shipment-sort-table th { min-width:0 !important; max-width:none !important; width:auto !important; overflow:hidden; box-sizing:border-box; }
    #shipment-overview .shipment-sort-table .th-label { overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    #shipment-overview .shipment-sort-table .head-filter { min-width:0; height:24px; }
    #shipment-overview .shipment-sort-table .js-shipment-row { height:34px; }
    #shipment-overview .shipment-sort-table .js-shipment-row td { height:34px; max-height:34px; padding:0 8px; line-height:32px; box-sizing:border-box; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    #shipment-overview .shipment-sort-table .js-shipment-row .drag-cell { padding:0; }
    #shipment-overview .drag-handle { line-height:32px; padding:0; }
    #shipment-overview .action-group { display:flex; align-items:center; gap:3px; height:32px; overflow:hidden; }
    #shipment-overview .action-group button { flex:none; padding:1px 4px; margin:0; height:22px; line-height:18px; }
    #shipment-overview .action-group .btn-complete-icon, #shipment-overview .action-group .btn-danger-icon { width:20px; }
    #shipment-overview .editable-cell { cursor:text; }
    #shipment-overview .editable-cell:focus, #shipment-overview .project-cell:focus { outline:2px solid #2264af; outline-offset:-2px; }
    #shipment-overview .editable-cell.is-dirty { box-shadow:inset 0 -3px #ffc107; }
    #shipment-overview .editable-cell.yesno-cell { text-align:center; cursor:pointer; }
    #shipment-overview .editable-cell.yesno-cell.is-yes { background:#b8efb8; color:#056005; }
    #shipment-overview .editable-cell.yesno-cell.is-no { background:#ffb3b3; color:#900; }
    #shipment-overview .cell-editor { display:block; width:100%; min-width:0; max-width:100%; height:26px; line-height:22px; padding:1px 4px; margin:3px 0; border:1px solid #2264af; box-sizing:border-box; background:#fff; font:12px Arial,Helvetica,sans-serif; }
    #shipment-overview .shipment-sort-table .virtual-spacer td { position:static !important; padding:0 !important; border:0 !important; background:transparent !important; line-height:0; font-size:0; }
    #shipment-overview .shipment-sort-table .virtual-spacer { background:transparent; }
    #shipment-overview tr.is-saving td { opacity:1; }
    #shipment-overview tr.is-saving .shipment-actions { box-shadow:inset 0 -3px #6c757d; }
    @media print {
        #shipment-overview .shipment-sort-wrap { height:auto; overflow:visible; border:0; }
        #shipment-overview .shipment-sort-table thead th, #shipment-overview .shipment-sort-table tr > :nth-child(-n+5) { position:static; }
        #shipment-overview .filter-bar, #shipment-overview .drag-handle, #shipment-overview .head-filter { display:none; }
    }
</style>
<div id="shipment-overview" class="shipment-sort-container">
    <h2>Shipment Overview <span id="sort-status" class="sort-status" role="status" aria-live="polite"></span></h2>
    <div class="filter-bar" aria-label="Filter und Projektaktionen">
        <button type="button" class="btn" id="filter-reset">Reset</button>
        <a class="btn" href="<?php echo $esc(URL::to('/shipFlat')); ?>">Flat View</a>
        <a class="btn" href="<?php echo $esc(URL::to('/showFrmNewOrder')); ?>" target="_blank" rel="noopener">Neues Schwarz Projekt</a>
        <a class="btn" href="<?php echo $esc(URL::to('/shipArchive')); ?>">Archive</a>
        <label class="filter-field">Projekt für Add / Archivieren
            <select id="shipment-project" aria-label="Projekt für Add / Archivieren">
                <option value="">Projekt auswählen …</option>
                <?php foreach ($projects as $project): if ($project['id'] === '') continue; ?>
                <option value="<?php echo $esc($project['id']); ?>"><?php echo $esc($project['ian'].' / '.$project['ausmusterung'].' — '.$project['artikel']); ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button type="button" class="btn btn-add-shipment" disabled>Add</button>
        <button type="button" class="btn btn-archive-shipment" disabled>Archivieren</button>
        <span class="muted" id="filter-count" aria-live="polite"></span>
        <button type="button" class="btn" id="show-save-errors" hidden>Speicherfehler anzeigen</button>
    </div>
    <div class="shipment-sort-wrap">
        <table class="shipment-sort-table inner-table" aria-label="Shipments und Lot-Daten" style="width:<?php echo $tableWidth; ?>px">
            <colgroup><?php foreach (array_merge($headWidths, $fieldWidths) as $width): ?><col style="width:<?php echo $width; ?>px"><?php endforeach; ?></colgroup>
            <thead><tr>
                <th class="drag-cell" title="Shipments verschieben">Sort.</th><th>Aktionen</th>
                <?php foreach ($headLabels as $key => $label): ?>
                <th><span class="th-label"><?php echo $esc($label); ?></span><input class="head-filter" data-filter="<?php echo $esc($key); ?>" aria-label="<?php echo $esc($label); ?> filtern"></th>
                <?php endforeach; ?>
                <?php foreach ($SHIP_FIELDS as $field): ?>
                <th class="<?php echo $esc($field['class']); ?>" title="<?php echo $esc($field['label']); ?>">
                    <span class="th-label"><?php echo $esc($field['label']); ?></span>
                    <?php if ($field['type'] === 'col_YesNo'): ?>
                    <select class="head-filter" data-shipment-filter="<?php echo $esc($field['key']); ?>" aria-label="<?php echo $esc($field['label']); ?> filtern">
                        <option value="">Alle</option><option value="yes">Ja</option><option value="no">Nein</option>
                    </select>
                    <?php else: ?>
                    <input class="head-filter" data-shipment-filter="<?php echo $esc($field['key']); ?>" aria-label="<?php echo $esc($field['label']); ?> filtern">
                    <?php endif; ?>
                </th>
                <?php endforeach; ?>
            </tr></thead>
            <tbody id="shipment-sort-body">
            </tbody>
        </table>
    </div>
    <?php foreach ($SHIP_OPTIONS as $key => $options): ?>
    <datalist id="ship-options-<?php echo $esc($key); ?>"><?php foreach ($options as $option): ?><option value="<?php echo $esc($option); ?>"></option><?php endforeach; ?></datalist>
    <?php endforeach; ?>
</div>
<script>
(function () {
    'use strict';
    var config = <?php echo $json(array('records' => $records, 'headWidths' => $headWidths, 'fieldWidths' => $fieldWidths, 'fields' => $SHIP_FIELDS, 'projects' => (object)$projects, 'logMa' => (object)$logMa, 'csrf' => csrf_token(), 'urls' => array('save' => URL::to('/saveLot'), 'remove' => URL::to('/deleteLot'), 'complete' => URL::to('/shipmentComplete'), 'archive' => URL::to('shipmentArchive'), 'log' => URL::to('/saveLogAdmin'), 'sort' => URL::to('shipmentSortierung'), 'show' => URL::to('show')))); ?>;
    function createShipmentStore(config, request, notify) {
        var fields = config.fields;
        var index = Object.create(null);
        fields.forEach(function (f, i) { index[f.key] = i; });
        var nextKey = 0;
        var records = [];
        var byKey = new Map();
        var sorting = false;
        var needsOrderSave = false;
        var projectSearch = Object.create(null);
        function refreshProjects() {
            Object.keys(config.projects).forEach(function (id) {
                var source = config.projects[id], target = {};
                Object.keys(source).forEach(function (key) { target[key] = String(source[key] || '').toLowerCase(); });
                projectSearch[id] = target;
            });
        }
        function make(raw) {
            var values = fields.map(function (_, i) { return String(raw.values[i] == null ? '' : raw.values[i]); });
            var record = {key:String(++nextKey), id:String(raw.id || ''), master:String(raw.master), values:values,
                clean:values.slice(), search:values.map(function (v) { return v.toLowerCase(); }),
                flags:(raw.flags || [0,0,0]).slice(), cleanFlags:(raw.flags || [0,0,0]).slice(),
                timer:null, promise:null, busy:false, error:'', state:'', revision:0};
            byKey.set(record.key, record); return record;
        }
        config.records.forEach(function (raw) { records.push(make(raw)); });
        refreshProjects();
        function changed(record) { record.revision++; notify(record); }
        function dirty(r) {
            return r.values.some(function (v,i) { return v !== r.clean[i]; }) || r.flags.some(function (v,i) { return v !== r.cleanFlags[i]; });
        }
        function set(r, i, value) {
            if (r.busy) return;
            r.values[i] = String(value); r.search[i] = String(value).toLowerCase(); changed(r);
        }
        function validDate(v) {
            if (!/^\d{4}-\d{2}-\d{2}$/.test(v)) return false;
            var date = new Date(v + 'T00:00:00Z');
            return !isNaN(date.getTime()) && date.toISOString().slice(0,10) === v;
        }
        function validate(r) {
            if (!r.master) throw new Error('Produktpass-ID fehlt.');
            fields.forEach(function (f,i) {
                var v = r.values[i].trim();
                if ((f.type === 'date' && v && !validDate(v)) ||
                    (f.type === 'number' && v && !/^-?(?:\d+(?:\.\d*)?|\.\d+)$/.test(v))) {
                    throw new Error(f.label + ': Bitte ' + (f.type === 'date' ? 'JJJJ-MM-TT' : 'eine gültige Zahl') + ' eingeben.');
                }
            });
        }
        function save(r) {
            clearTimeout(r.timer);
            if (r.promise) return r.promise.then(function () { return dirty(r) ? save(r) : null; });
            if (!dirty(r) || !byKey.has(r.key)) return Promise.resolve();
            try { validate(r); } catch (error) { r.error=error.message; r.state='error'; changed(r); return Promise.reject(error); }
            var snapshot = r.values.slice(), flags = r.flags.slice(), wasNew = !r.id;
            var payload = {PPProduktpass_Id:r.master, PPShipment_Id:r.id || null};
            fields.forEach(function (f,i) { payload[f.key] = f.type === 'col_YesNo' ? (snapshot[i] === 'Yes' ? 1 : 0) : snapshot[i].trim(); });
            ['PPShipment_Flag_EUService','PPShipment_Flag_OS','PPShipment_Flag_Critical'].forEach(function (key,i) { payload[key]=flags[i]; });
            r.state='saving'; r.error=''; changed(r);
            r.promise = request(config.urls.save,payload).then(function (result) {
                if (!result.PPShipment_Id) throw new Error('Shipment-ID fehlt in der Serverantwort. Vor erneutem Anlegen prüfen.');
                r.id=String(result.PPShipment_Id); r.clean=snapshot; r.cleanFlags=flags; r.promise=null;
                if (wasNew) needsOrderSave=true;
                r.state='saved'; changed(r);
                if (dirty(r)) return save(r);
                maybeSaveOrder();
            }).catch(function (error) { r.promise=null; r.error=error.message; r.state='error'; changed(r); throw error; });
            return r.promise;
        }
        function schedule(r) { clearTimeout(r.timer); r.timer=setTimeout(function () { save(r).catch(function () {}); },400); }
        function filter(terms, errorsOnly) {
            var active=terms.filter(function (term) { return term.value !== ''; });
            return records.filter(function (r) {
                if (errorsOnly && !r.error) return false;
                return active.every(function (term) {
                    if (term.index !== undefined) {
                        if (fields[term.index].type === 'col_YesNo') return (r.values[term.index] === 'Yes' ? 'yes' : 'no') === term.value;
                        return r.search[term.index].indexOf(term.value) !== -1;
                    }
                    return String((projectSearch[r.master] || {})[term.key] || '').indexOf(term.value) !== -1;
                });
            });
        }
        function persistOrder(before) {
            sorting=true; notify(null,'sorting');
            return request(config.urls.sort,{order:records.map(function (r) { return r.id; })}).then(function () {
                sorting=false; needsOrderSave=false; notify(null,'sorted');
            }).catch(function (error) {
                if (before) records=before;
                sorting=false; notify(null,'sort-error',error.message); throw error;
            });
        }
        function canSort() { return !sorting && records.every(function (r) { return !!r.id && !r.busy; }); }
        function maybeSaveOrder() {
            if (needsOrderSave && canSort()) persistOrder(null).catch(function () {});
        }
        function move(source, target, after) {
            if (!canSort() || source === target) return Promise.resolve();
            var before=records.slice();
            records.splice(records.indexOf(source),1);
            records.splice(records.indexOf(target)+(after ? 1 : 0),0,source);
            if (before.every(function (r,i) { return r===records[i]; })) return Promise.resolve();
            return persistOrder(before);
        }
        function add(master) {
            if (sorting) throw new Error('Bitte Ende der Sortierung abwarten.');
            var r=make({id:'',master:master,values:fields.map(function () { return ''; })});
            records.push(r); notify(null,'data'); return r;
        }
        function remove(r) {
            if (sorting || r.busy) return Promise.reject(new Error('Bitte laufenden Vorgang abwarten.'));
            r.busy=true; clearTimeout(r.timer); changed(r);
            return (r.promise || Promise.resolve()).then(function () {
                return r.id ? request(config.urls.remove,{PPShipment_Id:r.id}) : null;
            }).then(function () {
                records.splice(records.indexOf(r),1); byKey.delete(r.key); notify(null,'data'); maybeSaveOrder();
            }).catch(function (error) { r.busy=false; r.error=error.message; r.state='error'; changed(r); throw error; });
        }
        function complete(r) {
            if (r.busy || !r.id) return Promise.reject(new Error('Bitte Lot zuerst speichern.'));
            r.busy=true; changed(r);
            return save(r).then(function () { return request(config.urls.complete,{PPShipment_Id:r.id}); }).then(function (result) {
                if (!Object.prototype.hasOwnProperty.call(result,'PPShipment_ShipmentStatus')) throw new Error('Shipment-Status fehlt.');
                var i=index.PPShipment_ShipmentStatus;
                r.values[i]=String(result.PPShipment_ShipmentStatus); r.clean[i]=r.values[i]; r.search[i]=r.values[i].toLowerCase();
                r.busy=false; changed(r);
            }).catch(function (error) { r.busy=false; r.error=error.message; r.state='error'; changed(r); throw error; });
        }
        return {fields:fields,index:index,get:function (key) { return byKey.get(key); }, all:function () { return records; },
            dirty:dirty,set:set,save:save,schedule:schedule,filter:filter,add:add,remove:remove,complete:complete,move:move,
            canSort:canSort,sorting:function () { return sorting; },retryOrder:maybeSaveOrder,
            flag:function (r,i) { if (!r.busy) { r.flags[i]=r.flags[i] ? 0 : 1; changed(r); schedule(r); } },
            refreshProjects:refreshProjects,changed:changed,
            pending:function () { return sorting || records.some(function (r) { return dirty(r) || r.promise || r.busy; }); }};
    }
    var root=document.getElementById('shipment-overview');
    if (!root || root.dataset.bound) return;
    root.dataset.bound='1';
    var wrap=root.querySelector('.shipment-sort-wrap'), table=root.querySelector('table'), tbody=root.querySelector('tbody');
    var projectSelect=root.querySelector('#shipment-project'), status=root.querySelector('#sort-status');
    var filters=Array.prototype.slice.call(root.querySelectorAll('.head-filter'));
    var ROW_HEIGHT=34, OVERSCAN=8, filtered=[], terms=[], errorsOnly=false;
    var nodes=new Map(), rendered=new Map(), editor=null, dragged=null, allowed=null;
    var filterTimer=null, frame=null, printing=false, remoteActions=0, dragSpeed=0, dragFrame=null;
    var heads=['ian','ausmusterung','artikel','status','pm','tc','pjm','log'];
    function el(tag, cls, text) {
        var node=document.createElement(tag); if (cls) node.className=cls;
        if (text !== undefined) node.textContent=text; return node;
    }
    function button(cls,text,title) {
        var node=el('button',cls,text); node.type='button'; node.title=title || text;
        node.setAttribute('aria-label',title || text); return node;
    }
    function showStatus(type,text) { status.className='sort-status '+type; status.textContent=text || ''; }
    function request(url,payload) {
        return new Promise(function (resolve,reject) {
            var xhr=new XMLHttpRequest(); xhr.open('POST',url,true); xhr.timeout=30000;
            xhr.setRequestHeader('Content-Type','application/json'); xhr.setRequestHeader('X-CSRF-TOKEN',config.csrf);
            xhr.setRequestHeader('X-Requested-With','XMLHttpRequest'); payload._token=config.csrf;
            xhr.onload=function () {
                var result;
                try { result=JSON.parse(xhr.responseText); } catch (_) { reject(new Error('Ungültige Serverantwort.')); return; }
                if (xhr.status < 200 || xhr.status >= 300 || !result || result.ok === false || result.success === false) {
                    reject(new Error(result && (result.message || result.error) || 'Anfrage fehlgeschlagen ('+xhr.status+').'));
                } else resolve(result);
            };
            xhr.onerror=function () { reject(new Error('Netzwerkfehler. Änderungen bleiben erhalten.')); };
            xhr.ontimeout=function () { reject(new Error('Zeitüberschreitung. Vor erneutem Anlegen Serverstand prüfen.')); };
            xhr.send(JSON.stringify(payload));
        });
    }
    var store=createShipmentStore(config,request,function (r,event,message) {
        if (r) {
            var node=rendered.get(r.key); if (node) paintRow(node,r);
            var errors=store.all().filter(function (item) { return !!item.error; }).length;
            var errorsButton=root.querySelector('#show-save-errors'); errorsButton.hidden=!errors;
            errorsButton.textContent='Speicherfehler anzeigen ('+errors+')';
            if (r.error) showStatus('error',r.error);
            if (!editor && (terms.length || errorsOnly)) scheduleFilter(false);
            return;
        }
        if (event==='sorting') showStatus('saving','Sortierung wird gespeichert …');
        if (event==='sorted') showStatus('saved','Sortierung gespeichert.');
        if (event==='sort-error') showStatus('error',message+' Sortierung nicht gespeichert.');
        applyFilters(false); updateProjectActions();
    });
    function done(r) { return /^(1|erledigt)$/i.test(r.values[store.index.PPShipment_ShipmentStatus]); }
    function updateProjectActions() {
        root.querySelector('.btn-add-shipment').disabled=!projectSelect.value || store.sorting();
        root.querySelector('.btn-archive-shipment').disabled=!projectSelect.value || store.sorting() || remoteActions > 0;
    }
    function paintCell(cell,r,i) {
        if (editor && editor.cell===cell) return;
        var f=config.fields[i], value=r.values[i];
        cell.textContent=value; cell.title=f.label+': '+(value || '—');
        cell.classList.toggle('is-dirty',value!==r.clean[i]);
        if (f.type==='col_YesNo') {
            cell.classList.toggle('is-yes',value==='Yes'); cell.classList.toggle('is-no',value!=='Yes');
            cell.setAttribute('aria-label',f.label+': '+(value==='Yes' ? 'Ja' : 'Nein')+'; Doppelklick zum Umschalten');
        }
    }
    function paintRow(node,r) {
        ['flag-eu','flag-os','flag-kritisch'].forEach(function (cls,i) { node.classList.toggle(cls,!!r.flags[i]); });
        node.classList.toggle('shipment-done',done(r));
        ['saving','saved','error'].forEach(function (s) { node.classList.toggle('is-'+s,r.state===s); });
        node.dataset.shipmentId=r.id;
        node.querySelectorAll('[data-flag-index]').forEach(function (b) { b.classList.toggle('is-active',!!r.flags[Number(b.dataset.flagIndex)]); });
        var complete=node.querySelector('.js-complete-shipment');
        complete.classList.toggle('is-open',done(r)); complete.title=done(r) ? 'Lot wieder öffnen' : 'Lot als erledigt markieren';
        node.querySelector('.js-retry-save').hidden=!r.error;
        node.querySelector('.js-retry-save').title=r.error || 'Erneut speichern';
        node.querySelectorAll('button').forEach(function (b) { b.disabled=r.busy; });
        node.querySelectorAll('[data-field-index]').forEach(function (cell) { paintCell(cell,r,Number(cell.dataset.fieldIndex)); });
        var log=node.querySelector('[data-head="log"]');
        if (!editor || editor.cell!==log) log.textContent=(config.projects[r.master] || {}).log || '—';
    }
    function makeRow(r) {
        var row=el('tr','shipment-sort-row js-shipment-row'); row.dataset.key=r.key; row.draggable=true;
        var handle=el('td','drag-cell'); handle.appendChild(el('span','drag-handle','☰')); handle.title='Shipment verschieben'; row.appendChild(handle);
        var actions=el('td','shipment-actions'), group=el('div','action-group');
        ['EU','OS','!'].forEach(function (name,i) {
            var b=button('btn btn-mini btn-lot-flag',name); b.dataset.flagIndex=i;
            b.dataset.flag=['EU_Serviceware','OSProjekt','KritischesProjekt'][i]; group.appendChild(b);
        });
        group.appendChild(button('btn btn-complete-icon js-complete-shipment','✓','Erledigt / offen'));
        group.appendChild(button('btn btn-danger-icon js-remove-shipment','×','Entfernen'));
        var retry=button('btn btn-mini js-retry-save','↻','Erneut speichern'); retry.hidden=true; group.appendChild(retry);
        actions.appendChild(group); row.appendChild(actions);
        var p=config.projects[r.master] || {};
        heads.forEach(function (key) {
            var cell=el('td','project-cell'); cell.dataset.head=key;
            if (key==='ian') {
                var link=el('a','btn btn-mini',String(p.ian || '').slice(0,6));
                link.href=config.urls.show+'/'+encodeURIComponent((p.ian || '')+'_'+(p.ausmusterung || ''));
                link.target='_blank'; link.rel='noopener'; cell.appendChild(link);
            } else { cell.textContent=p[key] || (key==='log' ? '—' : ''); cell.title=p[key] || ''; }
            if (key==='log') { cell.tabIndex=0; cell.classList.add('js-log-admin-text'); cell.title='Doppelklick oder Enter zum Bearbeiten'; }
            row.appendChild(cell);
        });
        config.fields.forEach(function (f,i) {
            var cell=el('td','editable-cell '+(f.type==='col_YesNo' ? 'yesno-cell' : ''));
            cell.dataset.fieldIndex=i; cell.dataset.field=f.key; cell.tabIndex=0; row.appendChild(cell);
        });
        paintRow(row,r); return row;
    }
    function spacer(key,height) {
        var node=nodes.get(key);
        if (!node) { node=el('tr','virtual-spacer'); var cell=el('td'); cell.colSpan=config.fields.length+10; node.appendChild(cell); node.setAttribute('aria-hidden','true'); }
        node.firstChild.style.height=height+'px'; return node;
    }
    function render() {
        frame=null;
        var headerHeight=table.tHead ? table.tHead.offsetHeight : 62;
        var start=printing ? 0 : Math.max(0,Math.floor(wrap.scrollTop/ROW_HEIGHT)-OVERSCAN);
        var count=Math.ceil(Math.max(ROW_HEIGHT,wrap.clientHeight-headerHeight)/ROW_HEIGHT)+OVERSCAN*2;
        start=Math.min(start,Math.max(0,filtered.length-1));
        var end=printing ? filtered.length : Math.min(filtered.length,start+count);
        var indices=[]; for (var i=start;i<end;i++) indices.push(i);
        [editor && editor.record,dragged].forEach(function (r) {
            if (!r) return; var index=filtered.indexOf(r);
            if (index>=0 && indices.indexOf(index)<0) indices.push(index);
        });
        indices.sort(function (a,b) { return a-b; });
        var desired=[], nextNodes=new Map(), nextRendered=new Map(), last=0;
        function push(key,node) { desired.push(node); nextNodes.set(key,node); }
        indices.forEach(function (index) {
            if (index>last) { var gap='gap-before-'+filtered[index].key; push(gap,spacer(gap,(index-last)*ROW_HEIGHT)); }
            var r=filtered[index], key='row-'+r.key, node=nodes.get(key) || makeRow(r);
            node.classList.toggle('stripe-even',index%2===1); node.setAttribute('aria-rowindex',index+2);
            push(key,node); nextRendered.set(r.key,node); last=index+1;
        });
        if (last<filtered.length) push('gap-tail',spacer('gap-tail',(filtered.length-last)*ROW_HEIGHT));
        if (!filtered.length) {
            var empty=nodes.get('empty') || el('tr','no-rows');
            if (!empty.firstChild) { var cell=el('td'); cell.colSpan=config.fields.length+10; empty.appendChild(cell); }
            empty.firstChild.textContent=store.all().length ? 'Keine Treffer für die gewählten Filter.' : 'Keine Lot-Daten vorhanden.';
            push('empty',empty);
        }
        nodes.forEach(function (node,key) { if (!nextNodes.has(key)) node.remove(); });
        var cursor=tbody.firstChild;
        desired.forEach(function (node) {
            if (node===cursor) cursor=cursor.nextSibling;
            else tbody.insertBefore(node,cursor);
        });
        nodes=nextNodes; rendered=nextRendered;
        table.setAttribute('aria-rowcount',filtered.length+1);
    }
    function requestRender() { if (frame===null) frame=window.requestAnimationFrame(render); }
    function readTerms() {
        return filters.map(function (input) {
            var term={value:input.value.trim().toLowerCase()};
            if (input.dataset.shipmentFilter) term.index=store.index[input.dataset.shipmentFilter]; else term.key=input.dataset.filter;
            return term;
        }).filter(function (term) { return !!term.value; });
    }
    function applyFilters(resetScroll) {
        if (editor && !resetScroll) return;
        clearTimeout(filterTimer); terms=readTerms(); filtered=store.filter(terms,errorsOnly);
        if (resetScroll) wrap.scrollTop=0;
        root.querySelector('#filter-count').textContent=filtered.length+' / '+store.all().length+' Shipments'; requestRender();
    }
    function scheduleFilter(resetScroll) { clearTimeout(filterTimer); filterTimer=setTimeout(function () { applyFilters(resetScroll); },200); }
    function resetFilters() { filters.forEach(function (f) { f.value=''; }); errorsOnly=false; applyFilters(true); }
    function selectProject(r) { projectSelect.value=r.master; updateProjectActions(); }
    function recordFrom(node) { var row=node.closest('.js-shipment-row'); return row ? store.get(row.dataset.key) : null; }
    function commitEditor() {
        if (!editor) return;
        var active=editor; editor=null;
        if (active.kind==='field') {
            var value=active.input.value;
            if (config.fields[active.index].type==='number') value=value.replace(',','.');
            store.set(active.record,active.index,value);
            active.cell.replaceChildren(); paintCell(active.cell,active.record,active.index);
            store.save(active.record).catch(function () {});
        } else active.cell.textContent=(config.projects[active.record.master] || {}).log || '—';
        active.cell.classList.remove('editing'); if (terms.length) scheduleFilter(false);
    }
    function openEditor(cell,r,index,kind) {
        if (r.busy || (editor && editor.cell===cell)) return;
        commitEditor(); var input;
        if (kind==='log') {
            input=el('select','cell-editor'); input.appendChild(new Option('—',''));
            Object.keys(config.logMa).forEach(function (id) { input.appendChild(new Option(config.logMa[id],id,false,config.logMa[id]===(config.projects[r.master] || {}).log)); });
        } else {
            var f=config.fields[index]; if (f.type==='col_YesNo') return;
            input=el('input','cell-editor'); input.type=f.type==='date' ? 'date' : 'text'; input.value=r.values[index];
            input.setAttribute('aria-label',f.label); input.autocomplete='off';
            if (f.type==='number') input.setAttribute('inputmode','decimal');
            if (f.type==='textCombo') input.setAttribute('list','ship-options-'+f.key);
        }
        editor={cell:cell,record:r,index:index,input:input,kind:kind || 'field'};
        cell.classList.add('editing'); cell.replaceChildren(input);
        // Native focus scrolling does not account for the five sticky columns.
        var bounds=wrap.getBoundingClientRect(), rect=cell.getBoundingClientRect();
        var frozenWidth=config.headWidths.slice(0,5).reduce(function (sum,width) { return sum+width; },0);
        if (rect.left<bounds.left+frozenWidth+1) wrap.scrollLeft-=bounds.left+frozenWidth+1-rect.left;
        else if (rect.right>bounds.right-18) wrap.scrollLeft+=rect.right-bounds.right+18;
        input.focus({preventScroll:true});
        if (input.select && input.type==='text') input.select();
    }
    function toggleYesNo(cell,r) { commitEditor(); var i=Number(cell.dataset.fieldIndex); store.set(r,i,r.values[i]==='Yes' ? '' : 'Yes'); store.schedule(r); }
    function saveLog(active) {
        var r=active.record,id=active.input.value,label=id ? active.input.options[active.input.selectedIndex].text : '';
        editor=null; active.cell.classList.remove('editing'); active.cell.textContent=(config.projects[r.master] || {}).log || '—';
        remoteActions++; updateProjectActions();
        request(config.urls.log,{PPProduktpass_Id:r.master,PPMitarbeiter_Id:id}).then(function (result) {
            if (!result.success) throw new Error(result.message || 'LOG konnte nicht gespeichert werden.');
            config.projects[r.master].log=label; store.refreshProjects();
            rendered.forEach(function (node,key) { var row=store.get(key); if (row.master===r.master) paintRow(node,row); });
            applyFilters(false); showStatus('saved','Logistik-Mitarbeiter gespeichert.');
        }).catch(function (error) { showStatus('error',error.message); }).then(function () { remoteActions--; updateProjectActions(); });
    }
    root.addEventListener('input',function (event) {
        if (event.target.matches('.head-filter')) { scheduleFilter(true); return; }
        if (editor && event.target===editor.input && editor.kind==='field') {
            var value=editor.input.value; if (config.fields[editor.index].type==='number') value=value.replace(',','.');
            store.set(editor.record,editor.index,value); store.schedule(editor.record);
        }
    });
    root.addEventListener('change',function (event) {
        if (event.target.matches('.head-filter')) { scheduleFilter(true); return; }
        if (event.target===projectSelect) updateProjectActions();
        if (editor && event.target===editor.input) {
            if (editor.kind==='log') saveLog(editor);
            else {
                var value=editor.input.value;
                if (config.fields[editor.index].type==='number') value=value.replace(',','.');
                store.set(editor.record,editor.index,value); store.schedule(editor.record);
            }
        }
    });
    root.addEventListener('focusout',function (event) { if (editor && event.target===editor.input) commitEditor(); });
    root.addEventListener('keydown',function (event) {
        var cell=event.target.closest('[data-field-index], [data-head="log"]');
        if (editor && event.target===editor.input) {
            if (event.key==='Enter' || event.key==='Tab') {
                event.preventDefault(); var active=editor, next=active.index+(event.shiftKey ? -1 : 1); commitEditor();
                var row=rendered.get(active.record.key);
                if (row && next>=0 && next<config.fields.length) { var nextCell=row.querySelector('[data-field-index="'+next+'"]'); nextCell.focus(); openEditor(nextCell,active.record,next); }
            } else if (event.key==='Escape') { event.preventDefault(); commitEditor(); cell.focus(); }
            return;
        }
        if (cell && (event.key==='Enter' || event.key==='F2' || event.key===' ')) {
            event.preventDefault(); var r=recordFrom(cell);
            if (cell.dataset.head==='log') openEditor(cell,r,undefined,'log');
            else if (config.fields[Number(cell.dataset.fieldIndex)].type==='col_YesNo') toggleYesNo(cell,r);
            else openEditor(cell,r,Number(cell.dataset.fieldIndex));
        }
    });
    root.addEventListener('dblclick',function (event) {
        var cell=event.target.closest('[data-field-index], [data-head="log"]'); if (!cell) return;
        var r=recordFrom(cell); if (!r || r.busy) return;
        if (cell.dataset.head==='log') openEditor(cell,r,undefined,'log');
        else if (config.fields[Number(cell.dataset.fieldIndex)].type==='col_YesNo') toggleYesNo(cell,r);
    });
    root.addEventListener('click',function (event) {
        var r=recordFrom(event.target); if (r) selectProject(r);
        var cell=event.target.closest('[data-field-index]');
        if (cell && r && config.fields[Number(cell.dataset.fieldIndex)].type!=='col_YesNo') openEditor(cell,r,Number(cell.dataset.fieldIndex));
        var b=event.target.closest('button'); if (!b || b.disabled) return;
        if (b.id==='filter-reset') { commitEditor(); resetFilters(); }
        if (b.id==='show-save-errors') { commitEditor(); filters.forEach(function (f) { f.value=''; }); errorsOnly=true; applyFilters(true); }
        if (b.matches('.btn-add-shipment')) {
            commitEditor(); resetFilters(); var added=store.add(projectSelect.value);
            applyFilters(false); wrap.scrollTop=Math.max(0,(filtered.length-1)*ROW_HEIGHT); render();
            // Scroll after spacer height has been updated as well.
            wrap.scrollTop=Math.max(0,(filtered.length-1)*ROW_HEIGHT); render();
            var addedCell=rendered.get(added.key).querySelector('[data-field-index="0"]'); openEditor(addedCell,added,0);
        }
        if (b.matches('.btn-lot-flag')) { commitEditor(); store.flag(r,Number(b.dataset.flagIndex)); }
        if (b.matches('.js-retry-save')) { commitEditor(); store.save(r).catch(function () {}); store.retryOrder(); }
        if (b.matches('.js-complete-shipment')) {
            commitEditor(); if (!window.confirm(done(r) ? 'Lot als offen markieren?' : 'Lot als erledigt markieren?')) return;
            store.complete(r).catch(function (error) { showStatus('error',error.message); });
        }
        if (b.matches('.js-remove-shipment')) {
            commitEditor(); if (!window.confirm('Position löschen?')) return;
            store.remove(r).catch(function (error) { showStatus('error',error.message); });
        }
        if (b.matches('.btn-archive-shipment')) {
            commitEditor(); var id=projectSelect.value;
            if (!id || !window.confirm('Projekt '+config.projects[id].ian+' archivieren?')) return;
            if (store.pending() || remoteActions) { showStatus('error','Bitte laufende Änderungen zuerst speichern.'); return; }
            remoteActions++; updateProjectActions();
            request(config.urls.archive,{PPProduktpass_Id:id}).then(function () { remoteActions--; window.location.reload(); })
                .catch(function (error) { remoteActions--; updateProjectActions(); showStatus('error',error.message); });
        }
    });
    function stopDrag() { dragged=null; allowed=null; dragSpeed=0; if (dragFrame!==null) cancelAnimationFrame(dragFrame); dragFrame=null; requestRender(); }
    function dragScroll() {
        if (!dragged || !dragSpeed) { dragFrame=null; return; }
        wrap.scrollTop+=dragSpeed; requestRender(); dragFrame=requestAnimationFrame(dragScroll);
    }
    tbody.addEventListener('mousedown',function (event) { allowed=event.target.closest('.drag-handle') ? recordFrom(event.target) : null; });
    document.addEventListener('mouseup',function () { allowed=null; });
    tbody.addEventListener('dragstart',function (event) {
        var r=recordFrom(event.target);
        if (!r || r!==allowed || !store.canSort()) { event.preventDefault(); if (r===allowed) showStatus('error','Neue Lots zuerst speichern und laufende Vorgänge abwarten.'); return; }
        commitEditor(); dragged=r; event.dataTransfer.effectAllowed='move'; event.dataTransfer.setData('text/plain',r.id);
    });
    wrap.addEventListener('dragover',function (event) {
        if (!dragged) return; event.preventDefault(); var rect=wrap.getBoundingClientRect(), header=table.tHead.offsetHeight;
        dragSpeed=event.clientY<rect.top+header+45 ? -14 : event.clientY>rect.bottom-45 ? 14 : 0;
        if (dragSpeed && dragFrame===null) dragFrame=requestAnimationFrame(dragScroll);
    });
    wrap.addEventListener('drop',function (event) {
        if (!dragged) return; event.preventDefault();
        var source=dragged, target=recordFrom(event.target), row=event.target.closest('.js-shipment-row');
        var after=row ? event.clientY>row.getBoundingClientRect().top+ROW_HEIGHT/2 : false; stopDrag();
        if (target) store.move(source,target,after).catch(function () {});
    });
    tbody.addEventListener('dragend',stopDrag);
    wrap.addEventListener('scroll',requestRender,{passive:true}); window.addEventListener('resize',requestRender);
    window.addEventListener('beforeunload',function (event) { if (!store.pending() && !remoteActions) return; event.preventDefault(); event.returnValue=''; });
    window.addEventListener('beforeprint',function () { commitEditor(); printing=true; render(); });
    window.addEventListener('afterprint',function () { printing=false; render(); });
    var left=0;
    config.headWidths.slice(0,5).forEach(function (width,i) { table.style.setProperty('--frozen-left-'+(i+1),left+'px'); left+=width; });
    applyFilters(true); updateProjectActions(); render();
})();
</script>
