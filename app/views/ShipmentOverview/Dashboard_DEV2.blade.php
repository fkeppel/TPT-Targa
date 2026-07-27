{{-- resources/views/projekts/index.blade.php --}}
<style>
    :root {
        --bg-color: rgba(105, 162, 241, 0.28);
        --bg-colorHigh: rgba(105, 162, 241, 0.14);
        --bg-colorSticky: rgba(218, 234, 255, 1);
        --bg-colorStickyHigh: rgba(235, 244, 255, 1);
        --active-row: rgba(105, 162, 241, 0.35);
        --active-border: #2264af;
    }
    .container{
        padding: 20px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 1em;
    }
    .table-wrap{
        height: 90vh;
        overflow: auto;
        border: 1px solid #ddd;
        background: #fff;
    }
    .big-table{
        border-collapse: separate;
        border-spacing: 0;
        min-width: 100%;
        width: 100%;
        font-size: 12px;
        table-layout: auto;
    }
    .big-table th, .big-table td{
        padding: 8px 10px;
        border-right: 1px solid #eee;
        border-bottom: 1px solid #eee;
        white-space: nowrap;
        background: transparent;
        vertical-align: top;
    }
    .big-table thead th{
        position: sticky;
        top: 0;
        z-index: 50;
        background: #f7f7f7;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }
    .big-table thead th .th-label{
        display:block;
        margin-bottom:4px;
    }
    .big-table thead th .head-filter{
        width:100%;
        box-sizing:border-box;
        padding:4px 6px;
        border:1px solid #d0d0d0;
        border-radius:4px;
        font-size:11px;
    }
    .muted{ color:#777; font-size: 12px; }
    .center{ text-align:center; }
    .row-toggle { cursor: pointer; }
    .row-toggle:hover td { filter: brightness(0.985); }
    .detail-row[hidden] { display: none; }
    .detail-cell {
        padding: 0;
        background: #fff;
        max-width: 0;
    }
    .detail-scroll{
        overflow-x: auto;
        overflow-y: hidden;
        width: 100%;
        max-width: none;
        padding-bottom: 8px;
    }
    .detail-content{
        padding: 12px;
        width: 100%;
        box-sizing: border-box;
    }
    .chevron {
        display: inline-block;
        width: 18px;
        text-align: center;
        margin-right: 6px;
        cursor: pointer;
    }
    .inner-table{
        border-collapse: separate;
        border-spacing: 0;
        width: max-content;
        min-width: 100%;
        font-size: 12px;
        margin-top: 8px;
    }
    .inner-table th,
    .inner-table td{
        padding: 4px 8px;
        border-right: 1px solid #eee;
        border-bottom: 1px solid #eee;
        white-space: nowrap;
        height: 26px;
        vertical-align: middle;
    }
    .inner-table thead th{
        background: #f7f7f7;
        color: #1e5fb8;
        font-weight: 600;
        position: sticky;
        top: 0;
        z-index: 1;
        text-align: left;
    }
    .filter-bar{
        display: flex;
        gap: 12px;
        align-items: end;
        margin: 0 0 12px 0;
        flex-wrap: wrap;
    }
    .filter-field{
        display:flex;
        flex-direction:column;
        gap:6px;
    }
    .filter-field label{
        font-size:12px;
        color:#444;
    }
    .filter-field input{
        padding: 8px 10px;
        border: 1px solid #d0d0d0;
        border-radius: 6px;
        min-width: 220px;
        font-size: 12px;
    }
    .filter-actions{
        display:flex;
        gap:10px;
    }
    .btn{
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
    .btn:hover{ background:#f7f7f7; }
    .btn-mini{
        padding: 2px 8px;
        font-size: 11px;
        line-height: 1.2;
        height: 22px;
    }
    .inner-table td {
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .inner-table td input.js-ship-input {
        width: 100%;
        height: 22px;
        border: 1px solid #d0d0d0;
        background: #fff;
        font-size: 11px;
        line-height: 1.2;
        padding: 1px 4px;
        box-sizing: border-box;
    }
    .inner-table td input.js-ship-input.is-dirty {
        outline: 2px solid #ffe08a;
        outline-offset: -2px;
        background: #fffdf3;
    }
    .inner-table td input.js-ship-input:focus {
        outline-offset: -2px;
    }
    .inner-table td.col-text-sm,
    .inner-table th.col-text-sm { min-width: 110px; }
    .inner-table td.col-text-md,
    .inner-table th.col-text-md { min-width: 140px; }
    .inner-table td.col-text-lg,
    .inner-table th.col-text-lg { min-width: 180px; }
    .inner-table td.col-wide,
    .inner-table th.col-wide { min-width: 220px; }
    .inner-table td.col-status,
    .inner-table th.col-status { min-width: 200px; }
    .inner-table td.col-number,
    .inner-table th.col-number { min-width: 95px; }
    .inner-table td.col-number-lg,
    .inner-table th.col-number-lg { min-width: 120px; }
    .inner-table td.col-date,
    .inner-table th.col-date { min-width: 135px; }
    .inner-table td.col-date input.js-ship-input[type="date"] {
        min-width: 135px;
    }
    tr.is-saving td { opacity: .6; }
    tr.is-saved td  { outline: 2px solid #9fe6b8; outline-offset: -2px; }
    tr.is-error td  { outline: 2px solid #ff9a9a; outline-offset: -2px; }
    .inner-table tbody tr:hover td {
        background: rgba(0,0,0,0.02);
    }
    .row-toggle[aria-expanded="true"] td {
        background: var(--active-row) !important;
    }
    .row-toggle[aria-expanded="true"] td:first-child {
        box-shadow: inset 4px 0 0 var(--active-border);
    }
    .row-toggle[aria-expanded="true"]:hover td {
        filter: none;
    }
    .row-toggle.has-shipments td:first-child {
        box-shadow: inset 6px 0 0 #3aa76d;
    }
    .row-toggle.has-shipments:hover td {
        background-color: rgba(58,167,109,0.08);
    }
    .date-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .date-wrapper input {
        padding-right: 26px;
    }
    .date-icon {
        position: absolute;
        right: 6px;
        width: 14px;
        height: 14px;
        cursor: pointer;
        opacity: 0.6;
    }
    .date-icon:hover {
        opacity: 1;
    }
    .flag-cell{
        display:flex;
        align-items:center;
        gap:4px;
        white-space:nowrap;
    }
    .filler-col{
        width: 100%;
        min-width: 200px;
    }
    .lot-flag-cell{
        white-space:nowrap;
    }
    .btn-lot-flag.is-active[data-flag="EU_Serviceware"]{
        background:#ff9800;
        color:white;
    }
    .btn-lot-flag.is-active[data-flag="OSProjekt"]{
        background:#380694;
        color:white;
    }
    .btn-lot-flag.is-active[data-flag="KritischesProjekt"]{
        background:#f44336;
        color:white;
    }
    .js-shipment-row.flag-eu td{
        background:#ff9800;
    }
    .js-shipment-row.flag-usa td{
        background:#380694;
    }
    .js-shipment-row.flag-kritisch td{
        background:#f44336;
    }
    .js-shipment-row {
        --marker-eu: transparent;
        --marker-usa: transparent;
        --marker-kritisch: transparent;
    }
    .js-shipment-row.flag-eu {
        --marker-eu: #ff9800;
    }
    .js-shipment-row.flag-usa {
        --marker-usa: #380694;
    }
    .js-shipment-row.flag-kritisch {
        --marker-kritisch: #f44336;
    }
    .js-shipment-row.shipment-done td{
        background:#c8f0c8 !important;
    }
    .js-shipment-row td[data-field="PPShipment_Lot"] {
        box-shadow:
            inset 8px 0 0 var(--marker-eu),
            inset 16px 0 0 var(--marker-usa),
            inset 24px 0 0 var(--marker-kritisch);
        padding-left: 36px;
    }
    .inner-table td.col-YesNo {
        padding: 0;
        min-width: 70px;
        max-width: 70px;
    }
    .col-YesNo {
        width: 50px !important;
        min-width: 50px !important;
        max-width: 50px !important;
    }
    .js-yesno {
        width: 100%;
        height: 100%;
        min-height: 26px;
        border: none;
        cursor: pointer;
        font-size: 11px;
        font-weight: bold;
    }
    .js-yesno.is-yes {
        background: #b8efb8;
        color: #056005;
    }
    .js-yesno.is-no {
        background: #ffb3b3;
        color: #900;
    }
    .js-yesno.is-dirty{
        outline:2px solid #ffe08a;
        outline-offset:-2px;
    }
    .btn-danger-icon {
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
    .btn-danger-icon:hover {
        background: #c82333;
    }
    .btn-danger-icon:active {
        background: #bd2130;
    }
    .btn-danger-icon:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(220,53,69,.3);
    }
    .btn-danger-icon svg {
        display: block;
    }
    /* Projekt-Accordion */
    .project-accordion{
        width:100%;
        min-width:980px;
        background:#fff;
    }
    .accordion-head,
    .accordion-summary{
        display:grid;
        grid-template-columns: 34px 95px 105px 380px 72px 84px 84px 60px 70px minmax(100px, 1fr);
        align-items:stretch;
        width:100%;
        box-sizing:border-box;
    }
    .accordion-head{
        position:sticky;
        top:0;
        z-index:50;
        background:#f7f7f7;
        border-bottom:1px solid #ddd;
    }
    .accordion-head > div,
    .accordion-summary > div{
        min-width:0;
        padding:8px 10px;
        border-right:1px solid #eee;
        border-bottom:1px solid #eee;
        box-sizing:border-box;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
        font-size:12px;
    }
    .accordion-head .head-filter{
        width:100%;
        box-sizing:border-box;
        padding:4px 6px;
        border:1px solid #d0d0d0;
        border-radius:4px;
        font-size:11px;
    }
    .accordion-filler{
        min-width:100px;
        border-right:0 !important;
        background:transparent;
    }
    .accordion-summary{
        cursor:pointer;
    }
    .accordion-summary:hover > div{
        filter:brightness(.985);
    }
    .accordion-summary[aria-expanded="true"] > div{
        background:var(--active-row) !important;
    }
    .accordion-summary[aria-expanded="true"] > div:first-child{
        box-shadow:inset 4px 0 0 var(--active-border);
    }
    .accordion-summary.has-shipments > div:first-child{
        box-shadow:inset 6px 0 0 #3aa76d;
    }
    .accordion-panel[hidden]{
        display:none;
    }
    .accordion-panel{
        width:100%;
        box-sizing:border-box;
        border-bottom:1px solid #ccd8eb;
        background:#fff;
    }
    .accordion-panel .detail-content{
        width:100%;
        max-width:none;
        box-sizing:border-box;
        padding:12px 20px;
    }
    .accordion-panel .detail-scroll{
        width:100%;
        max-width:none;
        overflow-x:auto;
        overflow-y:hidden;
    }
    .accordion-panel .inner-table{
        min-width:100%;
        width:max-content;
    }
    .accordion-empty{
        padding:20px;
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
    $projekts  = $data['ppData']['kopf'];
    $shipments = isset($data['ppData']['ship']) ? $data['ppData']['ship'] : array();
    $masterKey = 'PPProduktpass_Id';
    $detailKey = 'PPProduktpass_Id';
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
    $SHIP_FIELDS_JSON  = htmlspecialchars(json_encode($SHIP_FIELDS), ENT_QUOTES, 'UTF-8');
    $SHIP_OPTIONS_JSON = htmlspecialchars(json_encode($SHIP_OPTIONS), ENT_QUOTES, 'UTF-8');
?>
<h1 class='page-title'>{{ $data['title'] }} </h1>
<div class="container">
     <div class="filter-bar" role="region" aria-label="Filter">
        <div class="filter-actions">
            <button type="button" class="btn" id="filter-reset">Reset</button>
            <a href="{{ URL::to('/shipFlat') }}" class="btn">Flat View</a>
            <a href="{{ URL::to('/shipArchive') }}" class="btn">Archive</a>
        </div>
        <div class="muted" id="filter-count" aria-live="polite"></div>
    </div>
   <div class="table-wrap">
        <div class="project-accordion" id="projekts-table" aria-label="Kopfdaten">
            <div class="accordion-head">
                <div></div>
                <div>
                    <div class="th-label">IAN</div>
                    <input class="head-filter" data-filter="ian">
                </div>
                <div>
                    <div class="th-label">Ausmusterung</div>
                    <input class="head-filter" data-filter="ausmusterung">
                </div>
                <div>
                    <div class="th-label">Artikelbezeichnung</div>
                    <input class="head-filter" data-filter="artikel">
                </div>
                <div>
                    <div class="th-label">Status</div>
                    <input class="head-filter" data-filter="status">
                </div>
                <div>
                    <div class="th-label">PM</div>
                    <input class="head-filter" data-filter="pm">
                </div>
                <div>
                    <div class="th-label">TC</div>
                    <input class="head-filter" data-filter="tc">
                </div>
                <div>
                    <div class="th-label">PJM</div>
                    <input class="head-filter" data-filter="pjm">
                </div>
                <div>
                    <div class="th-label">LOG</div>
                    <input class="head-filter" data-filter="log">
                </div>
                <div class="accordion-filler" aria-hidden="true"></div>
            </div>
                <?php
                    $prevIan = null;
                    $bgVar = '--bg-colorHigh';
                ?>
                @forelse($projekts as $projekt)
                    <?php
                        $masterVal = isset($projekt->{$masterKey}) ? $projekt->{$masterKey} : null;
                        if ($masterVal !== null && $masterVal !== '') {
                            $detailRowId = 'details-' . preg_replace('/\W+/', '-', (string)$masterVal);
                        } else {
                            $detailRowId = 'details-' . uniqid();
                        }
                        $projektShipments = array_filter($shipments, function ($s) use ($masterVal, $detailKey) {
                            if ($masterVal === null || $masterVal === '') return false;
                            if (!is_object($s) || !isset($s->{$detailKey})) return false;
                            return (string)$s->{$detailKey} === (string)$masterVal;
                        });
                        $projektShipments = array_values($projektShipments);
                        $hasShip = count($projektShipments) > 0;
                        $curIan = isset($projekt->IAN) ? (string)$projekt->IAN : '';
                        if ($prevIan === null) $prevIan = $curIan;
                        if ($curIan !== $prevIan) {
                            $bgVar = ($bgVar === '--bg-colorHigh') ? '--bg-color' : '--bg-colorHigh';
                            $prevIan = $curIan;
                        }
                        $ianVal = isset($projekt->IAN) ? trim((string)$projekt->IAN) : '';
                        $artVal = isset($projekt->Artikelbezeichnung) ? trim((string)$projekt->Artikelbezeichnung) : '';
                        $ausVal = isset($projekt->Ausmusterung) ? trim((string)$projekt->Ausmusterung) : '';
                        $statusVal = isset($projekt->TargaStatus) ? trim((string)$projekt->TargaStatus) : '';
                        $pmVal = isset($projekt->PMAdmin) ? trim((string)$projekt->PMAdmin) : '';
                        $tcVal = isset($projekt->TCAdmin) ? trim((string)$projekt->TCAdmin): '';
                        $pjmVal = isset($projekt->PJMAdmin) ? trim((string)$projekt->PJMAdmin) : '';
                        $logVal = isset($projekt->LogAdmin) ? trim((string)$projekt->LogAdmin) : '';
                    ?>
                    <section class="accordion-item">
                        <div class="row-toggle accordion-summary {{ $hasShip ? 'has-shipments' : '' }}"
                            data-target="{{ $detailRowId }}"
                            data-ian="{{ e($ianVal) }}"
                            data-artikel="{{ e($artVal) }}"
                            data-ausmusterung="{{ e($ausVal) }}"
                            data-status="{{ e($statusVal) }}"
                            data-pm="{{ e($pmVal) }}"
                            data-tc="{{ e($tcVal) }}"
                            data-pjm="{{ e($pjmVal) }}"
                            data-log="{{ e($logVal) }}"
                            aria-expanded="false"
                            role="button"
                            tabindex="0"
                            style="background-color: var({{ $bgVar }});">
                            <div class="chevron-cell"><span class="chevron">▸</span></div>
                            <div>{{ $projekt->IAN }}</div>
                            <div>{{ $projekt->Ausmusterung }}</div>
                            <div>{{ $projekt->Artikelbezeichnung }}</div>
                            <div>{{ $projekt->TargaStatus }}</div>
                            <div>{{ $projekt->PMAdmin }}</div>
                            <div>{{ $projekt->TCAdmin }}</div>
                            <div>{{ $projekt->PJMAdmin }}</div>
                            <div class="js-log-admin-cell">
                                <span class="js-log-admin-text" title="Doppelklick zum Bearbeiten">
                                    {{ $projekt->LogAdmin ? $projekt->LogAdmin : '—' }}
                                </span>
                                <select class="js-log-admin"
                                        data-produktpass-id="{{ $projekt->PPProduktpass_Id }}"
                                        style="display:none;">
                                    @foreach($data['logMa'] as $maid => $logma)
                                        <option value="{{ $maid }}"
                                            {{ isset($projekt->LogAdmin) && $projekt->LogAdmin == $logma ? 'selected' : '' }}>
                                            {{ $logma }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="accordion-filler" aria-hidden="true"></div>
                        </div>
                        <div id="{{ $detailRowId }}" class="detail-row accordion-panel" hidden>
                    <div class="detail-content" style="background-color: var({{ $bgVar }});">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div class="muted">Lot-Daten</div>
                            <button type="button"
                                    class="btn btn-add-shipment"
                                    data-master-id="{{ $masterVal }}"
                                    data-save-url="{{ URL::to('/saveLot') }}"
                                    data-delete-url="{{ URL::to('/deleteLot') }}"
                                    data-fields="{{ $SHIP_FIELDS_JSON }}"
                                    data-options="{{ $SHIP_OPTIONS_JSON }}">
                                Add
                            </button>
                            <button type="button"
                                    class="btn btn-archive-shipment"
                                    data-master-id="{{ $masterVal }}"
                                    data-archive-url="{{ URL::to('shipmentArchive') }}">
                                Archivieren
                            </button>
                        </div>
                        <div class="detail-scroll">
                            <table class="inner-table" aria-label="Lot-Daten">
                                <thead>
                                    <tr>
                                        @foreach($SHIP_FIELDS as $f)
                                            <th class="{{ e(isset($f['class']) ? $f['class'] : '') }}"
                                                title="{{ e($f['label']) }}">
                                                <span>{{ $f['label'] }}</span>
                                            </th>
                                        @endforeach
                                        <th>Aktionen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($projektShipments as $shipment)
                                        <?php
                                            $shipId = is_array($shipment)
                                                ? (isset($shipment['PPShipment_Id']) ? $shipment['PPShipment_Id'] : null)
                                                : (isset($shipment->PPShipment_Id) ? $shipment->PPShipment_Id : null);
                                        ?>
                                        <tr class="js-shipment-row {{ strtolower(trim($shipment->PPShipment_ShipmentStatus ?? '')) == 'erledigt' ? 'shipment-done' : '' }}"
                                            data-shipment-id="{{ $shipId }}"
                                            data-master-id="{{ $masterVal }}"
                                            data-eu-serviceware="{{ !empty($shipment->PPShipment_Flag_EUService) ? 1 : 0 }}"
                                            data-os-projekt="{{ !empty($shipment->PPShipment_Flag_OS) ? 1 : 0 }}"
                                            data-kritisches-projekt="{{ !empty($shipment->PPShipment_Flag_Critical) ? 1 : 0 }}">
                                            @foreach($SHIP_FIELDS as $f)
                                                <?php
                                                    $k = $f['key'];
                                                    if (is_array($shipment)) {
                                                        $val = isset($shipment[$k]) ? $shipment[$k] : null;
                                                    } else {
                                                        $val = isset($shipment->$k) ? $shipment->$k : null;
                                                    }
                                                    if ($val && $f['type'] === 'date') {
                                                        $ts = strtotime($val);
                                                        if ($ts) {
                                                            $val = date('Y-m-d', $ts);
                                                        } else {
                                                            $val = '';
                                                        }
                                                    }
                                                    $inputValue = e((string)$val);
                                                    $fieldClass = e(isset($f['class']) ? $f['class'] : '');
                                                ?>
                                                <td data-field="{{ $k }}"
                                                    data-type="{{ $f['type'] }}"
                                                    class="{{ $fieldClass }}">
                                                    @if($f['type'] === 'textCombo')
                                                        <?php
                                                            $options = isset($SHIP_OPTIONS[$k]) ? $SHIP_OPTIONS[$k] : array();
                                                            $listId = 'dl-' . preg_replace('/[^a-zA-Z0-9\-_]/', '-', $k) . '-' . ($shipId ? $shipId : uniqid());
                                                        ?>
                                                        <input type="text"
                                                            class="js-ship-input"
                                                            list="{{ $listId }}"
                                                            value="{{ $inputValue }}"
                                                            data-field="{{ $k }}"
                                                            data-type="{{ $f['type'] }}"
                                                            data-original="{{ $inputValue }}"
                                                            autocomplete="off">
                                                        <datalist id="{{ $listId }}">
                                                            @foreach($options as $opt)
                                                                <option value="{{ $opt }}"></option>
                                                            @endforeach
                                                        </datalist>
                                                    @elseif($f['type'] === 'date')
                                                        <div class="date-wrapper">
                                                            <input type="text"
                                                                class="js-ship-input js-date-text"
                                                                value="{{ $inputValue }}"
                                                                data-field="{{ $k }}"
                                                                data-type="{{ $f['type'] }}"
                                                                data-original="{{ $inputValue }}"
                                                                placeholder="">
                                                            <input type="date"
                                                                class="js-date-hidden"
                                                                style="position:absolute; opacity:0; pointer-events:none;">
                                                            <svg class="date-icon js-date-trigger" viewBox="0 0 24 24">
                                                                <path fill="currentColor"
                                                                    d="M7 10h5v5H7zM19 4h-1V2h-2v2H8V2H6v2H5c-1.1 
                                                                    0-2 .9-2 2v14c0 1.1.9 2 2 
                                                                    2h14c1.1 0 2-.9 
                                                                    2-2V6c0-1.1-.9-2-2-2zm0 
                                                                    16H5V9h14v11z"/>
                                                            </svg>
                                                        </div>
                                                    @elseif($f['type'] === 'col_YesNo')
                                                        <?php
                                                            $yesNoValue = (!empty($val) && (int)$val === 1) ? 'Yes' : '';
                                                            $yesNoClass = $yesNoValue === 'Yes' ? 'is-yes' : 'is-no';
                                                            $yesNoText = $yesNoValue === 'Yes' ? 'Yes' : '';
                                                        ?>
                                                        <button type="button"
                                                                class="js-ship-input js-yesno {{ $yesNoClass }}"
                                                                value="{{ $yesNoValue }}"
                                                                data-field="{{ $k }}"
                                                                data-type="{{ $f['type'] }}"
                                                                data-original="{{ $yesNoValue }}"
                                                                title="{{ e($f['label']) }}">
                                                            {{ $yesNoText }}
                                                        </button>
                                                    @elseif($f['type'] === 'number')
                                                        <input type="number"
                                                            step="any"
                                                            class="js-ship-input"
                                                            value="{{ $inputValue }}"
                                                            data-field="{{ $k }}"
                                                            data-type="{{ $f['type'] }}"
                                                            data-original="{{ $inputValue }}"
                                                            inputmode="decimal">
                                                    @else
                                                        <input type="text"
                                                            class="js-ship-input"
                                                            value="{{ $inputValue }}"
                                                            data-field="{{ $k }}"
                                                            data-type="{{ $f['type'] }}"
                                                            data-original="{{ $inputValue }}"
                                                            autocomplete="off">
                                                    @endif
                                                </td>
                                            @endforeach
                                                <td>
                                                    <button type="button"
                                                            class="btn btn-mini btn-lot-flag {{ !empty($shipment->PPShipment_Flag_EUService) ? 'is-active' : '' }}"
                                                            data-flag="EU_Serviceware">
                                                        EU
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-mini btn-lot-flag {{ !empty($shipment->PPShipment_Flag_OS) ? 'is-active' : '' }}"
                                                            data-flag="OSProjekt">
                                                        OS
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-mini btn-lot-flag {{ !empty($shipment->PPShipment_Flag_Critical) ? 'is-active' : '' }}"
                                                            data-flag="KritischesProjekt">
                                                        !
                                                    </button>
                                                    <button
                                                    type="button"
                                                    class="btn btn-danger-icon js-remove-shipment"
                                                    data-delete-url="{{ URL::to('/deleteLot') }}"
                                                    aria-label="Entfernen"
                                                    title="Entfernen"
                                                >
                                                    <svg
                                                        width="12"
                                                        height="12"
                                                        viewBox="0 0 24 24"
                                                        aria-hidden="true"
                                                        focusable="false"
                                                    >
                                                        <path
                                                            d="M6 6L18 18M18 6L6 18"
                                                            fill="none"
                                                            stroke="#fff"
                                                            stroke-width="3"
                                                            stroke-linecap="round"
                                                        />
                                                    </svg>
                                                </button>
                                                </td>
                                        </tr>
                                    @empty
                                        <tr class="no-rows">
                                            <td colspan="{{ count($SHIP_FIELDS) + 2 }}" class="muted">Keine Lot-Daten vorhanden.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                        </div>
                    </section>
                @empty
                    <div class="muted center accordion-empty">Keine Projekte vorhanden.</div>
                @endforelse
        </div>
    </div>
</div>
<script>
    if (window.__PP_SHIP_SCRIPT_BOUND__) {
        console.warn('PP shipment script already bound - skipping duplicate bind.');
    } else {
        window.__PP_SHIP_SCRIPT_BOUND__ = true;
        document.querySelectorAll(".row-toggle").forEach(function (row) {
            row.addEventListener("click", function (e) {
                if (e.target.closest('input, select, button, datalist, svg, path, .js-log-admin-text')) return;
                var targetId = row.getAttribute("data-target");
                var detailsRow = document.getElementById(targetId);
                if (!detailsRow) return;
                var isHidden = detailsRow.hasAttribute("hidden");
                if (isHidden) {
                    document.querySelectorAll(".row-toggle").forEach(function(otherRow){
                        if (otherRow === row) return;
                        otherRow.setAttribute("aria-expanded", "false");
                        var otherChevron = otherRow.querySelector(".chevron");
                        if (otherChevron) otherChevron.textContent = "▸";
                        var otherTargetId = otherRow.getAttribute("data-target");
                        var otherDetailsRow = document.getElementById(otherTargetId);
                        if (otherDetailsRow) {
                            otherDetailsRow.setAttribute("hidden", "");
                        }
                    });
                    detailsRow.removeAttribute("hidden");
                    row.setAttribute("aria-expanded", "true");
                    var ch = row.querySelector(".chevron");
                    if (ch) ch.textContent = "▾";
                } else {
                    detailsRow.setAttribute("hidden", "");
                    row.setAttribute("aria-expanded", "false");
                    var ch2 = row.querySelector(".chevron");
                    if (ch2) ch2.textContent = "▸";
                }
            });
        });
        (function () {
            var filterInputs = document.querySelectorAll('.head-filter');
            var masterRows = document.querySelectorAll('.row-toggle');
            var countEl = document.getElementById('filter-count');
            var resetBtn = document.getElementById('filter-reset');
            function norm(v){
                return (v || '').toLowerCase().trim();
            }
            function closeDetails(masterRow){
                var detailsRow = document.getElementById(masterRow.getAttribute('data-target'));
                if(!detailsRow) return;
                detailsRow.setAttribute('hidden','');
                masterRow.setAttribute('aria-expanded','false');
                var ch = masterRow.querySelector('.chevron');
                if(ch) ch.textContent = '▸';
            }   
            function applyFilters(){
                var visible = 0;
                masterRows.forEach(function(row){
                    var show = true;
                    filterInputs.forEach(function(input){
                        var key = input.getAttribute('data-filter');
                        var filter = norm(input.value);
                        if(!filter) return;
                        var value = norm(row.getAttribute('data-' + key));
                        if(value.indexOf(filter) === -1){
                            show = false;
                        }
                    });
                    row.style.display = show ? '' : 'none';
                    var detail = document.getElementById(row.getAttribute('data-target'));
                    if(detail){
                        if(show){
                            detail.style.display = '';
                        } else {
                            closeDetails(row);
                            detail.style.display = 'none';
                        }
                    }
                    if(show) visible++;
                });
                if(countEl){
                    countEl.textContent = visible + ' / ' + masterRows.length + ' Projekte';
                }
            }
            filterInputs.forEach(function(input){
                input.addEventListener('input', applyFilters);
                input.addEventListener('click', function(e){ e.stopPropagation(); });
                input.addEventListener('keydown', function(e){ e.stopPropagation(); });
            });
             if (resetBtn) {
                resetBtn.addEventListener('click', function () {
                    filterInputs.forEach(function(input){
                        input.value = '';
                    });
                    applyFilters();
                });
            }
            applyFilters();
        })();
        (function () {
            var CSRF = '{{ csrf_token() }}';
            function normalizeNumber(v){
                v = (v || '').toString().trim();
                if (v === '') return '';
                return v.replace(',', '.');
            }
            function sanitizeNumeric(v){
                v = (v || '').toString();
                v = v.replace(',', '.');
                v = v.replace(/[^\d.\-]/g, '');
                v = v.replace(/(?!^)-/g, '');
                var parts = v.split('.');
                if (parts.length > 2) {
                    v = parts.shift() + '.' + parts.join('');
                }
                return v;
            }
            function setRowState(tr, state){
                tr.classList.remove('is-saving','is-saved','is-error');
                if (state) tr.classList.add(state);
            }
            function updateLotMarker(tr) {
                tr.classList.remove('flag-eu', 'flag-usa', 'flag-kritisch');
                if (tr.getAttribute('data-eu-serviceware') === '1') {
                    tr.classList.add('flag-eu');
                }
                if (tr.getAttribute('data-os-projekt') === '1') {
                    tr.classList.add('flag-usa');
                }
                if (tr.getAttribute('data-kritisches-projekt') === '1') {
                    tr.classList.add('flag-kritisch');
                }
            }
            document.querySelectorAll('tr.js-shipment-row').forEach(function(tr){
                updateLotMarker(tr);
            });
            function getMasterRowFromDetail(detailContent){
                if (!detailContent) return null;
                var item = detailContent.closest('.accordion-item');
                if (!item) return null;
                return item.querySelector('.row-toggle');
            }
            function updateMasterShipmentState(detailContent){
                var masterRow = getMasterRowFromDetail(detailContent);
                if (!masterRow) return;
                var tbody = detailContent.querySelector('tbody');
                if (!tbody) return;
                var rows = tbody.querySelectorAll('tr.js-shipment-row');
                if (rows.length > 0) {
                    masterRow.classList.add('has-shipments');
                } else {
                    masterRow.classList.remove('has-shipments');
                }
            }
            function ensureEmptyRow(detailContent){
                var tbody = detailContent.querySelector('tbody');
                if (!tbody) return;
                var fields = getFieldsFromDetail(detailContent);
                var rowCount = tbody.querySelectorAll('tr.js-shipment-row').length;
                var emptyRow = tbody.querySelector('tr.no-rows');
                if (rowCount === 0 && !emptyRow) {
                    var tr = document.createElement('tr');
                    tr.className = 'no-rows';
                    var td = document.createElement('td');
                    td.colSpan = fields.length + 1;
                    td.className = 'muted';
                    td.textContent = 'Keine Lot-Daten vorhanden.';
                    tr.appendChild(td);
                    tbody.appendChild(tr);
                }
                if (rowCount > 0 && emptyRow) {
                    emptyRow.remove();
                }
            }
            var fieldsCache = new WeakMap();
            var optionsCache = new WeakMap();
            var timers = new WeakMap();
            function getFieldsFromDetail(detailContent){
                if (fieldsCache.has(detailContent)) return fieldsCache.get(detailContent);
                var btn = detailContent.querySelector('.btn-add-shipment');
                var raw = btn ? btn.getAttribute('data-fields') : '[]';
                var fields = [];
                try {
                    fields = JSON.parse(raw || '[]');
                } catch(e) {
                    fields = [];
                }
                fieldsCache.set(detailContent, fields);
                return fields;
            }
            function getOptionsFromDetail(detailContent){
                if (optionsCache.has(detailContent)) return optionsCache.get(detailContent);
                var btn = detailContent.querySelector('.btn-add-shipment');
                var raw = btn ? btn.getAttribute('data-options') : '{}';
                var options = {};
                try {
                    options = JSON.parse(raw || '{}');
                } catch(e) {
                    options = {};
                }
                optionsCache.set(detailContent, options);
                return options;
            }
            function getSaveUrlFromDetail(detailContent){
                var btn = detailContent.querySelector('.btn-add-shipment');
                return btn ? btn.getAttribute('data-save-url') : '/saveLot';
            }
            function getDeleteUrlFromBtn(btn){
                return (btn && btn.getAttribute('data-delete-url')) || '/deleteLot';
            }
            function getFieldControl(tr, key){
                return tr.querySelector('.js-ship-input[data-field="' + key + '"]');
            }
            function getControlValue(el){
                if (!el) return '';
                if (el.classList.contains('js-yesno')) {
                    return el.getAttribute('value') === 'Yes' ? 'Yes' : '';
                }
                return (el.value || '').trim();
            }
            function setControlDirty(el, dirty){
                if (!el) return;
                if (dirty) {
                    el.classList.add('is-dirty');
                } else {
                    el.classList.remove('is-dirty');
                }
            }
            function rowHasDirtyState(tr){
                return !!tr.querySelector('.is-dirty') || tr.getAttribute('data-flag-dirty') === '1';
            }
            function buildPayload(tr, fields){
                var payload = {
                    _token: CSRF,
                    PPProduktpass_Id: tr.getAttribute('data-master-id'),
                    PPShipment_Id: tr.getAttribute('data-shipment-id') || null
                };
                fields.forEach(function(f){
                    var key = f.key;
                    var ctrl = getFieldControl(tr, key);
                    var val = getControlValue(ctrl);
                    if (f.type === 'number') {
                        val = normalizeNumber(val);
                    }
                    if (f.type === 'col_YesNo') {
                        val = ctrl.getAttribute('value') === 'Yes' ? 1 : 0;
                    }                    
                    payload[key] = val;
                });
                payload.PPShipment_Flag_EUService = tr.getAttribute('data-eu-serviceware') === '1' ? 1 : 0;
                payload.PPShipment_Flag_OS        = tr.getAttribute('data-os-projekt') === '1' ? 1 : 0;
                payload.PPShipment_Flag_Critical  = tr.getAttribute('data-kritisches-projekt') === '1' ? 1 : 0;
                return payload;
            }
            function markRowClean(tr){
                tr.querySelectorAll('.js-ship-input').forEach(function(el){
                    el.setAttribute('data-original', getControlValue(el));
                    el.classList.remove('is-dirty');
                });
                tr.removeAttribute('data-flag-dirty');
            }
            function saveRow(tr){
                var detail = tr.closest('.detail-content');
                if (!detail) return;
                var fields = getFieldsFromDetail(detail);
                var url = getSaveUrlFromDetail(detail);
                if (tr.getAttribute('data-saving') === '1') {
                    tr.setAttribute('data-pending', '1');
                    return;
                }
                if (!rowHasDirtyState(tr)) return;
                tr.setAttribute('data-saving', '1');
                tr.removeAttribute('data-pending');
                setRowState(tr, 'is-saving');
                var xhr = new XMLHttpRequest();
                xhr.open('POST', url, true);
                xhr.setRequestHeader('Content-Type','application/json');
                xhr.setRequestHeader('X-CSRF-TOKEN', CSRF);
                xhr.onreadystatechange = function(){
                    if (xhr.readyState !== 4) return;
                    tr.removeAttribute('data-saving');
                    if (xhr.status >= 200 && xhr.status < 300) {
                        try {
                            var res = JSON.parse(xhr.responseText);
                            if (res && res.PPShipment_Id) {
                                tr.setAttribute('data-shipment-id', res.PPShipment_Id);
                            }
                        } catch(e){}
                        markRowClean(tr);
                        var status = tr.querySelector('[data-field="PPShipment_ShipmentStatus"]');
                        if (status) {
                            if ((status.value || '').trim().toLowerCase() === 'erledigt') {
                                tr.classList.add('shipment-done');
                            } else {
                                tr.classList.remove('shipment-done');
                            }
                        }
                        setRowState(tr, 'is-saved');
                        updateMasterShipmentState(detail);
                        ensureEmptyRow(detail);
                        updateLotMarker(tr);
                        setTimeout(function(){
                            setRowState(tr, '');
                        }, 700);
                        if (tr.getAttribute('data-pending') === '1') {
                            tr.removeAttribute('data-pending');
                            setTimeout(function(){
                                saveRow(tr);
                            }, 0);
                        }
                    } else {
                        setRowState(tr, 'is-error');
                        console.error('saveLot failed', xhr.status, xhr.responseText);
                    }
                };
                xhr.send(JSON.stringify(buildPayload(tr, fields)));
            }
            function scheduleSave(tr){
                if (tr.getAttribute('data-saving') === '1') {
                    tr.setAttribute('data-pending', '1');
                    return;
                }
                clearTimeout(timers.get(tr));
                timers.set(tr, setTimeout(function(){
                    if (rowHasDirtyState(tr)) {
                        saveRow(tr);
                    }
                }, 400));
            }
            function focusNext(current){
                var tr = current.closest('tr.js-shipment-row');
                if (!tr) return;
                var controls = Array.prototype.slice.call(tr.querySelectorAll('.js-ship-input'));
                var i = controls.indexOf(current);
                if (i < controls.length - 1) {
                    controls[i + 1].focus();
                }
            }
            document.addEventListener('click', function(e){
                var btn = e.target.closest && e.target.closest('.btn-lot-flag');
                if (!btn) return;
                e.preventDefault();
                e.stopPropagation();
                var tr = btn.closest('tr.js-shipment-row');
                if (!tr) return;
                var flag = btn.getAttribute('data-flag');
                var map = {
                    EU_Serviceware: 'data-eu-serviceware',
                    OSProjekt: 'data-os-projekt',
                    KritischesProjekt: 'data-kritisches-projekt'
                };
                var attr = map[flag];
                if (!attr) return;
                var current = tr.getAttribute(attr) === '1' ? '1' : '0';
                var next = current === '1' ? '0' : '1';
                tr.setAttribute(attr, next);
                tr.setAttribute('data-flag-dirty', '1');
                if (next === '1') {
                    btn.classList.add('is-active');
                } else {
                    btn.classList.remove('is-active');
                }
                updateLotMarker(tr);
                scheduleSave(tr);
            });
            document.addEventListener('dblclick', function(e){
                var btn = e.target.closest && e.target.closest('.js-yesno');
                if (!btn) return;
                e.preventDefault();
                e.stopPropagation();
                var tr = btn.closest('tr.js-shipment-row');
                if (!tr) return;
                var current = btn.getAttribute('value') === 'Yes' ? 'Yes' : '';
                var next = current === 'Yes' ? '' : 'Yes';
                btn.setAttribute('value', next);
                btn.textContent = next === 'Yes' ? 'Yes' : '';
                btn.classList.toggle('is-yes', next === 'Yes');
                btn.classList.toggle('is-no', next !== 'Yes');
                if (next !== (btn.getAttribute('data-original') || '')) {
                    setControlDirty(btn, true);
                } else {
                    setControlDirty(btn, false);
                }
                scheduleSave(tr);
            }, true);            
            document.addEventListener('keydown', function(e){
                var input = e.target.closest && e.target.closest('.js-ship-input');
                if (!input) return;
                if (e.key === 'Enter') {
                    if (input.type !== 'date') {
                        e.preventDefault();
                        focusNext(input);
                    }
                    return;
                }
                if (input.getAttribute('data-type') === 'number') {
                    if (e.ctrlKey || e.metaKey || e.altKey) return;
                    var ok = /^[0-9]$/.test(e.key) ||
                            e.key === ',' ||
                            e.key === '.' ||
                            e.key === '-' ||
                            ['Backspace','Delete','ArrowLeft','ArrowRight','Tab','Home','End'].indexOf(e.key) !== -1;
                    if (!ok) e.preventDefault();
                }
            }, true);
            document.addEventListener('input', function(e){
                var ctrl = e.target.closest && e.target.closest('.js-ship-input');
                if (!ctrl) return;
                var tr = ctrl.closest('tr.js-shipment-row');
                if (!tr) return;
                if (ctrl.getAttribute('data-type') === 'number') {
                    var v = ctrl.value || '';
                    var s = sanitizeNumeric(v);
                    if (s !== v) {
                        ctrl.value = s;
                    }
                }
                if (getControlValue(ctrl) !== (ctrl.getAttribute('data-original') || '')) {
                    setControlDirty(ctrl, true);
                } else {
                    setControlDirty(ctrl, false);
                }
                scheduleSave(tr);
            }, true);
            document.addEventListener('change', function(e){
                var input = e.target.closest && e.target.closest('.js-ship-input');
                if (!input) return;
                var tr = input.closest('tr.js-shipment-row');
                if (!tr) return;
                if (input.getAttribute('data-type') === 'number') {
                    input.value = normalizeNumber(input.value || '');
                }
                if (getControlValue(input) !== (input.getAttribute('data-original') || '')) {
                    setControlDirty(input, true);
                } else {
                    setControlDirty(input, false);
                }
                scheduleSave(tr);
            }, true);
            document.addEventListener('focusout', function(e){
                var ctrl = e.target.closest && e.target.closest('.js-ship-input');
                if (!ctrl) return;
                var tr = ctrl.closest('tr.js-shipment-row');
                if (!tr) return;
                if (ctrl.getAttribute('data-type') === 'number') {
                    ctrl.value = normalizeNumber(ctrl.value || '');
                }
                clearTimeout(timers.get(tr));
                saveRow(tr);
            }, true);
            document.addEventListener('click', function(e){
                var btn = e.target.closest && e.target.closest('.btn-add-shipment');
                if (!btn) return;
                var detail = btn.closest('.detail-content');
                var tbody = detail ? detail.querySelector('tbody') : null;
                if (!detail || !tbody) return;
                var fields = getFieldsFromDetail(detail);
                var optionsMap = getOptionsFromDetail(detail);
                var emptyRow = tbody.querySelector('tr.no-rows');
                if (emptyRow) emptyRow.remove();
                var tr = document.createElement('tr');
                tr.className = 'js-shipment-row';
                tr.setAttribute('data-master-id', btn.getAttribute('data-master-id'));
                tr.setAttribute('data-shipment-id', '');
                tr.setAttribute('data-eu-serviceware', '0');
                tr.setAttribute('data-os-projekt', '0');
                tr.setAttribute('data-kritisches-projekt', '0');
                fields.forEach(function(f){
                    var td = document.createElement('td');
                    td.setAttribute('data-field', f.key);
                    td.setAttribute('data-type', f.type || 'text');
                    if (f.class) {
                        td.className = f.class;
                    }
                    if (f.type === 'date') {
                        var wrapper = document.createElement('div');
                        wrapper.className = 'date-wrapper';
                        var textInput = document.createElement('input');
                        textInput.type = 'text';
                        textInput.className = 'js-ship-input js-date-text is-dirty';
                        textInput.setAttribute('data-field', f.key);
                        textInput.setAttribute('data-type', 'date');
                        textInput.setAttribute('data-original', '');
                        var hiddenDate = document.createElement('input');
                        hiddenDate.type = 'date';
                        hiddenDate.className = 'js-date-hidden';
                        hiddenDate.style.position = 'absolute';
                        hiddenDate.style.opacity = '0';
                        hiddenDate.style.pointerEvents = 'none';
                        var icon = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                        icon.setAttribute("viewBox", "0 0 24 24");
                        icon.setAttribute("class", "date-icon js-date-trigger");
                        var path = document.createElementNS("http://www.w3.org/2000/svg", "path");
                        path.setAttribute("fill", "currentColor");
                        path.setAttribute("d", "M7 10h5v5H7zM19 4h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z");
                        icon.appendChild(path);
                        wrapper.appendChild(textInput);
                        wrapper.appendChild(hiddenDate);
                        wrapper.appendChild(icon);
                        td.appendChild(wrapper);
                    } else {
                        var input = document.createElement('input');
                        input.className = 'js-ship-input is-dirty';
                        input.setAttribute('data-field', f.key);
                        input.setAttribute('data-type', f.type || 'text');
                        input.setAttribute('data-original', '');
                        if (f.type === 'textCombo') {
                            var listId = 'dl-' + f.key + '-' + Math.random().toString(36).slice(2);
                            input.type = 'text';
                            input.setAttribute('list', listId);
                            input.setAttribute('autocomplete', 'off');
                            var datalist = document.createElement('datalist');
                            datalist.id = listId;
                            var opts = optionsMap[f.key] || [];
                            opts.forEach(function(opt){
                                var option = document.createElement('option');
                                option.value = opt;
                                datalist.appendChild(option);
                            });
                            td.appendChild(input);
                            td.appendChild(datalist);
                        } else if (f.type === 'col_YesNo') {
                            input = document.createElement('button');
                            input.type = 'button';
                            input.className = 'js-ship-input js-yesno is-no is-dirty';
                            input.setAttribute('value', '');
                            input.setAttribute('data-field', f.key);
                            input.setAttribute('data-type', 'col_YesNo');
                            input.setAttribute('data-original', '');
                            input.setAttribute('title', 'Doppelklick zum Umschalten');
                            input.textContent = '✗';
                            td.appendChild(input);                            
                        } else if (f.type === 'number') {
                            input.type = 'number';
                            input.step = 'any';
                            input.setAttribute('inputmode', 'decimal');
                            td.appendChild(input);
                        } else {
                            input.type = 'text';
                            input.setAttribute('autocomplete', 'off');
                            td.appendChild(input);
                        }
                    }
                    tr.appendChild(td);
                });
                var act = document.createElement('td');
                [
                    ['EU_Serviceware', 'EU'],
                    ['OSProjekt', 'USA'],
                    ['KritischesProjekt', '!']
                ].forEach(function(item){
                    var b = document.createElement('button');
                    b.type = 'button';
                    b.className = 'btn btn-mini btn-lot-flag';
                    b.setAttribute('data-flag', item[0]);
                    b.textContent = item[1];
                    act.appendChild(b);
                });
                var rm = document.createElement('button');
                rm.type = 'button';
                rm.className = 'btn btn-mini js-remove-shipment';
                rm.textContent = 'Remove';
                rm.setAttribute('data-delete-url', btn.getAttribute('data-delete-url') || '/deleteLot');
                act.appendChild(rm);
                tr.appendChild(act);
                tbody.appendChild(tr);
                ensureEmptyRow(detail);
                updateMasterShipmentState(detail);
                updateLotMarker(tr);
                var first = tr.querySelector('.js-ship-input');
                if (first) first.focus();
            });
            document.addEventListener('click', function(e){
                var btn = e.target.closest && e.target.closest('.js-remove-shipment');
                if (!btn) return;
                var tr = btn.closest('tr.js-shipment-row');
                if (!tr) return;
                var id = tr.getAttribute('data-shipment-id');
                if (!id) {
                    var detailNew = tr.closest('.detail-content');
                    tr.remove();
                    if (detailNew) {
                        ensureEmptyRow(detailNew);
                        updateMasterShipmentState(detailNew);
                    }
                    return;
                }
                if (!confirm('Position löschen?')) return;
                setRowState(tr, 'is-saving');
                var xhr = new XMLHttpRequest();
                xhr.open('POST', getDeleteUrlFromBtn(btn), true);
                xhr.setRequestHeader('Content-Type','application/json');
                xhr.setRequestHeader('X-CSRF-TOKEN', CSRF);
                xhr.onreadystatechange = function(){
                    if (xhr.readyState !== 4) return;
                    if (xhr.status >= 200 && xhr.status < 300) {
                        var detailSaved = tr.closest('.detail-content');
                        tr.remove();
                        if (detailSaved) {
                            ensureEmptyRow(detailSaved);
                            updateMasterShipmentState(detailSaved);
                        }
                    } else {
                        setRowState(tr, 'is-error');
                        console.error('deleteLot failed', xhr.status, xhr.responseText);
                    }
                };
                xhr.send(JSON.stringify({
                    _token: CSRF,
                    PPShipment_Id: id
                }));
            });
            document.addEventListener('click', function(e){
                var trigger = e.target.closest && e.target.closest('.js-date-trigger');
                if (!trigger) return;
                var wrapper = trigger.closest('.date-wrapper');
                if (!wrapper) return;
                var hidden = wrapper.querySelector('.js-date-hidden');
                var text = wrapper.querySelector('.js-date-text');
                if (!hidden || !text) return;
                hidden.value = text.value || '';
                if (hidden.showPicker) {
                    hidden.showPicker();
                } else {
                    hidden.click();
                }
                hidden.onchange = function(){
                    text.value = hidden.value;
                    var tr = text.closest('tr.js-shipment-row');
                    if (tr) {
                        text.classList.add('is-dirty');
                        scheduleSave(tr);
                    }
                };
            });
        })();
    }
    document.addEventListener('change', function (e) {
        var select = e.target;
        if (!select.classList.contains('js-log-admin')) {
            return;
        }
        e.stopPropagation();
        console.log('Logistik-Mitarbeiter geändert:', select.value);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ URL::to("/saveLogAdmin") }}', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.onreadystatechange = function () {
            if (xhr.readyState !== 4) {
                return;
            }
            if (xhr.status >= 200 && xhr.status < 300) {
                var result = JSON.parse(xhr.responseText);
                if (result.success) {
                    console.log('Logistik-Mitarbeiter gespeichert.');
                }
            } else {
                console.error(
                    'Speichern fehlgeschlagen:',
                    xhr.status,
                    xhr.responseText
                );
            }
        };
        xhr.send(JSON.stringify({
            PPProduktpass_Id: select.getAttribute('data-produktpass-id'),
            PPMitarbeiter_Id: select.value
        }));
    });
    document.addEventListener('dblclick', function (e) {
        var text = e.target.closest
            ? e.target.closest('.js-log-admin-text')
            : null;
        if (!text) {
            return;
        }
        e.preventDefault();
        e.stopPropagation();
        var cell = text.closest('.js-log-admin-cell');
        var select = cell.querySelector('.js-log-admin');
        text.style.display = 'none';
        select.style.display = '';
        select.focus();
    });
    document.addEventListener('change', function (e) {
        var select = e.target;
        if (!select.classList.contains('js-log-admin')) {
            return;
        }
        e.preventDefault();
        e.stopPropagation();
        var cell = select.closest('.js-log-admin-cell');
        var text = cell.querySelector('.js-log-admin-text');
        var selectedOption = select.options[select.selectedIndex];
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ URL::to("/saveLogAdmin") }}', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.onreadystatechange = function () {
            if (xhr.readyState !== 4) {
                return;
            }
            var result;
            try {
                result = JSON.parse(xhr.responseText);
            } catch (error) {
                console.error('Ungültige Serverantwort:', xhr.responseText);
                return;
            }
            if (xhr.status >= 200 && xhr.status < 300 && result.success) {
                text.textContent = select.value !== ''
                    ? selectedOption.text
                    : '—';
                select.style.display = 'none';
                text.style.display = '';
                var row = select.closest('.row-toggle');
                if (row) {
                    row.setAttribute(
                        'data-log',
                        select.value !== '' ? selectedOption.text : ''
                    );
                }
            } else {
                console.error(
                    'Speichern fehlgeschlagen:',
                    result.message || xhr.responseText
                );
            }
        };
        xhr.send(JSON.stringify({
            PPProduktpass_Id: select.getAttribute('data-produktpass-id'),
            PPMitarbeiter_Id: select.value
        }));
    });
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.btn-archive-shipment');
        if (!btn) return;
        if (!confirm('Projekt archivieren?')) {
            return;
        }
        var xhr = new XMLHttpRequest();
        console.log('Archivierung gestartet für PPProduktpass_Id:', btn.getAttribute('data-master-id'));
        xhr.open('POST', btn.getAttribute('data-archive-url'), true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.onreadystatechange = function () {
            if (xhr.readyState !== 4) return;
            if (xhr.status >= 200 && xhr.status < 300) {
                console.log('Archivierung erfolgreich.');
                // Optional:
                location.reload();
            } else {
                console.error('Archivierung fehlgeschlagen:', xhr.responseText);
            }
        };
        xhr.send(JSON.stringify({
            PPProduktpass_Id: btn.getAttribute('data-master-id')
        }));
    });
</script>
