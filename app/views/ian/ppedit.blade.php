<style>
    #PPEditContainer {
            width: calc (100% - 2px) ;
            border:none;
            padding: 5px;
            display:grid;
            grid-template-columns: minmax(10%, 15%) minmax(10%, 30%) 25px minmax(10%, 15%) minmax(10%, 30%) 25px;
            font-family: arial;
            font-size:0.8em;
            margin-bottom:10px;
    }
    #PPEditContainer .label {
            border-bottom:1px solid #08549c;
            background-color:white;
            padding:8px;
            font-weight:bold;
            color: #08549c;
            margin-bottom:10px;
            overflow:hidden;
            vertical-align:top;
            display: flex;
            align-items: top;
    }
    #PPEditContainer .value {
            border-bottom:1px solid #08549c;
            padding:8px;
            margin-bottom:10px;
            overflow:hidden;
    } 
    #PPEditContainer .value input { 
        border:none;
        background-color:#F1F1F1;
        width:90%;
        padding:8px;
    }
  </style>
<?php
    $lang = $data['lang'];
    $changeArtT = true;
    $titleArtT = '';
    if (is_null($data['pp']['PPProduktpass_ArtikelTarga']) or strlen(trim($data['pp']['PPProduktpass_ArtikelTarga'])) == 0) {
        if (strlen($data['Protokoll']['tPPProduktpass']['PPProduktpass_ArtikelTarga'])) {
            $titleArtT = $data['Protokoll']['tPPProduktpass']['PPProduktpass_ArtikelTarga'];
        }
        $changeArtT = false;
    }
    $tw = '';
    $ty = '';
    $change = false;
    if (strlen($data['Protokoll']['tPPProduktpass']['PPProduktpass_CRDWoche'])) {
        $tw = $data['Protokoll']['tPPProduktpass']['PPProduktpass_CRDWoche'];
        $change = true;
    }
    if (strlen($data['Protokoll']['tPPProduktpass']['PPProduktpass_CRDJahr'])) {
        $ty = $data['Protokoll']['tPPProduktpass']['PPProduktpass_CRDJahr'];
        $change = true;
    }
    $title = '';
    if ($change) {
        $title = $tw . ' ' . $ty;
    }
?>
<div>
    <h5 class='header1'>{{ ServiceProvider::tl($data['lang'], 'Editierbare Produktpass Daten')}}</h5>
    <div id="PPEditContainer"  style='padding-left:30px;'>
            <input id='PPProduktpass_Id' name='PPProduktpass_Id'  type="hidden" value='{{ $data['pp']['PPProduktpass_Id'] }}' /> 
            <div class='label'>IAN</div>
            <div class='value'><input id='PPProduktpass_IAN' name='PPProduktpass_IAN' value='{{ $data['pp']['PPProduktpass_IAN'] }}' /></div>
            <div></div>
            <div class='label'>{{ ServiceProvider::tl($lang,'Artikelbezeichnung LIDL')}}</div>
            <div  class='value'>{{ $data['pp']['PPProduktpass_Artikelbezeichnung'] }}</div>
            <div></div>
            <div class='label' style='position:relative;'>{{ ServiceProvider::tl($lang,'Artikelbezeichnung TARGA')}} 
                    <img id="ChangeMarker"  src="{{ url('/data/Icons/AusrufeZeichen.png') }}" title="{{ $titleArtT }}" style="position:absolute;top:0px;right:8px;height:20px!important;width:20px!important;margin-top:6px;border:none;  @if ($changeArtT) display:block; @else display:none; @endif" /> 
            </div>
            <div class='value'>
                <input id='PPProduktpass_ArtikelTarga'  name="PPProduktpass_ArtikelTarga" value='{{ $data['pp']['PPProduktpass_ArtikelTarga'] }}' />
            </div>
            <div></div>
            <div class='label'>{{ ServiceProvider::tl($lang,'Ausmusterungnummer')}}</div>
            <div class='value'><input id='PPProduktpass_Ausmusterungnummer' name='PPProduktpass_Ausmusterungnummer'   value='{{ $data['pp']['PPProduktpass_Ausmusterungnummer'] }}' />
            </div>
            <div></div>
            <div class='label'>{{ ServiceProvider::tl($lang,'Liefertermin (KW/Jahr)')}}</div>
            <div class='value'><input id='PPProduktpass_Liefertermin'   style='width:30px!important;text-align:right;'   value="{{ $data['pp']->PPProduktpass_Liefertermin }}" /> / <input id='PPProduktpass_LieferterminJahr'   style='width:45px!important;text-align:right;'  value="{{  $data['pp']->PPProduktpass_LieferterminJahr }}" /></div>
            <div></div>
            <div class='label' style='position:relative;'>{{ ServiceProvider::tl($lang,'CRD (KW/Jahr)')}}   
                @if ($change)
                    <img src="{{ url('/data/Icons/AusrufeZeichen.png') }}" title="{{ $title }}" style="position:absolute;top:0px;right:8px;height:20px!important;width:20px!important;margin-top:6px;border:none;"/>
                @endif
            </div>
            <div class='value'>
                <input id='PPProduktpass_CRDWoche'  style='width:30px!important;text-align:right;' value="{{ $data['pp']->PPProduktpass_CRDWoche }}" /> / <input id='PPProduktpass_CRDJahr'   style='width:45px!important;text-align:right;' value="{{ $data['pp']->PPProduktpass_CRDJahr }}" />
            </div>
            <div></div>
            <div class='label'>{{ ServiceProvider::tl($lang,'Projekt')}}</div>
            <div class='value'>
                <input id='PPProduktpass_PPProjekte_Projekt'  value="{{ $data['pp']->PPProduktpass_PPProjekte_Projekt }}" />
            </div>
            <div></div>
            @if (strlen($data['pp']['PPProduktpass_PPProjekte_Projekt']) > 2)
                    <div class='label'>{{ ServiceProvider::tl($lang,'Zugehörige IANs')}}</div>
                    <div class='value'>
                        <?php $i = 0; ?>
                        @foreach ($data['ProjektIANs'] as $prjId => $prjIAN)
                            <?php $i++; ?>
                            <div style="display:inline-block; padding:8px;"><a href="/show/{{ $prjId }}"  style="text-decoration:none;color:darkblue;"  target="_blank"><b>{{ $prjIAN }}</b></a></div>
                            @if (!($i % 8))
                                <br>
                            @endif
                        @endforeach
                    </div>
                    <div></div>
            @endif
            <div class='label'>{{ ServiceProvider::tl($lang,'Bereich')}}</div>
            <div class='value'>   
                <select id='PPProduktpass_ThemaScope'   style='width:230px!important;padding:6px;' titel="Bereich" >
                    <option></option>
                    @foreach($data['scopes'] as $scope)
                        <option @if ($data['pp']->PPProduktpass_ThemaScope == $scope) selected @endif>{{ $scope }}</option>
                    @endforeach
                </select>
                <!-- input id='PPProduktpass_ThemaScope'   style='width:230px!important;'   value="{{ $data['pp']->PPProduktpass_ThemaScope }}" / -->
            </div>
            <div></div>
            <div class='label'>Parent/Child</div>
            <div class='value'>
                <div style="width:400px;height:80px;float:left;text-align:left;padding:6px;">
                    <div style='text-align:left;float:left;'>
                        <input id='PPProduktpass_IsParent'  name='PPProduktpass_IsParent' type="checkbox"  @if ($data['pp']->PPProduktpass_IsParent) checked=checked @endif style='width:30px; height:20px;' />
                        <div style='display:inline-block;width:120px;font-weight:bold;padding-top:4px;'>Parent</div>
                    </div>
                    <div style='text-align:left;float:left;'>
                        <input id='PPProduktpass_IsChild'  name='PPProduktpass_IsChild' type="checkbox"  @if ($data['pp']->PPProduktpass_IsChild) checked=checked @endif style='width:30px; height:20px;' />
                        <div style='display:inline-block;width:120px;font-weight:bold;padding-top:4px;'>Child</div>
                    </div>
                    <div style='text-align:left;float:left;'>
                        <input id='PPProduktpass_IsKaufland'  name='PPProduktpass_IsKaufland' type="checkbox"  @if ($data['pp']->PPProduktpass_IsKaufland) checked=checked @endif style='width:30px; height:20px;' />
                        <div style='display:inline-block;width:120px;font-weight:bold;padding-top:4px;'>{{ ServiceProvider::tl($lang,'Nachbestellung')}}</div>
                    </div>
                    <div style='text-align:left;float:left;'>
                        <input id='PPProduktpass_IsUSA'  name='PPProduktpass_IsUSA' type="checkbox"  @if ($data['pp']->PPProduktpass_IsUSA) checked=checked @endif style='width:30px; height:20px;' />
                        <div style='display:inline-block;width:100px;font-weight:bold;padding-top:4px;'>USA {{ ServiceProvider::tl($lang,'Projekt')}}</div>
                    </div>
                </div>
            </div>
            <div></div>
            <div class='label'>{{ ServiceProvider::tl($lang,'Kritisches Projekt')}}</div>
            <div class='value' style='text-align:left;'>
                <input id='PPProduktpass_IsCriticalProject'  name='PPProduktpass_IsCriticalProject' type="checkbox"  @if ($data['pp']->PPProduktpass_IsCriticalProject == 1) checked=checked @endif style='width:30px; height:20px;' />
                <div style='display:inline-block;width:120px;font-weight:bold;padding-top:4px;'>kritisches Projekt</div>
            </div>
            <div></div>
            <div class='label'>Projekt Bild</div>
            <div  class='value'>
                <a href="/data/uploads/{{ $data['pp']['PPProduktpass_ProjektBild'] }}" target="_blank"><img
                        src="/data/uploads/{{ $data['pp']['PPProduktpass_ProjektBild'] }}"
                        style="margin:5px;border: 1px solid gray;width:200px;" /></a>
            </div>
            <div></div>
        <!-- /form -->
    </div>
    @if (Auth::User()->PPMitarbeiter_Gruppe != 'extern')
        <div style="margin:0 auto;text-align:left;width:110px; z-index: 100;padding-top:8px;border:none;height:80px;margin-left:0px;">
            <button onclick='savePP();'  style="width:200px;padding:10px;margin-top:10px;margin-left:30px;font-weight:bold;">{{ ServiceProvider::tl($lang,'speichern')}}</button>
        </div>
    @endif
</div>
<script>
    function IsChecked (cb){
        //console.log(cb);
        var aktiv = document.getElementById(cb).checked;
        console.log(aktiv);
        if (aktiv){
            return 1
        }
        return 0;
    }
    function setClearMarker(){
        var elem = document.getElementById('ChangeMarker');
        var val = document.getElementById('PPProduktpass_ArtikelTarga').value;
        if (val.length > 0) {
            elem.style.display = 'block';
        } else {
            elem.style.display = 'none';
        }
    }
    function savePP () {
        var url = '/updatePPAjax';
        var PPProduktpass_Id = $('#PPProduktpass_Id').val();
        var PPProduktpass_ArtikelTarga = $('#PPProduktpass_ArtikelTarga').val();
        var PPProduktpass_IAN = $('#PPProduktpass_IAN').val();
        var PPProduktpass_Ausmusterungnummer = $('#PPProduktpass_Ausmusterungnummer').val();        
        var PPProduktpass_Liefertermin = $('#PPProduktpass_Liefertermin').val();
        var PPProduktpass_LieferterminJahr = $('#PPProduktpass_LieferterminJahr').val();
        var PPProduktpass_CRDWoche = $('#PPProduktpass_CRDWoche').val();
        var PPProduktpass_CRDJahr = $('#PPProduktpass_CRDJahr').val();
        var PPProduktpass_PPProjekte_Projekt = $('#PPProduktpass_PPProjekte_Projekt').val();
        var PPProduktpass_IsParent = IsChecked('PPProduktpass_IsParent');
        var PPProduktpass_IsChild = IsChecked('PPProduktpass_IsChild');
        var PPProduktpass_IsKaufland = IsChecked('PPProduktpass_IsKaufland');
        var PPProduktpass_IsCriticalProject = IsChecked('PPProduktpass_IsCriticalProject');
        var PPProduktpass_IsUSA = IsChecked('PPProduktpass_IsUSA');
        //var PPProduktpass_IsCriticalProject = IsChecked('PPProduktpass_IsCriticalProject');
        var PPProduktpass_Ausmusterungnummer = $('#PPProduktpass_Ausmusterungnummer').val();
        var PPProduktpass_IAN = $('#PPProduktpass_IAN').val();
        var PPProduktpass_ThemaScope = $('#PPProduktpass_ThemaScope').val();
        var data = {    PPProduktpass_Id:PPProduktpass_Id,
                        PPProduktpass_ArtikelTarga:PPProduktpass_ArtikelTarga,  
                        PPProduktpass_IAN:PPProduktpass_IAN,  
                        PPProduktpass_Ausmusterungnummer:PPProduktpass_Ausmusterungnummer,  
                        PPProduktpass_Liefertermin:PPProduktpass_Liefertermin,
                        PPProduktpass_LieferterminJahr:PPProduktpass_LieferterminJahr,
                        PPProduktpass_CRDWoche:PPProduktpass_CRDWoche, 
                        PPProduktpass_CRDJahr:PPProduktpass_CRDJahr, 
                        PPProduktpass_PPProjekte_Projekt:PPProduktpass_PPProjekte_Projekt, 
                        PPProduktpass_IsParent:PPProduktpass_IsParent, 
                        PPProduktpass_IsChild:PPProduktpass_IsChild, 
                        PPProduktpass_IsKaufland:PPProduktpass_IsKaufland, 
                        PPProduktpass_IsUSA:PPProduktpass_IsUSA,
                        PPProduktpass_ThemaScope:PPProduktpass_ThemaScope,
                        PPProduktpass_IsCriticalProject:PPProduktpass_IsCriticalProject 
                          };
        console.log ('Parameter');
        console.log (data);
        $.ajax({
            url:url,    //the page containing php script
            type: "post",    //request type,
            dataType: 'json',
            data: data,
            success:function(data){
                console.log('Success');
                console.log(data);
                setClearMarker();
                alert('Gespeichert!');
            }
        });
    }
</script>