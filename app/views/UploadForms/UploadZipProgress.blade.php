  <style>
    body { font-family: system-ui, sans-serif; max-width: 720px; margin: 40px auto; padding: 0 16px; }
    .row { margin: 16px 0; }
    progress { width: 100%; height: 18px; }
    .muted { color: #666; font-size: 14px; }
    .box { border: 1px solid #ddd; border-radius: 10px; padding: 16px; }
    button { padding: 10px 14px; border-radius: 10px; border: 1px solid #ccc; background: #fff; cursor: pointer; }
    button:disabled { opacity: .6; cursor: not-allowed; }
    .ok { color: #0a7; }
    .err { color: #c22; }
    code { background: #f6f6f6; padding: 2px 6px; border-radius: 6px; }
  </style>
  <h1>ZIP Upload</h1>
  <div class="box">
    <div class="row">
      <input id="zipfile" type="file" accept=".zip,application/zip" />
      <div class="muted">Bitte eine .zip Datei auswählen.</div>
    </div>
    <div class="row">
      <button id="btnUpload">Hochladen & starten</button>
    </div>
    <div class="row">
      <div><strong>Upload</strong> <span id="uploadPct" class="muted">0%</span></div>
      <progress id="uploadProg" value="0" max="100"></progress>
    </div>
    <div class="row">
      <div><strong>Server-Verarbeitung</strong> <span id="procPct" class="muted">0%</span></div>
      <progress id="procProg" value="0" max="100"></progress>
      <div id="statusText" class="muted">Warte auf Start…</div>
    </div>
    <div class="row muted">
      Job-ID: <code id="jobId">-</code>
    </div>
    <div class="row" id="result"></div>
  </div>
  <script>
    const $ = (id) => document.getElementById(id);
    const btn = $("btnUpload");
    const zipInput = $("zip");
    const uploadProg = $("uploadProg");
    const uploadPct = $("uploadPct");
    const procProg = $("procProg");
    const procPct = $("procPct");
    const statusText = $("statusText");
    const jobIdEl = $("jobId");
    const resultEl = $("result");
    function setUploadProgress(p) {
      uploadProg.value = p;
      uploadPct.textContent = `${p}%`;
    }
    function setProcessingProgress(p) {
      procProg.value = p;
      procPct.textContent = `${p}%`;
    }
    function setStatus(msg, cls) {
      statusText.textContent = msg;
      statusText.className = "muted" + (cls ? " " + cls : "");
    }
    function showResult(html) {
      resultEl.innerHTML = html || "";
    }
    function uploadZip(file) {
      return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        const form = new FormData();
        form.append("zip", file);
        xhr.open("POST", "/api/zip/start", true);
        // Wenn du Laravel + CSRF im Web-Guard nutzt, brauchst du ggf. X-CSRF-TOKEN Header.
        // xhr.setRequestHeader("X-CSRF-TOKEN", "…");
        xhr.upload.onprogress = (e) => {
          if (!e.lengthComputable) return;
          const percent = Math.round((e.loaded / e.total) * 100);
          setUploadProgress(percent);
        };
        xhr.onload = () => {
          if (xhr.status >= 200 && xhr.status < 300) {
            try { resolve(JSON.parse(xhr.responseText)); }
            catch { reject("Ungültige JSON-Antwort vom Server."); }
          } else {
            reject(xhr.responseText || `HTTP ${xhr.status}`);
          }
        };
        xhr.onerror = () => reject("Netzwerkfehler beim Upload.");
        xhr.send(form);
      });
    }
    function startPolling(jobId) {
      setStatus("Job gestartet. Warte auf Server-Status…");
      jobIdEl.textContent = jobId;
      const timer = setInterval(async () => {
        try {
          const r = await fetch(`/api/zip/status/${encodeURIComponent(jobId)}`, {
            headers: { "Accept": "application/json" }
          });
          if (!r.ok) throw new Error(`Status HTTP ${r.status}`);
          const s = await r.json();
          // Erwartetes Format:
          // { status, phase, unzipped_done, unzipped_total, processed_done, processed_total, message, percent? }
          const phase = s.phase || "unzip";
          const status = s.status || "running";
          if (phase === "unzip") {
            const done = Number(s.unzipped_done ?? 0);
            const total = Number(s.unzipped_total ?? 0);
            setStatus(s.message || `${done}/${total} Dateien entpackt`);
            setProcessingProgress(total > 0 ? Math.round((done / total) * 100) : 0);
          } else if (phase === "process") {
            const done = Number(s.processed_done ?? 0);
            const total = Number(s.processed_total ?? 0);
            setStatus(s.message || `${done}/${total} Dateien verarbeitet`);
            setProcessingProgress(total > 0 ? Math.round((done / total) * 100) : 0);
          } else {
            setStatus(s.message || `Phase: ${phase}`);
          }
          if (status === "done") {
            clearInterval(timer);
            setProcessingProgress(100);
            setStatus("Fertig ✅", "ok");
            showResult(`<div class="ok"><strong>Erfolg:</strong> Verarbeitung abgeschlossen.</div>`);
          }
          if (status === "failed") {
            clearInterval(timer);
            setStatus("Fehler ❌", "err");
            showResult(`<div class="err"><strong>Fehler:</strong> ${s.message || "Unbekannt"}</div>`);
          }
        } catch (e) {
          clearInterval(timer);
          setStatus("Status-Abfrage fehlgeschlagen ❌", "err");
          showResult(`<div class="err"><strong>Fehler:</strong> ${String(e.message || e)}</div>`);
        }
      }, 800);
    }
    btn.addEventListener("click", async () => {
      showResult("");
      setUploadProgress(0);
      setProcessingProgress(0);
      const file = zipInput.files?.[0];
      if (!file) {
        setStatus("Bitte zuerst eine ZIP-Datei auswählen.", "err");
        return;
      }
      btn.disabled = true;
      setStatus("Upload läuft…");
      try {
        const res = await uploadZip(file);
        if (!res.job_id) throw new Error("Server hat keine job_id zurückgegeben.");
        setStatus("Upload abgeschlossen. Starte Polling…", "ok");
        startPolling(res.job_id);
      } catch (e) {
        setStatus("Upload fehlgeschlagen ❌", "err");
        showResult(`<div class="err"><strong>Fehler:</strong> ${String(e)}</div>`);
      } finally {
        btn.disabled = false;
      }
    });
  </script>
