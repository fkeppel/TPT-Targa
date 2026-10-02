<style>
    body {
    font-family: Arial, Helvetica, sans-serif;
    background: #f3f5f7;
    margin: 0;
    padding: 40px;
}
.form-container {
    max-width: 700px;
    margin: 0 auto;
    background: #fff;
    padding: 35px;
    border-radius: 10px;
    box-shadow: 0 3px 12px rgba(0,0,0,.12);
}
h1 {
    margin: 0;
    color: #2c3e50;
}
.subtitle {
    color: #777;
    margin: 8px 0 30px;
}
.form-row {
    margin-bottom: 22px;
}
label {
    display: block;
    font-weight: bold;
    margin-bottom: 8px;
    color: #444;
}
input {
    width: 100%;
    padding: 12px 14px;
    font-size: 15px;
    border: 1px solid #cfd6dc;
    border-radius: 6px;
    box-sizing: border-box;
    transition: .2s;
}
input:focus {
    outline: none;
    border-color: #2d89ef;
    box-shadow: 0 0 6px rgba(45,137,239,.25);
}
.button-row {
    margin-top: 35px;
    text-align: right;
}
.btn-save,
.btn-cancel {
    display: inline-block;
    padding: 12px 22px;
    text-decoration: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
}
.btn-save {
    background: #2d89ef;
    color: #fff;
    border: none;
}
.btn-save:hover {
    background: #1f6fc5;
}
.btn-cancel {
    background: #e5e5e5;
    color: #444;
    margin-left: 10px;
}
.btn-cancel:hover {
    background: #d6d6d6;
}
.ddp-fields {
    display: flex;
    align-items: center;
    gap: 8px;
}
.ddp-fields input {
    width: 70px;
}
.ddp-fields input:last-child {
    width: 90px;
}
    </style>
<div class="form-container">
    <h1>Neues Projekt für den Shipment-Overview</h1>
    <p class="subtitle">Bitte die Projektdaten eingeben. Projekt erscheint im TPT Dashboard. </p>
    <form action="{{ URL::to('newSchwarzOrder') }}" method="post">
        <div class="form-row">
            <label for="project_number">Projektnummer</label>
            <input type="text"
                   id="project_number"
                   name="project_number"
                   placeholder="z.B. 24012345"
                   autofocus>
        </div>
        <div class="form-row">
            <label for="article_description">Artikelbezeichnung</label>
            <input type="text"
                   id="article_description"
                   name="article_description"
                   placeholder="Artikelbezeichnung">
        </div>
             <div class="form-row">
            <label for="ddp">DDP</label>
        <div class="ddp-fields">
        <input type="text"
               id="ddp_monat"
               name="ddp_monat"
               placeholder="MM"
               maxlength="2">
        <span>/</span>
        <input type="text"
               id="ddp_jahr"
               name="ddp_jahr"
               placeholder="JJJJ"
               maxlength="4">
    </div>
             </div>
        <div class="button-row">
            <button type="submit" class="btn-save">Speichern</button>
            <a href="{{ URL::previous() }}" class="btn-cancel">Abbrechen</a>
        </div>
    </form>
</div>