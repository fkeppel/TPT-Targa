<style>
    #filesInput {
        border:none;
        width:80%;
        height:60px;
        font-size:20px;
    }
  #progress{
    margin-top:15px;
    font-family: Tahoma;
    font-size: 14px;
  }
  #results{
    margin-top:10px;
    font-family: Tahoma;
    font-size: 14px;
    max-height: 300px;
    overflow:auto;
    border:1px solid #ddd;
    padding:10px;
    background:#fff;
  }
</style>
<div style="background-color: #FFF; border:1px solid gray;border-radius: 5px; width:90%;height:90%;text-align: left;padding:30px; font-family: Tahoma; font-size: 14px;margin-top:30px;">
  <h1 title="Es können auch mehr als 40 Dateien hochgeladen werden">
    Massen Upload von Prüfplänen
  </h1>
  <!-- GRAUER RAHMEN -->
  <div style="
      float:left;
      min-width:840px;
      width:50%;
      border:4px solid lightgray;
      margin-left:20px;
      padding:20px;
      height:750px;
      box-sizing:border-box;
  ">
    <h2 style="color:red;">Ordner Auswahl (Nur Prüfpläne)</h2>
    <form id="massUploadForm"
          method="POST"
          action="#"
          enctype="multipart/form-data"
          onsubmit="return false;">
      <div style="min-width:800px;width:80%;font-size:15px;border:1px solid lightgray;height:180px;padding:20px;">
                    <h3>Schritt 1: Ordner auswählen, der nur Prüfpläne enthalten darf.</h3>
                        <div style="margin-top:20px;">
          <input id="filesInput"
                 type="file"
                 name="MultiPdf[]"
                 multiple
                 webkitdirectory
                 accept="application/pdf,.pdf" />
                        </div>
                    </div>
      <div style="min-width:800px;width:80%;height:120px;border:1px solid lightgray;padding:20px;margin-top:15px;">
                    <h3>Schritt 2: Importieren</h3>
        <button type="button"
                id="btnUpload"
                style="width:400px;margin-top:20px;font-size:20px;height:40px;">
          IMPORTIEREN
        </button>
                </div>
            </form>
    <!-- ✅ HIERHIN GEHÖREN SIE -->
    <div id="progress"
         style="margin-top:15px;font-size:14px;">
    </div>
    <div id="results"
         style="
           margin-top:10px;
           font-size:14px;
           max-height:180px;
           overflow:auto;
           border:1px solid #ddd;
           padding:10px;
           background:#fff;
         ">
        </div>
    </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
(function () {
  const BATCH_SIZE = 20;                       // unter max_file_uploads (40)
  const endpoint = '/uploadMassenPruefplaene'; // deine Route
  const input = document.getElementById('filesInput');
  const btn = document.getElementById('btnUpload');
  const progressEl = document.getElementById('progress');
  const resultsEl = document.getElementById('results');
  if (!input || !btn) {
    console.error('filesInput oder btnUpload nicht gefunden.');
    return;
    }
  const originalBtnText = btn.textContent;
  const originalBtnStyle = btn.style.cssText;
  function chunkFiles(files, size) {
    const chunks = [];
    for (let i = 0; i < files.length; i += size) {
      chunks.push(files.slice(i, i + size));
    }
    return chunks;
  }
  function renderProgress(doneBatches, totalBatches, doneFiles, totalFiles) {
    progressEl.textContent =
      `Batches: ${doneBatches}/${totalBatches} — Dateien: ${doneFiles}/${totalFiles}`;
  }
  function appendResults(resultArray) {
    resultArray.forEach(r => {
      const div = document.createElement('div');
      div.style.color = r.Color || 'black';
      if (r.Link) {
        div.innerHTML = `<a href="${r.Link}">${r.Filename}</a> — ${r.Status}`;
      } else {
        div.textContent = `${r.Filename} — ${r.Status}`;
      }
      resultsEl.appendChild(div);
    });
  }
  async function postBatch(batchFiles) {
    const fd = new FormData();
    batchFiles.forEach(f => fd.append('MultiPdf[]', f));
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    if (tokenMeta) fd.append('_token', tokenMeta.getAttribute('content'));
    const res = await fetch(endpoint, { method: 'POST', body: fd });
    const text = await res.text();
    if (!res.ok) {
      throw new Error(`HTTP ${res.status}: ${text}`);
    }
    return JSON.parse(text); // Controller liefert immer JSON (Variante 3)
  }
  function showSuccessState() {
    btn.disabled = true;
    btn.textContent = '✔ Upload erfolgreich';
    btn.style.backgroundColor = '#2e7d32';
    btn.style.color = '#fff';
    btn.style.border = '2px solid #1b5e20';
    setTimeout(() => {
      // Button zurücksetzen
      btn.disabled = false;
      btn.textContent = originalBtnText;
      btn.style.cssText = originalBtnStyle;
      // Input-Feld leeren
      input.value = '';
      // Fortschritt leeren
      progressEl.textContent = '';
    }, 5000);
  }
  btn.addEventListener('click', async function () {
    const allFiles = Array.from(input.files || []);
    // Sicherheit: nur PDFs
    const files = allFiles.filter(f =>
      f.name && f.name.toLowerCase().endsWith('.pdf')
    );
    resultsEl.innerHTML = '';
    progressEl.textContent = '';
    if (files.length === 0) {
      progressEl.textContent = 'Bitte zuerst PDFs auswählen.';
      return;
    }
    btn.disabled = true;
    const batches = chunkFiles(files, BATCH_SIZE);
    let doneFiles = 0;
    renderProgress(0, batches.length, 0, files.length);
    try {
      for (let i = 0; i < batches.length; i++) {
        const json = await postBatch(batches[i]);
        if (json && json.result) {
          appendResults(json.result);
        }
        doneFiles += batches[i].length;
        renderProgress(i + 1, batches.length, doneFiles, files.length);
      }
      progressEl.textContent += ' — fertig.';
      showSuccessState();
    } catch (e) {
      btn.disabled = false;
      progressEl.textContent = 'Fehler: ' + e.message;
    }
  });
})();
</script>
