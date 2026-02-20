<style>
    #ausmusterungStamm {
        border: 1px solid lightgray;
        height: 987px;
        text-align: left;
        padding-left: 30px;
        ;
    }

    #ausmusterungStamm div {

        border-radius: 0px;
        text-align: left;
    }
</style>
<script>



    function clearFrm (){
       
        document.getElementsByName("submitArt")[0].value = 'enter'; 
        document.getElementById('ausminp').style.backgroundColor = 'white';
        document.getElementById('ausminp').value = '';

        var inputs = document.getElementsByClassName("inp1");
        console.log(inputs);
        for(i =0; i < inputs.length; i++) 
        {
           
            inputs[i].value = 0;
        }
        hideSaveButton();
    }   

    function submitFrm() {
        
        //alert("Value:" + document.getElementsByName("submitArt")[0].value); // = "show";
      
        var frm = document.getElementById('ausmfrm');
      
        document.getElementsByName("submitArt")[0].value = 'show'; 
       
        //alert("Value:" + document.getElementsByName("submitArt")[0].value); 
        
        
        frm.submit();

    }
    function hideSaveButton(){
        var svbtn = document.getElementById('ausmsave');
        svbtn.style.display = 'none';
    }
    
</script>

<div id="AusmusterungStamm">

    <form id="ausmfrm" action="/saveStammaus" method="post">
        <input type="hidden" name="submitArt" id="submitArt" value="save" />
        <h1>Logistik Pauschalen</h1>
     
        <div style="display:grid; grid-template-columns: 800px 800px;">

            <div style="padding:20px;">
                <div style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">



                    <h2>Ausmusterung</h2>
                    <div style="display:grid; grid-template-columns: 250px 150px 150px;">
                        <div>Ausmusterung</div>
                        <div><input  type="text" id="ausminp" style="width:100px;text-align:right;padding:4px; @if(strlen($stamm['ausmusterung']) == 4) background-color:lime; @endif" name='ausmusterung'
                                value="{{ $stamm['ausmusterung'] }}"  onfocus="clearFrm();" onchange="submitFrm();" /></div>
                        <div><button
                                style="padding:6x;width:100px; height:30px; background-color: dodgerblue; color:white;"
                                >anzeigen</button></div>
                    </div>


                    <h2>Kurs</h2>
                    <div style="display:grid; grid-template-columns: 250px 150px ">
                        <div>Kurs Ausmusterung</div> <input style="width:100px;text-align:right;padding:4px;"
                            name='kurs' value="{{ number_format($stamm['kurs'],4,',','.')  }}" />



                    </div>
                    <h2>Container Kosten</h2>

                    <div style="display:grid; grid-template-columns: 250px 150px 150px 150px;">

                        <div
                            style="border:1px solid gray;background-color:dodgerblue;color:white;font-weight:bolder;padding: 4px;">
                            Ladehafengruppe</div>
                        <div
                            style="border:1px solid gray;background-color:dodgerblue;color:white;font-weight:bolder;text-align: right;padding: 4px;">
                            Preis HQ</div>
                        <div
                            style="border:1px solid gray;background-color:dodgerblue;color:white;font-weight:bolder;text-align: right;padding: 4px;">
                            Preis 40'</div>
                        <div
                            style="border:1px solid gray;background-color:dodgerblue;color:white;font-weight:bolder;text-align: right;padding: 4px;">
                            Preis 20'</div>

                        @foreach ($stamm['preise'] as $grp => $arts)
                        <div style="border:1px solid gray;padding:4px;">Gruppe {{ $grp }}</div>
                        @foreach ($arts as $art => $preis)
                        <div style="border:1px solid gray;"><input class="inp1"
                                style="width:100%; border:none;text-align: right;padding:4px;"
                                name="preise[{{ $grp }}][{{ $art }}]" value="{{ number_format($preis,2,',','.') }}">
                        </div>
                        @endforeach
                        @endforeach
                    </div>

                
                </div>
            </div>
            <div style="position: relative;padding: 20px;">
                <h2>Standardwerte / Lokale Kosten</h2>
                <div style="display:grid; grid-template-columns: 250px 150px; grid-gap: 4px;">
                    <div>Kosten Löschhafen/Nachlauf</div>
                    <div><input class="inp1" style="width:100px;text-align:right;padding:4px;" name='kosten_nachlauf'
                            value="{{ number_format($stamm['kosten_nachlauf'],2,',','.')   }}" /></div>
                    <div>Kosten Entladung Lager</div>
                    <div><input class="inp1" style="width:100px;text-align:right;padding:4px;" name='kosten_entladung'
                            value="{{ number_format($stamm['kosten_entladung'],2,',','.')   }}" /></div>
                    <div>Finanzierungskosten (% ESP)</div>
                    <div><input class="inp1" style="width:100px;text-align:right;padding:4px;" name='kosten_finanzierung'
                            value="{{ number_format($stamm['kosten_finanzierung'],2,',','.')   }}" /></div>
                    <div>Sonstige Kosten (% VK)</div>
                    <div><input class="inp1" style="width:100px;text-align:right;padding:4px;" name='kosten_sonstigeVK'
                            value="{{ number_format($stamm['kosten_sonstigeVK'],2,',','.')   }}" /></div>
                </div>
                @if(strlen( $stamm['ausmusterung']) == 4 and Auth::User()->PPMitarbeiter_Gruppe  == 'admin')
                <button id="ausmsave"
                    style="margin: 0px auto; position:absolute; bottom: 0px;  padding:6x;width:390px; height:30px; background-color: dodgerblue; color:white;" type="submit"
                    name="action" value="save">Speichern</button>
                @endif
            </div>
        </div>
    </form>
</div>

