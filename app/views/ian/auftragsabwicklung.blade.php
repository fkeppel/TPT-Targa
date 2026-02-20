<h5 class='header1'>{{ ServiceProvider::tl($data['lang'], 'Auftragsabwicklung')}}</h5>
<div id='IANTableContainerAuftragsabwicklung' style='padding-left:30px;'>
    <div class="label">{{ ServiceProvider::tl($data['lang'], 'Intrastat-Nummer') }}</div>
    <div class="value">{{ ServiceProvider::tl($data['lang'],$data['tOrder']['order']->PPOrder_IntrastatNumber??'') }}</div>
    <div class="label">{{ ServiceProvider::tl($data['lang'], 'Einheit') }}</div>
    <div class="value">{{ ServiceProvider::tl($data['lang'],$data['tOrder']['order']->PPOrder_IntrastatAlternativeUnit??'') }}</div>
    <div class="label">{{ ServiceProvider::tl($data['lang'], 'Menge') }}</div>
    <div class="value">@if(!is_null($data['tOrder']['order'])){{ number_format($data['tOrder']['order']->PPOrder_IntrastatAlternativeUnitAmount,0,',','.') }}@endif</div>
</div>
<h5 class='header1'>{{ ServiceProvider::tl($data['lang'], 'EUDR Information')}}</h5>
<div id='IANTableContainerAuftragsabwicklung' style='padding-left:30px;'>
    <div class="label">{{ ServiceProvider::tl($data['lang'], 'EUDR Relevanz') }}</div>
    <div class="value">{{ ServiceProvider::tl($data['lang'],$data['tOrder']['order']->PPOrder_EUDR??'') }}</div>
</div>
<h5 class='header1'>{{ ServiceProvider::tl($data['lang'], 'Zollrechtliches Nettostückgewicht')}}</h5>
<div style="padding-left:30px; margin-bottom:30px;">
    <table style="font-size: 0.8em;border-collapse:collapse;">
        <thead>
            <tr>
                <th class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'GTIN') }}</th>
                <th class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'GTIN KL') }}</th>
                <th class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'Stylenummer') }}</th>
                <th class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'Stylebezeichnung') }}</th>
                <th class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'Größe') }}</th>
                <!-- th class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'LSV Code') }}</th -->
                <th class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'LSV Name') }}</th>
                <th class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'LSV Länder') }}</th>
                <th class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'Nettogewicht') }}</th>
                <th class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'Einheit') }}</th>
            </tr>
        </thead>
        <tbody>
        @if (isset($data['tOrder']['weights']))
            @foreach ($data['tOrder']['weights'] as $w)
                <tr>
                    <td class='tgTableTD'>{{ $w->PPOrderWeights_gtin }}</td>
                    <td class='tgTableTD'>{{ $w->PPOrderWeights_gtinKL }}</td>
                    <td class='tgTableTD'>{{ $w->PPOrderWeights_styleNo }}</td>
                    <td class='tgTableTD'>{{ ServiceProvider::tl($data['lang'],$w->PPOrderWeights_productName) }}</td>
                    <td class='tgTableTD'>{{ $w->PPOrderWeights_size }}</td>
                    <!-- td class='tgTableTD'>{{ $w->PPOrderWeights_lsv }}</td -->
                    <td class='tgTableTD'>@if(isset($data['tLsv']['names'][$w->PPOrderWeights_lsv]['name'])){{ $data['tLsv']['names'][$w->PPOrderWeights_lsv]['name'] }}@endif</td>
                    <td class='tgTableTD'>@if(isset($data['tLsv']['names'][$w->PPOrderWeights_lsv]['countryNames'])){{ $data['tLsv']['names'][$w->PPOrderWeights_lsv]['countryNames']  }}@endif</td>
                    <td class='tgTableTD'>{{ $w->PPOrderWeights_weight }}</td>
                    <td class='tgTableTD'>{{ $w->PPOrderWeights_unit }}</td>
                </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
