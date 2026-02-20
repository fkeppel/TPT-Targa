<!DOCTYPE html><html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TARGA Test {{$data['pp']->PPProduktpass_IAN}}</title>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
  <script>
    $(function() {
      $("#tabs").tabs();
    } );
    $(function() {          
      $("#tabs").on('tabsactivate', function (event, ui) { 
        event.preventDefault();
        var inParams = { tabid:ui.newPanel[0].id, ppid:"{{$data['pp']->PPProduktpass_Id}}", lang:"{{$data['lang']}}"};
        //alert(JSON.stringify(inParams));
        var params = JSON.stringify(inParams);
        var tabid=ui.newPanel[0].id;
        //alert(tabid);
        $.ajax({
          type: "POST",
          url: "/content",
          data: inParams,
          success: function (data) {
              var t = '#' + tabid;
              console.log(t);
              $(t).html(data);
          }
        });
      }); 
    });  
</script>
<style>
    #tabs {
      margin-top:18px;
      width:98%;
      overflow:auto;
      border:none;
      height:98%;
    }
    #tabs .divContainer {
      border:1px solid lightgray;
      overflow-y:auto;
      overflow-x:hidden;
      max-height:calc(100vh - 150px);
      height:90%;
    }
    .divContainer h5 {
      color:#08549c;
      text-decoration: underline;
      text-decoration-thickness: 2px;
      margin:8px;
      margin-top:20px;
      font-size:1em;
      font-weight:bolder;
    }
    .btn {
      width:55px;
      height:15px;
      float: left;
      border:1px solid gray;
      color:#08549c;
      text-align:center;
      vertical-align:middle;
      padding:4px;
      margin:5px;
      font-family:arial;
      font-weight:bold;
      background-color:lightgray;
      font-size:12px;
    }
        #IANContainer {
                width: 100%;
                border:none;
                padding: 5px;
                display:grid;
                grid-template-columns: minmax(8%, 15%) minmax(10%, 15%) 25px minmax(8%, 15%) minmax(10%, 15%) 25px minmax(8%, 15%) minmax(10%, 15%) 25px;
                font-family: arial;
                font-size:0.8em;
                margin-bottom:10px;
        }
        #IANContainer .label {
                border-bottom:1px solid #08549c;
                background-color:white;
                padding:8px;
                xpadding-bottom:4px;
                font-weight:bold;
                color: #08549c;
                margin-bottom:10px;
                overflow:hidden;
        }
        #IANContainer .value {
                border-bottom:1px solid #08549c;
                padding:8px;
                xpadding-bottom:4px;
                margin-bottom:10px;
                overflow:hidden;
        } 
        .value img {
            width:90%;
            border:1px solid orange;
        }
         #stammdaten {
                width: 80%;
                min-width: 800px;
                border:2px solid dodgerblue;
                padding: 20px;
                display:grid;
                grid-template-columns: minmax(150px, 10%)  minmax(250px, 10%) minmax(150px, 10%) minmax(250px, 10%) ;
                font-family: arial;
                font-size:0.8em;
    }
    #stammdaten .label {
            border:1px solid darkgray;
            background-color:lightgray;
            padding:8px;
            font-weight:bold;
    }
    #stammdaten .value {
            border:1px solid darkgray;
            padding:8px;
    }
    .header1 {
            padding-top:5px;
            padding-bottom:8px;
            border:none;
            font-size:1em;
    }
    .header2 {
            padding-top:15px;
            padding-bottom:8px;
            border:none;
            font-size:1em;
    }
    .ianTable {
        border-collapse:collapse;
        width:90%;
    }
    .ianTable th {
        border:1px solid gray;
        background-color:lightgray;
        text-align:left;
        padding:10px;
    }   
    .ianTable td {
        border:1px solid gray;
        text-align:left;
        padding:10px;
    }
    #PPEditContainer {
            width: 100%;
            border:10px solid red;
            padding: 5px;
            display:grid;
            grid-template-columns: minmax(8%, 15%) minmax(10%, 15%) 25px;
            font-family: arial;
            font-size:0.8em;
            margin-bottom:10px;
    }
    #PPEditContainer .label {
            --border-bottom:1px solid #08549c;
            border:4px solid blue;
            background-color:white;
            padding:8px;
            xpadding-bottom:4px;
            font-weight:bold;
            color: #08549c;
            margin-bottom:10px;
            overflow:hidden;
    }
    #PPEditContainer .value {
            --border-bottom:1px solid #08549c;
            border:4px solid lime;
            padding:8px;
            xpadding-bottom:4px;
            margin-bottom:10px;
            overflow:hidden;
    } 
  </style>
</head>
<body>
<?php $lang = $data['lang']?>
<h1>HALLO</h1>
<div id="tabs">
  <ul>
    <li><a href="#Allgemein">AllgemeinB</a></li>
    <li><a href="#Stammdaten">Stammdaten</a></li>
    <li><a href="#Qualität">Qualität</a></li>
    <li><a href="#Sortierung">Sortierung</a></li>
    <li><a href="#Menge">Menge</a></li>
    <li><a href="#Bestellübersicht">Bestellübersicht</a></li>
    <li><a href="#Auftragsabwicklung">Auftragsabwicklung</a></li>
    <li><a href="#Produktpass">Produktpass</a></li>
    <li><a href="#Dateien">Dateien</a></li>
    <li><a href="#Meeting">Meeting</a></li>
  </ul>
  <div class='divContainer' id="Allgemein">
    @include ('ian.auftragsinfo')
  </div>
  <div class='divContainer'  id="Produktpass"></div>
  <div class='divContainer'  id="Stammdaten"></div> 
  <div class='divContainer'  id="Qualität"></div> 
  <div class='divContainer'  id="Sortierung"></div> 
  <div class='divContainer'  id="Menge"></div> 
  <div class='divContainer'  id="Bestellübersicht"></div> 
  <div class='divContainer'  id="Auftragsabwicklung"></div>
  <div class='divContainer'  id="Dateien"></div>
  <div class='divContainer'  id="Meeting"></div>
</div>
</body></html>
