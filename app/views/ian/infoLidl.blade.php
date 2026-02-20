<div  id='topLidl'>
  @include ('ian.Allgemein')
</div>
<div class='divContainer' id="infoTabs">
  <ul>
    <li><a href="#StammdatenLidl">{{ ServiceProvider::tl($data['lang'], 'Stammdaten') }}</a></li>
    <li><a href="#QualitaetLidl">{{ ServiceProvider::tl($data['lang'], 'Qualität') }}</a></li>
    <li><a href="#SortierungLidl">{{ ServiceProvider::tl($data['lang'], 'Sortierung') }}</a></li>
    <li><a href="#MengeLidl">{{ ServiceProvider::tl($data['lang'], 'Menge') }}</a></li>
    <li><a href="#BestelluebersichtLidl">{{ ServiceProvider::tl($data['lang'], 'Bestellübersicht') }}</a></li>
    <li><a href="#AuftragsabwicklungLidl">{{ ServiceProvider::tl($data['lang'], 'Auftragsabwicklung') }}</a></li>
    <li><a href="#Themenplanung">{{ ServiceProvider::tl($data['lang'], 'Themenplanung') }}</a></li>
  </ul>
  <div class='divContainer'  id="StammdatenLidl">
     @include('ian.artikelstamm')
  </div> 
  <div class='divContainer'  id="QualitaetLidl">
     Qualität  
  </div> 
  <div class='divContainer'  id="SortierungLidl">
   Sortierung
  </div> 
  <div class='divContainer'  id="MengeLidl">
    Menge
  </div> 
  <div class='divContainer'  id="BestelluebersichtLidl">
    Bestellübersicht
  </div> 
  <div class='divContainer'  id="AuftragsabwicklungLidl">
    Auftragsabwicklung
  </div>
  <div class='divContainer'  id="Themenplanung">
    Themenplanung
  </div>
</div>
<script>
    $(function() {
      $( "#infoTabs" ).tabs();
    } );
    $(function() {          
      $("#infoTabs").on('tabsactivate', function (event, ui) { 
        event.preventDefault();
        var tabid2=ui.newPanel[0].id;
        var inParams = { tabid:tabid2, ppid:"{{$data['pp']->PPProduktpass_Id}}", lang:"{{$data['lang']}}"};
        //console.log('inParams:');
        //console.log( inParams);
        $.ajax({
          type: "POST",
          url: "/content",
          data: inParams,
          success: function (data) {
              console.log(tabid2);
              var t = '#' + tabid2;
              $(t).html(data);
          }
        });
      }); 
    });
</script>