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
        height: 70vh;
        overflow: auto;
        border: 1px solid #ddd;
        background: #fff;
    }
    .big-table{
        border-collapse: separate;
        border-spacing: 0;
        min-width: 1200px;
        width: max-content;
        font-size: 12px;
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
    .muted{ color:#777; font-size: 12px; }
    .center{ text-align:center; }
    .row-toggle { cursor: pointer; }
    .row-toggle:hover td { filter: brightness(0.985); }
    .detail-row[hidden] { display: none; }
    .detail-cell { padding: 0; background: #fff; }
    .detail-content { padding: 12px; }
    .chevron {
        display: inline-block;
        width: 18px;
        text-align: center;
        margin-right: 6px;
    }
    .inner-table{
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
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
</style>
<?php
    $projekts  = $data['ppData']['kopf'];
    $shipments = isset($data['ppData']['ship']) ? $data['ppData']['ship'] : array();
    $masterKey = 'PPProduktpass_Id';
    $detailKey = 'PPProduktpass_Id';
    $SHIP_FIELDS = array(
        array('key' => 'PPShipment_Lot',                                'label' => 'Lot',              'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_POD',                                'label' => 'POD',              'type' => 'textCombo', 'class' => 'col-text-md'),
        array('key' => 'PPShipment_POA',                                'label' => 'POA',              'type' => 'textCombo', 'class' => 'col-text-lg'),
        array('key' => 'PPShipment_Forwarder',                          'label' => 'Forwarder',        'type' => 'text',      'class' => 'col-text-md'),
        array('key' => 'PPShipment_Carrier',                            'label' => 'Carrier',          'type' => 'text',      'class' => 'col-text-md'),
        array('key' => 'PPShipment_Vessel',                             'label' => 'Vessel',           'type' => 'text',      'class' => 'col-text-lg'),
        array('key' => 'PPShipment_Voyage',                             'label' => 'Voyage',           'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_ENS',                                'label' => 'ENS',              'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_CYClosing',                          'label' => 'CY Closing',       'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_CRDGiven',                           'label' => 'CRD Given',        'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_CRDOpeningCalc',                     'label' => 'CRD Opening Calc', 'type' => 'number',    'class' => 'col-number-lg'),
        array('key' => 'PPShipment_CRDClosingCalc',                     'label' => 'CRD Closing Calc', 'type' => 'number',    'class' => 'col-number-lg'),
        array('key' => 'PPShipment_20ftGP',                             'label' => '20ft GP',          'type' => 'number',    'class' => 'col-number'),
        array('key' => 'PPShipment_40ftGP',                             'label' => '40ft GP',          'type' => 'number',    'class' => 'col-number'),
        array('key' => 'PPShipment_40ftHQ',                             'label' => '40ft HQ',          'type' => 'number',    'class' => 'col-number'),
        array('key' => 'PPShipment_LCLCBM',                             'label' => 'LCL / CBM',        'type' => 'number',    'class' => 'col-number'),
        array('key' => 'PPShipment_ETD',                                'label' => 'ETD',              'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_ETA',                                'label' => 'ETA',              'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_CurrentStatus',                      'label' => 'Current Status',   'type' => 'text',      'class' => 'col-status'),
        array('key' => 'PPShipment_BLForm',                             'label' => 'BL Form',          'type' => 'textCombo', 'class' => 'col-text-md'),
        array('key' => 'PPShipment_ShipRelease',                        'label' => 'Ship Release',     'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_OceanFreight',                       'label' => 'Ocean Freight',    'type' => 'number',    'class' => 'col-number-lg'),
        array('key' => 'PPShipment_INCOTERM',                           'label' => 'INCOTERM',         'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_MS_30PSI',                           'label' => '30% PSI',          'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_MS_EUG',                             'label' => 'EUG',              'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_MS_PSI',                             'label' => '100% PSI',         'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_Flag_Producer_booking',              'label' => 'Producer booking', 'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_Flag_Shipment_Release',              'label' => 'Producer booking', 'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_Flag_SO_BL_Inv',                     'label' => 'Producer booking', 'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_Flag_PL',                            'label' => 'Producer booking', 'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_Flag_CoO_Declaration_of_Fumigation', 'label' => 'Producer booking', 'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_Flag_Ocean_Freight',                 'label' => 'Producer booking', 'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_Flag_PL_sent_to_MaWi',               'label' => 'Producer booking', 'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_Flag_CLP_sent',                      'label' => 'Producer booking', 'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_Flag_Sea_freight_invoice',           'label' => 'Producer booking', 'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_Flag_Transport_invoice',             'label' => 'Producer booking', 'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_Flag_Unloading_invoice',             'label' => 'Producer booking', 'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_Flag_Other_logistical_costs',        'label' => 'Producer booking', 'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_Flag_CCC_sent',                      'label' => 'Producer booking', 'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_Flag_customs_invoice',               'label' => 'Producer booking', 'type' => 'text',      'class' => 'col-text-sm'),
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
        'PPShipment_BLForm' => array('Air Waybill','Original BL','Surrendered BL')
    );
    $SHIP_FIELDS_JSON  = htmlspecialchars(json_encode($SHIP_FIELDS), ENT_QUOTES, 'UTF-8');
    $SHIP_OPTIONS_JSON = htmlspecialchars(json_encode($SHIP_OPTIONS), ENT_QUOTES, 'UTF-8');
?>
<div class="container">
    <div class="filter-bar" role="region" aria-label="Filter">
        <div class="filter-field">
            <label for="filter-ian">Filter IAN!</label>
            <input id="filter-ian" type="text" placeholder="z.B. 12345…" autocomplete="off">
        </div>
        <div class="filter-field">
            <label for="filter-artikel">Filter Artikelbezeichnung</label>
            <input id="filter-artikel" type="text" placeholder="z.B. T-Shirt…" autocomplete="off">
        </div>
        <div class="filter-field">
            <label for="filter-ausmusterung">Filter Ausmusterung</label>
            <input id="filter-ausmusterung" type="text" placeholder="z.B. 2501…" autocomplete="off">
        </div>
        <div class="filter-actions">
            <button type="button" class="btn" id="filter-reset">Reset</button>
            <a href="{{ URL::to('/shipFlat') }}" class="btn">Flat View</a>
        </div>
        <div class="muted" id="filter-count" aria-live="polite"></div>
    </div>
    <div class="table-wrap">
        <table class="big-table" aria-label="Kopfdaten" id="projekts-table">
            <thead>
                <tr>
                    <th>IAN</th>
                    <th>Ausmusterung</th>
                    <th>Artikelbezeichnung</th>
                    <th>Status</th>
                    <th>PM</th>
                    <th>TC</th>
                    <th>PJM</th>
                </tr>
            </thead>
            <tbody>
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
                    ?>
                    <tr class="row-toggle {{ $hasShip ? 'has-shipments' : '' }}"
                        data-target="{{ $detailRowId }}"
                        data-ian="{{ e($ianVal) }}"
                        data-artikel="{{ e($artVal) }}"
                        data-ausmusterung="{{ e($ausVal) }}"
                        aria-expanded="false"
                        style="background-color: var({{ $bgVar }});">
                        <td><span class="chevron">▸</span>{{ $projekt->IAN }}</td>
                        <td>{{ $projekt->Ausmusterung }}</td>
                        <td>{{ $projekt->Artikelbezeichnung }}</td>
                        <td>{{ $projekt->TargaStatus }}</td>
                        <td>{{ $projekt->PMAdmin }}</td>
                        <td>{{ $projekt->TCAdmin }}</td>
                        <td>{{ $projekt->PJMAdmin }}</td>
                    </tr>
                    <tr id="{{ $detailRowId }}" class="detail-row" hidden>
                        <td class="detail-cell" colspan="7">
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
                                </div>
                                <table class="inner-table" aria-label="Lot-Daten">
                                    <thead>
                                        <tr>
                                            @foreach($SHIP_FIELDS as $f)
                                                <th class="{{ e(isset($f['class']) ? $f['class'] : '') }}">{{ $f['label'] }}</th>
                                            @endforeach
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($projektShipments as $shipment)
                                            <?php
                                                $shipId = is_array($shipment)
                                                    ? (isset($shipment['PPShipment_Id']) ? $shipment['PPShipment_Id'] : null)
                                                    : (isset($shipment->PPShipment_Id) ? $shipment->PPShipment_Id : null);
                                            ?>
                                            <tr class="js-shipment-row"
                                                data-shipment-id="{{ $shipId }}"
                                                data-master-id="{{ $masterVal }}">
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
                                                            class="btn btn-mini js-remove-shipment"
                                                            data-delete-url="{{ URL::to('/deleteLot') }}">
                                                        Remove
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="no-rows">
                                                <td colspan="{{ count($SHIP_FIELDS) + 1 }}" class="muted">Keine Lot-Daten vorhanden.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="muted center">Keine Projekte vorhanden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<script>
if (window.__PP_SHIP_SCRIPT_BOUND__) {
    console.warn('PP shipment script already bound - skipping duplicate bind.');
} else {
    window.__PP_SHIP_SCRIPT_BOUND__ = true;
    document.querySelectorAll(".row-toggle").forEach(function (row) {
        row.addEventListener("click", function (e) {
            if (e.target.closest('input, button, datalist, svg, path')) return;
            var targetId = row.getAttribute("data-target");
            var detailsRow = document.getElementById(targetId);
            if (!detailsRow) return;
            var isHidden = detailsRow.hasAttribute("hidden");
            if (isHidden) {
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
    /* =========================
       Filter IAN + Artikel + Ausmusterung
    ========================= */
    (function () {
        var ianInput = document.getElementById("filter-ian");
        var artInput = document.getElementById("filter-artikel");
        var ausInput = document.getElementById("filter-ausmusterung");
        var resetBtn = document.getElementById("filter-reset");
        var countEl  = document.getElementById("filter-count");
        var masterRows = Array.prototype.slice.call(document.querySelectorAll("tr.row-toggle"));
        function norm(s) {
            return (s || "").toString().toLowerCase().trim();
        }
        function closeDetails(masterRow) {
            var detailsRow = document.getElementById(masterRow.getAttribute("data-target"));
            if (!detailsRow) return;
            detailsRow.setAttribute("hidden", "");
            masterRow.setAttribute("aria-expanded", "false");
            var ch = masterRow.querySelector(".chevron");
            if (ch) ch.textContent = "▸";
        }
        function applyFilters() {
            var qIan = norm(ianInput && ianInput.value);
            var qArt = norm(artInput && artInput.value);
            var qAus = norm(ausInput && ausInput.value);
            var visible = 0;
            masterRows.forEach(function (mr) {
                var ian = norm(mr.getAttribute("data-ian"));
                var art = norm(mr.getAttribute("data-artikel"));
                var aus = norm(mr.getAttribute("data-ausmusterung"));
                var show =
                    (!qIan || ian.indexOf(qIan) !== -1) &&
                    (!qArt || art.indexOf(qArt) !== -1) &&
                    (!qAus || aus.indexOf(qAus) !== -1);
                mr.style.display = show ? "" : "none";
                var dr = document.getElementById(mr.getAttribute("data-target"));
                if (dr) {
                    if (show) {
                        dr.style.display = "";
                    } else {
                        closeDetails(mr);
                        dr.style.display = "none";
                    }
                }
                if (show) visible++;
            });
            if (countEl) {
                countEl.textContent = visible + " / " + masterRows.length + " Projekte";
            }
        }
        if (ianInput) ianInput.addEventListener("input", applyFilters);
        if (artInput) artInput.addEventListener("input", applyFilters);
        if (ausInput) ausInput.addEventListener("input", applyFilters);
        if (resetBtn) {
            resetBtn.addEventListener("click", function () {
                if (ianInput) ianInput.value = "";
                if (artInput) artInput.value = "";
                if (ausInput) ausInput.value = "";
                applyFilters();
            });
        }
        applyFilters();
    })();
    /* =========================
       Shipment Grid Logic
    ========================= */
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
        function getMasterRowFromDetail(detailContent){
            if (!detailContent) return null;
            var detailRow = detailContent.closest('tr.detail-row');
            if (!detailRow) return null;
            var masterRow = detailRow.previousElementSibling;
            if (masterRow && masterRow.classList.contains('row-toggle')) return masterRow;
            return null;
        }
        function updateMasterShipmentState(detailContent){
            var masterRow = getMasterRowFromDetail(detailContent);
            if (!masterRow) return;
            var tbody = detailContent.querySelector('tbody');
            if (!tbody) return;
            var rows = tbody.querySelectorAll('tr.js-shipment-row');
            if (rows.length > 0) masterRow.classList.add('has-shipments');
            else masterRow.classList.remove('has-shipments');
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
            return (el.value || '').trim();
        }
        function setControlDirty(el, dirty){
            if (!el) return;
            if (dirty) el.classList.add('is-dirty');
            else el.classList.remove('is-dirty');
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
                payload[key] = val;
            });
            return payload;
        }
        function markRowClean(tr){
            tr.querySelectorAll('.js-ship-input').forEach(function(el){
                el.setAttribute('data-original', getControlValue(el));
                el.classList.remove('is-dirty');
            });
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
            if (!tr.querySelector('.is-dirty')) return;
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
                    setRowState(tr, 'is-saved');
                    updateMasterShipmentState(detail);
                    ensureEmptyRow(detail);
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
        var timers = new WeakMap();
        function scheduleSave(tr){
            if (tr.getAttribute('data-saving') === '1') {
                tr.setAttribute('data-pending', '1');
                return;
            }
            clearTimeout(timers.get(tr));
            timers.set(tr, setTimeout(function(){
                if (tr.querySelector('.is-dirty')) saveRow(tr);
            }, 400));
        }
        function focusNext(current){
            var tr = current.closest('tr.js-shipment-row');
            if (!tr) return;
            var controls = Array.prototype.slice.call(tr.querySelectorAll('.js-ship-input'));
            var i = controls.indexOf(current);
            if (i < controls.length - 1) controls[i+1].focus();
        }
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
                if (s !== v) ctrl.value = s;
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
                var nv = normalizeNumber(input.value || '');
                input.value = nv;
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
            var tbody  = detail ? detail.querySelector('tbody') : null;
            if (!detail || !tbody) return;
            var fields = getFieldsFromDetail(detail);
            var optionsMap = getOptionsFromDetail(detail);
            var emptyRow = tbody.querySelector('tr.no-rows');
            if (emptyRow) emptyRow.remove();
            var tr = document.createElement('tr');
            tr.className = 'js-shipment-row';
            tr.setAttribute('data-master-id', btn.getAttribute('data-master-id'));
            tr.setAttribute('data-shipment-id', '');
            fields.forEach(function(f){
                var td = document.createElement('td');
                td.setAttribute('data-field', f.key);
                td.setAttribute('data-type', f.type || 'text');
                if (f.class) td.className = f.class;
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
            var rm  = document.createElement('button');
            rm.type = 'button';
            rm.className = 'btn btn-mini js-remove-shipment';
            rm.textContent = 'Remove';
            rm.setAttribute('data-delete-url', btn.getAttribute('data-delete-url') || '/deleteLot');
            act.appendChild(rm);
            tr.appendChild(act);
            tbody.appendChild(tr);
            ensureEmptyRow(detail);
            updateMasterShipmentState(detail);
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
            var text   = wrapper.querySelector('.js-date-text');
            if (!hidden || !text) return;
            hidden.value = text.value || '';
            if (hidden.showPicker) hidden.showPicker();
            else hidden.click();
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
</script>