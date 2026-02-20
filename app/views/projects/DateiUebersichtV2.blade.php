<style>
    .container {
        display:grid;
        width:90%;
        border: none;
        border-radius: 0px;
        ---grid-template-columns: 110px 90px 90px 450px 120px 580px 100px 100px 100px   ;
        grid-template-columns:6% 5% 5% 8% 25% 35%  5% 5% 5%;
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
    </style>
<div style = "width:90%;padding:20px;text-align:left;margin:0 auto;border:1px solid lightgray; border-radius:0px; height:90%;margin-top:30px;">
    <h3>{{$data['Header']}}</h3>
      {{Form::open(array('url' => '/showFilesAll', 'method' => 'POST', 'id' => 'searchAll'))}}
        {{Form::hidden('IsPost', 1)}}
          <div style='text-align:center;'>
                <button type='submit' style='width:100px;margin:11px;margin-left:0;'>suchen</button>
                <button type='button' onclick="clearInput();" style='width:120px;margin:11px;margin-left:0;'>Eingabe löschen</button>
            </div>
    <div class='container' style="background-color:#003D7C;width:99.4%;"> 
        <div class = "item item_header">IAN <br><input type="text" id="search_ian" name="search_ian" value="{{ $data['inp']['search_ian'] }}"  style="width:100%;"></div>
        <div class = "item item_header">Musterung<br><input type="text" id="search_ausmusterung" name="search_ausmusterung" value="{{ $data['inp']['search_ausmusterung'] }}"  style="width:100%;"> </div>
        <div class = "item item_header">Status<br> <input type="text" id="search_status" name="search_status" value="{{ $data['inp']['search_status'] }}"  style="width:100%;"></div>
        <div class = "item item_header">Datum<br><input type="text" id="search_date" name="search_date" value="{{ $data['inp']['search_date'] }}" placeholder='{{date('Y-m-d')}}'  style="width:100%;"></div>
        <!-- div class = "item item_header">Projekt</div-->
        <div class = "item item_header">Artikelbezeichnung<br><input type="text" id="search" name="search" value="{{ $data['inp']['search'] }}"  style="width:100%;"></div>
        <div class = "item item_header">Dateiname</div>
        <div class = "item item_header" style = "">Bereich<br> <input type="text" id="search_type" name="search_type" value="{{ $data['inp']['search_type'] }}"  style="width:100%;"></div>
        <div class = "item item_header" style = "">Unterbereich  <br><input type="text" id="search_subkat" name="search_subkat" value="{{ $data['inp']['search_subkat'] }}"  style="width:100%;"></div>
        <div class = "item item_header" style = "">Kategorie<br><input type="text" id="search_ord" name="search_ord" value="{{ $data['inp']['search_ord'] }}"  style="width:100%;"></div>
    </div> 
    {{ Form::close()}}
    @if (!is_null($data['files']))
    <div class='container' style='height:80%;border:1px solid gray;width:100%;overflow-x:hidden;'>
    @foreach ($data['files'] as $file)
        <div class = "item ih"><a href="{{url('/show/'.$file->PPProduktpass_IAN.'_'.substr($file->PPProduktpass_Ausmusterungnummer,0,4))}}" target='_blank'>{{$file->PPProduktpass_IAN}}</a></div>
        <div class = "item ih">{{substr($file->PPProduktpass_Ausmusterungnummer,0,4)}}</div>
        <div class = "item ih">{{$file->InternerStatus}}</div>
        <div class = "item ih">{{substr($file->FileDate,0,10)}}</div>
        <!-- div class = "item ih">{{$file->PPProduktpass_PPProjekte_Projekt}}</div -->
        <div class = "item ih">{{$file->PPProduktpass_Artikelbezeichnung}}</div>
        <div class = "item ih"><a href="{{ ViewController::getSpoLink($file->FId, 1) }}" target="blank">{{$file->PPPPFiles_Name}}</a><br></div>
        <div class = "item ih" style = "">{{$file->PPPPFiles_Type}}</div>
        <div class = "item ih" style = "">{{$file->PPPPFiles_SubKat}}</div>
        <div class = "item ih" style = "">{{$file->PPPPFiles_Ordnung}}</div>
    @endforeach
    </div>
    @endif
</div>
<script>
    function clearInput(){
        //console.log(document.getElementById('search_ausmusterung'));
        var elem = document.getElementById('search_ausmusterung');
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
            elem = document.getElementById('search_name');
            elem.value = '';
            elem = document.getElementById('search_ian');
            elem.value = '';
    }
    $(document).on("keypress", "form", function(event) {
   if (event.keyCode === 13) {
      event.preventDefault();
      $(this).submit();
   }
});
</script>