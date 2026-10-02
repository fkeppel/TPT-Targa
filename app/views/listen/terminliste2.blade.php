<?php 
    $responsibles = $data['mitarbeiter'];
    $projects = $data['projects'];
    $chargen = $data['chargen'];
    $termine = $data['termine'];
?>
<style>
/* ==========================================================
   SCROLLBEREICH
   ========================================================== */
    .filter-table-wrapper{
        width:100%;
        max-height:calc(100vh - 170px);
        overflow:auto;
        position:relative;
        -webkit-overflow-scrolling:touch;
        margin-top:40px;
    }
    /* ==========================================================
    TABELLE
    ========================================================== */
    .milestone-filter-table{
        width:1670px;
        min-width:1670px;
        max-width:1670px;
        table-layout:fixed;
        border-collapse:separate;
        border-spacing:0;
        background:#fff;
        border:1px solid #d7dde4;
        font-family:Segoe UI,Arial,sans-serif;
        font-size:12px;
        color:#333;
    }
    /* ==========================================================
    SPALTENBREITEN
    ========================================================== */
    .col-responsible{ width:70px; }
    .col-project{ width:250px; }
    .col-pattern{ width:55px; }
    .col-display-text{ width:250px; }
    .col-comment{ width:250px; }
    .col-date{ width:85px; }
    .col-date-type{ width:120px; }
    .col-status{ width:110px; }
    .col-action{ width:90px; }
    /* ==========================================================
    HEADER
    ========================================================== */
    .milestone-filter-table thead th{
        position:sticky;
        top:0;
        z-index:50;
        background:#34495e;
        color:#fff;
        padding:6px;
        text-align:left;
        font-size:10px;
        font-weight:bold;
        text-transform:uppercase;
        border-right:1px solid #556677;
        border-bottom:2px solid #233140;
    }
    .milestone-filter-table thead th:last-child{
        border-right:none;
    }
    /* ==========================================================
    FILTERZEILE
    ========================================================== */
    .filter-row td{
        position:sticky;
        top:34px;
        z-index:45;
        background:#f6f8fa;
        padding:5px;
        border-bottom:2px solid #d5dde6;
    }
    /* ==========================================================
    SORTIERUNG
    ========================================================== */
    .sort-links{
        margin-top:3px;
    }
    .sort-links a{
        color:#fff;
        opacity:.5;
        text-decoration:none;
        font-size:10px;
        margin-right:4px;
    }
    .sort-links a:hover{
        opacity:1;
    }
    /* ==========================================================
    FILTER
    ========================================================== */
    .filter-control{
        width:100%;
        max-width:100%;
        height:26px;
        padding:3px 5px;
        border:1px solid #ccd5dd;
        border-radius:3px;
        background:#fff;
        box-sizing:border-box;
        font-size:11px;
    }
    .filter-control:focus{
        outline:none;
        border-color:#4a90e2;
        box-shadow:0 0 4px rgba(74,144,226,.25);
    }
    /* ==========================================================
    ZELLEN
    ========================================================== */
    .milestone-filter-table td{
        height:52px;
        max-height:52px;
        padding:5px 6px;
        vertical-align:top;
        border-bottom:1px solid #ececec;
        overflow:hidden;
        box-sizing:border-box;
    }
    /* ==========================================================
    ZEBRA
    ========================================================== */
    .termin-row:nth-child(even){
        background:#fafafa;
    }
    .termin-row:nth-child(odd){
        background:#ffffff;
    }
    .termin-row:hover{
        background:#edf5ff !important;
    }
    /* ==========================================================
    PROJEKT
    ========================================================== */
    .project-main{
        font-weight:bold;
        color:#1c4f72;
        overflow:hidden;
        white-space:nowrap;
        text-overflow:ellipsis;
    }
    .cell-subtext{
        font-size:10px;
        color:#777;
        overflow:hidden;
        white-space:nowrap;
        text-overflow:ellipsis;
    }
    /* ==========================================================
    LABEL
    ========================================================== */
    .label-cell{
        width:250px;
        max-width:250px;
    }
    .label-text{
        display:block;
        overflow:hidden;
        white-space:nowrap;
        text-overflow:ellipsis;
    }
    /* ==========================================================
    BEMERKUNG
    ========================================================== */
    .comment-cell{
        width:250px;
        max-width:250px;
    }
    .comment-text{
        display:block;
        overflow:hidden;
        white-space:nowrap;
        text-overflow:ellipsis;
    }
    /* ==========================================================
    DATUM
    ========================================================== */
    .date-cell{
        white-space:nowrap;
        font-weight:bold;
    }
    /* ==========================================================
    STATUS
    ========================================================== */
    .milestone-status{
        display:inline-block;
        padding:2px 8px;
        border-radius:20px;
        font-size:10px;
        font-weight:bold;
        text-transform:uppercase;
    }
    .status-open{
        background:#fff3cd;
        color:#856404;
    }
    .status-done{
        background:#d4edda;
        color:#155724;
    }
    .status-overdue{
        background:#f8d7da;
        color:#a94442;
    }
    /* ==========================================================
    STATUSFILTER
    ========================================================== */
    .status-cell{
        font-size:11px;
    }
    .status-cell label{
        display:block;
        margin-bottom:3px;
        white-space:nowrap;
    }
    /* ==========================================================
    BUTTONS
    ========================================================== */
    .action-cell{
        text-align:center;
    }
    .filter-button{
        display:block;
        width:72px;
        margin:2px auto;
        padding:3px;
        background:#4b89dc;
        color:#fff;
        border-radius:3px;
        text-decoration:none;
        font-size:11px;
    }
    .filter-button:hover{
        background:#2d6fc9;
        color:#fff;
        text-decoration:none;
    }
    .reset-button{
        background:#7c8a96;
    }
    .reset-button:hover{
        background:#66727d;
    }
    /* ==========================================================
    TOOLTIP SPALTEN
    ========================================================== */
    .label-text,
    .comment-text,
    .project-main,
    .cell-subtext{
        cursor:default;
    }
    /* ==========================================================
    KEINE DATEN
    ========================================================== */
    .no-results{
        text-align:center;
        padding:20px;
        color:#777;
        font-weight:bold;
    }
</style>
{{ Form::open(array(
    'url'    => URL::current(),
    'method' => 'get',
    'class'  => 'milestone-filter-form'
)) }}
<div class="filter-table-wrapper">
    <table class="milestone-filter-table">
        <colgroup>
            <col class="col-responsible">
            <col class="col-project">
            <col class="col-pattern">
            <col class="col-display-text">
            <col class="col-comment">
            <col class="col-date">
            <col class="col-date-type">
            <col class="col-status">
            <col class="col-action">
        </colgroup>
        <thead>
            <tr>
                <th>
                    Verantwortlich
                    <span class="sort-links">
                        <a href="{{ URL::current() }}?sort=responsible&direction=asc"
                           title="Aufsteigend sortieren">▲</a>
                        <a href="{{ URL::current() }}?sort=responsible&direction=desc"
                           title="Absteigend sortieren">▼</a>
                    </span>
                </th>
                <th>
                    Projekt / IAN
                    <span class="sort-links">
                        <a href="{{ URL::current() }}?sort=project&direction=asc">▲</a>
                        <a href="{{ URL::current() }}?sort=project&direction=desc">▼</a>
                    </span>
                </th>
                <th>
                    Musterung
                    <span class="sort-links">
                        <a href="{{ URL::current() }}?sort=pattern&direction=asc">▲</a>
                        <a href="{{ URL::current() }}?sort=pattern&direction=desc">▼</a>
                    </span>
                </th>
                <th>Anzeigetext</th>
                <th>Bemerkung</th>
                <th>
                    Soll-Termin
                    <span class="sort-links">
                        <a href="{{ URL::current() }}?sort=due_date&direction=asc">▲</a>
                        <a href="{{ URL::current() }}?sort=due_date&direction=desc">▼</a>
                    </span>
                </th>
                <th>
                    Terminart
                    <span class="sort-links">
                        <a href="{{ URL::current() }}?sort=date_type&direction=asc">▲</a>
                        <a href="{{ URL::current() }}?sort=date_type&direction=desc">▼</a>
                    </span>
                </th>
                <th>
                    Status Milestone
                    <span class="sort-links">
                        <a href="{{ URL::current() }}?sort=status&direction=asc">▲</a>
                        <a href="{{ URL::current() }}?sort=status&direction=desc">▼</a>
                    </span>
                </th>
                <th>Aktion</th>
            </tr>
        </thead>
        <tbody>
            <tr class="filter-row">
                {{-- 1. Verantwortlich --}}
                <td>
                    <select name="responsible" class="filter-control">
                        <option value="">Alle</option>
                        @foreach ($responsibles as $responsible)
                            <option
                                value="{{ $responsible->PPMitarbeiter_Id }}"
                                {{ Input::get('responsible') == $responsible->PPMitarbeiter_Id
                                    ? 'selected="selected"'
                                    : '' }}
                            >
                                {{ $responsible->PPMitarbeiter_Kuerzel }}
                            </option>
                        @endforeach
                    </select>
                </td>
                {{-- 2. Projekt / IAN --}}
                <td>
                    <select name="project" class="filter-control">
                        <option value="">Alle Projekte</option>
                        @foreach ($projects as $project)
                            <option
                                value="{{ $project->PPProduktpass_Id }}"
                                {{ Input::get('project') == $project->PPProduktpass_Id
                                    ? 'selected="selected"'
                                    : '' }}
                            >
                                {{ $project->PPProduktpass_IAN }}  [{{ $project->PPProduktpass_Ausmusterungnummer }}] {{ $project->PPProduktpass_Artikelbezeichnung }}
                            </option>
                        @endforeach
                    </select>
                </td>
                {{-- 3. Musterung --}}
                <td>
                    <select name="pattern" class="filter-control">
                        <option value="">Alle</option>
                        @foreach ($chargen as $charge)
                            <option
                                value="{{ $charge->Ausmusterung }}"
                                {{ Input::get('pattern') == $charge->Ausmusterung
                                    ? 'selected="selected"'
                                    : '' }}
                            >
                                {{ $charge->Ausmusterung }}
                            </option>
                        @endforeach
                    </select>
                </td>
                {{-- 4. Anzeigetext --}}
                <td>
                    <input
                        type="text"
                        name="display_text"
                        class="filter-control"
                        value="{{ Input::get('display_text') }}"
                    >
                </td>
                {{-- 5. Bemerkung --}}
                <td>
                    <input
                        type="text"
                        name="comment"
                        class="filter-control"
                        value="{{ Input::get('comment') }}"
                    >
                </td>
                {{-- 6. Soll-Termin --}}
                <td>
                    <input
                        type="text"
                        name="due_date"
                        class="filter-control"
                        placeholder="TT.MM.JJJJ"
                        value="{{ Input::get('due_date') }}"
                    >
                </td>
                {{-- 7. Terminart --}}
                <td>
                    <select name="date_type" class="filter-control">
                        <option value="">Alle</option>
                        {{-- @foreach ($dateTypes as $dateType)
                            <option
                                value="{{ $dateType->id }}"
                                {{ Input::get('date_type') == $dateType->id
                                    ? 'selected="selected"'
                                    : '' }}
                            >
                                {{ $dateType->name }}
                            </option>
                        @endforeach --}}
                    </select>
                </td>
                {{-- 8. Status Milestone --}}
                <td class="status-cell">
                    <label>
                        Erledigte anzeigen:
                        <input
                            type="checkbox"
                            name="show_completed"
                            value="1"
                            {{ Input::get('show_completed') ? 'checked="checked"' : '' }}
                        >
                    </label>
                    <label>
                        Nur eigene:
                        <input
                            type="checkbox"
                            name="own_only"
                            value="1"
                            {{ Input::get('own_only') ? 'checked="checked"' : '' }}
                        >
                    </label>
                </td>
                {{-- 9. Aktion --}}
                <td class="action-cell">
                    <button type="submit" class="filter-button">
                        Filtern
                    </button>
                    <a href="{{ URL::current() }}" class="filter-button reset-button">
                        Löschen
                    </a>
                </td>
            </tr>
              @forelse ($termine as $termin)
        <?php
            /*
             * Datum aufbereiten.
             * Ungültige MySQL-Null-Datumswerte werden nicht angezeigt.
             */
            $dateMilestone = '';
            if (
                !empty($termin->DateMilestone) &&
                $termin->DateMilestone != '0000-00-00 00:00:00' &&
                $termin->DateMilestone != '0000-00-00'
            ) {
                $timestamp = strtotime($termin->DateMilestone);
                if ($timestamp !== false) {
                    $dateMilestone = date('d.m.Y', $timestamp);
                }
            }
            /*
             * Statusklasse bestimmen.
             * Die konkreten Statuswerte kannst du an deine Daten anpassen.
             */
            $statusClass = 'status-open';
            $statusText  = $termin->PPTermine_Status;
            if (
                isset($termin->PPStati_OKStatus) &&
                $termin->PPStati_OKStatus
            ) {
                $statusClass = 'status-done';
            } elseif (
                !empty($termin->PPTermine_DoneAt) &&
                $termin->PPTermine_DoneAt != '0000-00-00 00:00:00'
            ) {
                $statusClass = 'status-done';
                $statusText  = 'Erledigt';
            } elseif (
                !empty($termin->DateMilestone) &&
                strtotime($termin->DateMilestone) !== false &&
                strtotime($termin->DateMilestone) < strtotime(date('Y-m-d'))
            ) {
                $statusClass = 'status-overdue';
            }
        ?>
        <tr
            class="termin-row {{ $statusClass }}"
            data-termin-id="{{ $termin->PPTermine_Id }}"
            @if (!empty($termin->Background))
                style="background-color: {{ $termin->Background }};"
            @endif
        >
            {{-- 1. Verantwortlich --}}
            <td>
                {{ $termin->PPMitarbeiter_Kuerzel ?: '-' }}
                @if (!empty($termin->PPMitarbeiter_Taetigkeit))
                    <div class="cell-subtext">
                        {{ $termin->PPMitarbeiter_Taetigkeit }}
                    </div>
                @endif
            </td>
            {{-- 2. Projekt / IAN --}}
            <td>
                <div class="project-main">
                    {{ $termin->PPProduktpass_IAN }}
                    [{{ $termin->PPProduktpass_Ausmusterungnummer }}]
                </div>
                @if (!empty($termin->PPProduktpass_Artikelbezeichnung))
                    <div class="cell-subtext">
                        {{ $termin->PPProduktpass_Artikelbezeichnung }}
                    </div>
                @endif
            </td>
            {{-- 3. Musterung --}}
            <td>
                {{ $termin->PPProduktpass_Ausmusterungnummer ?: '-' }}
            </td>
            {{-- 4. Anzeigetext --}}
            <td class="label-cell">
                @if (!empty($termin->PPTermine_Label))
                    <span
                        class="label-text"
                        title="{{ $termin->PPTermine_Label }}">
                        {{ $termin->PPTermine_Label }}
                    </span>
                @elseif (!empty($termin->PPTermine_LabelEN))
                    <span
                        class="label-text"
                        title="{{ $termin->PPTermine_LabelEN }}">
                        {{ $termin->PPTermine_LabelEN }}
                    </span>
                @else
                    -
                @endif
            </td>
            {{-- 5. Bemerkung --}}
            <td class="comment-cell">
                <span class="comment-text"
                    title="{{ $termin->PPTermine_Bemerkungen }}">
                    {{ $termin->PPTermine_Bemerkungen }}
                </span>
            </td>
            {{-- 6. Soll-Termin --}}
            <td class="date-cell">
                {{ $dateMilestone ?: '-' }}
            </td>
            {{-- 7. Terminart --}}
            <td>
                {{ $termin->PPBoardSpalte_Bezeichnung ?: '-' }}
                @if (!empty($termin->PPTermineChanges_Categorie))
                    <div class="cell-subtext">
                        {{ $termin->PPTermineChanges_Categorie }}
                    </div>
                @endif
            </td>
            {{-- 8. Status Milestone --}}
            <td>
                <span class="milestone-status {{ $statusClass }}">
                    {{ $statusText ?: '-' }}
                </span>
                @if (
                    !empty($termin->PPTermineChanges_DoneAt) &&
                    $termin->PPTermineChanges_DoneAt != '0000-00-00 00:00:00'
                )
                    <div class="cell-subtext">
                        Erledigt am:
                        {{ date(
                            'd.m.Y',
                            strtotime($termin->PPTermineChanges_DoneAt)
                        ) }}
                    </div>
                @endif
            </td>
            {{-- 9. Aktion --}}
            <td class="action-cell">
                <a
                    href="{{ URL::to(
                        'termine/' . $termin->PPTermine_Id . '/edit'
                    ) }}"
                    class="filter-button"
                >
                    Bearbeiten
                </a>
                <a
                    href="{{ URL::to(
                        'termine/' . $termin->PPTermine_Id
                    ) }}"
                    class="filter-button"
                >
                    Details
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="9" class="no-results">
                Keine Termine gefunden.
            </td>
        </tr>
    @endforelse
        </tbody>
    </table>
</div>
{{ Form::close() }}