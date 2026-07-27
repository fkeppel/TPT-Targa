<style>
    .container {
        display:grid;
        width:90%;
        border:none;
        border-radius:0px;
        grid-template-columns:6% 5% 5% 8% 25% 35% 5% 5% 5%;
        overflow:auto;
        max-height:800px;
        font-family:'Open Sans', Tahoma, Arial, sans-serif;
        font-size:1em;
    }
    .item {
        border:0.5px solid lightslategray;
        border-radius:0px;
        font-family:'Open Sans', Tahoma, Arial, sans-serif;
        font-size:0.9em;
        padding:8px;
        box-sizing:border-box;
    }
    .ih {
        border:1px solid lightgray;
    }
    .item_header {
    background-color:#003D7C;
    color:white;
    min-height:62px;
    overflow:hidden;
}
    .sortTitle {
        cursor:pointer;
        user-select:none;
        display:block;
        height:18px;
        line-height:18px;
        margin-bottom:4px;
        white-space:nowrap;
        overflow:hidden;
        color:white;
        background-color: transparent;
    }
    .sortTitle:hover {
        color:#d9ecff;
    }
    .sortIcon {
        margin-left:4px;
        opacity:0.75;
        font-size:0.85em;
    }
    .sortIcon.active {
        opacity:1;
        font-weight:bold;
    }
.headerInput {
    width:100%;
    height:26px;
    padding:3px 5px;
    margin:0;
    box-sizing:border-box;
    font-size:0.9em;
}
    .topButtons {
    text-align:right;
    margin-bottom:12px;
    width:99.4%;
}
.topBtn {
    min-width:140px;
    height:38px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-size:0.95em;
    font-weight:bold;
    margin-left:8px;
    padding: 4px;
}
.btnSearch {
    background-color:#003D7C;
    color:white;
}
.btnSearch:hover {
    background-color:#0056a8;
}
.btnClear {
    background-color:#d9d9d9;
    color:#222;
}
.btnClear:hover {
    background-color:#bfbfbf;
}
.topBar {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:10px;
    width:99.4%;
}
.topHeader {
    font-size:1.4em;
    font-weight:bold;
    color:#003D7C;
    width:30%;
    vertical-align: top;
    padding-top: 0px;
}
.topButtons {
    text-align:right;
}
</style>
<?php
    $sort = isset($data['inp']['sort']) ? $data['inp']['sort'] : 'ian';
    $dir = isset($data['inp']['dir']) ? $data['inp']['dir'] : 'asc';
    $getSortIcon = function($col) use ($sort, $dir) {
        if ($sort !== $col) {
            return "<span class='sortIcon'>↕</span>";
        }
        return $dir === 'asc'
            ? "<span class='sortIcon active'>▲</span>"
            : "<span class='sortIcon active'>▼</span>";
    };
?>
<div style="width:90%;padding:20px;text-align:left;margin:0 auto;border:1px solid lightgray;border-radius:0px;height:90%;margin-top:30px;">
   {{ Form::open(array('url' => '/showFilesAll', 'method' => 'POST', 'id' => 'searchAll')) }}
{{ Form::hidden('IsPost', 1) }}
<input type="hidden" id="sort" name="sort" value="{{ isset($data['inp']['sort']) ? $data['inp']['sort'] : 'ian' }}">
<input type="hidden" id="dir" name="dir" value="{{ isset($data['inp']['dir']) ? $data['inp']['dir'] : 'asc' }}">
<div class="topBar">
    <div class="topHeader">
        {{$data['Header']}}
    </div>
    <div class="topButtons">
        <button class="topBtn btnSearch"
                type="submit">
            suchen (Enter)
        </button>
        <button class="topBtn btnClear"
                type="button"
                onclick="clearInput();">
            Eingabe löschen (ESC)
        </button>
    </div>
</div>
    <div class="container" style="background-color:#003D7C;width:99.4%;">
        <div class="item item_header">
            <div class="sortTitle" onclick="sortBy('ian')">IAN {{ $getSortIcon('ian') }}</div>
            <input class="headerInput" type="text" id="search_ian" name="search_ian" value="{{ $data['inp']['search_ian'] }}">
        </div>
        <div class="item item_header">
            <div class="sortTitle" onclick="sortBy('ausmusterung')">Musterung {{ $getSortIcon('ausmusterung') }}</div>
            <input class="headerInput" type="text" id="search_ausmusterung" name="search_ausmusterung" value="{{ $data['inp']['search_ausmusterung'] }}">
        </div>
        <div class="item item_header">
            <div class="sortTitle" onclick="sortBy('status')">Status {{ $getSortIcon('status') }}</div>
            <input class="headerInput" type="text" id="search_status" name="search_status" value="{{ $data['inp']['search_status'] }}">
        </div>
        <div class="item item_header">
            <div class="sortTitle" onclick="sortBy('datum')">Datum {{ $getSortIcon('datum') }}</div>
            <input class="headerInput" type="text" id="search_date" name="search_date" value="{{ $data['inp']['search_date'] }}" placeholder="{{ date('Y-m-d') }}">
        </div>
        <div class="item item_header">
            <div class="sortTitle" onclick="sortBy('artikel')">Artikelbezeichnung {{ $getSortIcon('artikel') }}</div>
            <input class="headerInput" type="text" id="search" name="search" value="{{ $data['inp']['search'] }}">
        </div>
        <div class="item item_header">
    <div class="sortTitle" onclick="sortBy('dateiname')">Dateiname {{ $getSortIcon('dateiname') }}</div>
    <input class="headerInput" type="text" id="search_name" name="search_name" value="{{ isset($data['inp']['search_name']) ? $data['inp']['search_name'] : '' }}">
</div>
        <div class="item item_header">
            <div class="sortTitle" onclick="sortBy('bereich')">Bereich {{ $getSortIcon('bereich') }}</div>
            <input class="headerInput" type="text" id="search_type" name="search_type" value="{{ $data['inp']['search_type'] }}">
        </div>
        <div class="item item_header">
            <div class="sortTitle" onclick="sortBy('unterbereich')">Unterbereich {{ $getSortIcon('unterbereich') }}</div>
            <input class="headerInput" type="text" id="search_subkat" name="search_subkat" value="{{ $data['inp']['search_subkat'] }}">
        </div>
        <div class="item item_header">
            <div class="sortTitle" onclick="sortBy('kategorie')">Kategorie {{ $getSortIcon('kategorie') }}</div>
            <input class="headerInput" type="text" id="search_ord" name="search_ord" value="{{ $data['inp']['search_ord'] }}">
        </div>
    </div>
    {{ Form::close() }}
    @if (!is_null($data['files']))
        <div class="container" style="height:80%;border:1px solid gray;width:100%;overflow-x:hidden;">
            @foreach ($data['files'] as $file)
                <div class="item ih">
                    <a href="{{url('/show/'.$file->PPProduktpass_IAN.'_'.substr($file->PPProduktpass_Ausmusterungnummer,0,4))}}" target="_blank">
                        {{$file->PPProduktpass_IAN}}
                    </a>
                </div>
                <div class="item ih">{{substr($file->PPProduktpass_Ausmusterungnummer,0,4)}}</div>
                <div class="item ih">{{$file->InternerStatus}}</div>
                <div class="item ih">{{substr($file->FileDate,0,10)}}</div>
                <div class="item ih">{{$file->PPProduktpass_Artikelbezeichnung}}</div>
                <div class="item ih">
                    <a href="{{ ViewController::getSpoLink($file->FId, 1) }}" target="blank">
                        {{$file->PPPPFiles_Name}}
                    </a><br>
                </div>
                <div class="item ih">{{$file->PPPPFiles_Type}}</div>
                <div class="item ih">{{$file->PPPPFiles_SubKat}}</div>
                <div class="item ih">{{$file->PPPPFiles_Ordnung}}</div>
            @endforeach
        </div>
    @endif
</div>
<script>
    function clearInput(){
        var ids = [
            'search_ausmusterung',
            'search',
            'search_name',
            'search_type',
            'search_subkat',
            'search_ord',
            'search_date',
            'search_status',
            'search_ian'
];
        for(var i = 0; i < ids.length; i++){
            var elem = document.getElementById(ids[i]);
            if(elem){
                elem.value = '';
            }
        }
        document.getElementById('sort').value = 'ian';
        document.getElementById('dir').value = 'asc';
    }
    function sortBy(column) {
        var sortElem = document.getElementById('sort');
        var dirElem = document.getElementById('dir');
        if (sortElem.value === column) {
            dirElem.value = dirElem.value === 'asc' ? 'desc' : 'asc';
        } else {
            sortElem.value = column;
            dirElem.value = 'asc';
        }
        document.getElementById('searchAll').submit();
    }
    $(document).on("keypress", "form", function(event) {
        //ENTER
        if (event.keyCode === 13) {
            event.preventDefault();
            $(this).submit();
        }
    });
    $(document).on("keydown", function(event) {
        // ESC
        if (event.keyCode === 27) {
            event.preventDefault();
            clearInput();
        }
    });
</script>