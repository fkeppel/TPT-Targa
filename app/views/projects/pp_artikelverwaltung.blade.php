<style>
    #sizeTable {
        font-family: tahoma;
        font-size: 10px;
        border-collapse: collapse;
    }
    #sizeTable td {
        border:1px solid lightgray;
    }

    #articleDesc div{
        padding:10px;
        border: 1px solid darkorange;
        border-radius: 0px;
    }
</style>
<div id="articleDesc" style="border:1px solid lightgray;padding-top:0px;" >




    <form action="/createArtikelERP" method="post">

        <div></div>
        <input type="hidden" name="createArtikelPPID" value="{{$data['pp']->PPProduktpass_Id}}" />
        <button style="width:300px;height:50px;font-size: 14px;font-weight: bold;margin: 20px;" type="submit" value="Artikel anlegen">Artikel anlegen</button>
        <?php
        $msg     = Session::get('message');
        $color   = isset($msg['color']) ? $msg['color'] : "darkgray";
        $message = isset($msg['message']) ? $msg['message'] : "No message";
        ?>

        <p style="color:{{$color}};font-size:14px; font-weight: bold;margin-left: 20px;">{{$message}}</p>

    </form>


    <?php
    $sText   = '"' . $data['pp']->PPProduktpass_Marke . '"  - ' . $data['pp']->PPProduktpass_IAN . " " . $data['pp']->PPProduktpass_Artikelbezeichnung . "<br>";
    foreach ($data['qualitaet'] as $qual) {
        if (strlen(trim($qual->PPProduktpass_Qualitaet_Value01) > 0)) {
            if (strpos($qual->PPProduktpass_Qualitaet_Header, "Oberstoff") !== false) {
                $sText = $sText . 'Oberstoff: ' . trim($qual->PPProduktpass_Qualitaet_Value01);
            }
            if (strpos($qual->PPProduktpass_Qualitaet_Header, "chengew") !== false) {
                $sText .= "  Flächengewicht: " . trim($qual->PPProduktpass_Qualitaet_Value01) . "g/m²";
            }
        }
    }
    $sText   .= "<br>";
    $sText   .= "Verkaufsverpackung: " . $data['pp']->PPProduktpass_Verkaufsverpackung;
    $sText   .= "<br>";
    $sText   .= isset($data['herkunftslaender'][$data['ab']->PPAB_Herkunftsland])
                ? "Herkunft: " . $data['herkunftslaender'][$data['ab']->PPAB_Herkunftsland]
                : "Herkunft: ";
    $sText   .= "<br>";
    ?>

    @if($data['IsBwOrder'])
    <?php
    $posnum  = 1;
    $lbMenge = array();
    foreach ($data['lieferlaender'] as $lLand) {
        if ($lLand['LT1Menge'] > 0) {
            $lbMenge[$lLand['Country']] = array('Menge' => $lLand['LT1Menge'], 'Groesse' => $lLand['Size']);
        }
    }
    ?>
    <div>
        @if (!is_null($data['SizeSort']['SizeSort']))
        <table id='sizeTable' >
            @foreach ($data['SizeSort']['SizeSort'] as $lb => $styles)
            @foreach ($lbMenge as $l => $ma)
            @if(strpos($lb,'-'.$l) !== false)
            <tr ><td colspan="10" style="background-color:transparent;padding:10px;">
                    <div style="font-family: monospace;">
                        <b>{{$posnum++}}. Artikel</b><br>
                        <div style=border:none;">{{$sText}}</div>
                </td></tr>
            <tr ><td colspan="10" style="background-color: lightskyblue;font-size: 12px;">{{$l}}   Menge: {{number_format($ma['Menge'],0,",",".")}}  Grösse: {{$ma['Groesse']}}</td></tr>
            <?php
            $land1 = substr($lb, 4, 2);
            If ($land1 == 'OS') {
                $land1 = substr($lb, 4, 4);
            }
            $VEProL = isset($data['VEProLand'][$land1]['VE']) ? $data['VEProLand'][$land1]['VE']
                        : -1;
            try {
                $sVE = number_format($VEProL, 0);
            }
            catch (Exception $ex) {
                $VEProL = -1;
            }
            ?>
            <tr ><td colspan="10" style="background-color: lightskyblue;font-size: 12px;">VE: {{number_format($VEProL,0)}} Stk im Karton</td></tr>

            <tr style='background-color: orange;'>
                <td>Style</td>
                <td>Farbe</td>
                @foreach ( $data['SizeSort']['Index'] as $size => $val)
                <td>{{$size}}</td>
                @endforeach
                <td>Zolltarif</td>      <td>GTIN</td>
            </tr>

            <tr>
                @foreach ($styles as $style => $fbs)
                <td>{{$style}}</td>
                @foreach ($fbs as $fb => $menge)
                <td>{{$fb}}</td>
                @foreach ( $data['SizeSort']['Index'] as $size => $val)
                <td>@if ($VEProL > 0 and isset($menge[$size]) and $menge[$size]> $VEProL) {{$menge[$size]}} Stk => {{$menge[$size]/$VEProL}} Krt @else {{isset($menge[$size])?$menge[$size]:0;}} Stk. @endif</td>
                @endforeach
                <td>{{isset($data['Zolltarife'][$style][$fb])?$data['Zolltarife'][$style][$fb]:''}}</td>
                <td>{{isset($data['GTIN'][$lb][$style][$fb])?$data['GTIN'][$lb][$style][$fb]:''}}</td>
                @endforeach
            </tr>
            @endforeach
            @endif
            @endforeach
            @endforeach
        </table>
        @endif
    </div>
    @else
    <div>
        <?php $OSNotFound = true; ?>
        @if (!is_null($data['SizeSort']['SizeSort']))
        <table id='sizeTable' >
            @foreach ($data['SizeSort']['SizeSort'] as $lb => $styles)
            @if ($OSNotFound)
            <?php
            $land1      = substr($lb, 4, 2);
            If ($land1 == 'OS') {
                $land1      = substr($lb, 4, 4);
                $OSNotFound = false;
            }
            $VEProL = isset($data['VEProLand'][$land1]['VE']) ? $data['VEProLand'][$land1]['VE']
                        : -1;
            try {
                $VEText = number_format($VEProL, 0);
            }
            catch (Exception $ex) {
                $VEText = "N.N:";
            }
            ?>
            <tr ><td colspan="10" style="background-color:transparent;">&nbsp;</td></tr>
            <tr ><td colspan="10" style="background-color: lightskyblue;font-size: 12px;">@if(substr($land1,0,2) == 'OS') OS @else {{$lb}} @endif</td></tr>

            <tr ><td colspan="10" style="background-color: lightskyblue;font-size: 12px;">VE: {{$VEText}} Stk im Karton</td></tr>

            <tr style='background-color: orange;'>
                <td>Style</td>
                <td>Farbe</td>
                @foreach ( $data['SizeSort']['Index'] as $size => $val)
                <td>{{$size}}</td>
                @endforeach
                <td>Zolltarif</td>      <td>GTIN</td>
            </tr>

            <tr>
                @foreach ($styles as $style => $fbs)
                <td>{{$style}}</td>
                @foreach ($fbs as $fb => $menge)
                <td>{{$fb}}</td>
                @foreach ( $data['SizeSort']['Index'] as $size => $val)
                <td>@if(substr($land1,0,2) != 'OS') @if (isset($menge[$size]) and $menge[$size]> $VEProL) Krt @else {{isset($menge[$size])?$menge[$size]:0;}} Stk. @endif @endif</td>
                @endforeach
                <td>{{isset($data['Zolltarife'][$style][$fb])?$data['Zolltarife'][$style][$fb]:''}}</td>
                <td>{{isset($data['GTIN'][$lb][$style][$fb])?$data['GTIN'][$lb][$style][$fb]:''}}</td>
                @endforeach
            </tr>
            @endforeach
            @endif
            @endforeach
        </table>
        @endif

    </div>
    @endif
</div>
<div>
    {{$data['ArtikelText']}}
</div>

