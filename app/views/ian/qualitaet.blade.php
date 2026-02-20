<h5 class='header1'>{{ ServiceProvider::tl($data['lang'], 'Qualität')}}</h5>
 <div id='IANTableContainerQual'>
            <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Stylenr') }}.</div>
            <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Stylebezeichnung') }}</div>
            <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Gewicht (ohne Verpackung) g/kg') }}</div>
            <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Größe (ohne Verpackung) LxBXH, mm/cm' ) }}</div>
            <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Qualität/technische Daten') }}</div>
            <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Fortsetzung Qualität') }}</div>
            <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Änderungen vom Vorgänger') }}</div>
            <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Markenreferenz') }}</div>
            <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Material') }}</div>
            <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Materialstärke') }}</div>
            <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Farbe') }}</div>
            @foreach ($data['style'] as $style)
                <div class='value'>{{ $style->PPProduktpass_Style_Header }}</div>
                <div class='value'>{{{ ServiceProvider::tl($data['lang'],$style->PPProduktpass_Style_Value01) }}}</div>
                <div class='value'>{{{ ServiceProvider::tl($data['lang'],$style->weightWithoutPackaging) }}}</div>
                <div class='value'>{{{ ServiceProvider::tl($data['lang'],$style->sizeWithoutPackaging) }}}</div>
                <div class='value'>{{{ServiceProvider::tl($data['lang'],$style->qualityTechnicalData)}}}</div>
                <div class='value'>{{{ ServiceProvider::tl($data['lang'],$style->additionalQualityInformation) }}}</div>
                <div class='value'>{{{ ServiceProvider::tl($data['lang'],$style->changesFromPredecessor) }}}</div>
                <div class='value'>{{{ ServiceProvider::tl($data['lang'],$style->brandReference ) }}}</div>
                <div class='value'>{{{ ServiceProvider::tl($data['lang'],$style->material) }}}</div>
                <div class='value'>{{{ ServiceProvider::tl($data['lang'],$style->materialThickness) }}}</div>
                <div class='value'>{{{ ServiceProvider::tl($data['lang'],$style->color) }}}</div>
            @endforeach
</div>
