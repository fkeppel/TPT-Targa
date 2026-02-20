<h5 class='header1'>{{ ServiceProvider::tl($data['lang'], 'Themenplanung')}}</h5>
<div id='IANContainer'>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Bereich') }}</div>
        <div class="value">{{ $data['pp']->PPProduktpass_ThemaScope }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'TARGA T-Nummer') }}</div>
        <div class="value">{{ $data['pp']->PPProduktpass_TargaTNr }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Muster benötigt') }}</div>
        <div class="value">{{ $data['pp']->PPProduktpass_ThemaRequierdSamples }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Kolliinhalt') }}</div>
        <div class="value">{{ $data['pp']->PPProduktpass_ThemaKolli }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Sortierung') }}</div>
        <div class="value">{{ $data['pp']->PPProduktpass_ThemaAssortment }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Garantie') }}</div>
        <div class="value">{{ $data['pp']->PPProduktpass_ThemaWarranty }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Risiko') }} </div>
        <div class="value">{{ $data['pp']->PPProduktpass_ThemaRisc }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Zertifizierungen') }} </div>
        <div class="value">{{ $data['pp']->PPProduktpass_ThemaCerificates }}</div>
        <div></div>
</div>