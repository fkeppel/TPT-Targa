<style>
    /* =========================================================
    Tokens / Basis
    ========================================================= 
    Version vor Re-Design
    */
    :root {
        --c-brand: #003D7C;
        --c-brand-2: darkblue;
        --c-gray-1: #efefef;
        --c-gray-2: #c0c0c0;
        --c-gray-3: darkgray;
        --c-border: lightgray;
        --radius: 0px;
        --row-h: 60px;
        /* Dashboard Zeilenhöhe */
        --filter-h: 32px;
        /* Suchfeld-Kacheln (Label+Value) */
        /* bessere Kleinschrift */
        --font-ui: "Helvetica Neue", Roboto, -apple-system, "Segoe UI", system-ui,
            Arial, "Noto Sans", "Liberation Sans", sans-serif;
        --col1-ian: 90px;
        /* Sticky IAN */
        --col2-phase: 60px;
        /* Phase/Ausmust. */
        --col3-artikel: 180px;
        /* Artikel */
        --col4-status: 120px;
        /* Interner/Lidl Status */
        --col5-ppstatus: 60px;
        /* PP Status / Import / Lidl-Date */
        --col6-crd: 90px;
        /* CRD/DDP */
        --col7-uebergabe: 100px;
        /* Übergabe an (nur Admin/Master) */
        --col8-ma: 150px;
        /* Mitarbeiter */
    }
    /* Spaltenbreiten der ersten 8 Spalten */
    .col1 {
        width: var(--col1-ian);
        min-width: var(--col1-ian);
        max-width: var(--col1-ian);
    }
    .col2 {
        width: var(--col2-phase);
        min-width: var(--col2-phase);
        max-width: var(--col2-phase);
    }
    .col3 {
        width: var(--col3-artikel);
        min-width: var(--col3-artikel);
        max-width: var(--col3-artikel);
    }
    .col4 {
        width: var(--col4-status);
        min-width: var(--col4-status);
        max-width: var(--col4-status);
    }
    .col5 {
        width: var(--col5-ppstatus);
        min-width: var(--col5-ppstatus);
        max-width: var(--col5-ppstatus);
    }
    .col6 {
        width: var(--col6-crd);
        min-width: var(--col6-crd);
        max-width: var(--col6-crd);
    }
    .col7 {
        width: var(--col7-uebergabe);
        min-width: var(--col7-uebergabe);
        max-width: var(--col7-uebergabe);
    }
    .col8 {
        width: var(--col8-ma);
        min-width: var(--col8-ma);
        max-width: var(--col8-ma);
    }
    /* Sticky-Spalte soll auch die Variable nutzen */
    .cpcStickycol {
        width: var(--col1-ian);
        min-width: var(--col1-ian);
        max-width: var(--col1-ian);
    }
    * {
        box-sizing: border-box;
    }
    html,
    body {
        font-family: var(--font-ui);
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-rendering: geometricPrecision;
    }
    /* nur falls du es irgendwo bewusst nutzt */
    .tahoma {
        font-family: Tahoma, Arial, sans-serif;
    }
    .u-left {
        text-align: left;
    }
    .u-center {
        text-align: center;
    }
    .u-right {
        text-align: right;
    }
    .p0 {
        padding: 0 !important;
    }
    .pr4 {
        padding-right: 4px;
    }
    .pl4 {
        padding-left: 4px;
    }
    .pt0 {
        padding-top: 0 !important;
    }
    .pointer {
        cursor: pointer;
    }
    .greenText {
        color: darkgreen;
    }
    .grayText {
        color: gray;
    }
    .orangered {
        color: orangered;
    }
    .noDeco {
        text-decoration: none;
    }
    .linkBlack {
        color: #000;
        text-decoration: none;
    }
    .linkBrand {
        color: var(--c-brand);
        text-decoration: none;
    }
    /* =========================================================
    Overlay Absagegrund
    ========================================================= */
    #overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .6);
        justify-content: center;
        align-items: center;
        z-index: 1119999;
    }
    #overlayContent {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        width: 320px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, .3);
    }
    #overlayContent h2 {
        margin: 0 0 10px 0;
    }
    #overlayContent form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .form-select {
        width: 100%;
        height: 30px;
        border: 1px solid gray;
        font-size: .9em;
        padding: 6px;
    }
    .btn {
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .btn-primary {
        background: #007bff;
        color: #fff;
    }
    /* =========================================================
    Header
    ========================================================= */
    .boardHeaderWrap {
        text-align: left;
        margin-top: 15px;
    }
    .boardHeader {
        position: relative;
        padding: 10px;
        font-weight: bold;
        font-size: 24px;
        background-color: var(--c-brand);
        color: #fff;
        width: 100%;
        border-radius: var(--radius);
        height: 55px;
    }
    .boardHeader--archive {
        height: auto;
    }
    .boardHeaderLogo {
        position: absolute;
        top: 8px;
        right: 2px;
        height: 43px;
    }
    .boardHeaderLogo--archive {
        top: 0;
        right: 0;
        height: 52px;
    }
    /* =========================================================
    Filter / Search Grid
    ========================================================= */
    .filterBox {
        padding: 4px;
        border-radius: var(--radius);
        border: 1px solid var(--c-brand-2);
        min-height: 100px;
        height: auto;
        overflow: visible;
    }
    .formGetTermine {
        color: var(--c-brand-2);
        margin: 5px;
    }
    .cFormHeader {
        border: none;
        max-height: 300px !important;
    }
    .searchGrid {
        display: grid;
        grid-template-columns: repeat(auto-fit, 120px 200px);
        gap: 10px;
        font-size: 12px;
        border: none;
        border-radius: var(--radius);
        overflow: visible;
        align-items: stretch;
    }
    /* Jede Kachel (Label + Value) exakt gleiche Höhe */
    .stLabel,
    .stValue {
        height: var(--filter-h);
        display: flex;
        align-items: center;
    }
    .stLabel {
        font-size: .8rem;
        padding: 0 8px;
        color: var(--c-brand-2);
        font-weight: bold;
        background-color: var(--c-gray-1);
        border: 1px solid var(--c-brand-2);
        border-radius: var(--radius);
        text-align: left;
    }
    .stValue {
        border: 1px solid var(--c-brand-2);
        border-radius: var(--radius);
        padding: 0;
        text-align: left;
        overflow: hidden;
        white-space: nowrap;
    }
    .stValue--plain {
        border: none;
        padding: 0;
    }
    /* Inputs/Selects immer exakt so hoch wie Value-Zelle */
    .stValue input,
    .stValue select {
        width: 100%;
        height: 100%;
        border: none;
        font-size: .7rem;
        line-height: var(--filter-h);
        padding: 0 6px;
    }
    /* Buttons im Grid */
    .stValue button {
        border-radius: var(--radius);
        border: 1px solid var(--c-brand-2);
    }
    .actionBtn {
        width: 100%;
        height: var(--filter-h);
        font-size: 80%;
    }
    .checkboxTiny {
        width: 30px;
        margin: 0;
    }
    /* #Zeilen */
    .rowsInput {
        width: 70px;
    }
    .inlineNote {
        white-space: nowrap;
        font-size: 11px;
        line-height: var(--filter-h);
        margin-left: 0px;
        opacity: .85;
    }
    /* Pager ("Seite") */
    .stValue--pager {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 0 6px;
        overflow: hidden;
        white-space: nowrap;
    }
    .stValue--pager .pagerBtn {
        height: calc(var(--filter-h) - 8px);
        width: 26px;
        padding: 0;
        line-height: calc(var(--filter-h) - 10px);
        border: 1px solid var(--c-brand-2);
        background: #fff;
    }
    .stValue--pager .pagerInput {
        height: calc(var(--filter-h) - 8px);
        width: 38px;
        border: 1px solid var(--c-brand-2);
        border-radius: var(--radius);
        text-align: right;
        padding: 0 6px;
        line-height: calc(var(--filter-h) - 10px);
    }
    .stValue--pager .pagerMeta {
        font-size: 11px;
        line-height: calc(var(--filter-h) - 8px);
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .infoHint {
        text-align: left;
        font-size: .7em;
        padding-top: 8px;
        color: #E74C3C;
    }
    /* =========================================================
    Schedule / Table
    ========================================================= */
    .schedule {
        overflow: auto;
        border-radius: var(--radius);
        text-align: left;
        margin: 0;
        padding: 0;
        position: relative;
        border: 1px solid var(--c-brand-2);
    }
    .schedule--std {
        width: calc(100% - 15px);
        height: calc(100% - 285px);
    }
    .schedule--ff {
        width: calc(100vw - 20px);
        height: calc(100vh - 270px);
    }
    .table {
        margin-left: 10px;
        display: table;
        text-align: left;
        font-size: 10px;
        padding: 0;
        border-collapse: collapse;
        border-spacing: 0;
        font-variant-numeric: tabular-nums;
    }
    .table thead {
        position: sticky;
        position: -webkit-sticky;
        z-index: 11200;
        top: 0;
    }
    .table thead::before,
    .table thead::after {
        content: '';
        position: absolute;
        left: 0;
        width: 100%;
    }
    .table thead::before {
        top: 0;
        border-top: 1px solid gray;
        margin-top: -0.5px;
    }
    .table thead::after {
        bottom: 0;
        border-bottom: 1px solid gray;
    }
    .table-row {
        display: table-row;
    }
    .table-row-header {
        display: table-row;
    }
    .table-cell,
    .table-cell_value {
        display: table-cell;
        vertical-align: top;
        min-width: 10px;
        max-width: 20px;
        border-radius: var(--radius);
        height: var(--row-h);
        max-height: var(--row-h);
        overflow: hidden;
    }
    /* Default borders */
    .table-cell {
        border: 1px solid var(--c-brand);
        padding: 3px;
    }
    .table-cell_value {
        border: 1px solid var(--c-border);
        padding: 0;
    }
    .table-cell-header-rotate {
        display: table-cell;
        border: 1px solid var(--c-brand);
        background-color: #fff;
        border-radius: var(--radius);
        padding: 3px;
        position: relative;
    }
    .cpcStickycol {
        border: none;
        position: sticky;
        position: -webkit-sticky;
        left: 0;
        z-index: 11100;
        width: 80px;
        min-width: 80px;
        max-width: 800px;
        background-clip: padding-box;
    }
    .bold {
        font-weight: bold;
        padding-left: 4px;
    }
    .termin_cell {
        width: 18px;
        height: 20px;
        border: none;
        padding: 0;
        overflow: hidden;
        font-size: 8px;
        border-radius: var(--radius);
    }
    .rotate {
        transform: rotate(-90deg);
        transform-origin: left top;
        position: absolute;
        bottom: 0;
        left: 5%;
        white-space: nowrap;
        font-size: 12px;
        margin-left: 3px;
    }
    .rotate--usa {
        font-weight: bold;
    }
    /* =========================================================
    TBODY building blocks
    ========================================================= */
    .cellSticky {
        width: 80px;
        padding: 0;
    }
    .cellStickyInner {
        border: 1px solid var(--c-gray-3);
        border-radius: var(--radius);
        padding: 8px;
        background-color: transparent;
        height: 100%;
        overflow: hidden;
    }
    .ianBox {
        border: none;
        background-color: transparent;
        border-radius: var(--radius);
        width: 88px;
        padding: 4px;
        margin: -9px;
    }
    .ianMain {
        font-size: 12px;
        font-weight: bold;
    }
    .parentChildLine {
        line-height: 1.1;
        background-color: transparent;
    }
    .altLineWrap {
        background-color: transparent;
    }
    .altBtn {
        border: 1px solid gray;
        background-color: transparent;
        border-radius: var(--radius);
        color: gray;
        padding: 5px;
        margin-top: 5px;
        font-weight: bold;
        width: max-content;
    }
    .mplanBtn {
        border: 1px solid var(--c-brand-2);
        font-weight: bold;
        border-radius: var(--radius);
        margin-top: 5px;
        width: max-content;
        padding: 2px 6px;
    }
    /* Standard: kein Umbruch (stabil bei row-h) */
    .table-cell,
    .table-cell_value {
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    /* Umbruch nur wo explizit */
    .cellWrapBreak {
        white-space: normal;
        word-break: break-word;
    }
    /* Status / Selects */
    .statusBlock {
        border-radius: var(--radius);
        background-color: transparent;
        padding: 0;
    }
    .statusBlockPad {
        padding-left: 4px;
    }
    .setStatusSelect {
        font-size: .7rem;
        width: 86px;
        box-sizing: content-box;
        padding: 2px;
    }
    .setStatusBtn {
        width: 92px;
    }
    /* CRD */
    .crdTable {
        margin-left: 0;
        font-size: 10px;
        table-layout: fixed;
    }
    .crdSmall {
        font-size: 8px;
    }
    /* Übergabe */
    .uebergabeCell {
        padding: 0;
    }
    .selectUebergabe {
        width: 90px;
        height: 26px;
        border: 1px solid gray;
        font-size: .7rem;
        padding: 1px;
    }
    .uebergabeBtn {
        width: 90px;
        margin-top: 8px;
    }
    /* PM/PJM/TC Tabelle */
    .pmTable {
        width: 100%;
        table-layout: fixed;
        font-size: 9px;
    }
    .pmTable td {
        overflow: hidden;
        border-bottom: 1px solid gray;
        padding: 1px 3px;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    .pmTable .col1 {
        width: 30px;
    }
    /* Vertretung selects */
    .vtrSelect {
        font-size: .7rem;
        padding: 5px;
        width: 100%;
    }
    .VTRINPHide {
        position: relative;
        display: none;
        height: 30px;
        border-radius: var(--radius);
    }
    .VTRINPShow {
        position: absolute;
        left: 0;
        bottom: -32px;
        /* unterhalb der Zelle anzeigen */
        width: 120px;
        /* sinnvoll größer */
        height: 36px;
        border-radius: var(--radius);
        background: #fff;
        border: 1px solid var(--c-brand-2);
        box-shadow: 0 4px 10px rgba(0, 0, 0, .25);
        padding: 4px;
        z-index: 9999;
        display: block;
    }
    .divSelectTaetHide {
        display: none;
    }
    .divSelectTaetShow {
        display: block;
        border-radius: var(--radius);
        width: 100%;
        height: 73px;
        padding: 0;
    }
    /* =========================================================
    Termin-Zelle
    ========================================================= */
    .termCell {
        border: 1px solid var(--c-brand);
        padding: 0;
        vertical-align: top;
        position: relative;
        overflow: hidden;
        font-size: 4px;
    }
    .termDeadlineBar {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 12px;
        line-height: 12px;
        text-align: center;
        border-radius: var(--radius);
        z-index: 3;
    }
    .termDeadlineText {
        font-size: 8px;
        font-weight: 600;
        color: var(--c-brand);
    }
    .termDeadlineTextWhite {
        color: #fff;
    }
    .termClickArea {
        position: absolute;
        top: 12px;
        left: 0;
        right: 0;
        bottom: 0;
        width: 30px;
        border-radius: var(--radius);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        z-index: 2;
        white-space: normal;
        /* nur hier Umbruch */
    }
    .termLabel {
        flex: 1 1 auto;
        display: block;
        overflow: hidden;
        font-size: 8px;
        line-height: 8px;
        padding: 1px 2px;
        font-weight: 500;
        color: rgb(9, 41, 146);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif, sans-serif;
        text-rendering: optimizeLegibility;
    }
    .termNotNeeded {
        font-size: 8px;
        line-height: 9px;
        padding: 1px 2px;
    }
    .markerRemark {
        position: absolute;
        right: 0;
        bottom: 0;
        width: 8px;
        height: 8px;
        border: none;
        border-radius: var(--radius);
        margin: 0;
        background-color: rgb(119, 119, 119);
    }
    .markerMplan {
        position: absolute;
        left: 0;
        bottom: 0;
        width: 4px;
        height: 4px;
        border: none;
        border-radius: var(--radius);
        margin: 0;
        background-color: var(--mplan);
    }
    /* =========================================================
    Termin-History
    ========================================================= */
    .terminHist {
        border-radius: var(--radius);
        display: table;
        border-collapse: collapse;
        font-size: 12px;
        border: 1px solid var(--c-brand);
    }
    .terminHist td {
        border: 1px solid lightskyblue;
        height: 25px;
        padding: 5px;
        text-align: left;
    }
    .terminHist th {
        border: 1px solid lightskyblue;
        background-color: lightgray;
        height: 25px;
        font-weight: bold;
        padding: 5px;
        text-align: left;
    }
    /* =========================================================
    ✅ ZOOM-FIX (110%): feste Höhe über Wrapper, td ohne Padding
    -> verhindert "Rundungsdrift" bei Zoom
    ========================================================= */
    /* TDs im Body bekommen KEIN Padding mehr, Wrapper macht das */
    tr.table-row>td.table-cell,
    tr.table-row>td.table-cell_value {
        padding: 0 !important;
        height: var(--row-h) !important;
        max-height: var(--row-h) !important;
        overflow: hidden !important;
    }
    /* fester Innenwrapper */
    .cellClip {
        height: var(--row-h);
        max-height: var(--row-h);
        display: block;
        position: relative;
        /* wichtig */
        overflow: visible;
        /* Overlay darf raus */
    }
    /* Padding-Varianten */
    .cellClip.pad3 {
        padding: 3px;
    }
    .cellClip.pad8 {
        padding: 8px;
    }
    .cellClip.pad0 {
        padding: 0;
    }
    /* alle inneren Tabellen dürfen nicht aufblasen */
    .cellClip table {
        max-height: 100%;
        overflow: hidden;
    }
    /* Sticky-Zelle: ihr bestehender Innerblock soll im Clip leben */
    .cellStickyInner {
        height: 100%;
        border: none;
    }
    /* Termin-Zelle: Wrapper reserviert volle Row-Höhe */
    .table-cell_value.termCell .termClickArea {
        height: calc(var(--row-h) - 12px);
        font-size: 6px;
    }
    .cpcStickycol {
        position: sticky;
        left: 0;
        z-index: 11100;
        /* nur benötigte Borders */
        border-left: 1px solid var(--c-brand) !important;
        border-top: 1px solid var(--c-brand) !important;
        border-bottom: 1px solid var(--c-brand) !important;
        /* rechte Seite aus — damit keine Doppel-Linie entsteht */
        border-right: 0 !important;
    }
    /* Body-rows müssen positioniert sein, sonst greift z-index nicht */
    tr.table-row {
        position: relative;
        z-index: 0;
    }
    /* Wenn ein Popover offen ist: diese Zeile über alle anderen */
    tr.table-row.is-popover-open {
        z-index: 5000;
    }
    /* Popover selbst */
    .VTRINPShow {
        position: absolute;
        left: 0;
        top: 100%;
        /* unterhalb der Zelle */
        margin-top: 4px;
        width: 160px;
        background: #fff;
        border: 1px solid var(--c-brand-2);
        box-shadow: 0 4px 10px rgba(0, 0, 0, .25);
        padding: 4px;
        z-index: 6000;
        /* innerhalb der Zeile ganz oben */
    }
    /* der Container, in dem VTRINP... liegt */
    td.col8 .cellClip {
        position: relative;
        overflow: visible;
    }
    /* wichtig: td darf nicht clippen */
    td.col8.table-cell {
        overflow: visible !important;
    }
    /* dein Popover */
    .VTRINPShow {
        position: absolute;
        left: 0;
        top: 0;
        /* wir setzen top per JS dynamisch */
        transform: translateY(32px);
        width: 160px;
        background: #fff;
        border: 1px solid var(--c-brand-2);
        box-shadow: 0 4px 10px rgba(0, 0, 0, .25);
        padding: 4px;
        z-index: 6000;
    }
    tr.table-row>td.table-cell.col8 {
        overflow: visible !important;
    }
    .filterBox {
        transition: opacity 0.2s ease;
    }
    .filterBox.hidden {
        opacity: 0;
        pointer-events: none;
    }
    .boardPage {
        /* wenn es innerhalb einer Seite ist: nimm die verfügbare Viewport-Höhe */
        height: calc(100vh - 102px);
        /* ggf. anpassen */
        display: flex;
        flex-direction: column;
        min-height: 0;
        /* wichtig für overflow in Flex */
    }
    /* Filterbox bleibt „auto“ hoch */
    #filterBox {
        flex: 0 0 auto;
    }
    /* Schedule nimmt den Rest */
    .schedule {
        flex: 1 1 auto;
        min-height: 0;
        /* wichtig, sonst overflow-bugs */
        overflow: auto;
        width: calc(100% - 15px);
        /* dein bisheriger std-Wert */
    }
    /* Firefox/FullScreen Varianten kannst du über width steuern,
        NICHT über height */
    .schedule--ff {
        width: calc(100vw - 20px);
    }
</style>
<?php
    if ($kalender['HasData']) {
        $headers = $kalender['Termine']['Header'];
        $values = $kalender['Termine']['Values'];
        $termineMusterung = $kalender['TermineMusterung'];
        $statiAll = $kalender['Termine']['StatiAll'];
    }
    $board = $kalender['Board'];
    $PMs = $kalender['PMs'];
    asort($PMs);
    $PJMs = $kalender['PJMs'];
    $TCs = $kalender['TCs'];
    $mitarbeiterliste = $kalender['mitarbeiterliste'];
    $mitarbeiterNamen = $kalender['mitarbeiterNamen'];
    $lproject = '';
    $lcolor = 0;
    $isFKE = Auth::user()->PPMitarbeiter_Kuerzel === 'FKE';
    if (isset($_COOKIE['TPTLanguage'])) {
        $lang = $_COOKIE['TPTLanguage'];
    } else {
        $lang = Auth::user()->PPMitarbeiter_Language;
        $_COOKIE['TPTLanguage'] = $lang;
    }
    $absagegruende = $kalender['AbsageGruende'];
?>
<div id="overlay">
    <div id="overlayContent">
        <h2>{{ ServiceProvider::tl($lang, 'Absagegrund bitte angeben:') }}</h2>
        <form id="FormAbsagegrund">
            <select name="inpAbsagegrund" id="inpAbsagegrund" class="form-select" required>
                <option value=''>{{ ServiceProvider::tl($lang, 'Bitte wählen...') }}</option>
                @foreach ($absagegruende as $grund)
                    <option value='{{ $grund }}'>{{ ServiceProvider::tl($lang, $grund) }}</option>
                @endforeach
            </select>
            <input type="hidden" id="inpPPId" name="inpPPId" value="" />
            <input type="hidden" id="inpState" name="inpState" value="" />
            <button type="submit" class="btn btn-primary">{{ ServiceProvider::tl($lang, 'Absenden') }}</button>
        </form>
    </div>
</div>
<div class="boardPage" >
    <div class="boardHeaderWrap">
        @foreach ($SALs as $sal)
            @if ($board == $sal->PPBoard_Id)
                <div class="boardHeader">
                    {{ ServiceProvider::tl($lang, $sal->PPBoard_Bezeichnung) }}
                    <img class="boardHeaderLogo" src="/css/images/TARGA_Logo_Basis_weiss_RGB.png" />
                </div>
            @endif
        @endforeach
        @if ($board == 2000)
            <div class="boardHeader boardHeader--archive">
                Dashboard {{ ServiceProvider::tl($lang, 'Archiv (GELIEFERT)') }}
                <img class="boardHeaderLogo boardHeaderLogo--archive" src="/css/images/TARGA_Logo_Basis_weiss_RGB.png" />
            </div>
        @endif
        @if ($board == 2002)
            <div class="boardHeader boardHeader--archive">
                Dashboard {{ ServiceProvider::tl($lang, ' Archiv (ABSAGE)') }}
                <img class="boardHeaderLogo boardHeaderLogo--archive" src="/css/images/TARGA_Logo_Basis_weiss_RGB.png" />
            </div>
        @endif
    </div>
    <button type="button" id="toggleFilterBtn" class="actionBtn" onclick="toggleFilterBox()">Filter ausblenden (Alt + s)</button>
    <div class="filterBox" id="filterBox">
        {{ Form::open(['url' => 'termine', 'class' => 'formGetTermine', 'id' => 'formgetTermine', 'onkeypress' => 'submitFormX(event);']) }}
        <input type="hidden" name="inp_board" value="{{ $board }}">
        <div id="cFormHeader" class="cFormHeader">
            <div class="searchTab searchGrid">
                <div class="stLabel">IAN</div>
                <div class="stValue">
                    <input id="inpFormIAN" name="sQry[PPProduktpass_IAN]" placeholder="IAN" @if (isset($kalender['SP'])) value="{{ $kalender['SP']['PPProduktpass_IAN'] }}" @endif />
                </div>
                <div class="stLabel">{{ ServiceProvider::tl($lang, 'Artikel') }}</div>
                <div class="stValue">
                    <input id="inpFormArtikel" name="sQry[PPProduktpass_Artikelbezeichnung]" placeholder="Article" @if (isset($kalender['SP'])) value="{{ isset($kalender['SP']['PPProduktpass_Artikelbezeichnung']) ? $kalender['SP']['PPProduktpass_Artikelbezeichnung'] : '' }}" @endif />
                </div>
                <div class="stLabel">{{ ServiceProvider::tl($lang, 'Bereich') }}</div>
                <div class="stValue">
                    <select id="inpFormBereich" name="sQry[PPProduktpass_ThemaScope]" titel="Bereich">
                        <option></option>
                        @foreach ($kalender['scopes'] as $scope)
                            <option @if (isset($kalender['SP']['PPProduktpass_ThemaScope']) && $kalender['SP']['PPProduktpass_ThemaScope'] == $scope) selected @endif>{{ $scope }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="stLabel">{{ ServiceProvider::tl($lang, 'Musterung') }}</div>
                <div class="stValue">
                    <input id="inpFormMusterung" name="sQry[PPProduktpass_Ausmusterungnummer]" placeholder="Musterung" value="{{ $kalender['SP']['PPProduktpass_Ausmusterungnummer'] ?? '' }}" />
                </div>
                <div class="stLabel">PM</div>
                <div class="stValue">
                    <select id="inpFormPM" name="sQry[PMler]">
                        <option></option>
                        @foreach ($PMs as $id => $mx5)
                            <option title='{{ isset($mitarbeiterNamen[$id]->PPMitarbeiter_Name) ? $mitarbeiterNamen[$id]->PPMitarbeiter_Name . ', ' . $mitarbeiterNamen[$id]->PPMitarbeiter_Vorname : 'NNN' }}' value="{{ $mx5 }}" @if (isset($kalender['SP']['PMler']) && $kalender['SP']['PMler'] == $mx5) selected @endif>
                                {{ $mx5 }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="stLabel">PJM</div>
                <div class="stValue">
                    <select id="inpFormPJM" name="sQry[PJMler]">
                        <option></option>
                        @foreach ($PJMs as $id => $mx5)
                            <option title='{{ isset($mitarbeiterNamen[$id]->PPMitarbeiter_Name) ? $mitarbeiterNamen[$id]->PPMitarbeiter_Name . ', ' . $mitarbeiterNamen[$id]->PPMitarbeiter_Vorname : 'NNN' }}' value="{{ $mx5 }}" @if (isset($kalender['SP']['PJMler']) && $kalender['SP']['PJMler'] == $mx5) selected @endif>
                                {{ $mx5 }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="stLabel">TC</div>
                <div class="stValue">
                    <select id="inpFormTC" name="sQry[TCler]">
                        <option></option>
                        @foreach ($TCs as $id => $mx5)
                            <option title='{{ isset($mitarbeiterNamen[$id]->PPMitarbeiter_Name) ? $mitarbeiterNamen[$id]->PPMitarbeiter_Name . ', ' . $mitarbeiterNamen[$id]->PPMitarbeiter_Vorname : 'NNN' }}' value="{{ $mx5 }}" @if (isset($kalender['SP']['TCler']) && $kalender['SP']['TCler'] == $mx5) selected @endif>
                                {{ $mx5 }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="stLabel">{{ ServiceProvider::tl($lang, 'Lidl Status') }}</div>
                <div class="stValue">
                    <select id="inpFormLidlStatus" name="sQry[statusDoc]">
                        <option @if (isset($kalender['SP']['statusDoc']) && $kalender['SP']['statusDoc'] == '%') selected @endif value="%">Alle</option>
                        <option @if (isset($kalender['SP']['statusDoc']) && $kalender['SP']['statusDoc'] == 'submit') selected @endif value="submit">submit</option>
                        <option @if (isset($kalender['SP']['statusDoc']) && $kalender['SP']['statusDoc'] == 'open') selected @endif value="open">open</option>
                        <option @if (isset($kalender['SP']['statusDoc']) && $kalender['SP']['statusDoc'] == 'declined') selected @endif value="declined">declined</option>
                        <option @if (isset($kalender['SP']['statusDoc']) && $kalender['SP']['statusDoc'] == 'PPCHANGEHG') selected @endif value="PPCHANGEHG">PPCHANGEHG
                        </option>
                        <option @if (isset($kalender['SP']['statusDoc']) && $kalender['SP']['statusDoc'] == 'TEMPPPHG') selected @endif value="TEMPPPHG">TEMPPPHG</option>
                        <option @if (isset($kalender['SP']['statusDoc']) && $kalender['SP']['statusDoc'] == 'RFQHG') selected @endif value="RFQHG">RFQHG</option>
                        <option @if (isset($kalender['SP']['statusDoc']) && $kalender['SP']['statusDoc'] == 'RFSHG') selected @endif value="RFSHG">RFSHG</option>
                    </select>
                </div>
                <div class="stLabel">{{ ServiceProvider::tl($lang, 'Import') }}</div>
                <div class="stValue">
                    <input id="inpFormPPProduktpass_RevisionDatum" name="sQry[PPProduktpass_RevisionDatum]" placeholder="Import: 2024-10-24" @if (isset($kalender['SP'])) value="{{ isset($kalender['SP']['PPProduktpass_RevisionDatum']) ? $kalender['SP']['PPProduktpass_RevisionDatum'] : '' }}" @endif />
                </div>
                <div class="stLabel">{{ ServiceProvider::tl($lang, 'Seite') }}</div>
                <div class="stValue stValue--pager">
                    <button type="button" class="pagerBtn" onclick="prevPage();" aria-label="prev">-</button>
                    <input class="pagerInput" id="page" name="page" inputmode="numeric" value="{{ $kalender['page'] }}" />
                    <span class="pagerMeta">{{ ServiceProvider::tl($lang, 'von') }}
                        {{ ceil($kalender['totalRows'] / $kalender['rows']) }}</span>
                    <input type="hidden" id="pages" value="{{ ceil($kalender['totalRows'] / $kalender['rows']) }}" />
                    <button type="button" class="pagerBtn" onclick="nextPage();" aria-label="next">+</button>
                </div>
                <div class="stLabel">{{ ServiceProvider::tl($lang, 'Nur kritische') }}</div>
                <div class="stValue stValue--plain">
                    <input type="hidden" id="inpPPProduktpass_IsCriticalProject" name="sQry[PPProduktpass_IsCriticalProject]" value="0" />
                    <input type="checkbox" class="checkboxTiny" id="inpPPProduktpass_IsCriticalProjectReal" name="sQry[PPProduktpass_IsCriticalProject]" @if (@isset($kalender['SP']['PPProduktpass_IsCriticalProject']) and $kalender['SP']['PPProduktpass_IsCriticalProject'] == 1) checked @endif value="1" />
                </div>
                <div class="stLabel">{{ ServiceProvider::tl($lang, '#Zeilen') }}</div>
                <div class="stValue">
                    <input class="rowsInput" id="rows" name="rows" value="{{ $kalender['rows'] }}" />
                    <span class="inlineNote">{{ ServiceProvider::tl($lang, 'Gesamt') }}:
                        {{ $kalender['totalRows'] }}&nbsp;&nbsp;</span>
                </div>
                <div class="stValue"><button id="submitFormBtn" class="actionBtn" type="submit" name="action" value="anzeigen"><b>{{ ServiceProvider::tl($lang, 'Anzeigen') }}</b></button></div>
                <div class="stValue"><button id="submitFormBtn" class="actionBtn" type="button" onclick="rstForm();"><b>{{ ServiceProvider::tl($lang, 'Zurücksetzen') }}</b></button></div>
                <div class="stValue"><button id="submitFormBtn" class="actionBtn" type="button" onclick="saveFilter({{ $board }});"><b>{{ ServiceProvider::tl($lang, 'Filter speichern *') }}</b></button>
                </div>
                <div class="stValue"><button id="submitFormBtn" class="actionBtn" type="button" onclick="getFilter({{ $board }});"><b>{{ ServiceProvider::tl($lang, 'Filter laden *') }}</b></button>
                </div>
                <div class="stValue"><button id="submitFormBtn" class="actionBtn" type="submit" name="action" value="anzeigen+"><b>{{ ServiceProvider::tl($lang, 'ohne Vertretung') }}</b></button></div>
            </div>
        </div>
        <div class="infoHint">
            {{ ServiceProvider::tl($lang, '*) Beim ersten Aufruf wird jetzt der Filter auf die eigenen Projekte gesetzt (PM = [USER] oder TC = [USER]) Mit dem Buttons [Zurücksetzen] + [Anzeigen] erhält man wieder die gesamte Liste') }}
        </div>
        {{ Form::close() }}
    </div>
    <?php
    $browser = 'ALL';
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'Fire') !== false) {
        $browser = 'FF';
    }
    $level = 1;
    ?>
    @if ($kalender['HasData'])
        <div class="schedule @if ($browser !== 'FF') schedule--std  @else  schedule--ff @endif">
            <table class="table">
                <thead>
                    <tr class="table-row-header">
                        <th class="table-cell-header-rotate cpcStickycol col1" style="background-clip: padding-box;border-bottom:none;"></th>
                        <th class="table-cell-header-rotate cpccol2 col2" style="background-clip: padding-box;border-bottom:none;"></th>
                        <th class="table-cell-header-rotate cpccol3 col3" style="background-clip: padding-box;border-bottom:none;"></th>
                        <th class="table-cell-header-rotate cpccol4 col4" style="background-clip: padding-box;border-bottom:none;"></th>
                        <th class="table-cell-header-rotate cpccol6 col5" style="background-clip: padding-box;border-bottom:none;"></th>
                        <th class="table-cell-header-rotate cpccol7 col6" style="background-clip: padding-box;border-bottom:none;"></th>
                        @if (Auth::User()->PPMitarbeiter_Gruppe == 'admin' or Auth::User()->isMaster)
                            <th class="table-cell-header-rotate cpccol8 col7" style="background-clip: padding-box;border-bottom:none;"></th>
                        @endif
                        <th class="table-cell-header-rotate cpccol9 col8" style="background-clip: padding-box;border-bottom:none;"></th>
                        <?php
                        $i = 0;
                        $a_oberbez = [];
                        $temp_h = 'X';
                        $colndx = 0;
                        $colors = ['white', 'lightgray', 'white', 'lightgray', 'white', 'lightgray', 'white', 'lightgray', 'white', 'lightgray', 'white', 'lightgray', 'white', 'lightgray', 'white', 'lightgray', 'white', 'lightgray', 'white', 'lightgray', 'white', 'lightgray', 'white', 'lightgray', 'white', 'lightgray', 'white', 'lightgray'];
                        foreach ($headers as $header) {
                            if ($temp_h !== $header->PPBoardSpalte_Oberbez) {
                                $i++;
                                $a_oberbez[$i]['bg'] = $colors[$colndx++];
                                $temp_h = $header->PPBoardSpalte_Oberbez;
                                $a_oberbez[$i]['bez'] = $header->PPBoardSpalte_Oberbez;
                                $a_oberbez[$i]['colspan'] = 1;
                            } else {
                                $a_oberbez[$i]['colspan']++;
                            }
                        }
                        ?>
                        @foreach ($a_oberbez as $obez)
                            <th class="table-cell-header-rotate cpccolAll" style="background-clip: padding-box; font-size:10px;padding:0px;background-color:<?php $obez['bg']; ?>;" colspan="{{ $obez['colspan'] }}">
                                <div style="@if ($obez['colspan'] == 1) width:22px;@else width:auto; @endif overflow:hidden;border-radius: 0px;border:none;background-color: transparent;padding-left:8px;">
                                    <span><b>{{ substr(ServiceProvider::tl($lang, $obez['bez']), 0, 10) }}</b></span>
                                </div>
                            </th>
                        @endforeach
                    </tr>
                    <tr class="table-row-header">
                        <!-- Spalte 10 -->
                        <td class="table-cell-header-rotate cpcStickycol" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;">
                            <div style="border-radius:0px;background-color:transparent;height:45px;padding:2px;border:1px solid darkgray;border-top:1px solid #003D7C;">
                                {{ ServiceProvider::tl($lang, 'IAN') }}</div>
                        </td>
                        <!-- Spalte 1 -->
                        <td class="table-cell-header-rotate bold" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;">
                            <div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">
                                {{ ServiceProvider::tl($lang, 'Phase') }} /
                                {{ ServiceProvider::tl($lang, 'Ausmust.') }}
                            </div>
                        </td>
                        <!-- Spalte 6 -->
                        <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;">
                            <div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">
                                {{ ServiceProvider::tl($lang, 'Artikel') }}
                            </div>
                        </td>
                        <!-- Spalte 2 -->
                        <td class="table-cell-header-rotate bold" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;">
                            <div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">
                                {{ ServiceProvider::tl($lang, 'Interner Status') }}<br>{{ ServiceProvider::tl($lang, 'Lidl Status') }}
                            </div>
                        </td>
                        <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;">
                            <div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">
                                {{ ServiceProvider::tl($lang, 'PP Status') }}<br>I-{{ ServiceProvider::tl($lang, 'Datum') }}<br>L-{{ ServiceProvider::tl($lang, 'Datum') }}
                            </div>
                        </td>
                        <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;">
                            <div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">
                                CRD<br>DDP
                            </div>
                        </td>
                        @if (Auth::User()->PPMitarbeiter_Gruppe == 'admin' or Auth::User()->isMaster)
                            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;">
                                <div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">
                                    {{ ServiceProvider::tl($lang, 'Übergabe an') }}<br>
                                    <select style='margin-top:5px;width:90px;padding:3px;border-radius:0px;font-size:1em;' id='selectTaetigkeit' onchange="fillSelect(this);">
                                        <option value=''></option>
                                        <option value='PM'>PM</option>
                                        <option value='PJM'>PJM</option>
                                        <option value='TC'>TC</option>
                                    </select>
                                </div>
                            </td>
                        @endif
                        <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;">
                            <div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">
                                {{ ServiceProvider::tl($lang, 'Mitarbeiter') }}
                            </div>
                        </td>
                        <?php $i = 0; ?>
                        @foreach ($headers as $header)
                            <?php $i++; ?>
                            <td class="table-cell-header-rotate" style="padding:0px;background-clip: padding-box;">
                                <div class="termin_cell" style="height:150px; overflow: hidden;width:30px;" title="{{ ServiceProvider::tl($lang, $header->PPBoardSpalte_Bezeichnung) }}">
                                    <div>{{ $header->PPBoardSpalteData_Kind }}</div>
                                    <div class="rotate" style="overflow: hidden;width: 110px; @if ($header->PPBoardSpalte_IsUSA) font-weight:bold; @endif">
                                        {{ ServiceProvider::tl($lang, mb_substr($header->PPBoardSpalte_Bezeichnung, 0, 20, 'UTF-8')) }}
                                    </div>
                                </div>
                            </td>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <?php $poscount = 0; ?>
                    @foreach ($values as $value)
                        <?php $poscount++; ?>
                        <tr class="table-row">
                            <?php
                            $first = true;
                            $j = 0;
                            ?>
                            @foreach ($headers as $header)
                                <?php $j++; ?>
                                @if ($first)
                                    <?php
                                    $first = false;
                                    $po['ltw'] = '';
                                    $po['ltj'] = '';
                                    $po['supplier'] = '';
                                    $po['ek'] = 0;
                                    $po['status'] = 'N.N.';
                                    $po['w2fob'] = '';
                                    $po['bsci'] = '';
                                    $lccol = '';
                                    $lcdate = '';
                                    if (!is_null($value['PO'])) {
                                        $po['ltw'] = $value['PO']->PPPurchase_FOBWeek;
                                        $po['ltj'] = $value['PO']->PPPurchase_FOBYear;
                                        if ($value['PO']->PPPurchase_FOBYear > 2000) {
                                            $po['ltj'] = $value['PO']->PPPurchase_FOBYear - 2000;
                                        }
                                        $po['supplier'] = $value['PO']->PPPurchase_Supplier;
                                        if ($value['Lief']) {
                                            $po['supplierid'] = $value['Lief']->Id;
                                            if (strlen($value['Lief']->PPAdressen_ZertBSCIValid) >= 10) {
                                                $po['bsci'] = date('d.m.Y', strtotime($value['Lief']->PPAdressen_ZertBSCIValid));
                                            }
                                        }
                                        $po['ek'] = $value['PO']->PPPurchase_EK != 0 ? $value['PO']->PPPurchase_EK : $value['PO']->PPPurchase_FOBQm;
                                        $po['ekwsym'] = $value['PO']->PPPurchase_Currency;
                                        $po['status'] = $value['POStatus'];
                                        $po['w2fob'] = $value['W2FOB'];
                                        try {
                                            $lccol = 'rgb(255,255,255)';
                                            if (isset($value['LC']) and !is_null($value['LC'])) {
                                                if (strlen($value['LC']->PPLC_FinalDate) >= 10) {
                                                    $lcdate = date('d.m.Y', strtotime($value['LC']->PPLC_FinalDate));
                                                    $lcdt = new DateTime($value['LC']->PPLC_FinalDate);
                                                    if (strlen($value['PO']->PPPurchase_OrderDate) >= 10) {
                                                        $od = new DateTime($value['PO']->PPPurchase_OrderDate);
                                                        $diff = date_diff($od, $lcdt);
                                                        $x = intval($diff->format('%r%a'));
                                                        if ($x >= 0) {
                                                            $lccol = 'rgb(0,255,0)';
                                                        } else {
                                                            $lccol = 'rgb(255,0,0)';
                                                        }
                                                    }
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $lcdate = 'Error';
                                        }
                                        try {
                                            $orderdate = '';
                                            if (strlen($value['PO']->PPPurchase_OrderDate) >= 10) {
                                                $od = new DateTime($value['PO']->PPPurchase_OrderDate);
                                                $orderdate = date_format($od, 'd.m.y');
                                            }
                                            $di = new DateTime($value['PP']->PPProduktpass_RevisionDatum);
                                            $diff = date_diff($od, $di);
                                            $x = intval($diff->format('%r%a'));
                                            if ($x <= 0) {
                                                $orderFormatColor = 'green';
                                            } else {
                                                $orderFormatColor = 'red';
                                                if ($value['PO']->PPPurchase_ManCheckOK == 1) {
                                                    $orderFormatColor = 'green';
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $orderFormatColor = 'pink';
                                            $orderdate = 'N.N.';
                                        }
                                        $po['date'] = $orderdate;
                                    }
                                    $ab['vk'] = 0;
                                    $ab['chq'] = 0;
                                    $ab['c40'] = 0;
                                    $ab['c20'] = 0;
                                    $ab['mengensplit'] = '-/-';
                                    if (!is_null($value['AB'])) {
                                        $ab['vk'] = $value['AB']->PPAB_VKEUR > 0 ? $value['AB']->PPAB_VKEUR : $value['AB']->PPAB_VKQMEUR;
                                        $ab['chq'] = $value['AB']->PPAB_CD11 + $value['AB']->PPAB_CD21 + $value['AB']->PPAB_CD31 + $value['AB']->PPAB_CD41;
                                        $ab['c40'] = $value['AB']->PPAB_CD12 + $value['AB']->PPAB_CD22 + $value['AB']->PPAB_CD32 + $value['AB']->PPAB_CD42;
                                        $ab['c20'] = $value['AB']->PPAB_CD13 + $value['AB']->PPAB_CD23 + $value['AB']->PPAB_CD33 + $value['AB']->PPAB_CD43;
                                        $ab['mengensplit'] = $value['MengenSplit'];
                                    }
                                    $pp['id'] = $value['PP']->PPProduktpass_Id;
                                    $pp['ian'] = $value['PP']->PPProduktpass_IAN;
                                    $pp['projekt'] = $value['PP']->PPProduktpass_PPProjekte_Projekt;
                                    $pp['artikel'] = $value['PP']->PPProduktpass_Artikelbezeichnung;
                                    $pp['ddpltw'] = $value['PP']->PPProduktpass_Liefertermin;
                                    $pp['ddplty'] = $value['PP']->PPProduktpass_LieferterminJahr - 2000;
                                    $pp['ltw'] = $value['PP']->PPProduktpass_Liefertermin;
                                    $pp['lty'] = $value['PP']->PPProduktpass_LieferterminJahr - 2000;
                                    $pp['crdltw'] = $value['PP']->PPProduktpass_CRDWoche;
                                    $pp['crdlty'] = $value['PP']->PPProduktpass_CRDJahr - 2000;
                                    $pp['PPstatus'] = $value['PP']->PPProduktpass_Status;
                                    $pp['Gesamtmenge'] = $value['PP']->PPProduktpass_Gesamtmenge;
                                    $styleCRD = 'black';
                                    if ($value['CRDChanged']) {
                                        $styleCRD = 'dodgerblue';
                                    }
                                    $isFirstRev = '';
                                    if ($value['PP']->PPProduktpass_RevisionVon_PPProduktpass_Id == 0) {
                                        $isFirstRev = '*';
                                    }
                                    $pp['ParentChild'] = '';
                                    $pc_color = 'white';
                                    if ($value['PP']->PPProduktpass_IsParent) {
                                        $pp['ParentChild'] = 'Parent';
                                        $pc_color = 'dodgerblue';
                                    }
                                    if ($value['PP']->PPProduktpass_IsChild) {
                                        $pp['ParentChild'] = 'Child';
                                        $pc_color = '#FFC133';
                                    }
                                    if ($value['PP']->PPProduktpass_IsKaufland) {
                                        $pp['ParentChild'] = 'Nachbestellung';
                                        $pc_color = '#F0FF33';
                                    }
                                    $pp['category'] = $value['PP']->category;
                                    $pp['statusDoc'] = $value['PP']->statusDoc;
                                    $pp['InternerStatus'] = $value['PP']->InternerStatus;
                                    $pp['color_isRFQ'] = strpos($value['PP']->category, 'RFQ') !== false ? 'black' : 'black';
                                    $pp['IsValid_OldIAN'] = $value['IsValid_OldIAN'];
                                    $pp['Mitarbeiter'] = $value['Mitarbeiter'];
                                    $pp['LidlUpdateDate'] = 'N.N.';
                                    //$pp['LidlUpdateDate'] = $value['PP']->updatedOn;
                                    if (strlen($value['PP']->updatedOn) >= 10 and strpos($value['PP']->updatedOn, '0000') === false) {
                                        $pp['LidlUpdateDate'] = date_format(date_create($value['PP']->updatedOn), 'd.m.y');
                                    }
                                    $pp['ZertStep'] = $value['PP']->PPProduktpass_StepNeeded ? 'Ja' : 'Nein';
                                    $pp['ZertBSCI'] = $value['PP']->PPProduktpass_BSCINeeded ? 'Ja' : 'Nein';
                                    $pp['DatumImport'] = 'Error';
                                    if (strlen($value['PP']->PPProduktpass_RevisionDatum) >= 10) {
                                        $pp['DatumImport'] = date_format(date_create($value['PP']->PPProduktpass_RevisionDatum), 'd.m.y');
                                    }
                                    $colArtikelBez = 'black';
                                    $alternativArtikel = $value['PP']->PPProduktpass_Artikelbezeichnung;
                                    if ($lang != 'DE') {
                                        $alternativArtikel = ServiceProvider::tl($lang, $value['PP']->PPProduktpass_Artikelbezeichnung);
                                    }
                                    if (!is_null($value['PP']->PPProduktpass_ArtikelTarga) and strlen($value['PP']->PPProduktpass_ArtikelTarga) > 2) {
                                        $alternativArtikel = $value['PP']->PPProduktpass_ArtikelTarga;
                                        if ($lang != 'DE') {
                                            $alternativArtikel = ServiceProvider::tl($lang, $value['PP']->PPProduktpass_ArtikelTarga);
                                        }
                                        $colArtikelBez = 'red';
                                    }
                                    $pp['artikel'] = substr($alternativArtikel, 0, 80);
                                    if (strlen($alternativArtikel) > 80) {
                                        $pp['artikel'] .= '+';
                                    }
                                    $pp['artikelVoll'] = $alternativArtikel;
                                    $pp['Musterung'] = substr($value['PP']->PPProduktpass_Ausmusterungnummer, 0, 4);
                                    $pp['AltCharge'] = $value['PP']->PPProduktpass_AltCharge;
                                    $pp['LinkAltIAN'] = $value['PP']->PPProduktpass_AltIAN . '_' . $pp['AltCharge'];
                                    $pp['AltIAN'] = $value['PP']->PPProduktpass_AltIAN;
                                    $pp['PMler'] = '';
                                    if (!is_null($value['PP']->PPProduktpass_PMAdmin) and isset($mitarbeiterliste[$value['PP']->PPProduktpass_PMAdmin])) {
                                        $pp['PMler'] = $mitarbeiterliste[$value['PP']->PPProduktpass_PMAdmin];
                                    }
                                    $pp['PJMler'] = '';
                                    if (!is_null($value['PP']->PPProduktpass_PJMAdmin) and isset($mitarbeiterliste[$value['PP']->PPProduktpass_PJMAdmin])) {
                                        $pp['PJMler'] = $mitarbeiterliste[$value['PP']->PPProduktpass_PJMAdmin];
                                    }
                                    $pp['TCler'] = 'N.N.';
                                    if (!is_null($value['PP']->PPProduktpass_TCAdmin) and isset($mitarbeiterliste[$value['PP']->PPProduktpass_TCAdmin])) {
                                        $pp['TCler'] = $mitarbeiterliste[$value['PP']->PPProduktpass_TCAdmin];
                                    }
                                    $pp['PMlerVTR'] = '';
                                    if (!is_null($value['PP']->PPProduktpass_PMAdminVTR) and isset($mitarbeiterliste[$value['PP']->PPProduktpass_PMAdminVTR])) {
                                        $pp['PMlerVTR'] = $mitarbeiterliste[$value['PP']->PPProduktpass_PMAdminVTR];
                                    }
                                    $pp['PJMlerVTR'] = '';
                                    if (!is_null($value['PP']->PPProduktpass_PJMAdminVTR) and isset($mitarbeiterliste[$value['PP']->PPProduktpass_PJMAdminVTR])) {
                                        $pp['PJMlerVTR'] = $mitarbeiterliste[$value['PP']->PPProduktpass_PJMAdminVTR];
                                    }
                                    $pp['TClerVTR'] = '';
                                    if (!is_null($value['PP']->PPProduktpass_TCAdminVTR) and isset($mitarbeiterliste[$value['PP']->PPProduktpass_TCAdminVTR])) {
                                        $pp['TClerVTR'] = $mitarbeiterliste[$value['PP']->PPProduktpass_TCAdminVTR];
                                    }
                                    $dto = new DateTime();
                                    $pp['lt'] = $dto->setISODate($pp['lty'] + 2000, $pp['ltw'])->format('d.m.Y');
                                    $now = new DateTime();
                                    $crd = new DateTime('now', new DateTimeZone('Europe/Berlin'));
                                    $crd->setTime(0, 0, 0);
                                    $hasCrd = isset($value['PP']->PPProduktpass_CRDJahr) && !is_null($value['PP']->PPProduktpass_CRDJahr) && (int) $value['PP']->PPProduktpass_CRDJahr !== 0;
                                    if ($hasCrd) {
                                        $crdw = (int) $value['PP']->PPProduktpass_CRDWoche;
                                        $crdy = (int) $value['PP']->PPProduktpass_CRDJahr;
                                    } else {
                                        $crdw = (int) $value['PP']->PPProduktpass_Liefertermin;
                                        $crdy = (int) $value['PP']->PPProduktpass_LieferterminJahr;
                                    }
                                    $crd->setISODate($crdy, $crdw, 5);
                                    if (!$hasCrd) {
                                        $crd->sub(new DateInterval('P9W'));
                                    }
                                    $inw2ddp = $now->diff($crd);
                                    $week_total = $inw2ddp->format('%R%a') / 7;
                                    $pp['w2crd'] = floor($week_total) + 1;
                                    $pbgcolor[0] = 'white';
                                    $pbgcolor[1] = 'lightgray';
                                    $cpbgcolor[1] = 'rgb(255, 199, 206)';
                                    $cpbgcolor[0] = 'rgb(255, 199, 206)';
                                    if ($lproject != $value['PP']->PPProduktpass_PPProjekte_Projekt or $lproject == '') {
                                        $lcolor++;
                                        $lcolor = $lcolor % 2;
                                        $lproject = $value['PP']->PPProduktpass_PPProjekte_Projekt;
                                    }
                                    $bgProject = $pbgcolor[$lcolor];
                                    $bgCritProject = $pbgcolor[$lcolor];
                                    if ($value['PP']->PPProduktpass_IsCriticalProject == 1) {
                                        $bgCritProject = $cpbgcolor[$lcolor];
                                    }
                                    $fails = MasterplanController::mplanTest($value['PP']->PPProduktpass_Id);
                                    $simInitColor = 'lightgray';
                                    if ($value['PP']->PPProduktpass_SimNeu == -1) {
                                        $simInitColor = 'lightgreen';
                                    }
                                    if (count($fails) > 0) {
                                        $simInitColor = '#ffcccc';
                                    }
                                    ?>
                                    <!-- ===============================
                      TBODY: ab hier Zellen mit .cellClip
                  ================================ -->
                                    <td class="cpcStickycol cellSticky col1 table-cell" data-bg data-bgval="{{ $bgCritProject }}">
                                        <div class="cellClip pad0">
                                            <div class="cellStickyInner">
                                                <a href="/show/{{ $pp['id'] }}" target="_blank" class="linkBlack">
                                                    <div class="ianBox">
                                                        @if (strlen($pp['ian']) > 10)
                                                            {{ substr($pp['ian'], 0, 10) }}X
                                                        @else
                                                            <span class="ianMain" data-color data-colorval="{{ $pp['color_isRFQ'] }}"><b>{{ $pp['ian'] }}</b>
                                                                {{ $isFirstRev }}</span>
                                                        @endif
                                                    </div>
                                                </a>
                                                <br>
                                                <div class="parentChildLine">{{ $pp['ParentChild'] }}</div>
                                                <br>
                                                <div class="altLineWrap">
                                                    @if (strlen($pp['AltIAN']) > 0)
                                                        @if ($pp['IsValid_OldIAN'])
                                                            <a href="/showAlt/{{ $pp['id'] }}" target="_blank" class="linkBrand"><b>{{ $pp['AltIAN'] }}_{{ $pp['AltCharge'] }}</b>
                                                            </a>
                                                        @else
                                                            {{ $pp['AltIAN'] }}_{{ $pp['AltCharge'] }}
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cellWrapBreak col2 table-cell" data-bg data-bgval="{{ $bgProject }}">
                                        <div class="cellClip pad3">
                                            {{ $pp['Musterung'] }}<br>
                                            <a href="/getMpForm/{{ $pp['id'] }}" target="_blank" class="noDeco">
                                                <div class="mplanBtn" data-bg data-bgval="{{ $simInitColor }}">MPlan</div>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="cellWrapBreak col3 table-cell" data-bg data-bgval="{{ $bgProject }}" data-color data-colorval="{{ $colArtikelBez }}" title="{{ $value['PP']->PPProduktpass_Artikelbezeichnung }}">
                                        <div class="cellClip pad3">
                                            {{ $pp['artikel'] }}
                                        </div>
                                    </td>
                                    <td class="cellWrapBreak col4 table-cell" data-bg data-bgval="{{ $bgProject }}">
                                        <div class="cellClip pad3">
                                            @if (ViewController::UserHasRole(Auth::User()->PPMitarbeiter_Id, 'STATUS'))
                                                <div class="statusBlock">
                                                    <select id="setzeStatus_{{ $pp['id'] }}" class="setStatusSelect">
                                                        <option @if ($pp['InternerStatus'] == 'MUSTERUNG') selected @endif value="MUSTERUNG">
                                                            {{ strtoupper(ServiceProvider::tl($lang, 'MUSTERUNG')) }}
                                                        </option>
                                                        <option @if ($pp['InternerStatus'] == 'PLAN') selected @endif value="PLAN">{{ ServiceProvider::tl($lang, 'PLAN') }}
                                                        </option>
                                                        <option @if ($pp['InternerStatus'] == 'FIX') selected @endif value="FIX">{{ ServiceProvider::tl($lang, 'FIX') }}
                                                        </option>
                                                        <option @if ($pp['InternerStatus'] == 'GELIEFERT') selected @endif value="GELIEFERT">
                                                            {{ ServiceProvider::tl($lang, 'GELIEFERT') }}</option>
                                                        <option @if ($pp['InternerStatus'] == 'ABSAGE') selected @endif value="ABSAGE">{{ ServiceProvider::tl($lang, 'ABSAGE') }}
                                                        </option>
                                                    </select>
                                                    <button class="setStatusBtn" type="button" onclick="setzeStatus({{ $pp['id'] }});">{{ ServiceProvider::tl($lang, 'setzen') }}</button>
                                                </div>
                                            @else
                                                <div class="statusBlock statusBlockPad">
                                                    {{ strtoupper(ServiceProvider::tl($lang, $pp['InternerStatus'])) }}
                                                </div>
                                            @endif
                                            <div class="statusBlock statusBlockPad">{{ $pp['statusDoc'] }}</div>
                                        </div>
                                    </td>
                                    <!-- Spalte 5 -->
                                    <td class="col5 table-cell" data-bg data-bgval="{{ $bgProject }}">
                                        <div class="cellClip pad3">
                                            <b>{{ $pp['PPstatus'] }}</b><br>{{ $pp['DatumImport'] }}<br>{{ $pp['LidlUpdateDate'] }}
                                        </div>
                                    </td>
                                    <!-- CRD/DDP -->
                                    <td class="col6 table-cell" data-bg data-bgval="{{ $bgProject }}">
                                        <div class="cellClip pad3">
                                            <table class="crdTable">
                                                <tr>
                                                    <td data-color data-colorval="{{ $styleCRD }}"><b>CRD:</b>
                                                    </td>
                                                    <td><b>{{ $crd->format('W') . '/' . substr($crd->format('o'), 2) }}</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td @if ($pp['ddpltw'] > 54) data-color data-colorval="red" @endif>
                                                        DDP:</td>
                                                    <td>{{ $pp['ddpltw'] }}/{{ $pp['ddplty'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="crdSmall">W2CRD:</span></td>
                                                    <td><b>{{ $pp['w2crd'] }}</b></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                    @if (Auth::User()->PPMitarbeiter_Gruppe == 'admin' or Auth::User()->isMaster)
                                        <td class="uebergabeCell col7 table-cell" data-bg data-bgval="{{ $bgProject }}">
                                            <div class="cellClip pad3">
                                                @if ((Auth::User()->PPMitarbeiter_Taetigkeit == 'TC' and Auth::User()->isMaster) or (Auth::User()->PPMitarbeiter_Gruppe == 'admin'))
                                                    <div name="divSelectTaet_TC" class="divSelectTaetHide">
                                                        <select id="uebergabe_TC_{{ $pp['id'] }}" class="selectUebergabe">
                                                            <option></option>
                                                            @foreach ($TCs as $id => $mx5)
                                                                <option title='{{ isset($mitarbeiterNamen[$id]->PPMitarbeiter_Name) ? $mitarbeiterNamen[$id]->PPMitarbeiter_Name . ', ' . $mitarbeiterNamen[$id]->PPMitarbeiter_Vorname : 'NNN' }}' value="{{ $id }}">{{ $mx5 }}
                                                                </option>
                                                            @endforeach
                                                        </select><br>
                                                        <button type="button" class="uebergabeBtn" onclick="uebergabe({{ $pp['id'] }},'TC', {{ $board }});">{{ ServiceProvider::tl($lang, 'übergeben') }}</button>
                                                    </div>
                                                @endif
                                                @if ((Auth::User()->PPMitarbeiter_Taetigkeit == 'PM' and Auth::User()->isMaster) or (Auth::User()->PPMitarbeiter_Gruppe == 'admin'))
                                                    <div name="divSelectTaet_PM" class="divSelectTaetHide">
                                                        <select id="uebergabe_PM_{{ $pp['id'] }}" class="selectUebergabe">
                                                            <option></option>
                                                            @foreach ($PMs as $id => $mx5)
                                                                <option title='{{ isset($mitarbeiterNamen[$id]->PPMitarbeiter_Name) ? $mitarbeiterNamen[$id]->PPMitarbeiter_Name . ', ' . $mitarbeiterNamen[$id]->PPMitarbeiter_Vorname : 'NNN' }}' value="{{ $id }}">{{ $mx5 }}
                                                                </option>
                                                            @endforeach
                                                        </select><br>
                                                        <button type="button" class="uebergabeBtn" onclick="uebergabe({{ $pp['id'] }},'PM', {{ $board }});">{{ ServiceProvider::tl($lang, 'übergeben') }}</button>
                                                    </div>
                                                @endif
                                                @if ((Auth::User()->PPMitarbeiter_Taetigkeit == 'PJM' and Auth::User()->isMaster) or (Auth::User()->PPMitarbeiter_Gruppe == 'admin'))
                                                    <div name="divSelectTaet_PJM" class="divSelectTaetHide">
                                                        <select id="uebergabe_PJM_{{ $pp['id'] }}" class="selectUebergabe">
                                                                <option></option>
                                                                @foreach ($PJMs as $id => $mx5)
                                                                <option title='{{ isset($mitarbeiterNamen[$id]->PPMitarbeiter_Name) ? $mitarbeiterNamen[$id]->PPMitarbeiter_Name . ', ' . $mitarbeiterNamen[$id]->PPMitarbeiter_Vorname : 'NNN' }}' value="{{ $id }}">{{ $mx5 }}
                                                                </option>
                                                            @endforeach
                                                        </select><br>
                                                        <button type="button" class="uebergabeBtn" onclick="uebergabe({{ $pp['id'] }},'PJM', {{ $board }});">{{ ServiceProvider::tl($lang, 'übergeben') }}</button>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    @endif
                                    <!-- Mitarbeiter -->
                                    <td class="u-center col8 table-cell" data-bg data-bgval="{{ $bgProject }}">
                                        <div class="cellClip pad3">
                                            <?php
                                            $user = Auth::user();
                                            $kuerzel = $user->PPMitarbeiter_Kuerzel;
                                            $isAdmin = $user->PPMitarbeiter_Gruppe == 'admin';
                                            $isMaster = $user->isMaster;
                                            $taetigkeit = $user->PPMitarbeiter_Taetigkeit;
                                            $allowVTRTC = false;
                                            $allowVTRPM = false;
                                            $allowVTRPJM = false;
                                            if (isset($pp['PMler']) and $kuerzel == $pp['PMler']) {
                                                $allowVTRPM = true;
                                            }
                                            if (isset($pp['PJMler']) and $kuerzel == $pp['PJMler']) {
                                                $allowVTRPJM = true;
                                            }
                                            if (isset($pp['TCler']) and $kuerzel == $pp['TCler']) {
                                                $allowVTRTC = true;
                                            }
                                            if ($taetigkeit == 'PM' and ($isAdmin or $isMaster)) {
                                                $allowVTRPM = true;
                                            }
                                            if ($taetigkeit == 'PJM' and ($isAdmin or $isMaster)) {
                                                $allowVTRPJM = true;
                                            }
                                            if ($taetigkeit == 'TC' and ($isAdmin or $isMaster)) {
                                                $allowVTRTC = true;
                                            }
                                            $mplanOK = count($fails) === 0;
                                            $mplanFails = [];
                                            if (!$mplanOK) {
                                                $mplanFails = $fails[$value['PP']->PPProduktpass_Id];
                                            }
                                            ?>
                                            <table class="pmTable">
                                                <tr>
                                                    @if ($allowVTRPM)
                                                        <td class="pointer greenText col1" onclick="VertretungShow('PM', {{ $pp['id'] }} );" title='{{ ServiceProvider::tl($lang, 'Vertreter PM setzen') }}'>
                                                            <b>PM</b>
                                                        </td>
                                                    @else
                                                        <td class='col1'><b>PM</b></td>
                                                    @endif
                                                    <td>{{ $pp['PMler'] }}</td>
                                                    <td><span id="VTRDISPM{{ $pp['id'] }}">
                                                            @if ($pp['PMlerVTR'] != '')
                                                                <b class="orangered">{{ $pp['PMlerVTR'] }}</b>
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    @if ($allowVTRPJM)
                                                        <td class="pointer greenText" onclick="VertretungShow('PJM', {{ $pp['id'] }} );" title='{{ ServiceProvider::tl($lang, 'Vertreter PJM setzen') }}'>
                                                            <b>PJM</b>
                                                        </td>
                                                    @else
                                                        <td><b>PJM</b></td>
                                                    @endif
                                                    <td>{{ $pp['PJMler'] }}</td>
                                                    <td><span id="VTRDISPJM{{ $pp['id'] }}">
                                                            @if ($pp['PJMlerVTR'] != '')
                                                                <b class="orangered">{{ $pp['PJMlerVTR'] }}</b>
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    @if ($allowVTRTC)
                                                        <td class="pointer greenText" onclick="VertretungShow('TC', {{ $pp['id'] }} );" title='{{ ServiceProvider::tl($lang, 'Vertreter TC setzen') }}'>
                                                            <b>TC</b>
                                                        </td>
                                                    @else
                                                        <td><b>TC</b></td>
                                                    @endif
                                                    <td>{{ $pp['TCler'] }}</td>
                                                    <td><span id="VTRDISTC{{ $pp['id'] }}">
                                                            @if ($pp['TClerVTR'] != '')
                                                                <b class="orangered">{{ $pp['TClerVTR'] }}</b>
                                                            @endif
                                                        </span></td>
                                                </tr>
                                            </table>
                                            <div id="VTRINPPM{{ $pp['id'] }}" class="VTRINPHide">
                                                <select id="vertretungPM{{ $pp['id'] }}" class="vtrSelect" onchange="VTRADD('PM', {{ $pp['id'] }});">
                                                    <option></option>
                                                    @foreach ($PMs as $vid => $vtr)
                                                        <option title='{{ isset($mitarbeiterNamen[$vid]->PPMitarbeiter_Name) ? $mitarbeiterNamen[$vid]->PPMitarbeiter_Name . ', ' . $mitarbeiterNamen[$vid]->PPMitarbeiter_Vorname : 'NNN' }}' @if ($pp['PMlerVTR'] == $vtr) selected @endif value="{{ $vid }}">{{ $vtr }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="VTRINPPJM{{ $pp['id'] }}" class="VTRINPHide">
                                                <select id="vertretungPJM{{ $pp['id'] }}" class="vtrSelect" onchange="VTRADD('PJM', {{ $pp['id'] }});">
                                                    <option></option>
                                                    @foreach ($PJMs as $vid => $vtr)
                                                        <option title='{{ isset($mitarbeiterNamen[$vid]->PPMitarbeiter_Name) ? $mitarbeiterNamen[$vid]->PPMitarbeiter_Name . ', ' . $mitarbeiterNamen[$vid]->PPMitarbeiter_Vorname : 'NNN' }}' @if ($pp['PJMlerVTR'] == $vtr) selected @endif value="{{ $vid }}">{{ $vtr }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="VTRINPTC{{ $pp['id'] }}" class="VTRINPHide">
                                                <select id="vertretungTC{{ $pp['id'] }}" class="vtrSelect" onchange="VTRADD('TC', {{ $pp['id'] }});">
                                                    <option></option>
                                                    @foreach ($TCs as $vid => $vtr)
                                                        <option title='{{ isset($mitarbeiterNamen[$vid]->PPMitarbeiter_Name) ? $mitarbeiterNamen[$vid]->PPMitarbeiter_Name . ', ' . $mitarbeiterNamen[$vid]->PPMitarbeiter_Vorname : 'NNN' }}' @if ($pp['TClerVTR'] == $vtr) selected @endif value="{{ $vid }}">{{ $vtr }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                @endif {{-- first --}}
                                <?php
                                /* ======= TERMIN-BLOCK – funktional wie Code 2, aber robuster aufgebaut ======= */
                                $EndeW2LT = isset($po['w2fob']) ? $po['w2fob'] : 0;
                                $dto = new DateTime();
                                if (isset($pp['lty'], $pp['ltw'])) {
                                    $dto->setISODate((int) $pp['lty'], (int) $pp['ltw'], 5);
                                }
                                $spaltenId = isset($header->PPBoardSpalte_Id) ? $header->PPBoardSpalte_Id : 0;
                                $term = isset($value['Termin'][$spaltenId]) && is_object($value['Termin'][$spaltenId]) ? $value['Termin'][$spaltenId] : null;
                                if ($term) {
                                    $t['id'] = isset($term->PPTermine_Id) ? $term->PPTermine_Id : 0;
                                } else {
                                    $t['id'] = 0;
                                    cpcDebug::cpc_debug('Fehler beim Aufbau des Dashboards', '@ERROR');
                                    if (isset($value['PP']->PPProduktpass_Id)) {
                                        cpcDebug::cpc_debug($value['PP']->PPProduktpass_Id, '@ERROR');
                                    }
                                }
                                $t['bgcolor'] = $term && isset($term->PPStati_Background) ? $term->PPStati_Background : '';
                                if (!$term) {
                                    cpcDebug::cpc_debug('Fehler beim Aufbau des Dashboards', '@ERROR');
                                    if (isset($value['PP']->PPProduktpass_Id)) {
                                        cpcDebug::cpc_debug($value['PP']->PPProduktpass_Id, '@ERROR');
                                    }
                                }
                                try {
                                    $t['bemerkung'] = $term && isset($term->PPTermine_Bemerkungen) ? $term->PPTermine_Bemerkungen : '';
                                    $t['terminart'] = isset($header->PPBoardSpalte_Bezeichnung) ? $header->PPBoardSpalte_Bezeichnung : '';
                                    $t['status'] = $term && isset($term->PPTermine_Status) ? $term->PPTermine_Status : '';
                                    $t['ma'] = $term && isset($term->PPTermine_MAZustaendigkeit) ? $term->PPTermine_MAZustaendigkeit : '';
                                    $t['history'] = $term && isset($term->PPTermine_History) ? $term->PPTermine_History : '';
                                } catch (Exception $e) {
                                    cpcDebug::cpc_debug('Fehler beim Aufbau des Dashboards', '-ERRORForm');
                                    if (isset($value['PP']->PPProduktpass_Id)) {
                                        cpcDebug::cpc_debug($value['PP']->PPProduktpass_Id, '-ERRORForm');
                                    }
                                    cpcDebug::cpc_debug($e->getMessage(), '-ERRORForm');
                                    $t['bemerkung'] = '';
                                    $t['terminart'] = isset($header->PPBoardSpalte_Bezeichnung) ? $header->PPBoardSpalte_Bezeichnung : '';
                                    $t['status'] = '';
                                    $t['ma'] = '';
                                    $t['history'] = '';
                                }
                                if (((isset($lang) && $lang === 'EN') || (isset($_COOKIE['TPTLanguage']) && $_COOKIE['TPTLanguage'] === 'EN')) && $term && isset($term->PPTermine_HistoryEN)) {
                                    $t['history'] = $term->PPTermine_HistoryEN;
                                }
                                $t['log'] = isset($value['Log'][$spaltenId]) ? $value['Log'][$spaltenId] : null;
                                $dbV = isset($value['Dashboard'][$spaltenId]) ? $value['Dashboard'][$spaltenId] : [];
                                $manSollDateRaw = $term && isset($term->PPTermine_ManSollDate) ? $term->PPTermine_ManSollDate : '0000-00-00 00:00:00';
                                if ($manSollDateRaw == '0000-00-00 00:00:00') {
                                    $t['rot'] = isset($header->PPBoardSpalte_Rot) ? $header->PPBoardSpalte_Rot : 0;
                                    $t['orange'] = isset($header->PPBoardSpalte_Orange) ? $header->PPBoardSpalte_Orange : 0;
                                    $t['IsMileStone'] = $term && isset($term->PPBoardSpalte_IsMilestone) ? $term->PPBoardSpalte_IsMilestone : false;
                                } else {
                                    try {
                                        $thisFriday = new DateTime();
                                        $thisFriday->setISODate((int) $thisFriday->format('Y'), (int) $thisFriday->format('W'), 5);
                                        $manSollDate = new DateTime($manSollDateRaw);
                                        $diffManSoll = $thisFriday->diff($manSollDate, true);
                                        $w2ManSoll = floor(((int) $diffManSoll->format('%R%a')) / 7);
                                        $manSoll = $term && isset($term->PPTermine_ManSoll) ? (int) $term->PPTermine_ManSoll : 0;
                                        $t['rot'] = -1 * $manSoll - 10;
                                        $t['orange'] = $t['rot'] + 2;
                                        $t['IsMileStone'] = true;
                                    } catch (Exception $e) {
                                        $t['rot'] = isset($header->PPBoardSpalte_Rot) ? $header->PPBoardSpalte_Rot : 0;
                                        $t['orange'] = isset($header->PPBoardSpalte_Orange) ? $header->PPBoardSpalte_Orange : 0;
                                        $t['IsMileStone'] = $term && isset($term->PPBoardSpalte_IsMilestone) ? $term->PPBoardSpalte_IsMilestone : false;
                                    }
                                }
                                $t['start'] = '0000-00-00';
                                $t['ende'] = '0000-00-00';
                                $t['IsUSA'] = $term && isset($term->PPBoardSpalte_IsUSA) ? $term->PPBoardSpalte_IsUSA : 0;
                                $t['Mitarbeiter'] = $term && isset($term->PPMitarbeiter_Kuerzel) ? $term->PPMitarbeiter_Kuerzel : '';
                                $t['bg'] = isset($value['BG'][$spaltenId]) ? $value['BG'][$spaltenId] : '';
                                $t['label'] = $term && isset($term->PPTermine_Label) ? $term->PPTermine_Label : '';
                                $t['labelEN'] = $term && isset($term->PPTermine_LabelEN) ? $term->PPTermine_LabelEN : '';
                                $t['bemerkung'] = $term && isset($term->PPTermine_Bemerkungen) ? $term->PPTermine_Bemerkungen : '';
                                $t['bemerkungEN'] = $term && isset($term->PPTermine_BemerkungenEN) ? $term->PPTermine_BemerkungenEN : '';
                                if ($lang == 'DE') {
                                    $orgLabel1 = $t['label'];
                                    $orgRemark1 = $t['bemerkung'];
                                    $translatedLabel1 = $t['labelEN'];
                                    $translatedRemark1 = $t['bemerkungEN'];
                                } else {
                                    $orgLabel1 = $t['labelEN'];
                                    $orgRemark1 = $t['bemerkungEN'];
                                    $translatedLabel1 = $t['label'];
                                    $translatedRemark1 = $t['bemerkung'];
                                }
                                $t['datafield'] = isset($value['Datafield'][$spaltenId]) ? $value['Datafield'][$spaltenId] : null;
                                if (isset($pp['ltw'], $pp['lty']) && (int) $pp['ltw'] + (int) $t['rot'] <= 0) {
                                    $t['SOLLW'] = (int) $pp['ltw'] + (int) $t['rot'] + 52;
                                    $t['SOLLY'] = (int) $pp['lty'] - 1;
                                } else {
                                    $t['SOLLW'] = isset($pp['ltw']) ? (int) $pp['ltw'] + (int) $t['rot'] : 0;
                                    $t['SOLLY'] = isset($pp['lty']) ? (int) $pp['lty'] : 0;
                                }
                                /**** Neu Berechnung ************************************************************* */
                                $w2start_undef = -100000;
                                $w2start = $w2start_undef;
                                $datenow = new DateTime();
                                $weekNow = $datenow->format('W');
                                $w2startNeu = $w2start_undef;
                                $startDateNeu = date('Y-m-d', strtotime('friday this week'));
                                $bgNeu = '240,240,240';
                                $startKWNeu = 0;
                                $pre = 'XXX';
                                $startdate = null;
                                $diff = null;
                                $diffTage = 0;
                                $msg = '';
                                try {
                                    $crd = new DateTime();
                                    $crdw = isset($value['PP']->PPProduktpass_CRDWoche) ? (int) $value['PP']->PPProduktpass_CRDWoche : 0;
                                    $crdy = isset($value['PP']->PPProduktpass_CRDJahr) ? (int) $value['PP']->PPProduktpass_CRDJahr : 0;
                                    if ($crdy == 0) {
                                        $crdw = isset($value['PP']->PPProduktpass_Liefertermin) ? (int) $value['PP']->PPProduktpass_Liefertermin : 0;
                                        $crdy = isset($value['PP']->PPProduktpass_LieferterminJahr) ? (int) $value['PP']->PPProduktpass_LieferterminJahr : 0;
                                    }
                                    $crd->setISODate($crdy, $crdw, 5);
                                    if ((isset($value['PP']->PPProduktpass_CRDJahr) ? (int) $value['PP']->PPProduktpass_CRDJahr : 0) == 0) {
                                        $interval = new DateInterval('P10W');
                                        $crd->sub($interval);
                                    }
                                    $stdPeriode = (int) $t['rot'] + 10;
                                    if ($stdPeriode < 0) {
                                        $stdPeriode *= -1;
                                    }
                                    $stdPeriodeInterval = new DateInterval('P' . $stdPeriode . 'W');
                                    $startDateNeu = clone $crd;
                                    if ((int) $t['rot'] + 10 < 0) {
                                        $startDateNeu->sub($stdPeriodeInterval);
                                    } else {
                                        $startDateNeu->add($stdPeriodeInterval);
                                    }
                                    $dayOfWeek = (int) $startDateNeu->format('w');
                                    if ($dayOfWeek > 5) {
                                        $dayOfWeek = 5;
                                    }
                                    $d2friday = 5 - $dayOfWeek;
                                    $d2FridayInterval = new DateInterval('P' . $d2friday . 'D');
                                    $startDateNeu->add($d2FridayInterval);
                                    $rwi = $datenow->diff($startDateNeu);
                                    $rw = ((int) $rwi->format('%a')) / 7;
                                    if ($datenow > $startDateNeu) {
                                        $rw *= -1;
                                    }
                                    $w2startNeu = round($rw, 0);
                                    $pre = 'STD';
                                    if ($manSollDateRaw != '0000-00-00 00:00:00') {
                                        $per1 = $term && isset($term->PPTermine_ManSoll) ? (int) $term->PPTermine_ManSoll : 0;
                                        $perI = new DateInterval('P' . $per1 . 'W');
                                        $startDateNeu = new DateTime($manSollDateRaw);
                                        $rwi = $datenow->diff($startDateNeu);
                                        $rw = ((int) $rwi->format('%R%a')) / 7;
                                        $w2startNeu = floor($rw);
                                        $pre = 'MAN';
                                    }
                                    $startKWNeuDisplay = '';
                                    $dOw = '';
                                    $datumStartRaw = $term && isset($term->PPTermine_DatumStart) ? $term->PPTermine_DatumStart : '0000-00-00';
                                    if (substr($datumStartRaw, 0, 10) != '0000-00-00') {
                                        $startDateNeu = new DateTime($datumStartRaw);
                                        $dayOfWeek = (int) $startDateNeu->format('w');
                                        if ($dayOfWeek > 5) {
                                            $dayOfWeek = 5;
                                        }
                                        $d2friday = 5 - $dayOfWeek;
                                        $d2FridayInterval = new DateInterval('P' . $d2friday . 'D');
                                        $startDateNeu->add($d2FridayInterval);
                                        $datenow = new DateTime(date('Y-m-d'));
                                        $dayOfWeek = (int) $datenow->format('w');
                                        if ($dayOfWeek > 5) {
                                            $dayOfWeek = 5;
                                        }
                                        $d2friday = 5 - $dayOfWeek;
                                        $d2FridayInterval = new DateInterval('P' . $d2friday . 'D');
                                        $datenow->add($d2FridayInterval);
                                        $diffI = $datenow->diff($startDateNeu, true);
                                        $diffTage = (int) $diffI->format('%R%a');
                                        if ($startDateNeu < $datenow) {
                                            $pre = 'I1';
                                            $startKWNeu = floor($diffTage / 7) * -1;
                                        } else {
                                            $pre = 'I2';
                                            $startKWNeu = ceil($diffTage / 7);
                                        }
                                        $w2startNeu = $startKWNeu;
                                        $startKWNeuDisplay = 'x';
                                    }
                                    if ($w2startNeu == -0) {
                                        $w2startNeu = 0;
                                    }
                                    if ($w2startNeu > 2) {
                                        $bgNeu = '240,240,240';
                                    }
                                    if ($w2startNeu <= 2 && $w2startNeu >= 0) {
                                        $bgNeu = '255,255,153';
                                    }
                                    if ($w2startNeu < 0) {
                                        $bgNeu = '255, 199, 206';
                                    }
                                } catch (Exception $ex) {
                                    $t['start'] = '0000-00-00';
                                    $msg = $ex->getMessage();
                                }
                                /********************* ENDE NEU *********************/
                                try {
                                    $datumStartRaw = $term && isset($term->PPTermine_DatumStart) ? $term->PPTermine_DatumStart : '0000-00-00';
                                    if (substr($datumStartRaw, 0, 10) != '0000-00-00') {
                                        $ds = new DateTime($datumStartRaw);
                                        $weekday = (int) $ds->format('N');
                                        if ($weekday > 5) {
                                            $weekday = 5;
                                        }
                                        $days2add = 5 - $weekday;
                                        $day2AddInterval = new DateInterval('P' . $days2add . 'D');
                                        $t['start'] = $ds->format('d.m.Y');
                                        $dateStart = new DateTime($t['start']);
                                        $weekStart = $dateStart->format('W');
                                        $datenow = new DateTime();
                                        $weekNow = $datenow->format('W');
                                        $w2start = $weekNow - $weekStart + 1;
                                        if ($w2start == -0) {
                                            $w2start = 0;
                                        }
                                        if ($w2start > 2) {
                                            $t['bg'] = '240,240,240';
                                        }
                                        if ($w2start <= 2 && $w2start >= 0) {
                                            $t['bg'] = '255,255,153';
                                        }
                                        if ($w2start < 0) {
                                            $t['bg'] = '255, 199, 206';
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $t['start'] = '1900-01-11';
                                }
                                $_weeks = 0;
                                if ($w2start == $w2start_undef) {
                                    $_weeks = (isset($po['w2fob']) ? (int) $po['w2fob'] : 0) + (int) $t['rot'];
                                    if ($_weeks == -0) {
                                        $_weeks = 0;
                                    }
                                    if ($_weeks > 2) {
                                        $t['bg'] = '240,240,240';
                                    }
                                    if ($_weeks <= 2 && $_weeks > 0) {
                                        $t['bg'] = '255,255,153';
                                    }
                                    if ($_weeks <= 0) {
                                        $t['bg'] = '255, 199, 206';
                                    }
                                }
                                try {
                                    $datumEndeRaw = $term && isset($term->PPTermine_DatumEnde) ? $term->PPTermine_DatumEnde : '0000-00-00';
                                    if (substr($datumEndeRaw, 0, 10) != '0000-00-00') {
                                        $de = new DateTime($datumEndeRaw);
                                        $t['ende'] = $de->format('d.m.Y');
                                    }
                                } catch (Exception $ex) {
                                }
                                $t['WERL'] = '';
                                $t['OKSTATUS'] = isset($value['OKSTATUS'][$spaltenId]) ? $value['OKSTATUS'][$spaltenId] : 'NO';
                                $t['WERLSET'] = isset($value['WERLSET'][$spaltenId]) ? $value['WERLSET'][$spaltenId] : 'NO';
                                $t['WERLW'] = isset($value['WERLW'][$spaltenId]) ? $value['WERLW'][$spaltenId] : 0;
                                $t['WERLY'] = isset($value['WERLY'][$spaltenId]) ? $value['WERLY'][$spaltenId] : 0;
                                if ($t['OKSTATUS'] == 'YES') {
                                    if ($t['WERLSET'] == 'YES') {
                                        $t['WERLY'] = (int) $t['WERLY'] - 2000;
                                        if ((int) $t['SOLLY'] == (int) $t['WERLY']) {
                                            $t['WERL'] = (int) $t['SOLLW'] - (int) $t['WERLW'];
                                        } else {
                                            $suby = -52;
                                            if ((int) $t['SOLLY'] > (int) $t['WERLY']) {
                                                $suby = +52;
                                            }
                                            $t['WERL'] = (int) $t['SOLLW'] + $suby - (int) $t['WERLW'];
                                        }
                                    }
                                    try {
                                        $datumEndeRaw = $term && isset($term->PPTermine_DatumEnde) ? $term->PPTermine_DatumEnde : '0000-00-00 00:00:00';
                                        $newErlDate = new DateTime($datumEndeRaw);
                                        if ($manSollDateRaw != '0000-00-00 00:00:00') {
                                            $newSollDate = new DateTime($manSollDateRaw);
                                        } else {
                                            $nnewcrd = new DateTime();
                                            $nnewcrdw = isset($value['PP']->PPProduktpass_CRDWoche) ? (int) $value['PP']->PPProduktpass_CRDWoche : 0;
                                            $nnewcrdy = isset($value['PP']->PPProduktpass_CRDJahr) ? (int) $value['PP']->PPProduktpass_CRDJahr : 0;
                                            if ($nnewcrdy == 0) {
                                                $nnewcrdw = isset($value['PP']->PPProduktpass_Liefertermin) ? (int) $value['PP']->PPProduktpass_Liefertermin : 0;
                                                $nnewcrdy = isset($value['PP']->PPProduktpass_LieferterminJahr) ? (int) $value['PP']->PPProduktpass_LieferterminJahr : 0;
                                            }
                                            $nnewcrd->setISODate($nnewcrdy, $nnewcrdw, 5);
                                            if ((isset($value['PP']->PPProduktpass_CRDJahr) ? (int) $value['PP']->PPProduktpass_CRDJahr : 0) == 0) {
                                                $interval = new DateInterval('P10W');
                                                $nnewcrd->sub($interval);
                                            }
                                            $nstdPeriode = (int) $t['rot'] + 10;
                                            if ($nstdPeriode < 0) {
                                                $nstdPeriode *= -1;
                                            }
                                            $nstdPeriodeInterval = new DateInterval('P' . $nstdPeriode . 'W');
                                            $newSollDate = clone $nnewcrd;
                                            if ((int) $t['rot'] + 10 < 0) {
                                                $newSollDate->sub($nstdPeriodeInterval);
                                            } else {
                                                $newSollDate->add($nstdPeriodeInterval);
                                            }
                                        }
                                        $ndiff = $newSollDate->diff($newErlDate, true);
                                        $newW2Erl = ((int) $ndiff->format('%R%a')) / 7;
                                        $newW2Erl = floor($newW2Erl);
                                        if ($newErlDate > $newSollDate) {
                                            $t['WERL'] = 0;
                                            if ($newW2Erl > 0) {
                                                $t['WERL'] = -1 * $newW2Erl;
                                            }
                                        } else {
                                            $t['WERL'] = $newW2Erl;
                                        }
                                    } catch (Exception $ex) {
                                    }
                                }
                                $as = explode('x', isset($header->PPBoardSpalte_Stati) ? $header->PPBoardSpalte_Stati : '');
                                $xs = [];
                                $xs['Neu'] = 'Neu';
                                foreach ($as as $s) {
                                    if (isset($statiAll[$s])) {
                                        $xs[$statiAll[$s]] = $statiAll[$s];
                                    }
                                }
                                $t['stati'] = $xs;
                                $newBG = $bgNeu;
                                $empty = false;
                                if ($t['status'] == 'nicht benötigt') {
                                    $empty = true;
                                    $newBG = '255, 199, 206';
                                }
                                $failType = 'transparent';
                                if (isset($mplanOK) && !$mplanOK && isset($mplanFails, $t['id'], $mplanFails[$t['id']]['stats'])) {
                                    $msfail = $mplanFails[$t['id']]['stats'];
                                    if (isset($msfail['budget'])) {
                                        $failType = 'orange';
                                    }
                                    if (isset($msfail['rule'])) {
                                        $failType = 'red';
                                    }
                                }
                                $deadlineTitleNo = $w2start != $w2start_undef ? "Deadline (manuell): {$w2startNeu}W \nDeadline (berechnet): " . ((int) (isset($po['w2fob']) ? $po['w2fob'] : 0) + (int) $t['rot']) . 'W' : 'Deadline (berechnet): ' . ((int) (isset($po['w2fob']) ? $po['w2fob'] : 0) + (int) $t['rot']) . 'W';
                                $deadlineTitleYes = $w2start != $w2start_undef ? "Deadline (manuell): {$w2startNeu}W \nDeadline (berechnet): " . ((int) (isset($pp['w2crd']) ? $pp['w2crd'] : 0) + (int) $t['rot'] + 9) . 'W' : 'Deadline (berechnet): ' . ((int) (isset($pp['w2crd']) ? $pp['w2crd'] : 0) + (int) $t['rot'] + 9) . 'W';
                                $title = implode("\n", array_filter([isset($dbV['Art']) ? $dbV['Art'] : null, 'CRD:' . (isset($dbV['CRDDate']) ? $dbV['CRDDate'] : ''), 'W2Soll:' . (isset($dbV['W2CRD']) ? $dbV['W2CRD'] : ''), 'Soll:' . (isset($dbV['SollDate']) ? $dbV['SollDate'] : ''), $msg, isset($pp['ian']) ? $pp['ian'] : null, $t['terminart'], 'MA: ' . $t['Mitarbeiter'] . ' Status: ' . $t['status'], strlen($t['label']) ? 'Label: ' . $t['label'] : null]));
                                ?>
                                <!-- Termin-Spalte: Wrapper fixiert Höhe -->
                                <td class="table-cell_value termCell" data-bg data-bgval="rgb({{ isset($t['bgcolor']) ? $t['bgcolor'] : '255,0,0' }})">
                                    <div class="cellClip pad0">
                                        @if ($t['OKSTATUS'] == 'NO')
                                            <div class="termDeadlineBar" data-bg data-bgval="rgb({{ $newBG }})" title="{{ $deadlineTitleNo }}">
                                                <span class="termDeadlineText" title="{{ $deadlineTitleNo }}">{{ $w2startNeu }}</span>
                                            </div>
                                        @else
                                            @if ($t['WERL'] < 0)
                                                <div class="termDeadlineBar" data-bg data-bgval="@if ($t['status'] != 'nicht benötigt') rgb(255,199,206) @else rgb(25,157,45) @endif" title="{{ $deadlineTitleYes }}">
                                                    <span class="termDeadlineText" data-color data-colorval="darkblue">
                                                        @if ($t['status'] != 'nicht benötigt')
                                                            {{ $t['WERL'] }}
                                                        @endif
                                                    </span>
                                                </div>
                                            @else
                                                <div class="termDeadlineBar" data-bg data-bgval="rgb(25,157,45)" title="{{ $deadlineTitleYes }}">
                                                    <span class="termDeadlineText termDeadlineTextWhite">
                                                        @if ($t['status'] != 'nicht benötigt')
                                                            {{ $t['WERL'] }}
                                                        @endif
                                                    </span>
                                                </div>
                                            @endif
                                        @endif
                                        <div class="termClickArea" data-bg data-bgval="rgb({{ isset($t['bgcolor']) ? $t['bgcolor'] : '255,0,0' }})" title="{{ $title }}" onclick="ajax_getTermin({{ $pp['id'] }},{{ $t['id'] }},{{ $board }})">
                                            @if ($t['status'] == 'nicht benötigt')
                                                <span class="termNotNeeded">
                                                    @if ($lang == 'DE')
                                                        nicht benötigt
                                                    @else
                                                        not needed
                                                    @endif
                                                </span>
                                            @endif
                                            @if (strlen(trim($t['bemerkung'])) > 0)
                                                <div class="markerRemark" title="{{ $orgRemark1 }}">&nbsp;</div>
                                            @endif
                                            <div class="markerMplan" data-mplan="{{ $failType }}" title="MPlan Status"></div>
                                            <span class="termLabel" title='{{ $translatedLabel1 }}'>{{ $orgLabel1 }}</span>
                                        </div>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <?php $_SESSION['TPT_Message'] = " $poscount Datensätze in " . number_format(microtime(true) - $kalender['STARTTIME'], '1', ',', '.') . ' Sekunden.'; ?>
        </div>
</div>
@else
<div class="tahoma" style="padding:20px;">
    <h1>Keine Daten gefunden!</h1>
</div>
@endif
<script>
    /* =========================================================
      data-bg / data-color / data-mplan anwenden
    ========================================================= */
    function applyDataStyles() {
        document.querySelectorAll("[data-bg][data-bgval]").forEach(el => {
            const bg = el.getAttribute("data-bgval");
            // direkt setzen (robust für sticky/zoom)
            el.style.backgroundColor = bg;
            // falls ein cellClip drin ist: auch den einfärben (manche Browser “überdecken” td)
            const clip = el.querySelector(":scope > .cellClip");
            if (clip) clip.style.backgroundColor = bg;
        });
        document.querySelectorAll("[data-color][data-colorval]").forEach(el => {
            const fg = el.getAttribute("data-colorval");
            el.style.color = fg;
        });
        document.querySelectorAll(".markerMplan[data-mplan]").forEach(el => {
            el.style.backgroundColor = el.getAttribute("data-mplan");
        });
    }
    $(document).ready(function() {
        const firstInput = document.getElementById('inpIAN');
        if (firstInput) firstInput.focus();
        applyDataStyles();
    });
    /* ========== Dein JS (nur 1 Bugfix: VTRADD dis-id) ========== */
    function submitFormX(event) {
        if (event.keyCode == 13) {
            const frm = document.getElementById('formgetTermine');
            frm.submit();
            return false;
        }
    }
    function uebergabe(ppid, art, board) {
        const elem = document.getElementById('uebergabe_' + art + '_' + ppid);
        const maid = elem.value;
        if (maid != 0) {
            //console.log(ppid + '#'+art+'#'+maid+'#'+board);
            setMA_PM_TC(ppid, art, maid, board);
        }
    }
    function setzeStatus(ppid) {
        const elem = document.getElementById('setzeStatus_' + ppid);
        const state = elem.value;
        if (state != 0) {
            if (state == 'ABSAGE') {
                overlay.style.display = "flex";
                document.getElementById('inpPPId').value = ppid;
                document.getElementById('inpState').value = state;
            } else {
                updateStatus(ppid, state);
                overlay.style.display = "none";
            }
        }
    }
    /* Save Filter Start */
    function saveFilter(board) {
        const filters = document.querySelectorAll('[name*="sQry"]');
        var qryFilter = {};
        for (let index = 0; index < filters.length; index++) {
            const elem = filters[index];
            var att = elem.name.replace('sQry[', '').replace(']', '');
            var val = elem.value;
            qryFilter[att] = val;
        }
        var critPro = document.getElementById('inpPPProduktpass_IsCriticalProjectReal').checked;
        qryFilter['PPProduktpass_IsCriticalProject'] = critPro ? 1 : 0;
        var json_qryFilter = JSON.stringify(qryFilter);
        var frmData = new FormData();
        frmData.append('qryFilter', json_qryFilter);
        frmData.append('board', board);
        $.ajax({
            type: "POST",
            url: "/saveFilter",
            data: frmData,
            processData: false,
            contentType: false,
            success: onSuccess_saveFilter,
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function onSuccess_saveFilter(jsonResult) {
        alert('Filter gespeichert!');
    }
    function getFilter(board) {
        var frmData = new FormData();
        frmData.append('board', board);
        $.ajax({
            type: "POST",
            url: "/getFilter",
            data: frmData,
            processData: false,
            contentType: false,
            success: onSuccess_getFilter,
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function onSuccess_getFilter(jsonResult) {
        var qryFilter = JSON.parse(jsonResult);
        const filters = document.querySelectorAll('[name*="sQry"]');
        for (let index = 0; index < filters.length; index++) {
            var elem = filters[index];
            var att = elem.name.replace('sQry[', '').replace(']', '');
            elem.value = qryFilter[att];
        }
        document.getElementById('formgetTermine').submit();
    }
    /* Save Filter Ende */
    function updateStatus(id, state, grund = '') {
        var frmData = new FormData();
        frmData.append('id', id);
        frmData.append('state', state);
        frmData.append('absageGrund', grund);
        $.ajax({
            type: "POST",
            url: "/updateStatus",
            data: frmData,
            processData: false,
            contentType: false,
            success: onSuccess_updateStatus,
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function onSuccess_updateStatus(jsonResult) {
        alert('{{ ServiceProvider::tl($lang, 'Status gesetzt!') }}');
        window.location.reload();
    }
    function setMA_PM_TC(id, art, maid, board) {
        var frmData = new FormData();
        frmData.append('id', id);
        frmData.append('art', art);
        frmData.append('maid', maid);
        frmData.append('board', board);
        $.ajax({
            type: "POST",
            url: "/setMA_PM_TC",
            data: frmData,
            processData: false,
            contentType: false,
            success: onSuccess_setMA_PM_TC,
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function onSuccess_setMA_PM_TC(jsonResult) {
        const data = JSON.parse(jsonResult).Data;
        const elem = document.getElementById('uebergabe_' + data.art + '_' + data.id);
        if (elem) elem.value = '';
        alert('[' + data.art + '] Mitarbeiter gesetzt!');
        window.location.reload();
    }
    function rstForm() {
        var elements = document.querySelectorAll('[id^=inpForm]');
        for (var i = 0; i < elements.length; i++) {
            if (elements[i].nodeName == 'INPUT') {
                elements[i].value = "";
                if (elements[i].id == 'inpFormMusterung' || elements[i].id == 'inpFormIAN') {
                    elements[i].value = "%";
                    if (elements[i].name == 'sQry[PPProduktpass_Ausmusterungnummer]') {
                        elements[i].value = "%";
                    }
                }
            } else if (elements[i].nodeName == 'SELECT') {
                elements[i].selectedIndex = 0;
            }
        }
        document.getElementById('formgetTermine').submit();
    }
    function ajax_getTermin(ppid, tid, board) {
        window.open("/getTerminFromId/" + ppid + "/" + tid + "/" + board, "Termindetails",
            "toolbar=no, scrollbars=no, resizable=no, top=10, left=10, width=1910, height=1160");
    }
    function VertretungShow(art, ppid) {
        const inp = document.getElementById('VTRINP' + art + ppid);
        if (!inp) return;
        // Row hochheben
        const row = inp.closest('tr.table-row');
        if (row) row.classList.add('is-popover-open');
        // Overlay zeigen
        inp.classList.remove('VTRINPHide');
        inp.classList.add('VTRINPShow');
        inp.style.display = 'block';
        // Position: unter die angeklickte PM/PJM/TC-Zeile
        // (wir nehmen die PM/PJM/TC-Zeile als Anker)
        inp.focus();
        const anchor = row.querySelector('.pmTable'); // fallback
        const host = inp.closest('.cellClip'); // relative Parent
        if (host && anchor) {
            const a = anchor.getBoundingClientRect();
            const h = host.getBoundingClientRect();
            //alert(a.bottom + " " + h.top);
            inp.style.left = '10px';
            inp.style.top = (h.top - a.bottom + 30) + 'px';
        }
    }
    function VertretungHide(art, ppid) {
        const inp = document.getElementById('VTRINP' + art + ppid);
        if (!inp) return;
        const row = inp.closest('tr.table-row');
        if (row) row.classList.remove('is-popover-open');
        inp.classList.replace('VTRINPShow', 'VTRINPHide');
        inp.style.display = 'none';
    }
    function VTRADD(art, ppid) {
        var vtr = document.getElementById('vertretung' + art + ppid);
        var dis = document.getElementById('VTRDIS' + art + ppid); // FIX
        if (vtr) {
            if (vtr.value == 0) {
                if (dis) dis.innerHTML = '';
            } else {
                if (dis) dis.innerHTML = '' + vtr.options[vtr.selectedIndex].text;
            }
            //console.log("id: " + ppid + " art: " + art +"  maid: " + vtr.value);
            setVTR(ppid, art, vtr.value);
            VertretungHide(art, ppid);
        }
    }
    function setVTR(id, art, maid) {
        var frmData = new FormData();
        frmData.append('id', id);
        frmData.append('art', art);
        frmData.append('maid', maid);
        $.ajax({
            type: "POST",
            url: "/setVTR",
            data: frmData,
            processData: false,
            contentType: false,
            success: onSuccess_setVTR,
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function onSuccess_setVTR(jsonResult) {
        var data = JSON.parse(jsonResult).Data;
        alert('[' + data.art + '] Vertretung gesetzt!');
    }
    function prevPage() {
        var elemInp = document.getElementById('page');
        var page = elemInp.value * 1;
        if (page - 1 > 0) {
            elemInp.value = page - 1;
            document.getElementById('formgetTermine').submit();
        } else {
            alert('Erste Seite erreicht!');
        }
    }
    function nextPage() {
        var elemInp = document.getElementById('page');
        var elemPages = document.getElementById('pages');
        var page = elemInp.value * 1;
        if (page < (elemPages.value * 1)) {
            elemInp.value = page + 1;
            document.getElementById('formgetTermine').submit();
        } else {
            alert('Letzte Seite erreicht!');
        }
    }
    /* Overlay Submit */
    const overlay = document.getElementById("overlay");
    //const openBtn = document.getElementById("openOverlay");
    //const closeBtn = document.getElementById("closeOverlay");
    const form = document.getElementById("FormAbsagegrund");
    // Overlay öffnen
    //openBtn.addEventListener("click", () => {
    //  overlay.style.display = "flex";
    //});
    // Overlay schließen
    //closeBtn.addEventListener("click", () => {
    //  overlay.style.display = "none";
    //});
    // Formular absenden
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        const data = Object.fromEntries(new FormData(form).entries());
        updateStatus(data.inpPPId, data.inpState, data.inpAbsagegrund);
        overlay.style.display = "none";
        form.reset();
    });
    function fillSelect(sel) {
        var val = sel.value; // PM | PJM | TC | ""
        // alle Blöcke ausblenden
        var blocks = document.querySelectorAll('[name^="divSelectTaet_"]');
        blocks.forEach(function(el) {
            el.classList.remove('divSelectTaetShow');
            el.classList.add('divSelectTaetHide');
        });
        if (!val) return;
        // passenden Block einblenden
        var showBlocks = document.querySelectorAll('[name="divSelectTaet_' + val + '"]');
        showBlocks.forEach(function(el) {
            el.classList.remove('divSelectTaetHide');
            el.classList.add('divSelectTaetShow');
        });
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' || e.key === 'Esc') {
            document.querySelectorAll('.VTRINPShow').forEach(function(el) {
                VertretungHide(el.id.replace('VTRINP', '').slice(0, -3), el.id.replace('VTRINP', '')
                    .slice(-3));
                const row = el.closest('tr.table-row');
                if (row) row.classList.remove('is-popover-open');
            });
        }
    });
    function toggleFilterBox() {
        const box = document.getElementById('filterBox');
        const btn = document.getElementById('toggleFilterBtn');
        const hidden = box.style.display === 'none';
        box.style.display = hidden ? 'block' : 'none';
        btn.textContent = hidden ? 'Filter ausblenden (Alt + s)' : 'Filter einblenden (Alt + s)';
        $('#inpFormMusterung').focus().select();
    }
    document.addEventListener('keydown', function(e) {
        // Alt + S
        if (e.altKey && !e.ctrlKey && !e.shiftKey && !e.metaKey && e.code === 'KeyS') {
            e.preventDefault(); // verhindert Browser-/Menü-Shortcut
            toggleFilterBox();
        }
    });
</script>
