  <style>
      :root {
          --bg: #0b0f1a;
          --card: #111827;
          --muted: #9aa4b2;
          --text: #e5e7eb;
          --accent: #3b82f6;
          --accent-2: #10b981;
          --border: #1f2937;
          --danger: #ef4444;
          --shadow: 0 10px 30px rgba(0, 0, 0, .35);
          --radius: 14px;
      }
      .wrap {
          max-width: 1100px;
          margin: 48px auto;
          padding: 0 20px;
      }
      .header {
          display: flex;
          gap: 12px;
          align-items: left;
          justify-content: space-between;
          flex-wrap: wrap;
          margin-bottom: 18px;
      }
      h1 {
          font-size: clamp(1.25rem, 1rem + 2vw, 2rem);
          margin: 0;
          letter-spacing: .2px;
      }
      .toolbar {
          display: flex;
          gap: 10px;
          align-items: left;
      }
      .input {
          background: var(--card);
          color: var(--text);
          border: 1px solid var(--border);
          border-radius: 999px;
          padding: 10px 14px;
          outline: none;
          min-width: 220px;
      }
      .btn {
          background: linear-gradient(180deg, var(--accent), #1d4ed8);
          color: #fff;
          border: 0;
          padding: 10px 14px;
          border-radius: 999px;
          cursor: pointer;
          box-shadow: var(--shadow);
      }
      .grid {
          display: grid;
          grid-template-columns: 15% 65% 20%;
          border-radius: var(--radius);
          --overflow: hidden;
          background: var(--card);
          box-shadow: var(--shadow);
      }
      .grid-cell {
          border-radius: 0px;
      }
      .grid-header,
      .grid-cell {
          padding: 0px;
          border-bottom: 1px solid var(--border);
      }
      .grid-header {
          font-weight: 600;
          font-size: 1rem;
          padding:5px;
          text-align: left;
          background: linear-gradient(180deg, #0f172a, #0b1220);
          color: #c9d3e1;
      }
      .grid-row {
          display: contents;
      }
      .grid-row:hover .grid-cell {
          background: #d1e0ff;
      }
      .badge {
          display: inline-flex;
          align-items: left;
          gap: 8px;
          padding: 4px 10px;
          border-radius: 999px;
          font-size: .84rem;
          border: 1px solid var(--border);
          background: #afcaf7
      }
      .dot {
          width: 8px;
          height: 8px;
          border-radius: 999px;
          background: var(--accent-2)
      }
      .badge.danger .dot {
          background: var(--danger)
      }
      .input-edit {
          width: 100%;
          background: transparent;
          border: none;
          color: inherit;
          font: inherit;
          padding: 6px;
          margin: 0;
          outline: none;
      }
      /* Für Textareas */
      .input-edit textarea {
          resize: none;
          /* Verhindert Größenänderung */
          overflow: auto;
          /* Scrollbalken bei Überlauf */
          word-wrap: break-word;
          /* Zeilenumbruch */
      }
      /* Wenn du beim Fokussieren einen Rahmen willst */
      .input-edit:focus {
          border-bottom: 1px solid var(--accent);
          background: rgba(88, 190, 79, 0.308);
      }
      .input-edit.is-saving {
          background: rgba(216, 91, 41, 0.08);
      }
      .input-edit.is-done {
          background: rgba(15, 194, 54, 0.1);
      }
      .input-edit.is-error {
          background: rgba(231, 21, 21, 0.582);
      }
      .cell-flex {
          display: flex;
          align-items: center;
          gap: 8px;
          background: transparent
      }
      /* Eingabefeld füllt den restlichen Platz */
      .cell-flex .input-edit {
          flex: 1 1 auto;
          min-width: 0;
          /* verhindert Überlauf in schmalen Layouts */
      }
      /* runder Icon-Button */
      .icon-btn {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          width: 24px;
          height: 24px;
          padding: 0;
          border: 0;
          background: transparent;
          /* Rot ist im SVG */
          cursor: pointer;
          border-radius: 9999px;
          /* für Focus-Ring */
          margin-right: 5px;
          margin-top: 5px;
      }
      .icon-btn .icon {
          width: 100%;
          height: 100%;
      }
      /* Hover / Active / Focus Feedback */
      .icon-btn:hover .icon circle {
          filter: brightness(0.95);
      }
      .icon-btn:active .icon {
          transform: scale(0.96);
          transform-origin: center;
      }
      .icon-btn:focus-visible {
          outline: none;
          box-shadow: 0 0 0 3px rgba(239, 68, 68, .35);
          /* roter Focus-Ring */
          border-radius: 9999px;
      }
      /* Responsive */
      @media (max-width:768px) {
          .grid {
              grid-template-columns: 1fr;
          }
          .grid-header {
              display: none;
          }
          .grid-cell {
              display: flex;
              justify-content: space-between;
              align-items: left;
              border-bottom: 1px solid var(--border);
              border-radius: 0px;
          }
          .grid-cell::before {
              content: attr(data-label);
              font-weight: 600;
              color: var(--muted);
              margin-right: 10px;
          }
      }
  </style>
  <div class="wrap">
      <div class="header">
          <h1>Warennummern mit Restriktionen</h1>
          <div class="toolbar">
              <input class="input" placeholder="Suchen…" oninput="filterRows(this.value)" />
              <button class="btn" onclick="resetFilter()">Zurücksetzen</button>
              <button class="btn" onclick="addRow()">Neue Zeile</button>
          </div>
      </div>
      <div class="grid" id="grid">
          <div class="grid-header">Zolltarifnummer</div>
          <div class="grid-header">Warenbezeichnung</div>
          <div class="grid-header">Restriktion</div>
          @foreach ($zoll as $key => $z)
              <div class="grid-row">
                  <div class="grid-cell" data-label="Tarif">
                      <input type="text" name="zoll[{{ $key }}][zolltarifnummer]"
                          value="{{ $z->RestrictedZolltarif_Zolltarifnummer }}" class="input-edit"
                          data-id="{{ $z->RestrictedZolltarif_Id }}" {{-- <<< Model-ID --}}
                          data-field="RestrictedZolltarif_Zolltarifnummer"> {{-- <<< DB-Feld --}}
                  </div>
                  <div class="grid-cell" data-label="Bezeichnung">
                      <textarea style="height:100px;" name="zoll[{{ $key }}][bezeichnung]" class="input-edit"
                          data-id="{{ $z->RestrictedZolltarif_Id }}" data-field="RestrictedZolltarif_Bezeichnug">{{ $z->RestrictedZolltarif_Bezeichnug }}</textarea>
                  </div>
                  <div class="grid-cell" data-label="Restriktion">
                      <div class="cell-flex">
                          <input name="zoll[{{ $key }}][restriction]" class="input-edit"
                              value="{{ $z->RestrictedZolltarif_Restriction }}" data-id="{{ $z->RestrictedZolltarif_Id }}"
                              data-field="RestrictedZolltarif_Restriction" />
                          <button type="button" class="icon-btn icon-del" data-id="{{ $z->RestrictedZolltarif_Id }}"
                              aria-label="Zeile löschen" title="Zeile löschen">
                              <!-- Weißes Kreuz auf rotem Kreis -->
                              <svg viewBox="0 0 24 24" aria-hidden="true" class="icon">
                                  <circle cx="12" cy="12" r="12" fill="#ef4444"></circle>
                                  <line x1="7" y1="7" x2="17" y2="17" stroke="#ffffff"
                                      stroke-width="2.5" stroke-linecap="round"></line>
                                  <line x1="17" y1="7" x2="7" y2="17" stroke="#ffffff"
                                      stroke-width="2.5" stroke-linecap="round"></line>
                              </svg>
                          </button>
                      </div>
                  </div>
              </div>
          @endforeach
      </div>
  </div>
  <template id="row-template">
      <div class="grid-row">
          <div class="grid-cell" data-label="Tarif">
              <input type="text" class="input-edit" data-id="__ID__" data-field="RestrictedZolltarif_Zolltarifnummer"
                  value="">
          </div>
          <div class="grid-cell" data-label="Bezeichnung">
              <textarea class="input-edit" style="height:100px;" data-id="__ID__" data-field="RestrictedZolltarif_Bezeichnug"></textarea>
          </div>
          <div class="grid-cell" data-label="Restriktion">
             <div class="cell-flex">
                <input class="input-edit" data-id="__ID__" data-field="RestrictedZolltarif_Restriction" value="">
                <!-- button type="button" class="btn-row btn-del" data-id="__ID__">Löschen</button -->
                <button type="button" class="icon-btn icon-del" data-id="__ID__"
                                aria-label="Zeile löschen" title="Zeile löschen">
                                <!-- Weißes Kreuz auf rotem Kreis -->
                                <svg viewBox="0 0 24 24" aria-hidden="true" class="icon">
                                    <circle cx="12" cy="12" r="12" fill="#ef4444"></circle>
                                    <line x1="7" y1="7" x2="17" y2="17" stroke="#ffffff"
                                        stroke-width="2.5" stroke-linecap="round"></line>
                                    <line x1="17" y1="7" x2="7" y2="17" stroke="#ffffff"
                                        stroke-width="2.5" stroke-linecap="round"></line>
                                </svg>
                </button>
             </div>
          </div>
      </div>
  </template>
  <script>
      var csrf = "{{ csrf_token() }}";
      function normalize(str) {
          return (str || '')
              .toString()
              .normalize ? str.toString().normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim() :
              str.toString().toLowerCase().trim();
      }
      function getRowText(row) {
          // 1) sichtbarer Text (Labels etc.)
          var text = row.textContent || '';
          // 2) plus Werte aus Inputs, Textareas, Selects
          var fields = row.querySelectorAll('input, textarea, select');
          for (var i = 0; i < fields.length; i++) {
              var el = fields[i];
              // für Select: ausgewählte Option lesen
              var val = (el.tagName === 'SELECT') ?
                  (el.options[el.selectedIndex] ? el.options[el.selectedIndex].text : '') :
                  el.value;
              text += ' ' + (val || '');
          }
          return normalize(text);
      }
      // Dein bestehender Aufruf bleibt: oninput="filterRows(this.value)"
      function filterRows(q) {
          var term = normalize(q);
          var rows = document.querySelectorAll('.grid-row');
          for (var i = 0; i < rows.length; i++) {
              var row = rows[i];
              var hay = getRowText(row);
              // zeigen/verstecken; sichtbar = 'contents' (wegen Grid-Layout)
              row.style.display = hay.indexOf(term) !== -1 ? 'contents' : 'none';
          }
      }
      // Optional: Wenn in Inputs getippt wird, sofort neu filtern (damit Änderungen berücksichtigt werden)
      document.addEventListener('input', function(ev) {
          if (ev.target && ev.target.closest('.grid-row')) {
              var search = document.querySelector('.toolbar .input');
              if (search && search.value) {
                  filterRows(search.value);
              }
          }
      });
      function resetFilter() {
          document.querySelector('.input').value = '';
          filterRows('');
      }
      (function() {
          // Basis-Config
          var UPDATE_URL_BASE = '/updateZoll/'; // => PUT /zoll/{id}
          // kleine Helfer
          function setState(el, state) {
              el.classList.remove('is-saving', 'is-error', 'is-done');
              if (state) el.classList.add(state);
          }
          function serialize(field, value) {
              // Laravel 4 PUT via method spoofing
              var pairs = [];
              pairs.push(encodeURIComponent('_method') + '=PUT');
              pairs.push(encodeURIComponent(field) + '=' + encodeURIComponent(value));
              return pairs.join('&');
          }
          function ajaxPut(id, field, value, onOk, onErr) {
              console.log('AJAX PUT', id, field, value);
              var xhr = new XMLHttpRequest();
              xhr.open('POST', UPDATE_URL_BASE + id, true); // POST + _method=PUT
              xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
              if (csrf) xhr.setRequestHeader('X-CSRF-Token', csrf);
              xhr.onreadystatechange = function() {
                  if (xhr.readyState === 4) {
                      if (xhr.status >= 200 && xhr.status < 300) {
                          try {
                              var json = JSON.parse(xhr.responseText || '{}');
                              if (json && (json.ok || json.success !== false)) onOk(json);
                              else onOk(json); // tolerant, falls keine ok-Flag zurückkommt
                          } catch (e) {
                              onOk({});
                          }
                      } else {
                          onErr(xhr);
                      }
                  }
              };
              xhr.send(serialize(field, value));
          }
          function handleBlur(ev) {
              var el = ev.target;
              if (!el.classList.contains('input-edit')) return;
              var id = el.getAttribute('data-id');
              var field = el.getAttribute('data-field');
              var value = el.value;
              if (!id || !field) return;
              // optional: Skip, wenn sich nichts geändert hat
              if (el._lastSavedValue === value) return;
              setState(el, 'is-saving');
              ajaxPut(id, field, value,
                  function() { // success
                      setState(el, 'is-done');
                      el._lastSavedValue = value;
                      // visueller Abschluss nach kurzer Zeit zurücksetzen
                      setTimeout(function() {
                          setState(el, null);
                      }, 800);
                  },
                  function() { // error
                      setState(el, 'is-error');
                      // optional: Tooltip oder Alert
                      console.error('Speichern fehlgeschlagen für ID', id, 'Feld', field);
                  }
              );
          }
          // Events registrieren (blur & Enter auf Inputs)
          document.addEventListener('blur', handleBlur, true);
          document.addEventListener('keydown', function(ev) {
              var el = ev.target;
              if (!el.classList || !el.classList.contains('input-edit')) return;
              // Bei Enter in Input (nicht in Textarea) sofort speichern
              if (ev.key === 'Enter' && el.tagName !== 'TEXTAREA') {
                  el.blur();
                  ev.preventDefault();
              }
          });
      })();
      (function() {
          // Endpunkte: an dein Routing anpassen
          var CREATE_URL = '/createZoll'; // POST /zoll  -> { ok:true, id:123 }
          var DELETE_URL_BASE = '/deleteZoll/'; // DELETE /zoll/{id}
          // Helfer: AJAX-POST (für create) und AJAX-DELETE (method spoofing)
          function ajaxCreate(onOk, onErr) {
              var xhr = new XMLHttpRequest();
              xhr.open('POST', CREATE_URL, true);
              xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
              if (typeof csrf !== 'undefined') xhr.setRequestHeader('X-CSRF-Token', csrf);
              // leeres Objekt anlegen; du kannst hier Defaults mitsenden
              var body = "_token=" + encodeURIComponent(csrf);
              xhr.onreadystatechange = function() {
                  if (xhr.readyState === 4) {
                      if (xhr.status >= 200 && xhr.status < 300) {
                          try {
                              var json = JSON.parse(xhr.responseText || '{}');
                              onOk(json);
                          } catch (e) {
                              onOk({});
                          }
                      } else {
                          onErr(xhr);
                      }
                  }
              };
              xhr.send(body);
          }
          function ajaxDelete(id, onOk, onErr) {
              var xhr = new XMLHttpRequest();
              xhr.open('POST', DELETE_URL_BASE + id, true); // method spoofing
              xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
              if (typeof csrf !== 'undefined') xhr.setRequestHeader('X-CSRF-Token', csrf);
              var body = "_token=" + encodeURIComponent(csrf); // + "&_method=POST";
              xhr.onreadystatechange = function() {
                  if (xhr.readyState === 4) {
                      if (xhr.status >= 200 && xhr.status < 300) {
                          onOk();
                      } else {
                          onErr(xhr);
                      }
                  }
              };
              xhr.send(body);
          }
          // Template -> DOM-Node erzeugen
          function buildRow(id) {
              var tpl = document.getElementById('row-template');
              var html = tpl.innerHTML.replace(/__ID__/g, id);
              var holder = document.createElement('div');
              holder.innerHTML = html.trim();
              return holder.firstChild; // .grid-row
          }
          // Öffentliche Funktion: Neue Zeile hinzufügen
          window.addRow = function() {
              // 1) Leeren Datensatz im Backend anlegen, um eine ID zu bekommen
              ajaxCreate(function(res) {
                  if (!res || !res.id) {
                      alert('Konnte neue ID nicht anlegen.');
                      return;
                  }
                  var id = res.id;
                  // 2) Row aus Template bauen und oben einfügen
                  var grid = document.getElementById('grid');
                  // nach dem Header (3 Zellen) einfügen: prepend hinter Header
                  // Wir finden die erste .grid-row; wenn keine existiert, einfach hinten anhängen
                  var firstRow = grid.querySelector('.grid-row');
                  var row = buildRow(id);
                  if (firstRow) {
                      grid.insertBefore(row, firstRow);
                  } else {
                      grid.appendChild(row);
                  }
                  const target = document.querySelector('[data-field="RestrictedZolltarif_Zolltarifnummer"]');
                  if (target) {
                      target.focus();
                  }
              }, function() {
                  alert('Anlegen fehlgeschlagen.');
              });
          };
          // Event Delegation für Delete-Buttons
            document.addEventListener('click', function(ev) {
          var btn = ev.target.closest('.btn-del, .icon-del'); // << neu: .icon-del
          if (!btn) return;
          var id = btn.getAttribute('data-id');
          if (!id) return;
          if (!confirm('Diese Zeile wirklich löschen?')) return;
          ajaxDelete(id, function() {
              var row = btn.closest('.grid-row');
              if (row) row.remove();
          }, function(xhr) {
              alert('Löschen fehlgeschlagen (' + xhr.status + ').');
          });
      });
      })();
  </script>
