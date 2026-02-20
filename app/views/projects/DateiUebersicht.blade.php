<style>
    .container {
        display:grid;
        width:90%;
        border: none;
        border-radius: 0px;
        grid-template-columns: minmax(80px,4%) minmax(100px,5%) minmax(100px,5%) minmax(120px,6%) minmax(300px,29%) minmax(500px,40%) minmax(100px,5%) minmax(100px,5%);
        overflow: auto;
        max-height:800px;
        font-family: 'Open Sans', Tahoma,  Arial,  sans-serif;
        font-size:1em;
    }
    .item {
        border:1px solid lightslategray;
        border-radius: 0px;
        font-family: 'Open Sans', Tahoma,  Arial,  sans-serif;
        font-size:0.9em;
        padding:8px;
        min-height:26px;
        max-height:28px;
    }
    .ih {
       border:1px solid lightgray;
    }
    .item_header{
        background-color: #003D7C;
        color:white;
    }
    #form input {
        padding: 10px;
        margin:10px;
    }
    #form {
        margin-top:0px;
        border:none;
        border-radius:0px;
        padding:0px;
    }
    #searchAll {
        border:none;
        margin:0px;
        padding:0px;
        margin:0px;
    }
    #form h3 {
        margin:0px;
        margin-bottom:10px;
    }
    #form div {
        border:none;
    }
    .scroller {
        scrollbar-width: thin ;
    }
    </style>
<?php 
    $lang = isset($_COOKIE['TPTLanguage'])?$_COOKIE['TPTLanguage']:Auth::user()->PPMitarbeiter_Language;
?>
<div style = "width:90%;padding:20px;text-align:left;margin:0 auto;border:1px solid gray; border-radius:0px; height:90%;margin-top:30px;">
    <div id="form" style="">
        <h3>{{$data['Header']}}</h3>
        {{Form::open(array('url' => '/showFilesAll', 'method' => 'POST', 'id' => 'searchAll'))}}
        {{Form::hidden('IsPost', 1)}}
            <input type="hidden" id="search_type" name="search_type" value="{{ $data['inp']['search_type'] }}"  style="width:150px;">
            <input type="hidden" id="search_subkat" name="search_subkat" value="{{ $data['inp']['search_subkat'] }}"  style="width:150px;">
            <input type="hidden" id="search_ord" name="search_ord" value="{{ $data['inp']['search_ord'] }}"  style="width:150px;">
        <div style="float:left;">
            IAN: <input type="text" id="search_ian" name="search_ian" value="{{ $data['inp']['search_ian'] }}"  style="width:80px;"> 
        </div>
        <div style="float:left;">
            {{ ServiceProvider::tl($lang,'Ausmusterung')}}: <input type="text" id="search_ausmusterung" name="search_ausmusterung" value="{{ $data['inp']['search_ausmusterung'] }}"  style="width:80px;"> 
        </div>
        <div style="float:left;">
            {{ ServiceProvider::tl($lang,'Status')}}: <input type="text" id="search_status" name="search_status" value="{{ $data['inp']['search_status'] }}"  style="width:80px;"> 
        </div>
        <div style="float:left;">
            {{ ServiceProvider::tl($lang,'Datum')}}: <input type="text" id="search_date" name="search_date" value="{{ $data['inp']['search_date'] }}" placeholder='{{date('Y-m-d')}}'  style="width:180px;"> 
        </div>
        <div style="float:left;" title='Bsp: 2024%Plan% findet Dateien die mit 2024 beginnen und irgendwo im Namen Plan enthalten.'>
            {{ ServiceProvider::tl($lang,'Suchbegriff')}} ({{ ServiceProvider::tl($lang,'Platzhalter')}}<sup><span style='font-size:0.6em;'>&#10033;</span></sup> = %): <input type="text" id="search" name="search" value="{{ $data['inp']['search'] }}"  style="width:300px;"> <br>
        </div>
        <div style="float:left;width:100px;">
            {{ Form::submit(ServiceProvider::tl($lang,'suchen'), array('class'=>'liq_submit', 'id' => 'sbmtbtn'))}}
        </div>
        <div style="float:left;width:100px;">
            <button type='button' onclick="clearInput();" style='width:100px;margin:11px;margin-left:0;'>{{ ServiceProvider::tl($lang,'Eingabe löschen')}}</button>
        </div>
        <div style="clear:both;">&nbsp;</div>
        {{ Form::close()}}
    </div>
    <div class='container' style="background-color:#003D7C;width:100%;"> 
        <div class = "item item_header">IAN</div>
        <div class = "item item_header">{{ ServiceProvider::tl($lang,'Musterung')}}</div>
        <div class = "item item_header">{{ ServiceProvider::tl($lang,'Status')}}</div>
        <div class = "item item_header">{{ ServiceProvider::tl($lang,'Datum')}}</div>
        <div class = "item item_header">{{ ServiceProvider::tl($lang,'Artikelbezeichnung')}}</div>
        <div class = "item item_header">{{ ServiceProvider::tl($lang,'Dateiname')}}</div>
        <div class = "item item_header">{{ ServiceProvider::tl($lang,'Bereich')}}</div>
        <div class = "item item_header">{{ ServiceProvider::tl($lang,'Unterbereich')}}</div>
    </div>
    @if (!is_null($data['files']))
    <div class='container scroller' style='max-height:calc(88% - 60px);border:1px solid gray;width:{{ViewController::getScrollbarWidth()}};min-height:30px;'>
    @foreach ($data['files'] as $file)
        <div class = "item ih"><a href="{{url('/show/'.$file->PPProduktpass_IAN.'_'.substr($file->PPProduktpass_Ausmusterungnummer,0,4))}}" target='_blank'>{{$file->PPProduktpass_IAN}}</a></div>
        <div class = "item ih">{{substr($file->PPProduktpass_Ausmusterungnummer,0,4)}}</div>
        <div class = "item ih">{{$file->InternerStatus}}</div>
        <div class = "item ih">{{substr($file->FileDate,0,10)}}</div>
        <div class = "item ih">{{$file->PPProduktpass_Artikelbezeichnung}}</div>
        <div class = "item ih"><a href="{{ ViewController::getSpoLink($file->FId, 1) }}" target="blank">{{$file->PPPPFiles_Name}}</a><br></div>
        <div class = "item ih">{{$file->PPPPFiles_Type}}</div>
        <div class = "item ih"><a href='{{url(ViewController::getFileTabLink($file->PPProduktpass_Id,$file->PPPPFiles_Type,$file->PPPPFiles_SubKat))}}' target='_blank'>{{$file->PPPPFiles_SubKat}}</a></div>
        {{-- https://tpt-dev.ad.targa.de/showAfterUpload/13/6/EKPM/0/0  --}}
    @endforeach
    </div>
    @endif
</div>
<script>
    function clearInput(){
        //console.log(document.getElementById('search_ausmusterung'));
        var elem = document.getElementById('search_ausmusterung');
            elem.value = '';
            elem = document.getElementById('ian');
            elem.value = '';
            elem = document.getElementById('search');
            elem.value = '';
            elem = document.getElementById('search_type');
            elem.value = '';
            elem = document.getElementById('search_subkat');
            elem.value = '';
            elem = document.getElementById('search_ord');
            elem.value = '';
            elem = document.getElementById('search_date');
            elem.value = '';
            elem = document.getElementById('search_status');
            elem.value = '';
    }
    $(document).on("keypress", "form", function(event) {
   if (event.keyCode === 13) {
      event.preventDefault();
      $(this).submit();
   }
});
</script>