{{-- app/views/yourtable/index.blade.php (Laravel 4) --}}
<style>
     :root {
        --bg-color: rgb(241, 216, 162, 0.5);
        --bg-colorHigh: rgba(241, 216, 162, 0.25);
        --bg-colorSticky: rgba(245, 236, 208);
        --bg-colorStickyHigh: rgba(253, 246,232);
    }
    /* Wrapper: horizontal + vertical scroll, damit sticky sinnvoll ist */
    .table-wrap{
        height: 70vh;               /* viewport-abhängig */
        overflow: auto;
        border: 1px solid #ddd;
        background: #fff;
    }
    /* Tabelle breit halten */
    .big-table{
        border-collapse: separate;   /* wichtig für sticky + borders */
        border-spacing: 0;
        min-width: 1600px;          /* 15 Spalten => Scroll statt Quetschen */
        width: max-content;
        font-size: 12px;
    }
    /* Zellen */
    .big-table th, .big-table td{
        padding: 8px 10px;
        border-right: 1px solid #eee;
        border-bottom: 1px solid #eee;
        white-space: nowrap;
        background: transparent;
    }
    /* Sticky Header */
    .big-table thead th{
        position: sticky;
        top: 0;
        z-index: 50;                /* über Body */
        background: #f7f7f7;
        border-bottom: 1px solid #ddd;
    }
    /* Sticky Spalten: 1-3 links fixieren */
    .sticky-col{
        position: sticky;
        left: 0;
        z-index: 40;                /* über normale Zellen */
        background: #fff;
        box-shadow: 1px 0 0 #ddd;   /* Trennlinie rechts */
    }
    /* Linke Offsets je Spalte (müssen zur tatsächlichen Breite passen) */
    .col-ID{ left: 0;     min-width: 80px;  }
    .col-IAN{ left: 80px;  min-width: 180px; }
    .col-Ausmusterungnummer{ left: 260px; min-width: 180px; }
    /* Sticky Header + Sticky Col Intersection: noch höher */
    .big-table thead .sticky-col{
        z-index: 60;
        background: #f7f7f7;
    }
    /* Inline Edit UX */
    .cell[contenteditable="true"]{
        cursor: text;
    }
    .cell.is-dirty{
        outline: 2px solid #ffe08a;
        background: #fffdf3;
    }
    .cell.is-saving{
        opacity: .6;
    }
    .cell.is-saved{
        outline: 2px solid #9fe6b8;
        background: #f3fff7;
    }
    .cell.is-error{
        outline: 2px solid #ff9a9a;
        background: #fff3f3;
    }
    .muted{ color:#777; }
    .center{ text-align:center; }
    /* Ganze Zeile markieren, wenn eine Zelle aktiv ist */
    .big-table tbody tr.is-active-row > td{
        background: #fcefcc;
    }
    /* Active Cell stärker hervorheben */
    .big-table td.is-active-cell{
        background: #ddd3bc;      /* andere Farbe als die Zeile */
        outline: 2px solid #f0860c;
        outline-offset: -2px;
    }
    /* Optional: damit Sticky-Zellen bei Row-Highlight mitziehen */
    .big-table tbody tr.is-active-row > td.sticky-col{
        background: #fcefcc; /* gleiche Zeilenfarbe */
    }
    /* Active sticky cell gewinnt */
    .big-table td.sticky-col.is-active-cell{
        background: #fcefcc;
    }
    .container{
        padding: 20px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 1em;
    }
    .ian-break td{
        border-top: 3px solid #999;
    }
    td.js-datecell[contenteditable="true"] { cursor: pointer; }
</style>
<link rel="stylesheet" href="/css/flatpickr.min.css">
<script src="/js/flatpicker.min.js"></script>
<script src="/js/flatpickr.l10n.de.js"></script>
<div class="container">
    <h1 class="page-header">{{ $data['title'] }}</h1>
    <div class="table-wrap">
        <table class="big-table">
            <thead>
                <tr>
                    @foreach ($data['labels'] as $label)
                    @if (substr($label,0,1) === '@')
                        <th class="sticky-col col-{{ substr($label,1) }}">{{ substr($label,1) }}</th>
                    @else
                        <?php 
                            if (is_string($label) && strlen($label) >= 2 && substr($label, -2, 1) === '#') {
                                $label = substr($label, 0, -2);
                            }
                        ?>
                        <th>{{ $label }}</th>
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
                        if($bgcolor == '--bg-colorHigh'){
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
                    $colspan = count($data['labels']);
                ?>@if ($ianBreak == 'ian-break')
                <tr data-row-id="{{ $row->PPProduktpass_Id }}" class="{{ $ianBreak }}">
                    @foreach ($data['labels'] as $att => $label)
                        @if (substr($label,0,1) === '@')
                            <td class="cell sticky-col col-{{ substr($label,1) }}" contenteditable="false" style="background-color: var({{ $bgStickyColor }});" >@if (strpos($label,'IAN') !== false) <a href="/dbIANdirect/{{ $row->IAN }}" target="_blank">{{ e($row->$att) }}</a> @else {{ e($row->$att) }} @endif</td>
                        @else
                            <?PHP 
                                $align = 'left';
                                $type = 'c';
                                if (is_string($label) && strlen($label) >= 2 && substr($label, -2, 1) === '#') {
                                    $format = $label[-1];
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
                                    <td class="cell js-datecell" contenteditable="true" data-field="{{ $att }}" data-original="{{ e($row->$att) }}" data-date-format="d.m.Y" style="background-color: var({{ $bgcolor }}); text-align: {{ $align }};">{{ e($row->$att) }}</td>
                                @elseif ($type == 'n')
                                    <td class="cell" contenteditable="true" data-field="{{ $att }}"  data-original="{{ e($row->$att) }}" style="background-color: var({{ $bgcolor }}); text-align: {{ $align }};">{{ e($row->$att) }}</td>
                                @else
                                    <td class="cell" contenteditable="true" data-field="{{ $att }}"  data-original="{{ e($row->$att) }}" style="background-color: var({{ $bgcolor }}); text-align: {{ $align }};">{{ e($row->$att) }}</td>
                                @endif
                            @elseif (substr($label,0,1) === '@')
                                <td class="cell" contenteditable="false" style="background-color: var({{ $bgStickyColor }}); text-align: {{ $align }};">{{ e($row->$att) }} - {{$label}}</td>
                            @else
                                <td class="cell" contenteditable="false" style="background-color: var({{ $bgcolor }}); text-align: {{ $align }};">{{ e($row->$att) }}</td>
                            @endif
                        @endif
                    @endforeach
                </tr>
                @endif
                <tr>
                    <td colspan="{{ $colspan }}" style="background-color: orange;">&nbsp;</td>
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
    // Dirty-Markierung
    document.addEventListener('input', function(e){
        var td = closest(e.target, 'td.cell');
        if (!td) return;
        var current = text(td);
        var original = td.getAttribute('data-original') || '';
        if (current !== original) td.classList.add('is-dirty');
        else td.classList.remove('is-dirty');
    }, true);
    // Speichern
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
        console.log('saveCell payload', {rowId: rowId, field: field, value: value, original: original});
        if (!rowId || !field) {
            console.error('Missing rowId/field', {rowId: rowId, field: field, td: td, tr: tr});
            return;
        }
        if (value === original) {
            // nichts geändert
            return;
        }
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
                console.log('Save successful', xhr.responseText);
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
    // Save beim Verlassen einer Zelle (robust für contenteditable)
   document.addEventListener('focusout', function(e){
    var td = closest(e.target, 'td.cell');
    if (!td) return;
    // Wenn Datepicker offen ist: nicht speichern
    if (td.getAttribute('data-picking') === '1') return;
    console.log('focusout → saveCell');
    saveCell(td);
    }, true);
    // Enter/Escape
   document.addEventListener('keydown', function(e){
        var td = closest(e.target, 'td.cell');
        if (!td) return;
        if (e.key === 'Enter') {
            e.preventDefault();
            td.blur();
        }
        if (e.key === 'Escape') {
            // Wenn Datepicker offen ist: NUR schließen, nichts zurücksetzen
            if (td.classList.contains('js-datecell') && td.getAttribute('data-picking') === '1') {
                e.preventDefault();
                e.stopPropagation();
                // Picker schließen, falls vorhanden
                if (td._flatpickr) td._flatpickr.close();
                // Flag sauber entfernen (falls onClose nicht feuert)
                td.removeAttribute('data-picking');
                // Fokus zurück auf die Zelle
                td.focus();
                return;
            }
            // Sonst: normales Verhalten (Revert)
            var original = td.getAttribute('data-original') || '';
            td.innerText = original;
            td.classList.remove('is-dirty','is-error');
            td.blur();
        }
    }, true);
    // Row + Active Cell Highlight
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
                // Wenn Fokus inzwischen in anderer Zelle ist -> nicht löschen
                if (active && active.classList && active.classList.contains('cell')) return;
                clearActive(table);
            }, 0);
        });
    }
    function attachDatepickerToTd(td) {
        if (td._fpAttached) return;
        td._fpAttached = true;
        // flatpickr braucht ein Input-Element
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
            locale: flatpickr.l10ns.de, // Deutsch
            allowInput: true,
            defaultDate: text(td) || null,
            onOpen: function () {
                td.setAttribute('data-picking', '1');
            },
            onChange: function (selectedDates, dateStr) {
                td.innerText = dateStr;
                td.classList.add('is-dirty');
                // Picker sofort schließen
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
        for (var i = 0; i < tds.length; i++) attachDatepickerToTd(tds[i]);
    }
    // nach dem Rendern initialisieren
    initDatepickers();
    //  Filter
    //  ende Filter
})();
    // --- flatpickr an Datumszellen binden ---
</script>
