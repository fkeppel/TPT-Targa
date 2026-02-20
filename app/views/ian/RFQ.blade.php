<style>
    .container {
        display: grid;
        border-radius: 0px;
        grid-template-columns: 20% 35% 35% 8%;
        overflow: auto;
        margin-left:10px;
        padding:30px;
        font-size:0.9em;
    }
    .item {
        height:220px;
        border:1px solid gray;
        border-radius: 0px;
        text-align: left;
        font-size:0.95em;
    }
   .item textarea {
        padding: 8px;
        border: none;
        --width: calc(100% - 13px);
        --height: calc(100% - 16px);
        width: 100%;
        height: 100%;
        font-size:1em;
    }
    #RFQ textarea {
        border-radius:0px;
        margin:0px;
        font-size:0.95em;
    }
</style>
<?php 
    $coord = array();
    $coord['PPProduktpass_Artikelbezeichnung'] =  'Artikelbezeichnung';
    $coord['PPProduktpass_IAN'] = 'IAN / Musterung';
    $coord['weightWithoutPackaging'] =  'Gewicht (ohne Verpackung)';
    $coord['sizeWithoutPackaging'] =  'Größe (ohne Verpackung)';
    $coord['qualityTechnicalData'] =  'Qualität/Technische Daten';
    $coord['additionalQualityInformation'] =  'Fortsetzung Qualität';
    $coord['changesFromPredecessor'] =  'Änderungen vom Vorgänger';
    $coord['brandReference'] =  'Markenreferenz';
    $coord['material'] =  'Material';
    $coord['materialThickness'] =  'Materialstärke';
    $coord['color'] =  'Farbe';
    $coord['PPProduktpass_Materialstaerke_der_Verkaufsverpackung'] =  'Materialstärke der Verpackung';
    $coord['retailPackagingComment'] =  'Bemerkung Verpackung';
    $coord['kolliinhalt'] =  'Kolliinhalt';
    $color[''] = '';
    $color['OK'] = 'green';
    $color['New'] = 'green';
    $color['Reset'] = 'green';
    $color['Change'] = 'orange';
    $lang = $data['lang'];
?>
<div id="RFQ" style="width:calc(100% - 20px); max-width:1920px; text-align:left; padding-left:25px; padding-top:25px; text-align:left; border-radius:0px;">
    <form action="/saveTranslation" method="POST">
        <div style="text-align:left;">
            <div style='padding-left:10px;'>
                <div style="float: left;width:200px;"><h5 style='margin-top:8px;font-size:1.5em;'>RFQ</h5></div>   
                <div style="float: left;width:1200px;">
                    <button  class='tgButton' type="submit" name="submitType" value="save" style="width:200px;margin-top:10px;margin-left:30px;"><b>{{ ServiceProvider::tl($lang,'Speichern')}}</b></button>
                    <button  class='tgButton' type="submit" name="submitType" value="reset" style="width:250px;margin-top:10px;margin-left:30px;"><b>{{ ServiceProvider::tl($lang,'Alles neu übersetzen')}}</b></button>
                    <a href="/downloadRFQ/{{$data['pp']->PPProduktpass_Id}}/E"><button  class='tgButton' type="button" style="width:200px;margin-top:10px;margin-left:30px;">{{ ServiceProvider::tl($lang,'Entwurf RFQ-Excel')}}</button></a>
                    <a href="/downloadRFQ/{{$data['pp']->PPProduktpass_Id}}/R"><button  class='tgButton' type="button" style="width:200px;margin-top:10px;margin-left:30px;">{{ ServiceProvider::tl($lang,'Release RFQ-Excel')}}</button></a>
                </div>
            <div style="clear: both;"></div>
            </div>
            <input type="hidden" name="ppid" value="{{$data['pp']->PPProduktpass_Id}}" />
            <div id="tabsRFQ" style='width:calc(100% - 20px);'>
                <ul>
                    <li>
                        <a href="#main">{{$data['pp']->PPProduktpass_IAN}}</a>
                    </li>
                    @foreach ($data['translation']['Styles'] as $styleId =>  $style)
                    <li>
                        <a href="#style_{{$styleId}}">{{$styleId}}</a>
                    </li>
                    @endforeach
                </ul>
                <div id="main" style="text-align: left;">
                    <div class="container" >
                        @foreach ($data['translation']['WebTab'] as $key =>  $trans)
                            <div class="item" style="">
                                <div style="padding-top:15px;padding-left:10px;height:{{ 20 * $trans['RowCount'] }}px;"><b>{{ ServiceProvider::tl($lang,$coord[$key]) }}</b></div>
                            </div>
                            <div class="item" style="background-color:lightgray;" >
                                <textarea style="display:none;" name="DE[{{$trans['ID']}}]">{{$trans['DE']}}</textarea>
                                <textarea  title="{{ $trans['OLDDE'] }}" disabled style="background-color:transparent;" >{{$trans['DE']}}</textarea>
                            </div>
                            <div class="item" style="">
                                <?php  
                                    $bg="background-color:transparent   ;";
                                    if (substr($trans["EN"],0,14) == "Not Translated"){
                                        $bg='background-color:plum;';
                                    }
                                ?>
                                <textarea style="{{$bg}} width:100%; height:100%;" name="EN[{{$trans['ID']}}]" >{{$trans['EN']}}</textarea>
                            </div>
                            <div class="item" style="padding:0px;">
                                <div style="border-radius:0px; background-color:{{ $color[$trans['Status']] }};">&nbsp;</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @foreach ($data['translation']['Styles'] as $styleId =>  $style)
                <div id="style_{{$styleId}}" style="overflow:auto;text-align: left;">
                    <div class="container" >
                        @foreach ($style as $key =>  $trans)
                            <div class="item" style="">
                                <div style="padding-top:15px;padding-left:10px;height:{{ 20 * $trans['RowCount'] }}px;"><b>{{ ServiceProvider::tl($lang,$coord[$key]) }}</b></div>
                            </div>
                            <div class="item" style="background-color:lightgray;padding:0px;" >
                                <textarea style="display:none;" name="DE[{{$trans['ID']}}]">{{$trans['DE']}}</textarea>
                                <textarea  title="{{ $trans['OLDDE'] }}" disabled style="background-color:transparent;width:100%; height:100%;" >{{$trans['DE']}}</textarea>
                            </div>
                            <div class="item" style="">
                                <?php  
                                $bg="background-color:transparent   ;";
                                if (substr($trans["EN"],0,14) == "Not Translated"){
                                    $bg='background-color:plum;';
                                }
                                    ?>
                                <textarea style="{{$bg}}" name="EN[{{$trans['ID']}}]">{{ $trans['EN']}}</textarea>
                            </div>
                            <div class="item" style="">
                                <div style="border-radius:0px; background-color:{{ $color[$trans['Status']] }};">&nbsp;</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </form>
</div>
<script>
    $(function () {
        console.log('tabsRFQ init');
        $("#tabsRFQ").tabs();
    });
</script>