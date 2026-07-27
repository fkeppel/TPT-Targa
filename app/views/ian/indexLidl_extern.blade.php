<style>
    div {
        border-radius:0px;
    }
    .ui-state-active,
    .ui-widget-content .ui-state-active,
    .ui-widget-header .ui-state-active,
    a.ui-button:active,
    .ui-button:active,
    .ui-button.ui-state-active:hover {
        border: 1px solid #1C73C5;
        background: #1C73C5;
        font-weight: normal;
        color: #ffffff;
    }
    #tabs {
        width: 98%;
        overflow: auto;
        border: none;
        min-height: calc(100vh - 150px);
        padding-left: 25px;
        font-size:1em;
        text-align:left;
        border-radius:0px!important
    }
    .divContainer {
        border: 1px solid lightgray!important;
        border-radius:0px;
        padding: 0px;
        width:95%!important;
    }
    .divContainer h5 {
        color: #08549c;
        text-decoration: underline;
        text-decoration-thickness: 2px;
        margin: 8px;
        margin-top: 20px;
        font-size: 1em;
        font-weight: bolder;
    }
    .btn {
        width: 55px;
        height: 15px;
        float: left;
        border: 1px solid gray;
        color: #08549c;
        text-align: center;
        vertical-align: middle;
        padding: 4px;
        margin: 5px;
        font-family: arial;
        font-weight: bold;
        background-color: lightgray;
        font-size: 12px;
    }
    #IANContainer {
        width: 100%;
        border: none;
        padding: 5px;
        display: grid;
        grid-template-columns: minmax(8%, 15%) minmax(10%, 15%) 25px minmax(8%, 15%) minmax(10%, 15%) 25px minmax(8%, 15%) minmax(10%, 15%) 25px minmax(8%, 15%) minmax(10%, 15%) 25px;
        font-family: arial;
        font-size: 0.8em;
        margin-bottom: 10px;
    }
    #IANContainer .label {
        border-bottom: 1px solid #08549c;
        background-color: white;
        padding: 8px;
        xpadding-bottom: 4px;
        font-weight: bold;
        color: #08549c;
        margin-bottom: 10px;
        overflow: hidden;
    }
    #IANContainer .value {
        border-bottom: 1px solid #08549c;
        padding: 8px;
        xpadding-bottom: 4px;
        margin-bottom: 10px;
        overflow: hidden;
    }
    .value img {
        width: 90%;
        border: 1px solid orange;
    }
    #Dateien {
        height:calc(100% - 120px);
    }
    #stammdaten {
        min-width: 800px;
        border: 2px solid dodgerblue;
        padding: 20px;
        display: grid!important;
        grid-template-columns: minmax(150px, 10%) minmax(250px, 10%) minmax(150px, 10%) minmax(250px, 10%);
        font-family: arial;
        font-size: 0.8em;
    }
    #stammdaten .label {
        border: 1px solid darkgray;
        background-color: lightgray;
        padding: 8px;
        font-weight: bold;
    }
    #stammdaten .value {
        border: 1px solid darkgray;
        padding: 8px;
    }
    .header1 {
        padding-top: 5px;
        padding-bottom: 8px;
        border: none;
        text-decoration: none;
        color: #08549c;
        margin-left:15px;
        font-size: 1.5em;
    }
    .header2 {
        padding-top: 0px;
        padding-bottom: 8px;
        border: none;
        font-size: 1em;
    }
    .ianTable {
        border-collapse: collapse;
        width: 90%;
        font-size:1em;
    }
    .ianTable th {
        border: 1px solid gray;
        background-color: lightgray;
        text-align: left;
        padding: 10px;
    }
    .ianTable td {
        border: 1px solid gray;
        text-align: left;
        padding: 10px;
    }
    #picLidl {
        border: none;
        float: left;
        width: 25%;
        overflow: hidden;
        padding-left: 15px;
    }
    #topLidl {
        border: none;
        min-height: 365px;
        margin-bottom: 20px;
    }
    #picLidl img {
        height: 95%;
        max-height: 280px;
    }
    #infoLidl {
        border: none;
        float: left;
        width: 70%;
        height: 700px:
    }
    #IANTableContainerQual {
        width: calc(100% - 30px);
        border: none;
        padding: 5px;
        padding-left:10px;
        display: grid;
        grid-template-columns: minmax(100px, 5%) repeat(10,minmax(8%, 15%));
        font-family: arial;
        font-size: 0.8em;
        margin-bottom: 10px;
    }
    #IANTableContainerAuftragsabwicklung {
        width: calc(100% - 30px);
        border: none;
        padding: 5px;
        padding-left:10px;
        display: grid;
        grid-template-columns: minmax(100px, 10%)  minmax(200px,20%) ;
        font-family: arial;
        font-size: 0.8em;
        margin-bottom: 10px;
    }
    #IANTableContainerQual .label {
        border-bottom: 1px solid #08549c;
        background-color: lightblue;
        padding: 8px;
        xpadding-bottom: 4px;
        font-weight: bold;
        color: #08549c;
        margin-bottom: 10px;
        overflow: hidden;
    }
    #IANTableContainerAuftragsabwicklung .label {
        border-bottom: 1px solid #08549c;
        background-color: white;
        padding: 8px;
        xpadding-bottom: 4px;
        font-weight: bold;
        color: #08549c;
        margin-bottom: 10px;
        overflow: hidden;
    }
    #IANTableContainerQual .value {
        border-bottom: 1px solid #08549c;
        padding: 8px;
        background-color: #f2f2f2;
        xpadding-bottom: 4px;
        margin-bottom: 10px;
        overflow: hidden;
    }
    #IANTableContainerAuftragsabwicklung .value {
        border-bottom: 1px solid #08549c;
        padding: 8px;
        background-color: white;
        xpadding-bottom: 4px;
        margin-bottom: 10px;
        overflow: hidden;
    }
    #IANTableContainerSort {
        border:1px solid lightgray;
        width:calc(100% - 30px);
        font-family:arial;
        font-size:0.8em;
    }
    #tableSort {
        border-collapse:collapse;
        font-size:1em;
    }
    #tableSort_th{
        border:1px solid lightgray;;
        padding:10px;
        width:30%;
        font-size:0.9em;
        text-align:left;
    }
    .tableSort_th_small {
        border:1px solid lightgray;;
        padding:10px;
        width:20px;
        font-size:0.9em;
        text-align:left;
    }
    #tableSort td{
        border:1px solid lightgray;;
        padding:10px;
        Font-size:1em;
        text-align:left;
    }
    #hlSort {
        border: 1px solid lightgray;
        font-size:1.1em;
        padding-top:15px;
        padding-bottom:15px;
        padding-left:5px;
        background-color:#f2f2f2;
    }
    #quantity {
        border-collapse:collapse;
        font-size:0.8em;
    }
    .tgTableHeads  {
        border: 1px solid lightgray;
        background-color: #f2f2f2;
        padding: 8px;
    }
    .tgTableTD { 
        border:1px solid lightgray;
        padding:8px;
    }
    .tgTableTDResult {
        padding:8px; 
        background-color:#ddd;
        border:1px solid gray;
    }
    .tgImage {
        height: auto; 
    }
    .tgTableAllgemein {
        border-collapse:collapse;
        font-size:1em;
    }
    .tgButton {
        padding:8px;
        background-color:lightgray;
        border:none;
        color:black;
        font-weight:bold;
        border:1px solid gray;
        font-size:0.8em
    }
    .tgH3 {
        color: #1C73C5;
        font-size:2em;
        padding-bottom:10px;
    }
    .tgCheckbox {
        width:20px;
        height:20px;
    }
    #infoLidl textarea {
        border:none;
        border-bottom:2px double  #08549c;
        padding:6px;
        height:60px; 
        resize:none;
    }
    #History {
        border:1px solid lightgray;
        width: 500px;
        height: 150px;
        padding:5px;
        font-size:0.8em;
        color:white;
        position:absolute;
        top:8%;
        left:20%;
        background-color: rgb(43, 89, 169,0.9);
        display:none;
        overflow:auto;
    }
      #History-Top {
        background-color: transparent;
    }
</style>
<script>
        window.DateienInit = false;
        $(function() {
            $("#tabs").tabs(2);
        });
        $(function() {
            $("#tabs").on('tabsactivate', function(event, ui) {
                //console.log('EVENT:' + event.target.id);
                if (ui.newPanel[0].id == 'Dateien'){
                    if(window.DateienInit){
                        return
                    }  else {
                        window.DateienInit = true;
                    }
                } 
                if (event.target.id == 'tabsFiles'){
                    return;
                }
                event.preventDefault();
                if (event.target.id != 'tabsRFQ'){
                    var inParams = {
                        tabid: ui.newPanel[0].id,
                        ppid: "{{ $data['pp']->PPProduktpass_Id }}",
                        lang: "{{ $data['lang'] }}"
                    };
                    //alert(JSON.stringify(inParams));
                    var params = JSON.stringify(inParams);
                    var tabid = ui.newPanel[0].id;
                    //alert(tabid);
                    $.ajax({
                        type: "POST",
                        url: "/content",
                        data: inParams,
                        success: function(data) {
                            console.log('Return: ' + tabid);
                            //console.log(data);
                            var t = '#' + tabid;
                            $(t).html(data);
                        }
                    });
                }
            });
        });
</script>
<?php $lang = $data['lang']; ?>
<div id="tabs" style='width:(100% - 20px);margin-top:20px;' >
    <ul>
        <li><a class='cref' href="#InfoLidl">{{ ServiceProvider::tl($data['lang'], 'LIDL-Info') }} [{{$data['pp']->PPProduktpass_IAN}}_{{substr($data['pp']->PPProduktpass_Ausmusterungnummer,0,4)}}]</a></li>
        <li><a class='cref'  href="#Dateien">{{ ServiceProvider::tl($data['lang'], 'Dateien') }}</a></li>
        @if(false)
        <li><a class='cref'  href="#ProduktpassEdit">{{ ServiceProvider::tl($data['lang'], 'Produktpass Edit') }}</a></li>
        <li><a class='cref'  href="#MeetingProtokoll">{{ ServiceProvider::tl($data['lang'], 'Meeting Protokoll') }}</a></li>
        <li><a class='cref'  href="#Notizen">{{ ServiceProvider::tl($data['lang'], 'Notizen') }}</a></li>
        <li><a class='cref'  href="#ServiceAnfrage">{{ ServiceProvider::tl($data['lang'], 'Service Anfrage') }}</a></li>
        @endif
         @if (ServiceProvider::AuthUserHasRole('RFQ'))
        <li><a class='cref'  href="#RFQ">{{ ServiceProvider::tl($data['lang'], 'RFQ') }}</a></li>
        @endif
    </ul>
    <div class='divContainer' id="InfoLidl">
            @include ('ian.infoLidl')
    </div>
    <div class='divContainer' id="Dateien">
    @if (isset($data['deepLink']) and  $data['deepLink'] == 'Dateien')
        <div style='width:250px;heihght:100%;padding:10px;'>{{ ServiceProvider::tl($lang, 'Bitte auf Dateien warten...') }}</div>
    @else
        <div style='width:250px;heihght:100%;padding:10px;'>{{ ServiceProvider::tl($lang, 'Bitte warten...') }}</div>
    @endif
    </div>
    @if(false)
    <div class='divContainer' id="ProduktpassEdit"></div>
    <div class='divContainer' id="MeetingProtokoll"></div>
    <div class='divContainer' id="Notizen"></div>
    <div class='divContainer' id="ServiceAnfrage"></div>
    @endif
    @if (ServiceProvider::AuthUserHasRole('RFQ'))
    <div class='divContainer' id="RFQ"></div>
    @endif
</div>
<script>
    function clickLink (){
        var user = '{{Auth::user()->PPMitarbeiter_Kuerzel}}';
        var deeplink = '{{isset($data["deepLink"])?$data["deepLink"]:"NoDeepLink"}}';
        //alert('Click: ' + deeplink);
        console.log('user: ' + user );
        console.log('deeplink: ' + deeplink );
        var links=document.getElementsByClassName('cref'), hrefs = [];
        for (var i = 0; i<links.length; i++)
        {   var str = links[i].href; 
            console.log(str.indexOf('#' + deeplink));
            if (str.indexOf('#' + deeplink) > 1){
                content(deeplink);
                console.log(i + ':'  + links[i] );
                links[i].click();
            }
        }
    }
    function content ( tabid ){
        var inParams = {
                        tabid: tabid,
                        ppid: "{{ $data['pp']->PPProduktpass_Id }}",
                        lang: "{{ $data['lang'] }}"
                    };
                    //alert(JSON.stringify(inParams));
        var params = JSON.stringify(inParams);
        var tabid = tabid;
        //alert(tabid);
        $.ajax({
            type: "POST",
            url: "/content",
            data: inParams,
            success: function(data) {
                console.log('Return: ' + tabid);
                //console.log(data);
                var t = '#' + tabid;
                $(t).html(data);
            }
        });
    }
    var deeplink = '{{isset($data["deepLink"])?$data["deepLink"]:"NoDeepLink"}}';
    if ( deeplink.length > 2){
        clickLink();
    }
     window.parent.document.title = "TPT IAN: {{$data['pp']->PPProduktpass_IAN}}_{{substr($data['pp']->PPProduktpass_Ausmusterungnummer,0,4)}}";
</script>