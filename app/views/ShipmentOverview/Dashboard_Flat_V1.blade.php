{{-- app/views/ShipmentOverview/Dashboard_Flat.blade.php --}}
<style>
    :root {
        --bg-color: rgba(241, 216, 162, 0.5);
        --bg-colorHigh: rgba(241, 216, 162, 0.25);
    }
    .container {
        padding: 20px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 1em;
    }
    .table-wrap {
        height: 70vh;
        overflow: auto;
        border: 1px solid #ddd;
        background: #fff;
    }
    .big-table {
        border-collapse: separate;
        border-spacing: 0;
        min-width: 2600px;
        width: max-content;
        font-size: 12px;
    }
    .big-table th,
    .big-table td {
        padding: 8px 10px;
        border-right: 1px solid #eee;
        border-bottom: 1px solid #eee;
        white-space: nowrap;
        background: transparent;
        vertical-align: top;
    }
    .big-table thead th {
        position: sticky;
        top: 0;
        z-index: 20;
        background: #f7f7f7;
        border-bottom: 1px solid #ddd;
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
    .big-table tbody tr:hover td {
        background: rgba(0,0,0,0.02);
    }
    .muted {
        color: #777;
        font-size: 12px;
    }
    .center {
        text-align: center;
    }
    .filter-bar {
        display: flex;
        gap: 12px;
        align-items: end;
        margin: 0 0 12px 0;
        flex-wrap: wrap;
    }
    .filter-field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .filter-field label {
        font-size: 12px;
        color: #444;
    }
    .filter-field input {
        padding: 8px 10px;
        border: 1px solid #d0d0d0;
        border-radius: 6px;
        min-width: 220px;
        font-size: 12px;
    }
    .filter-actions {
        display: flex;
        gap: 10px;
    }
    .btn {
        padding: 8px 10px;
        border: 1px solid #d0d0d0;
        background: #fff;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
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
    .sticky-left {
        position: sticky;
        left: 0;
        z-index: 5;
        background: #f7f7f7;
    }
    .sticky-left-2 {
        position: sticky;
        left: 110px;
        z-index: 5;
        background: #f7f7f7;
    }
    .sticky-left-3 {
        position: sticky;
        left: 245px;
        z-index: 5;
        background: #f7f7f7;
    }
    .sticky-left-4 {
        position: sticky;
        left: 465px;
        z-index: 5;
        background: #f7f7f7;
    }
    .sticky-left-5 {
        position: sticky;
        left: 625px;
        z-index: 5;
        background: #f7f7f7;
    }
    .sticky-left-6 {
        position: sticky;
        left: 735px;
        z-index: 5;
        background: #f7f7f7;
    }
    .sticky-left-7 {
        position: sticky;
        left: 845px;
        z-index: 5;
        background: #f7f7f7;
    }
    tbody .sticky-left,
    tbody .sticky-left-2,
    tbody .sticky-left-3,
    tbody .sticky-left-4,
    tbody .sticky-left-5,
    tbody .sticky-left-6,
    tbody .sticky-left-7 {
        z-index: 4;
    }
    .big-table td.col-text-sm,
    .big-table th.col-text-sm { min-width: 110px; }
    .big-table td.col-text-md,
    .big-table th.col-text-md { min-width: 140px; }
    .big-table td.col-text-lg,
    .big-table th.col-text-lg { min-width: 180px; }
    .big-table td.col-wide,
    .big-table th.col-wide { min-width: 220px; }
    .big-table td.col-status,
    .big-table th.col-status { min-width: 200px; }
    .big-table td.col-number,
    .big-table th.col-number { min-width: 95px; }
    .big-table td.col-number-lg,
    .big-table th.col-number-lg { min-width: 120px; }
    .big-table td.col-date,
    .big-table th.col-date { min-width: 135px; }
</style>
<?php
    $ppData = $data['ppData'] ?? array();
    $projekts  = (is_array($ppData) && isset($ppData['kopf'])) ? $ppData['kopf'] : array();
    $shipments = (is_array($ppData) && isset($ppData['ship'])) ? $ppData['ship'] : array();
    $masterKey = 'PPProduktpass_Id';
    $detailKey = 'PPProduktpass_Id';
    $SHIP_FIELDS = array(
        array('key' => 'PPShipment_Lot',            'label' => 'Lot',              'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_POD',            'label' => 'POD',              'type' => 'textCombo', 'class' => 'col-text-md'),
        array('key' => 'PPShipment_POA',            'label' => 'POA',              'type' => 'textCombo', 'class' => 'col-text-lg'),
        array('key' => 'PPShipment_Forwarder',      'label' => 'Forwarder',        'type' => 'text',      'class' => 'col-text-md'),
        array('key' => 'PPShipment_Carrier',        'label' => 'Carrier',          'type' => 'text',      'class' => 'col-text-md'),
        array('key' => 'PPShipment_Vessel',         'label' => 'Vessel',           'type' => 'text',      'class' => 'col-text-lg'),
        array('key' => 'PPShipment_Voyage',         'label' => 'Voyage',           'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_ENS',            'label' => 'ENS',              'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_CYClosing',      'label' => 'CY Closing',       'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_CRDGiven',       'label' => 'CRD Given',        'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_CRDOpeningCalc', 'label' => 'CRD Opening Calc', 'type' => 'number',    'class' => 'col-number-lg'),
        array('key' => 'PPShipment_CRDClosingCalc', 'label' => 'CRD Closing Calc', 'type' => 'number',    'class' => 'col-number-lg'),
        array('key' => 'PPShipment_20ftGP',         'label' => '20ft GP',          'type' => 'number',    'class' => 'col-number'),
        array('key' => 'PPShipment_40ftGP',         'label' => '40ft GP',          'type' => 'number',    'class' => 'col-number'),
        array('key' => 'PPShipment_40ftHQ',         'label' => '40ft HQ',          'type' => 'number',    'class' => 'col-number'),
        array('key' => 'PPShipment_LCLCBM',         'label' => 'LCL / CBM',        'type' => 'number',    'class' => 'col-number'),
        array('key' => 'PPShipment_ETD',            'label' => 'ETD',              'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_ETA',            'label' => 'ETA',              'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_CurrentStatus',  'label' => 'Current Status',   'type' => 'text',      'class' => 'col-status'),
        array('key' => 'PPShipment_BLForm',         'label' => 'BL Form',          'type' => 'textCombo', 'class' => 'col-text-md'),
        array('key' => 'PPShipment_ShipRelease',    'label' => 'Ship Release',     'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_OceanFreight',   'label' => 'Ocean Freight',    'type' => 'number',    'class' => 'col-number-lg'),
        array('key' => 'PPShipment_INCOTERM',       'label' => 'INCOTERM',         'type' => 'text',      'class' => 'col-text-sm'),
        array('key' => 'PPShipment_MS_30PSI',       'label' => '30% PSI',          'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_MS_EUG',         'label' => 'EUG',              'type' => 'date',      'class' => 'col-date'),
        array('key' => 'PPShipment_MS_PSI',         'label' => '100% PSI',         'type' => 'date',      'class' => 'col-date')
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
<div class="container">
    <div class="filter-bar" role="region" aria-label="Filter">
        <div class="filter-field">
            <label for="filter-ian">Filter IAN</label>
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
            <a href="{{ URL::to('/ship') }}" class="btn">Edit View</a>
        </div>
        <div class="muted" id="filter-count" aria-live="polite"></div>
    </div>
    <div class="table-wrap">
        <table class="big-table" aria-label="Shipment Overview Flat" id="projekts-table">
            <thead>
                <tr>
                    <th class="sticky-left col-text-sm" data-sort="0" data-type="text">IAN</th>
                    <th class="sticky-left-2 col-text-sm" data-sort="1" data-type="text">Ausmusterung</th>
                    <th class="sticky-left-3 col-wide" data-sort="2" data-type="text">Artikelbezeichnung</th>
                    <th class="sticky-left-4 col-text-md" data-sort="3" data-type="text">Status</th>
                    <th class="sticky-left-5 col-text-sm" data-sort="4" data-type="text">PM</th>
                    <th class="sticky-left-6 col-text-sm" data-sort="5" data-type="text">TC</th>
                    <th class="sticky-left-7 col-text-sm" data-sort="6" data-type="text">PJM</th>
                    @foreach($SHIP_FIELDS as $index => $field)
                        <?php
                        $sortType = ($field['type'] === 'number') ? 'number' : (($field['type'] === 'date') ? 'date' : 'text');
                        ?>
                        <th
                            class="{{ ($index === 0 ? 'col-sep ' : '') . e($field['class'] ?? '') }}"
                            data-sort="{{ 7 + $index }}"
                            data-type="{{ $sortType }}"
                        >
                            {{ $field['label'] }}
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
                    $ianVal = trim((string)($projekt->IAN ?? ''));
                    $artVal = trim((string)($projekt->Artikelbezeichnung ?? ''));
                    $ausVal = trim((string)($projekt->Ausmusterung ?? ''));
                    ?>
                    <tr
                        data-ian="{{ e($ianVal) }}"
                        data-artikel="{{ e($artVal) }}"
                        data-ausmusterung="{{ e($ausVal) }}"
                        style="background-color: var({{ $rowBgVar }});"
                    >
                        <td class="sticky-left head-cell col-text-sm">{{ $projekt->IAN ?? '' }}</td>
                        <td class="sticky-left-2 col-text-sm">{{ $projekt->Ausmusterung ?? '' }}</td>
                        <td class="sticky-left-3 col-wide">{{ $projekt->Artikelbezeichnung ?? '' }}</td>
                        <td class="sticky-left-4 col-text-md">{{ $projekt->TargaStatus ?? '' }}</td>
                        <td class="sticky-left-5 col-text-sm">{{ $projekt->PMAdmin ?? '' }}</td>
                        <td class="sticky-left-6 col-text-sm">{{ $projekt->TCAdmin ?? '' }}</td>
                        <td class="sticky-left-7 col-text-sm">{{ $projekt->PJMAdmin ?? '' }}</td>
                        @foreach($SHIP_FIELDS as $index => $field)
                            <?php
                            $value = so_flat_value($shipment, $field['key'], $field['type']);
                            $cellClass = ($index === 0 ? 'col-sep ' : '') . ($field['class'] ?? '');
                            ?>
                            <td class="{{ e(trim($cellClass)) }}">{{ $value }}</td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ 7 + count($SHIP_FIELDS) }}" class="muted center">
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
    var allRows = Array.prototype.slice.call(tbody.querySelectorAll("tr"));
    var ianInput = document.getElementById("filter-ian");
    var artInput = document.getElementById("filter-artikel");
    var ausInput = document.getElementById("filter-ausmusterung");
    var resetBtn = document.getElementById("filter-reset");
    var countEl  = document.getElementById("filter-count");
    var headers = table.querySelectorAll("thead th[data-sort]");
    var currentSort = {
        index: null,
        direction: "asc"
    };
    function norm(s) {
        return (s || "").toString().toLowerCase().trim();
    }
    function getVisibleDataRows() {
        return Array.prototype.slice.call(tbody.querySelectorAll("tr")).filter(function (row) {
            return !row.querySelector(".center");
        });
    }
    function updateCount() {
        var visible = getVisibleDataRows().filter(function (row) {
            return row.style.display !== "none";
        }).length;
        var total = getVisibleDataRows().length;
        if (countEl) {
            countEl.textContent = visible + " / " + total + " Zeilen";
        }
    }
    function applyFilters() {
        var qIan = norm(ianInput && ianInput.value);
        var qArt = norm(artInput && artInput.value);
        var qAus = norm(ausInput && ausInput.value);
        getVisibleDataRows().forEach(function (row) {
            var ian = norm(row.getAttribute("data-ian"));
            var art = norm(row.getAttribute("data-artikel"));
            var aus = norm(row.getAttribute("data-ausmusterung"));
            var show =
                (!qIan || ian.indexOf(qIan) !== -1) &&
                (!qArt || art.indexOf(qArt) !== -1) &&
                (!qAus || aus.indexOf(qAus) !== -1);
            row.style.display = show ? "" : "none";
        });
        updateCount();
    }
    function getCellValue(row, index) {
        var cell = row.children[index];
        if (!cell) return "";
        return (cell.textContent || "").trim();
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
        var rows = getVisibleDataRows();
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
    Array.prototype.forEach.call(headers, function (th) {
        th.addEventListener("click", function () {
            var index = parseInt(th.getAttribute("data-sort"), 10);
            var type = th.getAttribute("data-type") || "text";
            sortTableByColumn(index, type);
        });
    });
    applyFilters();
})();
</script>