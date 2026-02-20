<style>
.container {
    width:1526px;
    display: grid;
    border-radius: 0px;
    grid-template-columns: 250px 600px 600px 50px;
    border:1px solid lightgray;
    height:715px;
    overflow: auto;
    margin-left:10px;
}
.item {
    height:120px;
    border:1px solid gray;
    border-radius: 0px;
    text-align: left;
}
.item textarea {
    padding:8px;
    border:none;
    height: 98%;
    width:100%;
}
#RFQ button {
    width: 250px;
    height: 50px;
    padding:8px;
}
#RFQ textarea {
    border-radius:0px;
    margin:0px;
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
$color['Change'] = 'orange';
?>
<div id="RFQ" style="width:2000px; height:880px; text-align:left; overflow:auto;border:1px solid lightgray; padding-left:25px; text-align:left; border-radius:0px;">
    <form action="/saveTranslation" method="POST">
        <div style="text-align:left;">
            <div style='padding:10px;'>
                <div style="float: left;width:200px;"><h1>RFQ</h1></div>   
                <div style="float: left;width:1200px;">
                    <button type="submit" name="submitType" value="save"><b>Speichern</b></button>
                    <button type="submit" name="submitType" value="reset"><b>Alles neu übersetzen</b></button>
                    <a href="/downloadRFQ/{{$data['pp']->PPProduktpass_Id}}/E"><button type="button">Entwurf RFQ-Excel</button></a>
                    <a href="/downloadRFQ/{{$data['pp']->PPProduktpass_Id}}/R"><button type="button">Release RFQ-Excel</button></a>
                </div>
            <div style="clear: both;"></div>
            </div>
            <input type="hidden" name="ppid" value="{{$data['pp']->PPProduktpass_Id}}" />
            <div id="tabsRFQ">
                <ul>
                    <li>
                        <a href="#main">{{$data['pp']->PPProduktpass_IAN}}</a>
                    </li>
                    @foreach ($data['translation']['Styles'] as $styleId =>  $style)
                    <li>
                        <a href="#style{{$styleId}}">{{$styleId}}</a>
                    </li>
                    @endforeach
                </ul>
                <div id="main" style="height:740px;overflow:auto;text-align: left;">
                    <div class="container" >
                        @foreach ($data['translation']['Main'] as $key =>  $trans)
                            <div class="item" style="min-height:{{ 20 * $trans['RowCount'] }}px;">
                                <div style="padding-top:15px;padding-left:10px;height:{{ 20 * $trans['RowCount'] }}px;"><b>{{$coord[$key]}}</b></div>
                            </div>
                            <div class="item" style="min-height:{{ 20 * $trans['RowCount'] }}px;background-color:lightgray;" >
                                <textarea style="display:none;" name="DE[{{$trans['ID']}}]">{{ $trans['DE']}}</textarea>
                                <textarea  title="{{ $trans['OLDDE'] }}" disabled style="background-color:transparent;" >{{ $trans["DE"]}}</textarea>
                            </div>
                            <div class="item" style="min-height:{{ 20 * $trans['RowCount'] }}px;">
                                <?php  
                                $bg="background-color:transparent   ;";
                                if (substr($trans["EN"],0,14) == "Not Translated"){
                                    $bg='background-color:plum;';
                                }
                                    ?>
                                <textarea style="{{$bg}}" name="EN[{{$trans['ID']}}]">{{ $trans["EN"]}}</textarea>
                            </div>
                            <div class="item" style="min-height:{{ 20 * $trans['RowCount'] }}px;">
                                <div style="border-radius:0px; background-color:{{ $color[$trans['Status']] }};">&nbsp;</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @foreach ($data['translation']['Styles'] as $styleId =>  $style)
                <div id="style{{$styleId}}" style="height:740px;overflow:auto;text-align: left;">
                    <div class="container" >
                        @foreach ($style as $key =>  $trans)
                            <div class="item" style="min-height:{{ 20 * $trans['RowCount'] }}px;">
                                <div style="padding-top:15px;padding-left:10px;height:{{ 20 * $trans['RowCount'] }}px;"><b>{{$coord[$key]}}</b></div>
                            </div>
                            <div class="item" style="min-height:{{ 20 * $trans['RowCount'] }}px;background-color:lightgray;" >
                                <textarea style="display:none;" name="DE[{{$trans['ID']}}]">{{ $trans['DE']}}</textarea>
                                <textarea  title="{{ $trans['OLDDE'] }}" disabled style="background-color:transparent;" >{{ $trans["DE"]}}</textarea>
                            </div>
                            <div class="item" style="min-height:{{ 20 * $trans['RowCount'] }}px;">
                                <?php  
                                $bg="background-color:transparent   ;";
                                if (substr($trans["EN"],0,14) == "Not Translated"){
                                    $bg='background-color:plum;';
                                }
                                    ?>
                                <textarea style="{{$bg}}" name="EN[{{$trans['ID']}}]">{{ $trans['EN']}}</textarea>
                            </div>
                            <div class="item" style="min-height:{{ 20 * $trans['RowCount'] }}px;">
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
                console.log('Tabs init');
                $("#tabsRFQ").tabs();
            });
</script>