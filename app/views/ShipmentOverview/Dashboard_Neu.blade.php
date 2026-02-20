  {{-- resources/views/projekts/index.blade.php --}}
  <style>
      :root {
          --bg-color: rgba(241, 216, 162, 0.5);
          --bg-colorHigh: rgba(241, 216, 162, 0.25);
          --bg-colorSticky: rgba(245, 236, 208);
          --bg-colorStickyHigh: rgba(253, 246,232);
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
      .chevron { display: inline-block; width: 18px; text-align: center; margin-right: 6px; }
      .inner-table{
          border-collapse: separate;
          border-spacing: 0;
          width: 100%;
          font-size: 12px;
          margin-top: 8px;
      }
      .inner-table th, .inner-table td{
          padding: 8px 10px;
          border-right: 1px solid #eee;
          border-bottom: 1px solid #eee;
          white-space: nowrap;
      }
   .inner-table thead th{
    background: #f7f7f7;     /* bleibt grau */
   color: #1e5fb8;
font-weight: 600;      /* nur Schrift blau */
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
      .filter-field{ display:flex; flex-direction:column; gap:6px; }
      .filter-field label{ font-size:12px; color:#444; }
      .filter-field input{
          padding: 8px 10px;
          border: 1px solid #d0d0d0;
          border-radius: 6px;
          min-width: 220px;
          font-size: 12px;
      }
      .filter-actions{ display:flex; gap:10px; }
      .btn{
          padding: 8px 10px;
          border: 1px solid #d0d0d0;
          background: #fff;
          border-radius: 6px;
          cursor: pointer;
          font-size: 12px;
      }
      .btn:hover{ background:#f7f7f7; }
      .btn-mini{ padding: 6px 8px; font-size: 12px; }
      /* Inline edit in Positionsdaten */
      .inner-table td[contenteditable="true"]{
          cursor: text;
          background: rgba(255,255,255,0.6);
      }
      .inner-table td.is-dirty{
          outline: 2px solid #ffe08a;
          outline-offset: -2px;
      }
      tr.is-saving td { opacity: .6; }
      tr.is-saved td  { outline: 2px solid #9fe6b8; outline-offset: -2px; }
      tr.is-error td  { outline: 2px solid #ff9a9a; outline-offset: -2px; }
      .inner-table th,
      .inner-table td {
          padding: 4px 8px;          /* vorher 8px 10px */
          line-height: 1.2;
          height: 26px;
          vertical-align: middle;
      }
      /* contenteditable-Zellen flach halten */
      .inner-table td[contenteditable="true"] {
          padding: 3px 6px;
          line-height: 1.2;
      }
      /* verhindert Aufblähen durch Zeilenumbrüche */
      .inner-table td {
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
      }
      /* Remove/Add Buttons auf Zeilenhöhe bringen */
      .inner-table .btn-mini,
      .inner-table .btn {
          padding: 2px 8px;
          font-size: 11px;
          line-height: 1.2;
          height: 22px;
      }
      /* Tabellenkopf der Positionsdaten ebenfalls kompakt */
      .inner-table thead th {
          padding: 4px 8px;
          height: 26px;
      }
      /* Fokusrahmen bei editierbaren Zellen ohne Layout-Shift */
      .inner-table td.is-dirty,
      .inner-table td:focus {
          outline-offset: -2px;
      }
      /* optional: Hover wie im Master */
      .inner-table tbody tr:hover td {
          background: rgba(0,0,0,0.02);
      }
      .row-toggle[aria-expanded="true"] td {
          background: #69a2f1 !important;   /* dezentes Blau */
      }
      /* optional: linke Markierungsleiste */
      .row-toggle[aria-expanded="true"] td:first-child {
          box-shadow: inset 4px 0 0 #2264af;
      }
      /* Hover soll Highlight nicht überdecken */
      .row-toggle[aria-expanded="true"]:hover td {
          filter: none;
      }
      /* =========================
        Marker: Positionsdaten vorhanden
      ========================= */
      .row-toggle.has-shipments td:first-child {
          box-shadow: inset 6px 0 0 #3aa76d;   /* grüner Streifen links */
      }
      /* optional zusätzlich leicht grünlicher Hover */
      .row-toggle.has-shipments:hover td {
          background-color: rgba(58,167,109,0.08);
      }
  </style>
  <?php
    $projekts  = $data['ppData']['kopf']; // Master
    $shipments = $data['ppData']['ship'] ?? []; // Detail
    $masterKey = 'PPProduktpass_Id';
    $detailKey = 'PPProduktpass_Id';
     $SHIP_FIELDS = array(
    array('key' => 'PPShipment_Lot',    'label' => 'Lot',    'type' => 'text'),
    array('key' => 'PPShipment_POD',    'label' => 'POD',    'type' => 'text'),
    array('key' => 'PPShipment_POA',    'label' => 'POA',    'type' => 'text'),
    array('key' => 'PPShipment_Forwarder', 'label' => 'Forwarder', 'type' => 'text'),
    array('key' => 'PPShipment_Carrier', 'label' => 'Carrier', 'type' => 'text'),
    array('key' => 'PPShipment_Vessel', 'label' => 'Vessel', 'type' => 'text'),
    array('key' => 'PPShipment_Voyage', 'label' => 'Voyage', 'type' => 'text'),
    array('key' => 'PPShipment_CRDGiven', 'label' => 'CRD Given', 'type' => 'text'),
    array('key' => 'PPShipment_CRDOpeningCalc', 'label' => 'CRD Opening Calc', 'type' => 'number'),
    array('key' => 'PPShipment_CRDClosingCalc', 'label' => 'CRD Closing Calc', 'type' => 'number'),
    array('key' => 'PPShipment_20ftGP', 'label' => '20ftGP', 'type' => 'number'),
    array('key' => 'PPShipment_40ftGP', 'label' => '40ftGP', 'type' => 'number'),
    array('key' => 'PPShipment_ETD', 'label' => 'ETD', 'type' => 'date'),
    array('key' => 'PPShipment_ETA', 'label' => 'ETA', 'type' => 'date'),
    array('key' => 'PPShipment_CurrentStatus', 'label' => 'Current Status', 'type' => 'text'),
    array('key' => 'PPShipment_BLForm', 'label' => 'BL Form', 'type' => 'text'),
    array('key' => 'PPShipment_ShipRelease', 'label' => 'Ship Release', 'type' => 'date'),
    array('key' => 'PPShipment_OceanFreight','label'=>'Ocean Freight','type'=>'number'),
    array('key' => 'PPShipment_INCOTERM','label'=>'INCOTERM','type'=>'text'),
    array('key' => 'PPShipment_MS_30PSI','label'=>'30% PSI','type'=>'date'),
    array('key' => 'PPShipment_MS_EUG','label'=>'EUG','type'=>'date'),
    array('key' =>'PPShipment_MS_PSI','label'=>'100% PSI','type'=>'date')
    // Beispiel: neues Feld hinzufügen -> NUR HIER ergänzen:
    // array('key' => 'PPShipment_Vessel', 'label' => 'Vessel', 'type' => 'text'),
  );
  // JSON für data-attribute (Laravel4-sicher)
  $SHIP_FIELDS_JSON = htmlspecialchars(json_encode($SHIP_FIELDS), ENT_QUOTES, 'UTF-8');
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
      </div>
      <div class="muted" id="filter-count" aria-live="polite"></div>
    </div>
    <div class="table-wrap">
      <table class="big-table" aria-label="Kopfdaten" id="projekts-table">
        <thead>
          <tr>
            <th>IAN!</th>
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
              $ianVal = trim((string)($projekt->IAN ?? ''));
              $artVal = trim((string)($projekt->Artikelbezeichnung ?? ''));
            ?>
            {{-- MASTER --}}
           <tr class="row-toggle {{ $hasShip ? 'has-shipments' : '' }}"
    data-target="{{ $detailRowId }}"
    data-ian="{{ e($ianVal) }}"
    data-artikel="{{ e($artVal) }}"
    data-ausmusterung="{{ e(trim((string)($projekt->Ausmusterung ?? ''))) }}"
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
            {{-- DETAIL --}}
            <tr id="{{ $detailRowId }}" class="detail-row" hidden>
              <td class="detail-cell" colspan="7">
                <div class="detail-content" style="background-color: var({{ $bgVar }});">
                  <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
                    <div class="muted">Lot-Daten</div>
                    <button type="button"
        class="btn btn-add-shipment"
        data-master-id="{{ $masterVal }}"
        data-save-url="{{ URL::to('/saveLot') }}"
        data-delete-url="{{ URL::to('/deleteLot') }}"
        data-fields="{{ $SHIP_FIELDS_JSON }}">
  Add
</button>
                  </div>
                  <table class="inner-table" aria-label="Lot-Daten">
    <thead>
  <tr>
    @foreach($SHIP_FIELDS as $f)
      <th>{{ $f['label'] }}</th>
    @endforeach
    <th></th>
  </tr>
</thead>
    <tbody>
  @forelse($projektShipments as $shipment)
    <?php
      $shipId = is_array($shipment) ? ($shipment['PPShipment_Id'] ?? null) : ($shipment->PPShipment_Id ?? null);
    ?>
    <tr class="js-shipment-row"
        data-shipment-id="{{ $shipId }}"
        data-master-id="{{ $masterVal }}">
      @foreach($SHIP_FIELDS as $f)
        <?php
          $k = $f['key'];
          $val = is_array($shipment) ? ($shipment[$k] ?? null) : ($shipment->$k ?? null);
          if ($val && $f['type'] === 'date') {
                $ts = strtotime($val);
                if ($ts) {
                    $val = date('Y-m-d', $ts);
                }
            }
        ?>
        <td class="js-ship-cell"
            contenteditable="true"
            data-field="{{ $k }}"
            data-type="{{ $f['type'] }}"
            data-original="{{ e($val) }}">{{ $val }}</td>
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
              <td colspan="9" class="muted center">Keine Projekte vorhanden.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <script>
/**
 * Guard: verhindert doppeltes Binden der Event Listener,
 * falls das Script (aus Versehen) mehr als 1x eingebunden wird.
 */
if (window.__PP_SHIP_SCRIPT_BOUND__) {
  console.warn('PP shipment script already bound - skipping duplicate bind.');
} else {
  window.__PP_SHIP_SCRIPT_BOUND__ = true;
  /* =========================
     Master/Detail Toggle
  ========================= */
  document.querySelectorAll(".row-toggle").forEach(function (row) {
    row.addEventListener("click", function () {
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
     Filter IAN + Artikel
  ========================= */
 (function () {
  var ianInput = document.getElementById("filter-ian");
  var artInput = document.getElementById("filter-artikel");
  var ausInput = document.getElementById("filter-ausmusterung"); // NEU
  var resetBtn = document.getElementById("filter-reset");
  var countEl  = document.getElementById("filter-count");
  var masterRows = Array.prototype.slice.call(document.querySelectorAll("tr.row-toggle"));
  function norm(s) { return (s || "").toString().toLowerCase().trim(); }
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
    var qAus = norm(ausInput && ausInput.value); // NEU
    var visible = 0;
    masterRows.forEach(function (mr) {
      var ian = norm(mr.getAttribute("data-ian"));
      var art = norm(mr.getAttribute("data-artikel"));
      var aus = norm(mr.getAttribute("data-ausmusterung")); // NEU
      var show =
        (!qIan || ian.indexOf(qIan) !== -1) &&
        (!qArt || art.indexOf(qArt) !== -1) &&
        (!qAus || aus.indexOf(qAus) !== -1); // NEU
      mr.style.display = show ? "" : "none";
      var dr = document.getElementById(mr.getAttribute("data-target"));
      if (dr) {
        if (show) dr.style.display = "";
        else {
          closeDetails(mr);
          dr.style.display = "none";
        }
      }
      if (show) visible++;
    });
    if (countEl) countEl.textContent = visible + " / " + masterRows.length + " Projekte";
  }
  if (ianInput) ianInput.addEventListener("input", applyFilters);
  if (artInput) artInput.addEventListener("input", applyFilters);
  if (ausInput) ausInput.addEventListener("input", applyFilters); // NEU
  if (resetBtn) resetBtn.addEventListener("click", function () {
    ianInput.value = "";
    artInput.value = "";
    if (ausInput) ausInput.value = ""; // NEU
    applyFilters();
  });
  applyFilters();
})();
  /* =========================
     Positionsdaten Grid Logic
  ========================= */
 (function () {
  var CSRF = '{{ csrf_token() }}';
  function text(el){ return (el.innerText || '').trim(); }
  function setText(el,v){ el.textContent = v || ''; }
  function normalizeNumber(v){
    v = (v||'').toString().trim();
    if (v === '') return '';
    return v.replace(/\./g,'').replace(',', '.');
  }
  function sanitizeNumeric(v){
    v = (v||'').toString().replace(/[^\d\.,-]/g,'');
    v = v.replace(/(?!^)-/g,'');
    return v;
  }
  function setRowState(tr, state){
    tr.classList.remove('is-saving','is-saved','is-error');
    if (state) tr.classList.add(state);
  }
  // ---- fields pro Detailbereich aus data-fields holen (cache)
  var fieldsCache = new WeakMap();
  function getFieldsFromDetail(detailContent){
    if (fieldsCache.has(detailContent)) return fieldsCache.get(detailContent);
    var btn = detailContent.querySelector('.btn-add-shipment');
    var raw = btn ? btn.getAttribute('data-fields') : '[]';
    var fields = [];
    try { fields = JSON.parse(raw || '[]'); } catch(e){ fields = []; }
    fieldsCache.set(detailContent, fields);
    return fields;
  }
  function getSaveUrlFromDetail(detailContent){
    var btn = detailContent.querySelector('.btn-add-shipment');
    return btn ? btn.getAttribute('data-save-url') : '/saveLot';
  }
  function getDeleteUrlFromBtn(btn){
    return (btn && btn.getAttribute('data-delete-url')) || '/deleteLot';
  }
  // ---- Payload dynamisch aus Fields bauen
  function buildPayload(tr, fields){
    var payload = {
      _token: CSRF,
      PPProduktpass_Id: tr.getAttribute('data-master-id'),
      PPShipment_Id: tr.getAttribute('data-shipment-id') || null
    };
    fields.forEach(function(f){
      var key = f.key;
      var td = tr.querySelector('[data-field="' + key + '"]');
      var val = td ? text(td) : '';
      if (f.type === 'number') val = normalizeNumber(val);
      payload[key] = val;
    });
    return payload;
  }
  // ---- Save Lock + Pending
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
          if (res && res.PPShipment_Id) tr.setAttribute('data-shipment-id', res.PPShipment_Id);
        } catch(e){}
        tr.querySelectorAll('.js-ship-cell').forEach(function(td){
          td.setAttribute('data-original', text(td));
          td.classList.remove('is-dirty');
        });
        setRowState(tr, 'is-saved');
        setTimeout(function(){ setRowState(tr, ''); }, 700);
        if (tr.getAttribute('data-pending') === '1') {
          tr.removeAttribute('data-pending');
          setTimeout(function(){ saveRow(tr); }, 0);
        }
      } else {
        setRowState(tr, 'is-error');
        console.error('saveLot failed', xhr.status, xhr.responseText);
      }
    };
    xhr.send(JSON.stringify(buildPayload(tr, fields)));
  }
  // ---- Debounce pro Row
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
  // ---- Enter: nächste Zelle
  function focusNext(td){
    var tr = td.closest('tr.js-shipment-row');
    if (!tr) return;
    var cells = Array.from(tr.querySelectorAll('.js-ship-cell'));
    var i = cells.indexOf(td);
    if (i < cells.length - 1) cells[i+1].focus();
  }
  document.addEventListener('keydown', function(e){
    var td = e.target.closest && e.target.closest('.js-ship-cell');
    if (!td) return;
    if (e.key === 'Enter') {
      e.preventDefault();
      focusNext(td);
      return;
    }
    // numeric guard über data-type
    if (td.getAttribute('data-type') === 'number') {
      if (e.ctrlKey || e.metaKey || e.altKey) return;
      var ok = /^[0-9]$/.test(e.key) || e.key === ',' || e.key === '.' || e.key === '-' ||
               ['Backspace','Delete','ArrowLeft','ArrowRight','Tab','Home','End'].includes(e.key);
      if (!ok) e.preventDefault();
    }
  }, true);
  document.addEventListener('input', function(e){
    var td = e.target.closest && e.target.closest('.js-ship-cell');
    if (!td) return;
    var tr = td.closest('tr.js-shipment-row');
    if (td.getAttribute('data-type') === 'number') {
      var v = text(td);
      var s = sanitizeNumeric(v);
      if (s !== v) setText(td, s);
    }
    if (text(td) !== (td.getAttribute('data-original') || '')) td.classList.add('is-dirty');
    else td.classList.remove('is-dirty');
    scheduleSave(tr);
  }, true);
  document.addEventListener('focusout', function(e){
    var td = e.target.closest && e.target.closest('.js-ship-cell');
    if (!td) return;
    var tr = td.closest('tr.js-shipment-row');
    clearTimeout(timers.get(tr));
    saveRow(tr);
  }, true);
  // ---- Add Row dynamisch aus Fields
  document.addEventListener('click', function(e){
    var btn = e.target.closest && e.target.closest('.btn-add-shipment');
    if (!btn) return;
    var detail = btn.closest('.detail-content');
    var tbody  = detail ? detail.querySelector('tbody') : null;
    if (!detail || !tbody) return;
    var fields = getFieldsFromDetail(detail);
    var emptyRow = tbody.querySelector('tr.no-rows');
    if (emptyRow) emptyRow.remove();
    var tr = document.createElement('tr');
    tr.className = 'js-shipment-row';
    tr.setAttribute('data-master-id', btn.getAttribute('data-master-id'));
    tr.setAttribute('data-shipment-id', '');
    fields.forEach(function(f){
      var td = document.createElement('td');
      td.contentEditable = true;
      td.className = 'js-ship-cell is-dirty';
      td.setAttribute('data-field', f.key);
      td.setAttribute('data-type', f.type || 'text');
      td.setAttribute('data-original', '');
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
    var first = tr.querySelector('.js-ship-cell');
    if (first) first.focus();
  });
  // ---- Remove (soft delete)
  document.addEventListener('click', function(e){
    var btn = e.target.closest && e.target.closest('.js-remove-shipment');
    if (!btn) return;
    var tr = btn.closest('tr.js-shipment-row');
    if (!tr) return;
    var id = tr.getAttribute('data-shipment-id');
    // neue, noch nicht gespeicherte Zeile
    if (!id) {
      tr.remove();
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
        tr.remove();
      } else {
        setRowState(tr, 'is-error');
        console.error('deleteLot failed', xhr.status, xhr.responseText);
      }
    };
    xhr.send(JSON.stringify({_token: CSRF, PPShipment_Id: id}));
  });
})();
}
</script>
