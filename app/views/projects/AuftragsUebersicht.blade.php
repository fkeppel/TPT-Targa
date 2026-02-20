<style>
    .container {
        display:grid;
        width:100%;
        border: none;
        border-radius: 0px;
        grid-template-columns: 110px 90px 90px 250px 120px 480px 100px 90px  90px 90px 167px ;
        overflow: auto;
        max-height:800px;
        font-family: 'Open Sans', Tahoma,  Arial,  sans-serif;
        font-size:1em;
    }
    .item {
        border:0.5px solid lightslategray;
        border-radius: 0px;
        font-family: 'Open Sans', Tahoma,  Arial,  sans-serif;
        font-size:0.9em;
        padding:8px;
    }
    .item_header{
        background-color: #003D7C;
        color:white;
    }
    #form input {
        padding: 10px;
        margin:10px;
    }
    </style>
    <?php 
        $lang = isset($_COOKIE['TPTLanguage'])?$_COOKIE['TPTLanguage']:Auth::user()->PPMitarbeiter_Languge;
        $langOrg='DE';
        if ($lang == 'DE') {
            $langOrg='EN';
        }
    ?>
<div style = "width:1695px;padding:20px;text-align:left;margin:0 auto;border:1px solid darkblue; height: 965px;margin-top:30px;">
    <h3>{{ ServiceProvider::tl($lang,$data['Header'])}}</h3>
    <div id="form" style="border:none; height: 40px;">
        {{Form::open(array('url' => '/showOrderAll', 'method' => 'POST', 'id' => 'searchAll'))}}
        {{Form::hidden('IsPost', 1)}}
        <div style="float: left;">
            {{ ServiceProvider::tl($lang,'Ausmusterung')}}: <input type="text" id="search_ausmusterung" name="search_ausmusterung" value="{{ $data['inp']['search_ausmusterung'] }}"  style="width:80px;"> 
        </div>
        <div style="float: left;">
            {{ ServiceProvider::tl($lang,'Suchbegriff')}}: <input type="text" id="search" name="search" value="{{ $data['inp']['search'] }}"  style="width:300px;"> 
        </div>
        <div style="float: left;width:100px;">
            {{ Form::submit( ServiceProvider::tl($lang,'suchen'), array('class'=>'liq_submit', 'id' => 'sbmtbtn'))}}
        </div>
        <div style="float:left;width:100px;padding-top:12px;">
            <button onclick="clearInput();" class='liq_submit' style='height:38px;'>{{ ServiceProvider::tl($lang,'Eingabe löschen')}}</button>
        </div>
        <div style="clear:both;">&nbsp;</div>
        {{ Form::close()}}
    </div>
    <div class='container' style="background-color:#003D7C;"> 
        <div class = "item item_header">IAN</div>
        <div class = "item item_header">{{ ServiceProvider::tl($lang,'Musterung')}}</div>
        <div class = "item item_header">{{ ServiceProvider::tl($lang,'Status')}}</div>
        <div class = "item item_header">{{ ServiceProvider::tl($lang,'Projekt')}}</div>
        <div class = "item item_header">Link</div>
        <div class = "item item_header">{{ ServiceProvider::tl($lang,'Artikelbezeichnung')}}</div>
        <div class = "item item_header">{{ ServiceProvider::tl($lang,'Liefertermin')}}</div>
        <div class = "item item_header">PM</div>
        <div class = "item item_header">PJM</div>
        <div class = "item item_header">TC</div>
        <div class = "item item_header" style = "">{{ ServiceProvider::tl($lang,'Projektbild')}}</div>
    </div>
    <div class='container'>
    @foreach ($data['liqs'] as $liq)
       <div class = "item">{{$liq->PPProduktpass_IAN}}</div>
        <div class = "item">{{substr($liq->PPProduktpass_Ausmusterungnummer,0,4)}}</div>
        <div class = "item" title="{{$liq->InternerStatus}}">{{ ServiceProvider::tl($lang,$liq->InternerStatus)}}</div>
        <div class = "item">{{$liq->PPProduktpass_PPProjekte_Projekt}}</div>
        <div class = "item"><a href="show/{{$liq->PPProduktpass_Id}}" target="_blank" style="text-decoration:none;color:darkblue;"><b>[Produktpass]</b></a>
                            <br>
                            <a href="dbIANdirect/{{$liq->PPProduktpass_IAN}}_{{substr($liq->PPProduktpass_Ausmusterungnummer,0,4)}}" target="_blank" style="text-decoration:none;color:darkblue;"><b>[Dashboard]</b></a>
        </div>
        <div class = "item" title='' >
            {{ ServiceProvider::tl($lang, $liq->PPProduktpass_Artikelbezeichnung) }}
        </div>
        <div class = "item">{{$liq->PPProduktpass_Liefertermin."/".$liq->PPProduktpass_LieferterminJahr}}</div>
        <div class = "item">{{$liq->PM}}</div>
        <div class = "item">{{$liq->PJM}}</div>
        <div class = "item">{{$liq->TC}}</div>
        <?php 
        $src = '/data/Icons/placeholderLidl.png';
        if (isset($liq->PPProduktpass_ProjektBild) and strlen($liq->PPProduktpass_ProjektBild)){
            $src= '/data/uploads/'.$liq->PPProduktpass_ProjektBild;
        }
        ?>
        <div class = "item" style = ""><a href="/data/uploads/{{$liq->PPProduktpass_ProjektBild}}" target="_blank"><img src="{{$src}}" alt='Projektbild'  style="height:60px;"/></a></div>
    @endforeach
    </div>
</div>
<script>
    function clearInput(){
        document.getElementById('search_ausmusterung').value = '';
        document.getElementById('search').value = '';
    }
    $(document).on("keypress", "form", function(event) {
   if (event.keyCode === 13) {
      event.preventDefault();
      $(this).submit();
   }
});
</script>