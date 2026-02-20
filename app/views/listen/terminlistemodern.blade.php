{{-- resources/views/projekte/index.blade.php --}}
   <style>
    /* ====== Grundlayout ====== */
    .table-wrapper {
        max-width: 1850px;              /* optimal für Full-HD Monitore */
        margin: 20px auto;
        height: calc(100vh - 180px);    /* etwas Abstand oben/unten */
        border: 1px solid #d9dee3;
        border-radius: 8px;
        background: #fff;
        overflow: hidden;
        font-family: "Segoe UI", Roboto, Arial, sans-serif;
        color: #1f2937;
        font-size: 14px;
    }
    .table-viewport {
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .table-header {
        position: sticky;
        top: 0;
        z-index: 20;
        background: rgba(255,255,255,0.97);
        backdrop-filter: saturate(180%) blur(2px);
        border-bottom: 1px solid #d1d5db;
    }
    .table-body {
        flex: 1 1 auto;
        overflow-y: auto;
        overflow-x: hidden;
    }
    /* ====== Grid-Basis (9 Spalten) ====== */
    .table-grid {
        display: grid;
        grid-template-columns:
            140px   /* Verantwortlich */
            250px   /* Projekt/IAN */
            90px   /* Musterung */
            330px   /* Anzeigetext */
            330px   /* Bemerkung */
            120px   /* Soll-Termin */
            140px   /* Terminart */
            100px;   /* Status Milestone */
        column-gap: 1px;
        align-items: stretch;
    }
    /* ====== Kopfbereich ====== */
    .table-grid--head .cell {
        background: #f3f4f6;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #374151;
        padding: 10px 12px;
    }
    .table-grid--filters .cell {
        background: #ffffff;
        padding: 8px;
        border-top: 1px solid #e5e7eb;
    }
    /* ====== Zeilen & Zellen ====== */
    .row { display: contents; }
    .row .cell {
        text-align: left
    }
    .cell {
        background: #ffffff;
        padding: 10px 12px;
        border-bottom: 1px solid #e5e7eb;
        font-size: 14px;
        line-height: 1.4;
    }
    .table-body .row:nth-child(even) .cell {
        xxbackground: #eef3fa;
    }
    .table-body .row:nth-child(odd) .cell {
        xxxbackground: #b9b9b9;
    }
    .cell--truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    /* ====== Eingabefelder ====== */
    .input, .select, .button, .link-button {
        font: inherit;
        color: inherit;
        outline: none;
        border-radius: 6px;
    }
    .input, .select {
        width: 100%;
        padding: 6px 8px;
        border: 1px solid #cbd5e1;
        background: #fff;
        box-sizing: border-box;
    }
    .input:focus, .select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37,99,235,0.15);
    }
    .button, .link-button {
        display: inline-block;
        padding: 6px 10px;
        border: 1px solid #cbd5e1;
        background: #f9fafb;
        cursor: pointer;
        text-decoration: none;
        border-radius: 6px;
    }
    .button:hover, .link-button:hover {
        background: #e5e7eb;
    }
    /* ====== Badges ====== */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 2px 8px;
        font-size: 12px;
        border-radius: 999px;
        border: 1px solid #cbd5e1;
        background: #fff;
    }
    .badge--offen     { border-color: #f59e0b; color:#92400e; }
    .badge--laufend   { border-color: #3b82f6; color:#1e3a8a; }
    .badge--fertig    { border-color: #10b981; color:#065f46; }
    .badge--verzoegert{ border-color: #ef4444; color:#991b1b; }
    /* ====== Pagination ====== */
    .pagination {
        border-top: 1px solid #d1d5db;
        padding: 10px;
        background: #f9fafb;
        text-align: center;
    }
    /* ====== Scrollbar ====== */
    .table-body::-webkit-scrollbar {
        width: 8px;
    }
    .table-body::-webkit-scrollbar-thumb {
        background-color: #d1d5db;
        border-radius: 4px;
    }
    .cell--wrap {
        white-space: normal;       /* Umbrüche erlauben */
        word-wrap: break-word;     /* Lange Wörter umbrechen */
        overflow: visible;         /* Alles anzeigen */
    }
    /* ====== Hover-Effekt für Tabellenzeilen ====== */
    .table-grid .row:hover > .cell {
        background-color:  #afd9f5;;   /* zarter gelber Ton */
        transition: background-color 0.15s ease-in-out;
    }
    .cell--colored {
        background-color: var(--cell-color);
    }
    /* ====== Responsive Fallback ====== */
    @media (max-width: 1800px) {
        .table-wrapper {
            max-width: 100%;
            overflow-x: auto;
        }
    }
</style>
    <div class="table-wrapper">
    <?php 
        $lang = 'DE';
        if ( isset($_COOKIE['TPTLanguage']) ){
            $lang = $_COOKIE['TPTLanguage'];
        } else {
            $lang = Auth::user()->PPMitarbeiter_Language;
        }
        $_art = ServiceProvider::tl($lang,'Terminliste - '); 
        if (Session::get('art') == 'PP'){
            $_art .= ServiceProvider::tl($lang,'Projekte');
        } 
        if (Session::get('art') == 'MU'){
            $_art .= ServiceProvider::tl($lang,'Musterung');
        }  
    ?>
        <div class="table-viewport"> {{-- Sticky Header: Zeile 1 (Überschriften) + Zeile 2 (Filter) --}} <div class="table-header">
                <div class="table-grid table-grid--head">
                    <div class="cell">Verantwortlich!</div>
                    <div class="cell">Projekt/IAN</div>
                    <div class="cell">Musterung</div>
                    <div class="cell">Anzeigetext</div>
                    <div class="cell">Bemerkung</div>
                    <div class="cell">Soll-Termin</div>
                    <div class="cell">Terminart</div>
                    <div class="cell">Status Milestone</div>
                </div>
                <form method="POST" class="table-grid table-grid--filters" action="/terminlisteFilter" id="Terminliste">
                    <input type="hidden" name="art" value="{{ Session::get('art') }}" />
                    <div class="cell"> <input name="qVerantwortlicher" id="qVerantwortlicher" value="" class="input" placeholder="z. B. Müller"> </div>
                    <div class="cell"> <input name="qIAN" id="qIAN" class="input" placeholder="Projekt / IAN"> </div>
                    <div class="cell"> <input name="qAusm" id="qAusm" value="" class="input" placeholder="Musterung"> </div>
                    <div class="cell"> <input name="qAnzeigetext" value="" class="input" placeholder="Anzeigetext"> </div>
                    <div class="cell"> <input name="qBemerkung" value="" class="input" placeholder="Bemerkung"> </div>
                    <div class="cell"> <input name="qSollTermin" id="qiSollTermin" value="{{Session::get('qSollTermin');}}" class="input"> </div>
                    <div class="cell"> <input name="qTerminart" id="qTerminart"  value="" class="input" placeholder="Terminart"> </div>
                    <div class="cell">
                         <?php $fcol = Session::get('qfcol'); ?>
                        <table style='border:none;border-collapse:collapse;font-size:0.8rem;'>
                            <tr>
                                <td style="padding:4px;  text-align:left;">{{ ServiceProvider::tl($lang,'Erledigte:') }}</td>
                                <td style="padding:4px;  text-align:center;"><input style="height:15px;" type="checkbox" name="fcol[all]"  @if (isset($fcol['all'])) checked='checked' @endif /></td>
                            </tr>
                            <tr>
                                <td style="padding:4px;  text-align:left;" title='Termine, bei denen ich als Vertretung eingetragen bin, werden nicht angezeigt!'>{{ ServiceProvider::tl($lang,'Eigene:') }}</td>
                                <td style="padding:4px;  text-align:center;"><input style="height:15px;" type="checkbox" name="fcol[onlyMy]"  @if (isset($fcol['onlyMy'])) checked='checked' @endif /></td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div> 
            {{-- Datenbereich --}} 
            <div class="table-body">
    <div class="table-grid">
       <?php
            $bg       = $data['bg']        ?? [];
            $termine  = $data['aTermine']  ?? [];
        ?>
        @forelse($bg as $key => $bgcol)
           <?php
                $row = $termine[$key] ?? null;
                if (!$row) { continue; }
                 $cpcCol = $row->Background;
                if ($row->PPTermine_Status == 'offen'){
                    $cpcCol = "189,215,238";
                } 
                if ($row->PPTermine_Status == 'erledigt'){
                    $cpcCol = "198,254,206";
                } 
                $overdue = false;
                $_now = date('Y-m-d H:i:s');
                if ($_now > $row->DateMilestone){
                    $overdue = true;
                }
            ?>
            <div class="row">
                <div class="cell">{{ $row->PPMitarbeiter_Kuerzel }}</div>
                <div class="cell">
                    <a href="/show/{{ $row->PPProduktpass_Id }}" target="_blank" style="text-decoration:none; color:#000; cursor:pointer;">
                        <span style="margin-right:25px; color:darkblue; font-weight:bold;">{{ $row->PPProduktpass_IAN }}</span><br>
                        <span style='color:darkgray;'><b>Liefertermin: {{ $row->PPProduktpass_Liefertermin }}/{{ $row->PPProduktpass_LieferterminJahr }}</b></span>
                    </a><br>
                    <span titel='{{$row->PPProduktpass_Artikelbezeichnung}}' >{{ substr($row->PPProduktpass_Artikelbezeichnung,0,55) }}</span>
                </div>
                <div class="cell">{{ substr($row->PPProduktpass_Ausmusterungnummer, 0, 4) }}</div>
                <div class="cell cell--wrap" title="{{ $row->PPTermine_Label }}">{{ $row->PPTermine_Label }}</div>
                <div class="cell cell--wrap" title="{{ $row->PPTermine_Bemerkungen }}">{{ $row->PPTermine_Bemerkungen }}</div>
                <div class="cell">
                    <span>{{ date('d.m.Y', strtotime($row->DateMilestone)) }}</span>
                    @if ($row->PPTermineChanges_Categorie == 'Hauptaufgabe')
                        @if (substr($row->PPTermineChanges_DoUntil, 0, 4) != '0000')
                            <span style="@if($overdue)color:red;@endif"><b>&bull;</b></span>
                        @elseif (!empty($data['manSoll'][$key]))
                            <span style="@if($overdue)color:red;@endif"><b>*</b></span>
                        @endif
                    @else
                        <span style="font-size:0.5rem; @if($overdue)color:red;@endif"><b>#</b></span>
                    @endif
                </div>
                <div class="cell cell--colored" style="--cell-color: rgb({{$cpcCol}});">
                    @if (!empty($row->PPBoardSpalte_Oberbez))
                        <b>{{ $row->PPBoardSpalte_Oberbez }}</b><br>
                    @endif
                    <span style="font-size:0.9rem;">{{ $row->PPBoardSpalte_Bezeichnung }}</span><br>
                    @if ($row->PPTermineChanges_Categorie == 'Hauptaufgabe')
                        <b>Hauptaufgabe</b>
                    @else
                        <b>Unteraufgabe</b><br>{{ $row->PPTermineChanges_Categorie }}
                    @endif
                </div>
                <div class="cell">
                    <?php $xboard = 1000; if (Session::get('art') == 'MU') { $xboard = 1001; } ?>
                    <div  onclick="ajax_getTerminTab({{$row->PPProduktpass_Id}}, {{$row->PPTermine_Id}}, {{ $xboard }} , 'All', 1)" style="background-color:transparent;text-align: center; vertical-align:middle; margin:0px; color:darkblue; border:none; cursor:pointer;"> 
                        <b>{{$row->PPTermine_Status}}</b>
                </div>
                </div>
            </div>
        @empty
            <div class="row">
                <div class="cell" style="grid-column: 1 / -1; text-align:center; color:#6b7280; padding:16px;">
                    Keine Einträge gefunden.
                </div>
            </div>
        @endforelse
    </div>
</div>
        </div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Alle Filter-Formulare holen (falls du mehrere Tabellen hast)
    var forms = document.querySelectorAll('.table-grid--filters');
    forms.forEach(function (form) {
        form.addEventListener('keypress', function (e) {
            // Prüfen, ob Enter gedrückt wurde
            if (e.key === 'Enter') {
                e.preventDefault(); // Kein Fokus-Sprung
                form.submit();      // Formular absenden
            }
        });
    });
});
    function ajax_getTerminTab(ppid, tid, board, select, openOnly) {
        window.open("/getTerminFromId/" + ppid + "/" + tid + "/" + board,target='_blank', "toolbar=no,scrollbars=no,resizable=no,top=10,left=10,width=1900,height=1220,rel=noreferrer,rel=nopener");
        //window.open("/getTerminFromId/" + ppid + "/" + tid + "/" + board + "/" + select + "/" + openOnly, "_blank", "rel=noopener,rel=noreferrer,toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=100,width=1235,height=1920");
    }
</script>