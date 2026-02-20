<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Mehrere Dateien hochladen mit Vorschau</title>
  <style>
    #fileInput {
      display: none;
    }
    #dropZone {
      border: 2px dashed #888;
      border-radius: 10px;
      width: 300px;
      height: 100px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #555;
      font-size: 16px;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-bottom: 20px;
      text-align: center;
    }
    #dropZone.hover {
      background-color: #f0f0f0;
      border-color: #333;
    }
    #controls {
      margin-bottom: 20px;
    }
    #preview {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }
    .preview-item {
      max-width: 150px;
      max-height: 150px;
      border: 1px solid #ccc;
      padding: 5px;
      overflow: hidden;
    }
    .preview-item img {
      max-width: 100%;
      max-height: 100%;
      display: block;
    }
    .preview-item p {
      font-size: 12px;
      word-break: break-word;
    }
  </style>
</head>
<body>
  <h2>Mehrere Dateien hochladen mit Vorschau</h2>
  <script>
    const fileInput = document.getElementById('fileInput');
    const dropZone = document.getElementById('dropZone');
    const preview = document.getElementById('preview');
    function updateDropZoneSize() {
      dropZone.style.width = `${widthInput.value}px`;
      dropZone.style.height = `${heightInput.value}px`;
    }
    widthInput.addEventListener('input', updateDropZoneSize);
    heightInput.addEventListener('input', updateDropZoneSize);
    updateDropZoneSize();
    dropZone.addEventListener('click', () => {
      fileInput.click();
    });
    dropZone.addEventListener('dragover', (e) => {
      e.preventDefault();
      dropZone.classList.add('hover');
    });
    dropZone.addEventListener('dragleave', () => {
      dropZone.classList.remove('hover');
    });
    dropZone.addEventListener('drop', (e) => {
      e.preventDefault();
      dropZone.classList.remove('hover');
      handleFiles(e.dataTransfer.files);
    });
    fileInput.addEventListener('change', () => {
      handleFiles(fileInput.files);
    });
    function handleFiles(files) {
      preview.innerHTML = ""; // Alte Vorschau löschen
      Array.from(files).forEach(file => {
        const item = document.createElement('div');
        item.className = 'preview-item';
        if (file.type.startsWith("image/")) {
          const reader = new FileReader();
          reader.onload = function(e) {
            item.innerHTML = `<img src="${e.target.result}" alt="${file.name}">`;
            preview.appendChild(item);
          };
          reader.readAsDataURL(file);
        } else {
          item.innerHTML = `<p>${file.name}</p>`;
          preview.appendChild(item);
        }
      });
    }
  </script>
</body>
</html>
