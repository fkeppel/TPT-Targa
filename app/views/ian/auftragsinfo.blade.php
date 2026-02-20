<h5 class='header1'>{{ ServiceProvider::tl($data['lang'], 'Dokument Info')}}</h5>
<div id='IANContainer'>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Produktpassnummer') }}</div>
        <div class="value">{{ $data['pp']->rfqNo }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Status') }}</div>
        <div class="value">{{ $data['pp']->statusDoc }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Kategorie') }}</div>
        <div class="value">{{ $data['pp']->category }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Lieferantennummer') }}</div>
        <div class="value">{{ $data['pp']->vendorNo }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Erstellt von') }}</div>
        <div class="value">{{ $data['pp']->createUserName }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Geändert von Benutzer') }} </div>
        <div class="value">{{ $data['pp']->updateUserName }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Erstellt am') }} </div>
        <div class="value">{{ $data['pp']->createdOn }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Letzte Aktualisierung') }}</div>
        <div class="value">{{ $data['pp']->updatedOn }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Letze Version') }}</div>
        <div class="value">{{ $data['pp']->isLatest }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Fälligkeitsdatum') }}</div>
        <div class="value">{{ $data['pp']->expiryDate }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Gesetzliche Ersatzteilverfügbarkeit') }}</div>
        <div class="value">{{ $data['pp']->PPProduktpass_legalSpareparts }}</div>
</div>
<h5 class='header2'>{{ ServiceProvider::tl($data['lang'], 'Produkt Info')}}</h5>
<div id='IANContainer'>
    <div class="label">{{ ServiceProvider::tl($data['lang'], 'IAN') }}</div>
    <div class="value"><b>{{ $data['pp']->PPProduktpass_IAN }}</b></div>
    <div></div>
    <div class="label">    {{ ServiceProvider::tl($data['lang'], 'Charge') }}</div>
    <div class="value"><b>{{ substr($data['pp']->PPProduktpass_Ausmusterungnummer, 0, 4) }}</b></div>
    <div></div>
    <div class="label">{{ ServiceProvider::tl($data['lang'], 'Version') }}</div>
    <div class="value">{{ $data['pp']->version }}</div>
    <div></div>
    <div class="label">{{ ServiceProvider::tl($data['lang'], 'Artikelbezeichnung') }}</div>
    <div class="value">{{ $data['pp']->PPProduktpass_Artikelbezeichnung }}</div>
    <div></div>
    <div class="label">{{ ServiceProvider::tl($data['lang'], 'Abwicklungsart') }}</div>
    <div class="value">{{ $data['pp']->Abwicklungsart }}</div>
    <div></div>
    <div class="label">{{ ServiceProvider::tl($data['lang'], 'Lieferbedingungen') }}</div>
    <div class="value">{{ $data['pp']->PPProduktpass_incoterm }}</div>
    <div></div>
    <div class="label">{{ ServiceProvider::tl($data['lang'], 'Non LIDL IAN') }}</div>
    <div class="value"><input lang="de" class="tgCheckbox" type="checkbox" name="noLIDLItem" id="item_noLIDLItem_input" value="false" disabled=""></div>
    <div></div>
    <div class="label">{{ ServiceProvider::tl($data['lang'], 'LCL') }}</div>
    <div class="value"><input lang="de" class="tgCheckbox" type="checkbox" name="LCL" id="item_LCL_input" @if ($data['pp']->PPProduktpass_LCL == 'true') checked @endif value="1" disabled=""></div>
    <div></div>
    <div class="label">{{ ServiceProvider::tl($data['lang'], 'Projektbild') }}</div>
    <div class="value">
            @if ($data['pp']['PPProduktpass_Transferd2Sharepoint'])
            <?php
                $spoLink = null;
                if (!is_null($data['pp']['PPProduktpass_ProjektBild'])){
                    $image = substr($data['pp']['PPProduktpass_ProjektBild'],7);
                    $ianDir = $data['pp']['PPProduktpass_IAN'].'_'.substr($data['pp']['PPProduktpass_Ausmusterungnummer'],0,4);
                    $spoLink = "https://targagmbh.sharepoint.com/sites/TPTStorage/Freigegebene%20Dokumente/IANs/$ianDir/$image";
                    // Idee iframe $id = 'https://targagmbh.sharepoint.com/sites/TPTStorage/_layouts/15/embed.aspx?UniqueId='.'w40a80440-70a7-411d-b24d-be21cdd8ef6f';
                }
            ?>
            @if (!is_null($spoLink) )
                @if (!is_null($data['pp']['PPProduktpass_ProjektBild']) and strlen ($data['pp']['PPProduktpass_ProjektBild'])>2)
                    <a href="{{ url('/data/uploads/' . $data['pp']['PPProduktpass_ProjektBild']) }}" target="_blank"><img src="{{ url('/data/uploads/' . $data['pp']['PPProduktpass_ProjektBild']) }}" alt="{{ $data['pp']['PPProduktpass_ProjektBild'] }}" id="image_img_d0e289" class="tgImage"></a>
                @endif 
                <!-- a href="{{ url($spoLink) }}" target="_blank"><img src="{{ url($spoLink) }}" alt="{{ $image }}" id="image_img_d0e289" class="tgImage">{{ $image }}</a -->                        
            @endif
        @else 
            @if (!is_null($data['pp']['PPProduktpass_ProjektBild']) and strlen ($data['pp']['PPProduktpass_ProjektBild'])>2)
                <a href="{{ url('/data/uploads/' . $data['pp']['PPProduktpass_ProjektBild']) }}" target="_blank"><img src="{{ url('/data/uploads/' . $data['pp']['PPProduktpass_ProjektBild']) }}" alt="{{ $data['pp']['PPProduktpass_ProjektBild'] }}" id="image_img_d0e289" class="tgImage"></a>
            @endif
        @endif
    </div>
    <div></div>
    <div class="label">{{ ServiceProvider::tl($data['lang'], 'Frühester Liefertermin Land ') }}</div>
    <div class="value">{{ $data['pp']->PPProduktpass_earliestDDCountry1  }}</div>
    <div></div>
    <div class="label">{{ ServiceProvider::tl($data['lang'], 'Frühester Liefertermin Land 2') }}</div>
    <div class="value">{{ $data['pp']->PPProduktpass_earliestDDCountry2  }}</div>
    <div></div>
    <div class="label">{{ ServiceProvider::tl($data['lang'], 'Frühester Liefertermin Land 3') }}</div>
    <div class="value">{{ $data['pp']->PPProduktpass_earliestDDCountry3  }}</div>
</div>
