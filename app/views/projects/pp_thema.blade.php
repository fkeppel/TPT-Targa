<style>
   
  #Thema label {
        border-radius:0px;
        width:200px;
        --border: 1px solid #003D7C;
        border: none;
        
        padding:8px;
        color:var(--tgBlue);
        background-color:white; 
    }
    #Thema input {
        border-radius:0px;
        width:200px;
        border: 1px solid lightgray;
        padding:8px;
        color:black;
        background-color:white;
    }

    #Thema select {
        border-radius:0px;
        width:200px;
        border: 1px solid lightgray;
        padding:8px;
        color:black;
        background-color:white;
    }

    #Thema fieldset {
            padding:20px;
    }

    #NeuArtikel  input {
        height:100%;
        margin:0px;
        width: 100%;
       
        padding: 5px;
    }
    #NeuArtikel  textarea {
        border-radius: 0px;
        height:100%;
        margin:0px;
        width: 100%;
        
        padding: 5px;
    }

    #NeuArtikel  div {
        padding:0px;
       
        border-radius:0px;
    }
    
    #produktvorschlag {
        border-radius:0px !important;
    }
    #produktvorschlag select {
        padding:5px;
    }



    #ArtikelPos  input {
        height:100%;
        margin:0px;
        width: 100%;
       
        padding: 5px;
    }
    #ArtikelPos  textarea {
        border-radius: 0px;
        height:100%;
        margin:0px;
        width: 100%;
        
        padding: 5px;
    }

    #ArtikelPos  div {
        padding:0px;
       
        border-radius:0px;
    }

    #NeuArtikel, #ArtikelPos {
        column-gap: 10px;
        border:1px solid red;
        row-gap: 10px;
        border-radius: 0px;
        display:grid;
        grid-template-columns:10% 12% 10% 12% 10% 12%;
    }
</style>
<div id="Thema" style="border:none; border-radius: 0px; height:840px;overflow: auto;">

    <form action="/drop" method="post" class="dropzone" id="my-awesome-dropzone" enctype="multipart/form-data" >
        <fieldset>
        <input type="hidden" name="ppid" id="ppid" value="{{$data['pp']['PPProduktpass_Id']}}">

        <div id="NeuArtikel">
            <div><label>Lieferant</label></div>
            <div><input name="Art[Lieferant]" type="text" value=""/></div>
            <div><label>Referenznummer</label></div>
            <div><input  type="text" value=""/></div>
            <div><label>Datum</label></div>
            <div><input  type="text" value=""/></div>

            <div><label>Themennummer</label></div>
            <div><input  type="text" value=""/></div>
            <div><label>Thema</label></div>
            <div><input  type="text" value=""/></div>
            <div><label>Produktvorschlag</label></div>
            <div id="produktvorschlag"><select >
                <option>LIDL</option>
                <option>Lieferant</option>
                <option>nicht relevant</option>
            </select></div>

            <div><button type="submit" id='sbmtbtn'> SENDEN</button> </div>
            <div style="grid-column: 2 / span 3">
            <div id="dropzone-previews" style="height:200px;border:1px solid red;"></div>
           
            </div>
        
            <div><label>Begründung</label></div>
            <div style="height:60px;"><textarea></textarea></div>

            

            <div><label>Projektbezeichnung</label></div>
            <div><input  type="text" value=""/> </div>
            <div><label>Zertifizierung</label></div>
            <div><input  type="text" value=""/> </div>
            <div><label>Ländervorschläge</label></div>
            <div><input  type="text" value=""/> </div>
            
            <div><label>VE</label></div>
            <div><input  type="text" value=""/> </div>
            <div><label>Angebotspreis/Mischpreis</label></div>
            <div><input  type="text" value=""/> </div>
            <div><label>Incoterm</label></div>
            <div><input  type="text" value=""/> </div>
            
            <div style="grid-column: 1 / span 3;background-color:lightgray;height:30px;font-weight:bold;padding:6px;border:1px solid gray;">Geplante Produktionsstätte</div>
            <div style="grid-column: 4 / span 3;background-color:lightgray;height:30px;font-weight:bold;padding:6px;border:1px solid gray;">Alternative Produktionsstätte</div>
            
            <div><label>Name</label></div>
            <div style="grid-column: 2 / span 2;"><input  type="text" value=""/> </div>
            <div><label>Name</label></div>
            <div style="grid-column: 5 / span 2;"><input  type="text" value=""/> </div>
       
            <div><label>Adresse</label></div>
            <div style="grid-column: 2 / span 2;height:60px;"><textarea  type="text" style="height:55px;"></textarea></div>
            <div><label>Adresse</label></div>
            <div style="grid-column: 5 / span 2;height:60px;"><textarea  type="text" style="height:55px;"></textarea></div>

            <div style="height:30px;"><label>Lidl ID</label></div>
            <div style="grid-column: 2 / span 2;"><input  type="text" value="" style="height:30px;width:124px;"/> <label style="width:80px;">Status</label><input  type="text" value="" style="width:50px;"/></div>
            <div style="height:30px;"><label>Lidl Id</label></div>
            <div style="grid-column: 5 / span 2;"><input  type="text" value="" style="height:30px;width:124px;"/> <label style="width:80px;">Status</label><input  type="text" value="" style="width:50px;"/></div>
        </div>

        </fieldset>
    </form>


    <form action="/updateThemaPos" method="post">
        <fieldset>
            <input type="hidden" name="ppid" id="ppid" value="{{$data['pp']['PPProduktpass_Id']}}">
            <input type="hidden" name="ppid" id="artposid" value="">
            <div id="ArtikelPos">
                
                <div><label>Bezeichnung</label></div>
                <div style="grid-column: 2 / span 2;"><input  type="text" value=""/> </div>
                <div><label>Referenz</label></div>
                <div style="grid-column: 5 / span 2;"><input  type="text" value=""/> </div>


                <div><label>Gewicht</label></div>
                <div><input  type="text" value=""/> </div>
                <div><label>Größe</label></div>
                <div><input  type="text" value=""/> </div>
                <div><label>Gewichtung</label></div>
                <div><input  type="text" value=""/> </div>

             
                <div><label>Einzel-EK</label></div>
                <div><input  type="text" value=""/> </div>
                <div><label>UVP</label></div>
                <div><input  type="text" value=""/> </div>
                <div></div>
                <div></div>


                <div><label>Abbildung</label></div>
                <div style="grid-column: 2 / span 2;"><a href="http://targa-test.twoffice.de/data/uploads/pcmbRv_1671007664_SEUSTER_10X5_Blue.jpg" target="_blank"><img src="http://targa-test.twoffice.de/data/uploads/pcmbRv_1671007664_SEUSTER_10X5_Blue.jpg" style="width:100%;"/></a></div>
                <div><label>Qualität</label></div>
                <div style="grid-column: 5 / span 2;"><textarea></textarea> </div>

            </div>

        </fieldset>
    </form>
</div>

<script>
   
   /* Start  */
   Dropzone.autoDiscover = false;

var dzoptions = {
  
  autoProcessQueue: false,
  paramName: "file",
  maxFilesize: 10,
  url: '/drop',
  previewsContainer: "#dropzone-previews",
  uploadMultiple: true,
  parallelUploads: 5,
  maxFiles: 20,
  init: function() {
    var cd;

    //Anfang
    var myDropzone = this;
    $("#sbmtbtn").on('click',function(e) {
               console.log('SUBMIT');
               e.preventDefault();
               myDropzone.processQueue(); 
               //$('form#my-awesome-dropzone').submit();
            });      
            this.on('sending', function(file, xhr, formData) {
            // Append all form inputs to the formData Dropzone will POST
            var data = $('#my-awesome-dropzone').serializeArray();
            $.each(data, function(key, el) {
                formData.append(el.name, el.value);
            });
        });

    //Ende

    this.on("success", function(file, response) {
      $('.dz-progress').hide();
      $('.dz-size').hide();
      $('.dz-error-mark').hide();
      console.log(response);
      console.log('FILE:');
      console.log(file);
      cd = response;
      //Location.reload();
    });

    this.on("addedfile", function(file) {
      var removeButton = Dropzone.createElement("<a href=\"#\">Datei entfernen</a>");
      var _this = this;
      removeButton.addEventListener("click", function(e) {
        e.preventDefault();
        e.stopPropagation();
        _this.removeFile(file);
        var name = "largeFileName=" + cd.pi.largePicPath + "&smallFileName=" + cd.pi.smallPicPath;
        $.ajax({
          type: 'POST',
          url: 'DeleteImage',
          data: name,
          dataType: 'json'
        });
      });
      file.previewElement.appendChild(removeButton);
    });
  }
};
//Dropzone.options.myAwesomeDropzone = options;  // works only with autodiscover
var myDropzone1 = new Dropzone("form#my-awesome-dropzone", dzoptions);
//dzoptions.url = "/drop";
//var myDropzone2 = new Dropzone("div#myId", dzoptions);

</script>