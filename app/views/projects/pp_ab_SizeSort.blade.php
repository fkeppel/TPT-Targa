<?php $lb        = "Start";
?>

<?php
$summeSort = array();
//$laender = array_slice($ds['aOSLaender'],$lc_start,$lc_length);
$mengeos   = $data['mengeos'];

$laender = array("DE", "BE", "NL", "CZ", "ES", "GB", "FR", "PL", "SK");
foreach ($laender as $OsLand) {
    $summeSort[$OsLand] = 0;
    $lm[$OsLand]        = 0;
}
?>

<table style="font-size: 11px;margin-top: 20px;margin-bottom: 20px;">

    <?php $lb        = "Start"; ?>

    @foreach ($data['designSort'] as $ds)
    @if (strpos($ds['Laenderblock'],"OS")!==false)
    <?PHP
    $lastds    = $ds['Laenderblock'];
    $calcVE    = 0;
    ?>
    @if ($lb == "Start" and $lb != $ds['Laenderblock'])

    <tr>
        <td class="abblocktd2" colspan="4" style="text-align: left;background-color: orange;">{{$ds['Laenderblock']}}  @if (isset($data['mengeosproland'][$ds['Laenderblock']]['Menge']))<b>VE:  {{number_format($data['mengeosproland'][$ds['Laenderblock']]['VE'],0)}}</b>@endif </td>
    </tr>
    <tr>
        <td class="abblocktd1">Sortierung</td>
        <td class="abblocktd1">Style/Farbe</td>
        <td class="abblocktd1">Style/Farbe [EN]</td>
        @foreach ($laender as $land)
        @if (strpos($ds['Laenderblock'],'OS'.$land) !== false)
        <td class="abblocktd1" style="text-align: right;">Menge OS{{$land}} @if (isset($data['mengeosproland']["OS".$land]['VE'])) <br><?php $calcVE    = $data['mengeosproland']["OS" . $land]['VE']; ?><b> VE: {{number_format($data['mengeosproland']["OS".$land]['VE'],0)}}</b>@endif </td>
        @if (isset($data['mengeosproland']["OS".$land]['Menge']))

        <td class="abblocktd1" style="text-align: right;">{{number_format($data['mengeosproland']["OS".$land]['Menge'],0,",",".")}}</td>
        @endif
        @endif
        @endforeach
    </tr>
    @endif

    @if ($lb != $ds['Laenderblock'])
    {{-- Summenzeile --}}
    @if ($lb != "Start")
    <tr>
        <td class="abblocktd1"  colspan="2">Summe </td>
        @foreach ($laender as $land)
        <?php $osLand    = "OS" . $land; ?>
        @if (strpos($lb,'OS'.$land)!==false)
        <td class="abblocktd1" style="text-align:right;padding-right: 15px;">
            <?php
            $color     = "black";
            $sumCalc   = isset($summeSort[$land]) ? $summeSort[$land] * $calcVE : -1;
            $vergleich = isset($data['mengeosproland']["OS" . $land]['Menge']) ? $data['mengeosproland']["OS" . $land]['Menge']
                        : 0;
            if ($sumCalc != $vergleich) {
                $color = "red";
            }
            ?>
            <p style="color:{{$color}}"> {{$land}} Crts: {{$summeSort[$land]}}  <b>{{ number_format($sumCalc,0,',','.') }}</b></p>
        </td>
        @if (isset($data['mengeosproland']["OS".$land]['Menge']))
        <td class="abblocktd1" style="text-align:right;padding-right: 15px;"><b>{{number_format($data['mengeosproland']["OS".$land]['Menge'],0,",",".")}}</b></td>
        @endif
        @endif

        @endforeach
        <?php
        foreach ($laender as $OsLand) {
            $summeSort[$OsLand] = 0;
            $lm[$OsLand]        = 0;
        }
        ?>
    </tr>
    <tr><td colspan="4">&nbsp;</td></tr>
    <tr>
        <td class="abblocktd2" colspan="4" style="text-align: left;background-color: orange;">{{$ds['Laenderblock']}}  @if (isset($data['mengeosproland'][$ds['Laenderblock']]['Menge'])) <b>VE:  {{number_format($data['mengeosproland'][$ds['Laenderblock']]['VE'],0)}}</b>@endif </td>

    </tr>
    <tr>
        <td class="abblocktd1">Sortierung</td>
        <td class="abblocktd1">Style/Farbe</td>
        <td class="abblocktd1">Style/Farbe [EN]</td>
        @foreach ($laender as $land)
        @if (strpos($ds['Laenderblock'],'OS'.$land)!== false )
        <td class="abblocktd1" style="text-align: center;">Menge OS{{$land}} <br><b>
                <?php
                $calcVE = isset($data['mengeosproland']["OS" . $land]['VE']) ? $data['mengeosproland']["OS" . $land]['VE']
                            : 0;
                ?>
                VE: {{number_format($calcVE)}}</b></td>
        <td class="abblocktd1" style="text-align: center;">@if (isset($data['mengeosproland']["OS".$land]['Menge'])){{number_format($data['mengeosproland']["OS".$land]['Menge'],0,",",".")}}@endif</td>
        @endif
        @endforeach
    </tr>
    @endif
    <?php $lb     = $ds['Laenderblock']; ?>
    @endif

    <tr>
        <td class="abblocktd1">{{$ds['header']}}</td>
        <td class="abblocktd1">{{$ds['design']}}</td>
        <td class="abblocktd1">{{
                                        (isset($data['StyleTranslation'][$ds['header']]['Value01']) and strlen($data['StyleTranslation'][$ds['header']]['Value01']) > 0)
                                                            ? $data['StyleTranslation'][$ds['header']]['Value01']
                                                            : $ds['translate_design'];
            }}</td>
        @foreach ($laender as $land)
        <?php
        if (isset($data['mengeosproland']["OS" . $land]['VE'])) {
            $lm[$land] += $ds['OSMenge' . $land] * $data['mengeosproland']["OS" . $land]['VE'];
        }
        else {
            $lm[$land] += 0;
        }
        ?>
        @if ($ds['max'] <= -1)
        {{ Form::HIDDEN('bIsSizeSort',0)}}
        @if (strpos($ds['Laenderblock'],'OS'.$land)!==false)
        <td class="abblocktd2" style="text-align: right;">{{ Form::text("PPM[".$ds['id']."][OSMenge".$land."]",number_format($ds['OSMenge'.$land],1,',','.'),array('style'=>'text-align:right;width:55px;border:none;padding-right:5px;')) }}</td>
        @if (isset($data['mengeosproland']["OS".$land]['Menge']))
        <td class="abblocktd2" style="text-align: right;">{{number_format($ds['OSMenge'.$land]*$data['mengeosproland']["OS".$land]['VE'],0,',','.')}}</td>
        @endif
        <?php $summeSort[$land] += $ds['OSMenge' . $land]; ?>
        @endif
        @else
        {{ Form::HIDDEN('bIsSizeSort',1)}}
        @if (strpos($ds['Laenderblock'],'OS'.$land))
        <td class="abblocktd2" style="text-align: right;">
            <?php $xMax             = $ds['max'] == 0 ? 1 : $ds['max']; ?>
            <table style="font-family: Tahoma;font-size: 10px;">
                <tr>
                    <td style="text-align:left;width:30px;paddin:5px;vertical-align: middle;"><b>Gr&ouml;&szlig;e {{ $ds['max']}}</b></td>
                    @for ($ik = 1; $ik <= $xMax; $ik++)
                    <td style="text-align:center;width:30px;">{{$ds['SIZE'][$ik]}}</td>
                    @endfor
                </tr>
                <tr>
                    <td style="text-align:left;width:30px;paddin:5px;vertical-align: middle;">EAN</td>
                    @for ($ik = 1; $ik <=$xMax; $ik++)
                    <td style="text-align:center;width:30px;"><div style="width:120px;padding:5px;border:1px solid darkblue;border-radius: 0px; text-align: right;">{{$ds['AEAN'][$ik]}}</div></td>
                    @endfor
                </tr>
                <tr>
                    <td style="text-align:left;width:30px;paddin:5px;vertical-align: middle;"><b>Menge (Stk)</b></td>
                    @for ($ik = 1; $ik <= $xMax; $ik++)
                    <td style="text-align:center;"><div style="width:130px;padding:0px;border:1px solid darkblue;border-radius: 0px; text-align: right;">{{ Form::text("PPM[".$ds['id']."][aOSMenge][$land][$ik]",number_format($ds['aOSMenge'][$land][$ik] ,1,',','.'),array('style'=>'text-align:right;width:115px;border:none;padding:5px;border-radius:0px;')) }}</div></td>
                    <?php if ($xMax > 0) $summeSort[$land] += $ds['aOSMenge'][$land][$ik]; ?>
                    @endfor
                </tr>
            </table>
        </td>
        @endif
        @endif
        @endforeach
    </tr>

    @endif
    @endforeach
    {{-- Summenzeile am Ende--}}
    @if (!isset($lastds))
    <?PHP $lastds           = ""; ?>
    @endif
    <tr>
        <td class="abblocktd1"  colspan="2">Summe  {{$lastds}} </td>
        @foreach ($laender as $land)

        @if (strpos($lastds,'OS'.$land)!==false)

        <td class="abblocktd1" style="text-align:right;padding-right: 15px;">
            {{$land}} <b>{{ number_format($summeSort[$land],0,',','.') }}</b>
        </td>
        @if (isset($data['mengeosproland']["OS".$land]['Menge']))
        <td class="abblocktd1" style="text-align: right;">{{number_format($data['mengeosproland']["OS".$land]['Menge'],0,',','.')}} &nbsp;&nbsp; </td>
        @endif
        @endif


        @endforeach
    </tr>
</table>
