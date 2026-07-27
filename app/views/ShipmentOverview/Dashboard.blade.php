{{-- app/views/yourtable/index.blade.php (Laravel 4) --}}
<style>
    :root {
        --bg-color: rgba(105, 162, 241, 0.28);
        --bg-colorHigh: rgba(105, 162, 241, 0.14);
        --bg-colorSticky: rgba(218, 234, 255, 1);
        --bg-colorStickyHigh: rgba(235, 244, 255, 1);
        --active-row: rgba(105, 162, 241, 0.35);
        --active-cell: rgba(34, 100, 175, 0.22);
        --active-border: #2264af;
    }
    .container{
        padding: 20px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 1em;
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
        color: #222;
        text-decoration: none;
        display: inline-block;
    }
    .btn:hover{ background:#f7f7f7; }
    .table-wrap{
        height: 70vh;
        overflow: auto;
        border: 1px solid #ddd;
        background: #fff;
    }
    .big-table{
        border-collapse: separate;
        border-spacing: 0;
        min-width: 1600px;
        width: max-content;
        font-size: 12px;
    }
    .big-table th, .big-table td{
        padding: 8px 10px;
        border-right: 1px solid #eee;
        border-bottom: 1px solid #eee;
        white-space: nowrap;
        background: transparent;
    }
    .big-table thead th{
        position: sticky;
        top: 0;
        z-index: 50;
        background: #f7f7f7;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }
    .sticky-col{
        position: sticky;
        left: 0;
        z-index: 40;
        background: #fff;
        box-shadow: 1px 0 0 #ddd;
    }
    .col-ID{ left: 0; min-width: 80px; }
    .col-IAN{ left: 80px; min-width: 180px; }
    .col-Ausmusterungnummer{ left: 260px; min-width: 180px; }
    .big-table thead .sticky-col{
        z-index: 60;
        background: #f7f7f7;
    }
    .cell[contenteditable="true"]{
        cursor: text;
    }
    .cell.is-dirty{
        outline: 2px solid #ffe08a;
        background: #fffdf3 !important;
    }
    .cell.is-saving{
        opacity: .6;
    }
    .cell.is-saved{
        outline: 2px solid #9fe6b8;
        background: #f3fff7 !important;
    }
    .cell.is-error{
        outline: 2px solid #ff9a9a;
        background: #fff3f3 !important;
    }
    .muted{ color:#777; font-size: 12px; }
    .center{ text-align:center; }
    .big-table tbody tr.is-active-row > td{
        background: var(--active-row) !important;
    }
    .big-table td.is-active-cell{
        background: var(--active-cell) !important;
        outline: 2px solid var(--active-border);
        outline-offset: -2px;
    }
    .big-table tbody tr.is-active-row > td.sticky-col{
        background: var(--active-row) !important;
    }
    .big-table td.sticky-col.is-active-cell{
        background: var(--active-cell) !important;
    }
    .ian-break td{
        border-top: 3px solid #2264af;
    }
    td.js-datecell[contenteditable="true"] { cursor: pointer; }
        .header-filter{
        margin-top: 6px;
        width: 100%;
        min-width: 120px;
        box-sizing: border-box;
        padding: 4px 6px;
        border: 1px solid #c8d6ea;
        border-radius: 4px;
        font-size: 11px;
        font-weight: normal;
        background: #fff;
    }
    .big-table thead th{
        vertical-align: top;
    }
</style>
<link rel="stylesheet" href="/css/flatpickr.min.css">
<script src="/js/flatpicker.min.js"></script>
<script src="/js/flatpickr.l10n.de.js"></script>
<div class="container">
    <h1 class="page-header">{{ $data['title'] }}</h1>
    <div class="table-wrap">
        <table class="big-table" id="shipment-flat-table">
           <thead>
    <tr>
        @foreach ($data['labels'] as $att => $label)
            @if (substr($label,0,1) === '@')
                <th class="sticky-col col-{{ substr($label,1) }}">
                    {{ substr($label,1) }}
                    @if (strpos($label, 'IAN') !== false)
                        <br>
                        <input class="header-filter"
                               id="filter-ian"
                               type="text"
                               placeholder="Filter IAN"
                               autocomplete="off">
                    @elseif (strpos($label, 'Ausmusterung') !== false)
                        <br>
                        <input class="header-filter"
                               id="filter-ausmusterung"
                               type="text"
                               placeholder="Filter Ausmusterung"
                               autocomplete="off">
                    @endif
                </th>
            @else
                <?php
                    $cleanLabel = $label;
                    if (is_string($cleanLabel) && strlen($cleanLabel) >= 2 && substr($cleanLabel, -2, 1) === '#') {
                        $cleanLabel = substr($cleanLabel, 0, -2);
                    }
                    if (substr($cleanLabel,0,1) === '+') {
                        $cleanLabel = substr($cleanLabel, 1);
                    }
                ?>
                <th>
                    {{ $cleanLabel }}
                    @if ($cleanLabel === 'Artikelbezeichnung')
                        <br>
                        <input class="header-filter"
                               id="filter-artikel"
                               type="text"
                               placeholder="Filter Artikel"
                               autocomplete="off">
                    @endif
                </th>
            @endif
        @endforeach
    </tr>
</thead>
            <tbody>
                <?php
                    $ian = 'X';
                    $bgcolor = '--bg-colorHigh';
                    $bgStickyColor = '--bg-colorStickyHigh';
                    $ianBreak = 'ian-break';
                ?>
                @forelse($data['ppData'] as $row)
                    <?php
                        if ($row->IAN != $ian) {
                            $ianBreak = 'ian-break';
                            if ($bgcolor == '--bg-colorHigh') {
                                $bgcolor = '--bg-color';
                                $bgStickyColor = '--bg-colorSticky';
                            } else {
                                $bgcolor = '--bg-colorHigh';
                                $bgStickyColor = '--bg-colorStickyHigh';
                            }
                            $ian = $row->IAN;
                        } else {
                            $ianBreak = '';
                        }
                        $ianVal = isset($row->IAN) ? trim((string)$row->IAN) : '';
                        $artVal = isset($row->Artikelbezeichnung) ? trim((string)$row->Artikelbezeichnung) : '';
                        $ausVal = '';
                        if (isset($row->Ausmusterung)) {
                            $ausVal = trim((string)$row->Ausmusterung);
                        } elseif (isset($row->Ausmusterungnummer)) {
                            $ausVal = trim((string)$row->Ausmusterungnummer);
                        }
                    ?>
                    <tr data-row-id="{{ $row->PPProduktpass_Id }}"
                        class="{{ $ianBreak }}"
                        data-ian="{{ e($ianVal) }}"
                        data-artikel="{{ e($artVal) }}"
                        data-ausmusterung="{{ e($ausVal) }}">
                        @foreach ($data['labels'] as $att => $label)
                            @if (substr($label,0,1) === '@')
                                <td class="cell sticky-col col-{{ substr($label,1) }}"
                                    contenteditable="false"
                                    style="background-color: var({{ $bgStickyColor }});">
                                    @if (strpos($label,'IAN') !== false)
                                        <a href="/dbIANdirect/{{ $row->IAN }}" target="_blank">{{ e($row->$att) }}</a>
                                    @else
                                        {{ e($row->$att) }}
                                    @endif
                                </td>
                            @else
                                <?php
                                    $align = 'left';
                                    $type = 'c';
                                    $displayLabel = $label;
                                    if (is_string($label) && strlen($label) >= 2 && substr($label, -2, 1) === '#') {
                                        $format = substr($label, -1);
                                        $displayLabel = substr($label, 0, -2);
                                        if ($format == 'd') {
                                            if ($row->$att == null || $row->$att == '' || $row->$att == '0000-00-00 00:00:00') {
                                                $row->$att = '';
                                            } else {
                                                $d = new DateTime($row->$att);
                                                $row->$att = $d->format('d.m.Y');
                                            }
                                            $align = 'right';
                                            $type = 'd';
                                        }
                                        if ($format == 'n') {
                                            $row->$att = number_format($row->$att, 0, ',', '.');
                                            $align = 'right';
                                            $type = 'n';
                                        }
                                        if ($format == 'f') {
                                            $row->$att = number_format($row->$att, 2, ',', '.');
                                            $align = 'right';
                                            $type = 'n';
                                        }
                                    }
                                ?>
                                @if (substr($label,0,1) === '+')
                                    @if ($type == 'd')
                                        <td class="cell js-datecell"
                                            contenteditable="true"
                                            data-field="{{ $att }}"
                                            data-original="{{ e($row->$att) }}"
                                            data-date-format="d.m.Y"
                                            style="background-color: var({{ $bgcolor }}); text-align: {{ $align }};">{{ e($row->$att) }}</td>
                                    @else
                                        <td class="cell"
                                            contenteditable="true"
                                            data-field="{{ $att }}"
                                            data-original="{{ e($row->$att) }}"
                                            style="background-color: var({{ $bgcolor }}); text-align: {{ $align }};">{{ e($row->$att) }}</td>
                                    @endif
                                @else
                                    <td class="cell"
                                        contenteditable="false"
                                        style="background-color: var({{ $bgcolor }}); text-align: {{ $align }};">{{ e($row->$att) }}</td>
                                @endif
                            @endif
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="16" class="muted center">Keine Daten vorhanden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<script>
(function() {
    var CSRF = '{{ csrf_token() }}';
    function text(el){
        return (el.innerText || el.textContent || '').trim();
    }
    function closest(el, selector){
        while (el && el.nodeType === 1) {
            if (el.matches && el.matches(selector)) return el;
            el = el.parentElement;
        }
        return null;
    }
    document.addEventListener('input', function(e){
        var td = closest(e.target, 'td.cell');
        if (!td) return;
        var current = text(td);
        var original = td.getAttribute('data-original') || '';
        if (current !== original) td.classList.add('is-dirty');
        else td.classList.remove('is-dirty');
    }, true);
    function saveCell(target){
        var td = closest(target, 'td.cell');
        if (!td) return;
        var tr = closest(td, 'tr[data-row-id]');
        if (!tr) {
            console.error('No TR with data-row-id found for cell', td);
            return;
        }
        var rowId = tr.getAttribute('data-row-id');
        var field = td.getAttribute('data-field');
        var value = text(td);
        var original = td.getAttribute('data-original') || '';
        if (!rowId || !field) {
            console.error('Missing rowId/field', {rowId: rowId, field: field, td: td, tr: tr});
            return;
        }
        if (value === original) return;
        td.classList.remove('is-error','is-saved');
        td.classList.add('is-saving');
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ URL::to("/cellupdate") }}', true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
        xhr.setRequestHeader('X-CSRF-TOKEN', CSRF);
        xhr.onreadystatechange = function(){
            if (xhr.readyState !== 4) return;
            td.classList.remove('is-saving');
            if (xhr.status >= 200 && xhr.status < 300) {
                td.setAttribute('data-original', value);
                td.classList.remove('is-dirty');
                td.classList.add('is-saved');
                setTimeout(function(){ td.classList.remove('is-saved'); }, 800);
            } else {
                td.classList.add('is-error');
                console.error('Save failed', xhr.status, xhr.responseText);
            }
        };
        xhr.send(JSON.stringify({
            _token: CSRF,
            row_id: rowId,
            field: field,
            value: value
        }));
    }
    document.addEventListener('focusout', function(e){
        var td = closest(e.target, 'td.cell');
        if (!td) return;
        if (td.getAttribute('data-picking') === '1') return;
        saveCell(td);
    }, true);
    document.addEventListener('keydown', function(e){
        var td = closest(e.target, 'td.cell');
        if (!td) return;
        if (e.key === 'Enter') {
            e.preventDefault();
            td.blur();
        }
        if (e.key === 'Escape') {
            if (td.classList.contains('js-datecell') && td.getAttribute('data-picking') === '1') {
                e.preventDefault();
                e.stopPropagation();
                if (td._flatpickr) td._flatpickr.close();
                td.removeAttribute('data-picking');
                td.focus();
                return;
            }
            var original = td.getAttribute('data-original') || '';
            td.innerText = original;
            td.classList.remove('is-dirty','is-error');
            td.blur();
        }
    }, true);
    function clearActive(table){
        var prevRow = table.querySelector('tr.is-active-row');
        if (prevRow) prevRow.classList.remove('is-active-row');
        var prevCell = table.querySelector('td.is-active-cell');
        if (prevCell) prevCell.classList.remove('is-active-cell');
    }
    var table = document.querySelector('.big-table');
    if (table) {
        table.addEventListener('focusin', function(e){
            var td = closest(e.target, 'td.cell');
            if (!td) return;
            clearActive(table);
            var tr = closest(td, 'tr');
            if (tr) tr.classList.add('is-active-row');
            td.classList.add('is-active-cell');
        });
        table.addEventListener('focusout', function(e){
            var td = closest(e.target, 'td.cell');
            if (!td) return;
            setTimeout(function(){
                var active = document.activeElement;
                if (active && active.classList && active.classList.contains('cell')) return;
                clearActive(table);
            }, 0);
        });
    }
    function attachDatepickerToTd(td) {
        if (td._fpAttached) return;
        td._fpAttached = true;
        var input = document.createElement('input');
        input.type = 'text';
        input.style.position = 'absolute';
        input.style.opacity = '0';
        input.style.width = '1px';
        input.style.height = '1px';
        input.style.pointerEvents = 'none';
        if (!td.style.position) td.style.position = 'relative';
        td.appendChild(input);
        var fmt = td.getAttribute('data-date-format') || 'd.m.Y';
        var fp = flatpickr(input, {
            dateFormat: fmt,
            locale: flatpickr.l10ns.de,
            allowInput: true,
            defaultDate: text(td) || null,
            onOpen: function () {
                td.setAttribute('data-picking', '1');
            },
            onChange: function (selectedDates, dateStr) {
                td.innerText = dateStr;
                td.classList.add('is-dirty');
                this.close();
            },
            onClose: function () {
                td.removeAttribute('data-picking');
                td.focus();
            }
        });
        td.addEventListener('click', function () { fp.open(); });
        td.addEventListener('focus', function () { fp.open(); });
        td.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                fp.open();
            }
        });
        td._flatpickr = fp;
    }
    function initDatepickers() {
        var tds = document.querySelectorAll('td.js-datecell[contenteditable="true"]');
        for (var i = 0; i < tds.length; i++) {
            attachDatepickerToTd(tds[i]);
        }
    }
    initDatepickers();
    /* =========================
       Filter IAN + Artikel + Ausmusterung
    ========================= */
    (function () {
        var ianInput = document.getElementById("filter-ian");
        var artInput = document.getElementById("filter-artikel");
        var ausInput = document.getElementById("filter-ausmusterung");
        var resetBtn = document.getElementById("filter-reset");
        var countEl  = document.getElementById("filter-count");
        var masterRows = Array.prototype.slice.call(document.querySelectorAll("tr[data-row-id]"));
        function norm(s) {
            return (s || "").toString().toLowerCase().trim();
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
                if (show) visible++;
            });
            if (countEl) {
                countEl.textContent = visible + " / " + masterRows.length + " Zeilen";
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
})();
</script>