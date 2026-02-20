<style>
    :root{
    --bg: #f8fafc;
    --panel: #ffffff;
    --muted: #eff2f6;
    --border: #e5e7eb;
    --text: #0f172a;
    --text-muted:#475569;
    --primary:#0ea5e9;
    --primary-600:#0284c7;
    --accent:#22c55e;
    --danger:#ef4444;
    --warning:#f59e0b;
    --radius: 10px;
    --shadow: 0 6px 24px rgba(15,23,42,.06), 0 2px 8px rgba(15,23,42,.04);
    }
    *{ box-sizing:border-box }
    html, body { height:100% }
    body{
    background: var(--bg);
    color: var(--text);
    font: 14px/1.5 "Inter", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    margin:0;
    }
    /* ====== LAYOUT: Container & Bereiche ====== */
    #terminliste{
    /* Flex-Spalte: oben Filter-Card, darunter Ergebnisse */
    display:flex;
    flex-direction:column;
    gap:12px;
    min-height:100vh;            /* statt height + calc(...) */
    padding:16px 24px;
    margin:0 auto;
    max-width:1400px;
    min-width:320px;
    background:transparent;
    border:none;
    }
    .tl-card{
    margin:0;                    /* enger an Ergebnisbereich */
    background:var(--panel);
    border:1px solid var(--border);
    border-radius:var(--radius);
    box-shadow:var(--shadow);
    padding:18px;
    }
    .tl-header{
    display:flex; align-items:center; justify-content:space-between;
    gap:16px; margin-bottom:12px;
    }
    .tl-title{ font-size:clamp(18px,2vw,22px); color:var(--primary-600); margin:0; font-weight:700; }
    /* ====== Filter-Grid & Header (Sticky) ====== */
    .tl-grid{
    display:grid;
    grid-template-columns: 7% 28% 7% 7% 7% 8% 14% 14% 6%;
    gap:8px; font-size:13px;
    }
    .tl-th{
    position:sticky; top:0; z-index:2;
    padding:10px 12px;
    background:linear-gradient(#f8fafc,#f1f5f9);
    border:1px solid var(--border);
    border-radius:8px;
    font-weight:600; color:var(--text);
    display:flex; align-items:center; justify-content:space-between; gap:8px;
    }
    .tl-th a{ color:var(--text-muted); text-decoration:none; font-size:12px; }
    .tl-th a:hover{ color:var(--primary); }
    /* ====== Filter-Inputs ====== */
    .searchP{
    border:1px solid var(--border) !important;
    background:var(--panel);
    border-radius:8px !important;
    padding:6px; display:flex; align-items:center; gap:8px;
    }
    .searchP select,
    .searchP input[type="text"]{
    width:100%; height:38px;
    border:1px solid var(--border);
    border-radius:8px !important;
    outline:none; padding:0 10px; background:#fff; color:var(--text); font-size:13px;
    transition:border-color .15s, box-shadow .15s;
    }
    .searchP select:focus,
    .searchP input[type="text"]:focus{ border-color:var(--primary); box-shadow:0 0 0 4px rgba(14,165,233,.15); }
    .searchP option{ color:var(--text); font-size:13px; }
    /* ====== Ergebnisbereich: füllt restliche Höhe ====== */
    .tl-results{
    flex:1;                      /* nimmt restlichen Platz */
    min-height:420px;            /* bleibt groß genug */
    border:1px solid var(--border);
    border-radius:var(--radius);
    overflow:auto;
    background:var(--panel);
    }
    /* ====== Ergebnis-Grid ====== */
    #resultTable{
    display:grid;
    grid-template-columns: 7% 28.3% 7% 7% 7.2% 8% 14% 14.5% 6%;
    gap:8px; padding:12px; font-size:13px;
    }
    #resultTable > div{
    border:1px solid var(--border);
    border-radius:8px !important;
    padding:10px; background:#fff;
    }
    #resultTable > div:hover{ box-shadow:0 2px 10px rgba(15,23,42,.06); }
    /* ====== Badges & Text ====== */
    .badge{ display:inline-block; padding:4px 8px; border-radius:999px; font-size:12px; font-weight:600; }
    .badge-open{ background:#e0f2fe; color:#0369a1; }
    .badge-done{ background:#dcfce7; color:#166534; }
    .badge-warn{ background:#fef3c7; color:#92400e; }
    .text-danger{ color:var(--danger); }
    .muted{ color:var(--text-muted) } .small{ font-size:12px } .ta-right{ text-align:right } .m0{ margin:0 }
    /* ====== Buttons ====== */
    .btn{
    display:inline-flex; align-items:center; justify-content:center;
    height:36px; min-width:90px; padding:0 12px;
    border-radius:8px; border:1px solid var(--border);
    background:var(--muted); color:var(--text);
    font-weight:600; font-size:13px; cursor:pointer;
    transition:transform .05s ease, box-shadow .15s, background .15s;
    }
    .btn:hover{ background:#e9eef5; box-shadow:0 2px 8px rgba(15,23,42,.08); }
    .btn:active{ transform:translateY(1px); }
    .btn-primary{ background:var(--primary); color:#fff; border-color:transparent; }
    .btn-primary:hover{ background:var(--primary-600); }
    /* ====== Dense Mode (optional, wenn du es noch dichter willst) ====== */
    /*
    #resultTable{ gap:6px; padding:8px; }
    #resultTable > div{ padding:8px; }
    .tl-th{ padding:8px 10px; }
    */
    /* ====== Responsive ====== */
    @media (max-width:1200px){
    .tl-grid{ grid-template-columns: 10% 30% 10% 10% 10% 10% 10% 10% 10%; }
    #resultTable{ grid-template-columns: 10% 30% 10% 10% 10% 10% 10% 10% 10%; }
    }
    @media (max-width:900px){
    .tl-grid, #resultTable{ grid-template-columns:1fr 1fr; }
    .tl-th{ position:static; }
    }
</style>
<div id="terminlisteB">
  {{ Form::open(array('url'=>'/terminlisteFilter','id'=>'Terminliste1')) }}
   <input type="hidden" name="art" value="{{ Session::get('art') }}" />
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
  <div class="tl-card">
    <div class="tl-header">
      <h1 class="tl-title" class="m0"><b>{{ $_art }}</b></h1>
      <!-- Optional: Platz für sekundäre Aktionen oder Info -->
      <div class="muted small">Letzte Aktualisierung: {{ date('d.m.Y H:i') }}</div>
    </div>
    <!-- Kopfzeile / Sort -->
    <div class="tl-grid">
      <div class="tl-th">
        <span>{{ ServiceProvider::tl($lang,'Verantwortlich') }}</span>
        <span>
          <a href="/terminliste/1U">&#9650;</a>
          <a href="/terminliste/1D">&#9660;</a>
        </span>
      </div>
      <div class="tl-th">
        <span>{{ ServiceProvider::tl($lang,'Projekt') }}/{{ ServiceProvider::tl($lang,'IAN') }}</span>
        <span><a href="/terminliste/2U">&#9650;</a><a href="/terminliste/2D">&#9660;</a></span>
      </div>
      <div class="tl-th">
        <span>{{ ServiceProvider::tl($lang,'Musterung') }}</span>
        <span><a href="/terminliste/8U">&#9650;</a><a href="/terminliste/8D">&#9660;</a></span>
      </div>
      <div class="tl-th">{{ ServiceProvider::tl($lang,'Anzeigetext') }}</div>
      <div class="tl-th">{{ ServiceProvider::tl($lang,'Bemerkung') }}</div>
      <div class="tl-th ta-right">
        <span>{{ ServiceProvider::tl($lang,'Soll-Termin') }}</span>
        <span><a href="/terminliste/6U">&#9650;</a><a href="/terminliste/6D">&#9660;</a></span>
      </div>
      <div class="tl-th ta-right">
        <span>{{ ServiceProvider::tl($lang,'Terminart') }}</span>
        <span><a href="/terminliste/4U">&#9650;</a><a href="/terminliste/4D">&#9660;</a></span>
      </div>
      <div class="tl-th">
        <span>{{ ServiceProvider::tl($lang,'Status Milestone') }}</span>
        <span><a href="/terminliste/5U">&#9650;</a><a href="/terminliste/5D">&#9660;</a></span>
      </div>
      <div class="tl-th">{{ ServiceProvider::tl($lang,'Aktion') }}</div>
      <!-- Filter-Reihe (deine bestehende Logik; nur Styles modernisiert) -->
      <div class="searchP">
        <select name="qVerantwortlicher" id="qVerantwortlicher">
          <option value="%">{{ ServiceProvider::tl($lang,'Alle') }}</option>
          @foreach ($data['mitarbeiter'] as $m)
            <option title="@if (isset($data['mitarbeiterNamen'][$m])) {{ $data['mitarbeiterNamen'][$m] }} @endif"
              value="{{ $m }}" @if(Session::get('qMA') == $m) selected @endif>{{ $m }}</option>
          @endforeach
        </select>
      </div>
      <div class="searchP">
        <select name="qIAN" id="qIAN">
          <option value="%">{{ ServiceProvider::tl($lang,'Alle') }}</option>
          @foreach ($data['searchValues']['PPs'] as $pp)
            <option value="{{ $pp->PPProduktpass_IAN }}" @if ($pp->PPProduktpass_IAN == Session::get('qIAN')) selected @endif>
              {{ $pp->PPProduktpass_IAN }} [{{ $pp->PPProduktpass_Ausmusterungnummer }}] {{ $pp->PPProduktpass_Artikelbezeichnung }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="searchP">
        <select name="qAusm" id="qAusm">
          <option value="%">{{ ServiceProvider::tl($lang,'Alle')}}</option>
          @foreach ($data['searchValues']['AUSM'] as $ausm)
            <option value="{{ $ausm->PPProduktpass_Ausmusterungnummer }}" @if ($ausm->PPProduktpass_Ausmusterungnummer == Session::get('qAusm')) selected @endif>
              {{ $ausm->PPProduktpass_Ausmusterungnummer }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="searchP"></div>
      <div class="searchP"></div>
      <div class="searchP">
        <input type="text" name="qSollTermin" id="qiSollTermin" value="{{Session::get('qSollTermin')}}">
      </div>
      <div class="searchP">
        <select name="qTerminart" id="qTerminart">
          <option value="%">{{ ServiceProvider::tl($lang,'Alle') }}</option>
          @foreach ($data['searchValues']['tas'] as $ta)
            <option value="{{ $ta->PPBoardSpalte_Bezeichnung }}" @if ($ta->PPBoardSpalte_Bezeichnung == Session::get('qTerminart')) selected @endif>
              {{ $ta->PPBoardSpalte_Bezeichnung }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="searchP">
        <table style="border:none;border-collapse:collapse;width:100%;font-size:12px">
          <tr>
            <td style="padding:4px;">{{ ServiceProvider::tl($lang,'Erledigte anzeigen:') }}</td>
            <td style="padding:4px; text-align:center;">
              <input type="checkbox" name="fcol[all]" @if (isset($fcol['all'])) checked @endif>
            </td>
          </tr>
          <tr>
            <td style="padding:4px;" title='Termine, bei denen ich als Vertretung eingetragen bin, werden nicht angezeigt!'>
              {{ ServiceProvider::tl($lang,'Nur eigene:') }}
            </td>
            <td style="padding:4px; text-align:center;">
              <input type="checkbox" name="fcol[onlyMy]" @if (isset($fcol['onlyMy'])) checked @endif>
            </td>
          </tr>
        </table>
      </div>
      <div class="searchP" style="gap:6px">
        <button type="submit" class="btn btn-primary">{{ ServiceProvider::tl($lang,'Filtern') }}</button>
        <button type="submit" onclick="delInput();" class="btn">{{ ServiceProvider::tl($lang,'Löschen') }}</button>
      </div>
    </div>
  </div>
  {{ Form::close() }}
  @if (isset($data['bg']) and count($data['bg']) > 0)
  <div class="tl-results">
    <div id="resultTable">
      @foreach ($data['bg'] as $key => $bgcol)
        <?php
          $row  = $data['aTermine'][$key];
          $cpcCol = $row->Background;
          if ($row->PPTermine_Status == 'offen'){ $cpcCol = "189,215,238"; }
          if ($row->PPTermine_Status == 'erledigt'){ $cpcCol = "198,254,206"; }
          $overdue = (date('Y-m-d H:i:s') > $row->DateMilestone);
        ?>
        <!-- Spalte 1 -->
        <div class="muted" style="padding-top:16px; text-align:center;">
          <span @if(Auth::user()->PPMitarbeiter_Kuerzel == $row->PPMitarbeiter_Kuerzel) style="font-weight:700" @endif>
            {{$row->PPMitarbeiter_Kuerzel}}
          </span>
        </div>
        <!-- Spalte 2 -->
        <div>
          <a href="/show/{{$row->PPProduktpass_Id}}" target="_blank" rel="noreferrer noopener" style="color:#0f172a; text-decoration:none;">
            <span style="margin-right: 10px; color:var(--primary-600); font-weight: 700;">{{$row->PPProduktpass_IAN}}</span><br>
            <span class="small muted">Liefertermin: {{$row->PPProduktpass_Liefertermin}}/{{$row->PPProduktpass_LieferterminJahr}}</span>
          </a>
          <div class="small" style="margin-top:6px">{{$row->PPProduktpass_Artikelbezeichnung}}</div>
        </div>
        <!-- Spalte 3 -->
        <div class="small">{{substr($row->PPProduktpass_Ausmusterungnummer,0,4)}}</div>
        <!-- Spalte 4 -->
        <div class="small" title='{{$row->PPTermine_Label}}' style="max-height:110px; overflow:auto;">
          {{$row->PPTermine_Label}}
        </div>
        <!-- Spalte 5 -->
        <div class="small" title='{{$row->PPTermine_Bemerkungen}}' style="max-height:110px; overflow:auto;">
          {{$row->PPTermine_Bemerkungen}}
        </div>
        <!-- Spalte 6 -->
        <div>
          <span>{{date("d.m.Y", strtotime($row->DateMilestone))}}</span>
          @if($row->PPTermineChanges_Categorie == 'Hauptaufgabe')
            @if(substr($row->PPTermineChanges_DoUntil,0,4) != "0000")
              <span class="@if($overdue) text-danger @endif"><b>&bull;</b></span>
            @elseif ($data['manSoll'][$key] != '')
              <span class="@if($overdue) text-danger @endif"><b>*</b></span>
            @endif
          @else
            <span class="small @if($overdue) text-danger @endif"><b>#</b></span>
          @endif
        </div>
        <!-- Spalte 7 -->
        <div class="small">
          @if (strlen($row->PPBoardSpalte_Oberbez)>1)
            <b>{{$row->PPBoardSpalte_Oberbez}}</b><br>
          @endif
          <span>{{$row->PPBoardSpalte_Bezeichnung}}</span><br>
          @if($row->PPTermineChanges_Categorie == 'Hauptaufgabe')
            <span class="badge badge-open">Hauptaufgabe</span>
          @else
            <span class="muted">Unteraufgabe:</span> {{$row->PPTermineChanges_Categorie}}
          @endif
        </div>
        <!-- Spalte 8 (Statusfeld farbig) -->
        <div style="padding-top:16px; background-color:rgb({{$cpcCol}}); border:1px solid var(--border);">
          <?php $xboard = 1000; if (Session::get('art') == 'MU') { $xboard = 1001; } ?>
          <div onclick="ajax_getTerminTab({{$row->PPProduktpass_Id}}, {{$row->PPTermine_Id}}, {{ $xboard }} , 'All', 1)"
               style="text-align:center; cursor:pointer;">
            <b>{{$row->PPTermine_Status}}</b>
          </div>
        </div>
        <!-- Spalte 9 (Aktion leer) -->
        <div></div>
      @endforeach
    </div>
  </div>
  @else
    <div class="tl-card" style="margin-top:16px;">
      <h1 class="m0" style="color:#4169e1; font-size:16px;">{{$data['error']}}</h1>
    </div>
  @endif
</div>
<script>
function delInput() {
  const ids = ["qVerantwortlicher","qAusm","qIAN","qStatus","qintStatus","qTerminart"];
  ids.forEach(id => { const el = document.getElementById(id); if(el) el.selectedIndex = 0; });
  const t = document.getElementById("qiSollTermin"); if(t) t.value='';
  return true;
}
function ajax_getTerminTab(ppid, tid, board, select, openOnly) {
  window.open("/getTerminFromId/" + ppid + "/" + tid + "/" + board, "_blank",
    "toolbar=no,scrollbars=yes,resizable=yes,top=10,left=10,width=1900,height=1220,rel=noreferrer,rel=nopener");
}
</script>