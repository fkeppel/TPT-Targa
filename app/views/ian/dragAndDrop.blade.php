<style>
    #fileInput{{$kat['Kategorie']}} {
        display: none;
    }
    #dropZone{{$kat['Kategorie']}} {
        border: 2px dashed #888;
        border-radius: 10px;
        width: 100%;
        height: 100%;
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
    #dropZone{{$kat['Kategorie']}}.hover {
        background-color: #f0f0f0;
        border-color: #333;
    }
    #controls{{$kat['Kategorie']}} {
        margin-bottom: 20px;
    }
    #preview{{$kat['Kategorie']}} {
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
<div id="dropZone{{$kat['Kategorie']}}">Dateien hierher ziehen oder klicken!!!</div>
<input type="file" id="fileInput{{$kat['Kategorie']}}" accept="*" multiple>
<div id="preview{{$kat['Kategorie']}}"></div>
<script>
    const fileInput{{$kat['Kategorie']}} = document.getElementById('fileInput{{$kat['Kategorie']}}');
    const dropZone{{$kat['Kategorie']}} = document.getElementById('dropZone{{$kat['Kategorie']}}');
    const preview{{$kat['Kategorie']}} = document.getElementById('preview{{$kat['Kategorie']}}');
    dropZone{{$kat['Kategorie']}}.addEventListener('click', () => {
    fileInput{{$kat['Kategorie']}}.click();
    });
    dropZone{{$kat['Kategorie']}}.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone{{$kat['Kategorie']}}.classList.add('hover');
    });
    dropZone{{$kat['Kategorie']}}.addEventListener('dragleave', () => {
    dropZone{{$kat['Kategorie']}}.classList.remove('hover');
    });
    dropZone{{$kat['Kategorie']}}.addEventListener('drop', (e) => {
        console.log('drop{{$kat['Kategorie']}}');
        e.preventDefault();
        dropZone{{$kat['Kategorie']}}.classList.remove('hover');
        handleFiles{{$kat['Kategorie']}}(e.dataTransfer.files);
    });
    fileInput{{$kat['Kategorie']}}.addEventListener('change', () => {
        handleFiles{{$kat['Kategorie']}}(fileInput{{$kat['Kategorie']}}.files);
    });
    function handleFiles{{$kat['Kategorie']}}(files) {
        preview{{$kat['Kategorie']}}.innerHTML = ""; // Alte Vorschau löschen
        Array.from(files).forEach(file => {
        const item = document.createElement('div');
        item.className = 'preview-item';
        if (file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = function(e) {
                item.innerHTML = `<img src="${e.target.result}" alt="${file.name}">`;
                preview{{$kat['Kategorie']}}.appendChild(item);
            };
            console.log('item');
            console.log(item);
            reader.readAsDataURL(file);
        } else {
            console.log('No Image');
            item.innerHTML = `<p>${file.name}</p>`;
            preview{{$kat['Kategorie']}}.appendChild(item);
        }
    });
    }
</script>
