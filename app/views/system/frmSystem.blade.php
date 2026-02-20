<div style="border: 4px solid gray; padding:30px; margin-top:60px; width:50%;">
  <h1>Projektbild Test</h1>
  <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-top:20px;">
    <!-- Form 1: Check -->
    <form id="formCheck" action="projektbildCheck" method="post"
          style="border:1px solid #ddd; border-radius:12px; padding:16px; box-shadow:0 2px 8px rgba(0,0,0,.06);">
      <h3 style="margin:0 0 12px 0;">Projektbild prüfen</h3>
      <label style="display:block; font-weight:600; margin-bottom:6px;">Ausmusterung</label>
      <input type="text" name="ausmusterung" required
             style="width:100%; padding:10px 12px; border:1px solid #ccc; border-radius:10px;">
      <button type="submit"
              style="margin-top:12px; width:100%; padding:10px 12px; border:0; border-radius:10px; cursor:pointer;">
        Testen
      </button>
    </form>
    <!-- Form 2: Repair -->
    <form id="formRepair" action="projektbildRepair" method="post"
          style="border:1px solid #ddd; border-radius:12px; padding:16px; box-shadow:0 2px 8px rgba(0,0,0,.06);">
      <h3 style="margin:0 0 12px 0;">Projektbild reparieren</h3>
      <label style="display:block; font-weight:600; margin-bottom:6px;">Ausmusterung</label>
      <input type="text" name="ausmusterung" required
             style="width:100%; padding:10px 12px; border:1px solid #ccc; border-radius:10px;">
      <button type="submit"
              style="margin-top:12px; width:100%; padding:10px 12px; border:0; border-radius:10px; cursor:pointer;">
        Reparieren
      </button>
    </form>
  </div>
  <div style="margin-top:20px;">
    <label style="display:block; font-weight:600; margin-bottom:6px;">Ergebnis</label>
    <textarea id="resultArea" rows="10"
              style="width:100%; padding:10px 12px; border:1px solid #ccc; border-radius:10px; font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;"
              placeholder="Antworten erscheinen hier..."></textarea>
  </div>
</div>
<script>
  // Wenn du Laravel nutzt: CSRF Token aus meta-Tag ziehen
  // <meta name="csrf-token" content="{{ csrf_token() }}">
  const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  const resultArea = document.getElementById('resultArea');
  function prettyStatus(raw) {
    switch (raw) {
        case 'ok':           return 'OK';
        case 'repaired':     return 'REPARIERT';
        case 'missing_local':return 'FEHLT';
        case 'no_bildname':  return 'KEIN_BILDNAME';
        case 'download_failed': return 'DOWNLOAD_FEHLER';
        default:             return String(raw || 'UNBEKANNT');
    }
  }
  function appendResult(title, text) {
    const ts = new Date().toISOString().replace('T', ' ').replace('Z','');
    resultArea.value =
      `[${ts}] ${title}\n${text}\n\n` + resultArea.value;
  }
  async function handleAjaxForm(form, title) {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      resultArea.value = '';
      const url = form.getAttribute('action');
      const fd  = new FormData(form);
      // Optional: Button während Request deaktivieren
      const btn = form.querySelector('button[type="submit"]');
      const oldText = btn.textContent;
      btn.disabled = true;
      btn.textContent = 'Bitte warten...';
      try {
        const res = await fetch(url, {
          method: 'POST',
          headers: {
            ...(csrf ? {'X-CSRF-TOKEN': csrf} : {}),
            'Accept': 'application/json'
          },
          body: fd
        });
        const contentType = res.headers.get('content-type') || '';
        let payload;
        if (contentType.includes('application/json')) {
          payload = await res.json();
        } else {
          payload = await res.text();
        }
        if (!res.ok) {
          // Laravel-typisch: { message, errors }
          const msg = typeof payload === 'string'
            ? payload
            : (payload.message || JSON.stringify(payload, null, 2));
          appendResult(`${title} (FEHLER ${res.status})`, msg);
          return;
        }
        // Erfolgsanzeige
         // Erfolgsanzeige (kompakt): nur IAN, AUSM, Status (OK/REPARIERT)
        if (typeof payload === 'object' && payload && Array.isArray(payload.items)) {
            const lines = payload.items.map(it => {
                const ian  = it.ian ?? '';
                const ausm = it.ausm ?? '';
                const status = prettyStatus(it.status);
                return `${ian} | ${ausm} | ${status}`;
            }).join('\n');
            appendResult(`${title} (OK)`, lines);
        } else {
            // sauberer Fallback OHNE "out"
            const fallback =
                (typeof payload === 'string')
                ? payload
                : JSON.stringify(payload, null, 2);
            appendResult(`${title} (OK)`, fallback);
        }
      } catch (err) {
        appendResult(`${title} (NETZWERKFEHLER)`, String(err));
      } finally {
        btn.disabled = false;
        btn.textContent = oldText;
      }
    });
  }
  handleAjaxForm(document.getElementById('formCheck'),  'projektbildCheck');
  handleAjaxForm(document.getElementById('formRepair'), 'projektbildRepair');
</script>
