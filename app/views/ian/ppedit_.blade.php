<div>
    <h1>Änderungen Produktpass</h1> 
    <div style='width:90%;height:80%;overflow:auto;'>
        <form method='post' action='storePP'>
            <input type='hidden' name='PP[Key]' value='{{ $data['pp']->PPProduktpass_Id }}' /> 
            <table>
            <tr>
            <td>Artikel Targa</td>
            <td><input style='width:40%;' name='PP[PPProduktpass_ArtikelTarga]' value='{{ $data['pp']->PPProduktpass_ArtikelTarga }}' /></td>
            </tr>
            <td>Warengruppe</td>
            <td><input style='width:40%;' name='PP[PPProduktpass_ArtikelTarga]' value='{{ $data['pp']->PPProduktpass_ArtikelTarga }}' /></td>
            </table>
            <div style='border:1px solid gray;'>Artikel Targa:  </div>
            <div style='border:1px solid gray;'>Warengruppe: <input style='width:40%;' name='PP[PPProduktpass_WAWIArtikelnummer]' value='{{ $data['pp']->PPProduktpass_WAWIArtikelnummer }}' /> </div>
            <button type='button' onclick='sbm();'>speichern</button>
            <button type='button' onclick='hide();'>löschen</button>
        </form>
    </div>
    <div id='Message'></div>
</div>
<script>
    function show (message){
        var msg = document.getElementById('Message');
        msg.style.cssText ='border:2px solid green;';
        msg.innerHTML='<h1>'+ message +'</h1>';
    }
    function hide (){
        var msg = document.getElementById('Message');
        msg.style.cssText ='border:none;';
        msg.innerHTML='';
    }
    function sbm (){
        var atts = document.querySelectorAll("[name^='PP[']");
        var params = {};
        for(i=0; i<atts.length;i++){
            var att = atts[i].name.replace('PP[','');
            att = att.replace(']','');
            params[att] = atts[i].value;
        }
        params1 = JSON.stringify(params);
        store(params1);
    }
    function store(params){
        console.log(params);
        $.ajax({
          type: "POST",
          url: "storePPX",
          data: { params: params },
          cache:false,
          success: function (data) {
            var res = data['result'];
            console.log(data);
            if (res == 'OK'){
                show('Gespeichert liebe Leute');
                setTimeout(hide, 1000);
            } else {
                show('nicht Gespeichert');
            }
          },
          error: function (jqXHR, textStatus, ex) {
                    alert(textStatus + "," + ex + "," + jqXHR.responseText);
        }
        });
    }
</script>