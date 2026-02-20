<h1 class='header1' id='headerArtikel'>{{ ServiceProvider::tl($data['lang'], $data['pp']->PPProduktpass_Artikelbezeichnung ) }}</h1> 
<div id='picLidl'>
    @if ($data['pp']['PPProduktpass_Transferd2Sharepoint'])
        <?php
        $spoLink = null;
        if (!is_null($data['pp']['PPProduktpass_ProjektBild'])) {
            $image = substr($data['pp']['PPProduktpass_ProjektBild'], 7);
            $ianDir = $data['pp']['PPProduktpass_IAN'] . '_' . substr($data['pp']['PPProduktpass_Ausmusterungnummer'], 0, 4);
            $spoLink = "https://targagmbh.sharepoint.com/sites/TPTStorage/Freigegebene%20Dokumente/IANs/$ianDir/$image";
            // Idee iframe $id = 'https://targagmbh.sharepoint.com/sites/TPTStorage/_layouts/15/embed.aspx?UniqueId='.'w40a80440-70a7-411d-b24d-be21cdd8ef6f';
        }
        ?>
        @if (!is_null($spoLink))
            @if (!is_null($data['pp']['PPProduktpass_ProjektBild']) and strlen($data['pp']['PPProduktpass_ProjektBild']) > 2)
                 <a href="{{ url('/data/uploads/' . $data['pp']['PPProduktpass_ProjektBild']) }}" target="_blank">
                    <img src="{{ url('/data/uploads/' . $data['pp']['PPProduktpass_ProjektBild']) }}"
                         alt="{{ $data['pp']['PPProduktpass_ProjektBild'] }}" id="image_img_d0e289" class="tgImage">
                </a>
                @endif
            <!-- a href="{{ url($spoLink) }}" target="_blank"><img src="{{ url($spoLink) }}" alt="{{ $image }}" id="image_img_d0e289" class="tgImage">{{ $image }}</a -->
        @endif
    @else
        @if (!is_null($data['pp']['PPProduktpass_ProjektBild']) and strlen($data['pp']['PPProduktpass_ProjektBild']) > 2)
             <a href="{{ url('/data/uploads/' . $data['pp']['PPProduktpass_ProjektBild']) }}" target="_blank">
                <img src="{{ url('/data/uploads/' . $data['pp']['PPProduktpass_ProjektBild']) }}"
                     alt="{{ $data['pp']['PPProduktpass_ProjektBild'] }}" id="image_img_d0e289" class="tgImage">
            </a>
        @endif
    @endif
</div>
<div id='infoLidl'>
        <div id='History'>
            <div id='History-Top'></div> 
            <div style='position:absolute;top:0px;right:0px;color:white; padding:3px; font-weight:bold; border:1px solid white;z-index:1000;background-color:transparent;' onclick='closeHistory();'>X</div>
        </div>
    <h5 class='header2'>{{ ServiceProvider::tl($data['lang'], 'Allgemeine Informationen') }}</h5>
    <div id='IANContainer'>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'IAN') }}</div>
        <div class="value"><b>{{ $data['pp']->PPProduktpass_IAN }}</b></div>
        <div></div>
        <div class="label"> {{ ServiceProvider::tl($data['lang'], 'Charge') }}</div>
        <div class="value"><b>{{ substr($data['pp']->PPProduktpass_Ausmusterungnummer, 0, 4) }}</b></div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Erstellt am') }} </div>
        <div class="value">{{ $data['pp']->createdOn }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Letzte Aktualisierung') }}</div>
        <div class="value">{{ $data['pp']->updatedOn }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Non LIDL IAN') }}</div>
        <div class="value"><input class="tgCheckbox"  type = 'checkbox' value="false" disabled /></div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Frühester Liefertermin Land ') }}</div>
        <div class="value">{{ $data['pp']->PPProduktpass_earliestDDCountry1  }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Frühester Liefertermin Land 2') }}</div>
        <div class="value">{{ $data['pp']->PPProduktpass_earliestDDCountry2  }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Frühester Liefertermin Land 3') }}</div>
        <div class="value">{{ $data['pp']->PPProduktpass_earliestDDCountry3  }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Abwicklungsart') }}</div>
        <div class="value">{{ $data['pp']->Abwicklungsart }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'Lieferbedingungen') }}</div>
        <div class="value">{{ $data['pp']->PPProduktpass_incoterm }}</div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'LCL') }}</div>
        <div class="value"><input lang="de" class="tgCheckbox" type="checkbox" name="LCL" id="item_LCL_input" @if ($data['pp']->PPProduktpass_LCL == 'true') checked @endif value="1" disabled=""></div>
        <div></div>
        <div class="label">{{ ServiceProvider::tl($data['lang'], 'TARGA/LIDL Status') }}</div>
        <div class="value" style='background-color:yellow;font-weight:bold;'>{{$data['pp']->InternerStatus}} / {{$data['pp']->statusDoc}} @if (!is_null($data['pp']->PPProduktpass_Absagegrund) and strlen($data['pp']->PPProduktpass_Absagegrund) > 2) <br>Grund: {{$data['pp']->PPProduktpass_Absagegrund}} @endif </div>
        <div></div>
            @if ( strpos(Auth::user()->PPMitarbeiter_Role, 'ZOLL') !== false  or Auth::user()->PPMitarbeiter_Gruppe == 'admin'  )
                <div class="label" onclick='getZollHistory();' style='color:dodgerblue;' >{{ ServiceProvider::tl($data['lang'], 'Zolltarifnummer') }} 
                    @foreach ($data['embargo'] as $type => $embargo)
                        @if ($embargo == 1)
                            <br><span style="color: red;">{{$type}}</span>
                        @endif
                        @if ($embargo == 0)
                            <br><span style="color: dodgerblue;">{{$type}} N.N.</span>
                        @endif
                        @if ($embargo == -1 && $type == 'EUDR')
                            <br><span style="color: dodgerblue;">kein EUDR</span>
                        @endif
                    @endforeach
                </div>
                <div class="value" ><textarea  id='PPProduktpass_Zolltarif'>{{$data['pp']->PPProduktpass_Zolltarif}}</textarea>
                </div>
                <div></div>
                <div class="label">{{ ServiceProvider::tl($data['lang'], 'Zollsatz') }}</div>
                <div class="value" ><textarea  id='PPProduktpass_Zollsatz'>{{$data['pp']->PPProduktpass_Zollsatz}}</textarea></div>
                <div><input type='hidden'  id='PPProduktpass_Id'  value='{{$data['pp']->PPProduktpass_Id}}' /></div>
                <div><button style='margin-top:5px;' onclick='saveZoll();'  >Zolldaten speichern.</button></div>
            @else 
                <div class="label" onclick='getZollHistory();' style='color:dodgerblue;' >{{ ServiceProvider::tl($data['lang'], 'Zolltarifnummer') }}
                       @foreach ($data['embargo'] as $type => $embargo)
                        @if ($embargo == 1)
                            <br><span style="color: red;">{{$type}}</span>
                        @endif
                        @if ($embargo == 0)
                            <br><span style="color: dodgerblue;">{{$type}} N.N.</span>
                        @endif
                        @if ($embargo == -1 && $type == 'EUDR')
                            <br><span style="color: dodgerblue;">kein EUDR</span>
                        @endif
                    @endforeach
                </div>
                <div class="value" >{{$data['pp']->PPProduktpass_Zolltarif}}</div>
                <div></div>
                <div class="label">{{ ServiceProvider::tl($data['lang'], 'Zollsatz') }}</div>
                <div class="value" >{{$data['pp']->PPProduktpass_Zollsatz}}</div>
                <div></div>
                <div></div>
            @endif
            <div></div>
            <div></div>
    </div>
</div>
<script>
    function saveZoll () {
        //alert('Zolldaten speichern');
        var url = '/updateZollAjax';
        var PPProduktpass_Id = $('#PPProduktpass_Id').val();
        var PPProduktpass_Zollsatz = $('#PPProduktpass_Zollsatz').val();
        var PPProduktpass_Zolltarif = $('#PPProduktpass_Zolltarif').val();
        var data =  {   PPProduktpass_Id:PPProduktpass_Id,
                        PPProduktpass_Zollsatz:PPProduktpass_Zollsatz,  
                        PPProduktpass_Zolltarif:PPProduktpass_Zolltarif
                    };
        console.log ('ParameterX');
        console.log (data);
       //return;
        $.ajax({
            url:url,    //the page containing php script
            type: "post",    //request type,
            dataType: 'json',
            data: data,
            success:function(data){
                console.log('Success');
                console.log(data);
                alert('Zolldaten gespeichert!');
            }
        });
    }
    function getZollHistory () {
        var url = '/getZollHistory';
        var PPProduktpass_Id = $('#PPProduktpass_Id').val();
        var params =  {   PPProduktpass_Id:PPProduktpass_Id,
                    };
        console.log ('Parameter');
        console.log (params);
        $.ajax({
            url:url,    //the page containing php script
            type: "post",    //request type,
            dataType: 'json',
            data: params,
            success:function(data){
                console.log('Success');
                console.log(data);
                const itemWrap = document.getElementById('History'); 
                const item = document.getElementById('History-Top');
                item.innerHTML = data['History'];
                itemWrap.style.display = 'block';
            }
        });
    }
    function closeHistory () {
        const item = document.getElementById('History');
        item.style.display = 'none';
    }
    document.getElementById('translateBtn').addEventListener('click', function () {
    const text = document.getElementById('headerArtikel').innerText;
    fetch('/translateLive', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'text=' + encodeURIComponent(text)
    })
   .then(response => {
        console.log("RAW response:", response); // <- komplette Response
        return response.text();
    })
    .then(result => {
        console.log("Result from server:", result); // <- tatsächlicher Rückgabewert
        document.getElementById('headerArtikel').innerText = result;
    })
    .catch(err => console.error(err));
});
</script>