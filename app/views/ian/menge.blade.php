<h5 class='header1'>{{ ServiceProvider::tl($data['lang'], 'Mengen')}}</h5>
 <div id='IANTableContainerMenge' style='padding:20px;'>
   <div style='padding-bottom:20px;'>
            <table style='font-size:0.7em;border-collapse:collapse;table-layout:fixed;'> 
                <tr>
                    <td colspan='2' style="padding:5px;border:1px solid lightgray;"><b>{{ ServiceProvider::tl($data['lang'],'Spätestes CRD')}}</b></td>
                </tr>
                <tr>
                    <td style="width:120px;padding:5px;vertical-align:top;border:1px solid lightgray;">{{ ServiceProvider::tl($data['lang'],'DDP -8 Wochen')}}</td>
                    <td style="width:600px;padding:5px;vertical-align:top;border:1px solid lightgray;">{{ ServiceProvider::tl($data['lang'],'gilt nur für die Haupthäfen: CNDCB, CNSZX, CNNBO, CNSHA, CNTAO, CNXMN, CNYTN, CNTAC, BDCGP')}}</td>
                </tr>
                <tr style='background-color:#f2f2f2;'>
                    <td style="padding:5px;vertical-align:top;border:1px solid lightgray;">{{ ServiceProvider::tl($data['lang'],'DDP -9 Wochen')}}</td>
                    <td style="padding:5px;vertical-align:top;border:1px solid lightgray;">{{ ServiceProvider::tl($data['lang'],'gilt für alle übrigen Häfen')}}</td>
                </tr> 
                <tr>
                    <td colspan="2" style='padding-bottom:10px;padding-top:10px;border:1px solid lightgray;'><b>{{ ServiceProvider::tl($data['lang'],'Shipment release muss für alle Verschiffungen 2 Wochen vor CRD gemeldet werden.')}}</b></td>
                </tr>
            </table>
    </div>
    <div style="clear:both;">&nbsp;</div>
            <!-- div class="tgTableHeads" id="tooltipQuantity" name="tooltipQuantity">Gesamtmenge pro Land ist die Summe aus 1. LT Menge, 2. LT Menge und 3. LT Menge</div !-->
            <table id="quantity">
                <thead>
                    <tr>
                        <th class="tgTableHeads" id="country" name="country">{{ ServiceProvider::tl($data['lang'], 'Land') }}</th>
                        <th class="tgTableHeads" id="totalNumOfCtn" name="totalNumOfCtn">{{ ServiceProvider::tl($data['lang'], 'Kollianzahl') }}</th>
                        <th class="tgTableHeads" id="totalPackRatio" name="totalPackRatio">{{ ServiceProvider::tl($data['lang'], 'Kolliinhalt') }}</th>
                        <th class="tgTableHeads" id="totalQtyPerCountry" name="totalQtyPerCountry">{{ ServiceProvider::tl($data['lang'], 'Gesamtmenge pro Land') }}</th>
                        <th class="tgTableHeads" id="deliveryDateOWIM_tpt" name="deliveryDateOWIM_tpt">{{ ServiceProvider::tl($data['lang'], '1. LT OWIM (ETA)') }}</th>
                        <th class="tgTableHeads" id="ctryDeliveryWeek1_tpt" name="ctryDeliveryWeek1_tpt">{{ ServiceProvider::tl($data['lang'], '1. LT Land') }}</th>
                        <th class="tgTableHeads" id="ctryDeliveryTotalQty1_tpt" name="ctryDeliveryTotalQty1_tpt">{{ ServiceProvider::tl($data['lang'], '1. LT Menge') }}</th>
                        <th class="tgTableHeads" id="ctryDeliveryWeek2_tpt" name="ctryDeliveryWeek2_tpt">{{ ServiceProvider::tl($data['lang'], '2. LT Land') }}</th>
                        <th class="tgTableHeads" id="ctryDeliveryTotalQty2_tpt" name="ctryDeliveryTotalQty2_tpt">{{ ServiceProvider::tl($data['lang'], '2. LT Menge') }}</th>
                        <th class="tgTableHeads" id="ctryDeliveryWeek3_tpt" name="ctryDeliveryWeek3_tpt">{{ ServiceProvider::tl($data['lang'], '3. LT Land') }}</th>
                        <th class="tgTableHeads" id="ctryDeliveryTotalQty3_tpt" name="ctryDeliveryTotalQty3_tpt">{{ ServiceProvider::tl($data['lang'], '3. LT Menge') }}</th>
                        <th class="tgTableHeads" id="completionType" name="completionType">{{ ServiceProvider::tl($data['lang'], 'Abwicklungsart') }}</th>
                        <th class="tgTableHeads" id="articleInformation" name="articleInformation">{{ ServiceProvider::tl($data['lang'], 'Artikelinfo') }}</th>
                        <th class="tgTableHeads" id="countryRemarks" name="countryRemarks">{{ ServiceProvider::tl($data['lang'], 'sonstige Länderbemerkungen') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total1 = 0;
                    $total2 = 0;
                    $total3 = 0;
                    $totalCtn = 0;
                    $total = 0; 
                    $m = $data['mengeAlt']; 
                    $import = '';
                    if (isset($data['importDatum'])){
                    $import = $data['importDatum'];
                    }
                    ?>
                    @foreach ($data['menge'] as $qty)
                        <?php if ($qty->PPProduktpass_Menge_Kolli != 0) {
                            $totalCtn += $qty->PPProduktpass_Menge_Quantity / $qty->PPProduktpass_Menge_Kolli;
                        }
                        $total += is_null($qty->PPProduktpass_Menge_Quantity) ? 0 : $qty->PPProduktpass_Menge_Quantity;
                        $total1 += is_null($qty->PPProduktpass_Menge_LT1Menge) ? 0 : $qty->PPProduktpass_Menge_LT1Menge;
                        $total2 += is_null($qty->PPProduktpass_Menge_LT2Menge) ? 0 : $qty->PPProduktpass_Menge_LT2Menge;
                        $total3 += is_null($qty->PPProduktpass_Menge_LT3Menge) ? 0 : $qty->PPProduktpass_Menge_LT3Menge;
                        $_land = $qty->PPProduktpass_Menge_Country;
                        if (isset($m[$_land])){
                            $alt = $m[$_land];
                        } else {
                            $alt = $qty;
                        }
                        $bed = true;
                        ?>
                        <tr id="quantity_d0e427_inputRow" class="tgLangDE">
                            <td class='tgTableTD' style="text-align:center;">{{ $qty->PPProduktpass_Menge_Country }}</td>
                            <td  class='tgTableTD'  style="padding-right:4px;text-align:right;">@if ($qty->PPProduktpass_Menge_Kolli != 0){{ number_format($qty->PPProduktpass_Menge_Quantity / $qty->PPProduktpass_Menge_Kolli, 0, ',', '.') }}
                                @else 0 @endif </td>
                            <td  class='tgTableTD'  style="padding-right:4px;text-align:right;color:@if(isset($alt->PPProduktpass_Menge_Kolli) and $alt->PPProduktpass_Menge_Kolli != $qty->PPProduktpass_Menge_Kolli) dodgerblue @else black @endif;" title='{{$import}}   {{$alt->PPProduktpass_Menge_Kolli}}'>{{ number_format($qty->PPProduktpass_Menge_Kolli, 0) }}</td>
                            <td  class='tgTableTD'  style="padding-right:4px;text-align:right;color:@if(isset($alt->PPProduktpass_Menge_Quantity) and $alt->PPProduktpass_Menge_Quantity != $qty->PPProduktpass_Menge_Quantity) dodgerblue @else black @endif;" title='{{$import}}   {{$alt->PPProduktpass_Menge_Quantity}}'>{{ number_format($qty->PPProduktpass_Menge_Quantity, 0, ',', '.') }}</td>
                            <td  class='tgTableTD'  style="text-align:center;color:@if(isset($alt->PPProduktpass_Menge_DeliveryWeek) and $alt->PPProduktpass_Menge_DeliveryWeek != $qty->PPProduktpass_Menge_DeliveryWeek) dodgerblue @else black @endif;" title='{{$import}}   {{$alt->PPProduktpass_Menge_DeliveryWeek}}'>{{ $qty->PPProduktpass_Menge_DeliveryWeek }}</td>
                            <td  class='tgTableTD'  style="text-align:center;color:@if(isset($alt->PPProduktpass_Menge_LT1) and $alt->PPProduktpass_Menge_LT1 != $qty->PPProduktpass_Menge_LT1) dodgerblue @else black @endif;" title='{{$import}}   {{$alt->PPProduktpass_Menge_LT1}}'>{{ $qty->PPProduktpass_Menge_LT1 }}</td>
                            <td  class='tgTableTD'  style="padding-right:4px;text-align:right;color:@if(isset($alt->PPProduktpass_Menge_LT1Menge) and $alt->PPProduktpass_Menge_LT1Menge != $qty->PPProduktpass_Menge_LT1Menge) dodgerblue @else black @endif;" title='{{$import}}   {{$alt->PPProduktpass_Menge_LT1Menge}}'>{{ number_format($qty->PPProduktpass_Menge_LT1Menge, 0, ',', '.') }}</td>
                            <td  class='tgTableTD'  style="text-align:center;color:@if(isset($alt->PPProduktpass_Menge_LT2) and $alt->PPProduktpass_Menge_LT2 != $qty->PPProduktpass_Menge_LT2) dodgerblue @else black @endif;" title='{{$import}}   {{$alt->PPProduktpass_Menge_LT2}}'>{{ $qty->PPProduktpass_Menge_LT2 }}</td>
                            <td  class='tgTableTD'  style="padding-right:4px;text-align:right;color:@if(isset($alt->PPProduktpass_Menge_LT2Menge) and $alt->PPProduktpass_Menge_LT2Menge != $qty->PPProduktpass_Menge_LT2Menge) dodgerblue @else black @endif;" title='{{$import}}   {{$alt->PPProduktpass_Menge_LT2Menge}}'>{{ number_format($qty->PPProduktpass_Menge_LT2Menge, 0, ',', '.') }}</td>
                            <td  class='tgTableTD'  style="text-align:center;color:@if(isset($alt->PPProduktpass_Menge_LT3) and $alt->PPProduktpass_Menge_LT3 != $qty->PPProduktpass_Menge_LT3) dodgerblue @else black @endif;" title='{{$import}}   {{$alt->PPProduktpass_Menge_LT3}}'>{{ $qty->PPProduktpass_Menge_LT3 }}</td>
                            <td  class='tgTableTD'  style="padding-right:4px;text-align:right;color:@if(isset($alt->PPProduktpass_Menge_LT3Menge) and $alt->PPProduktpass_Menge_LT3Menge != $qty->PPProduktpass_Menge_LT3Menge) dodgerblue @else black @endif;" title='{{$import}}   {{$alt->PPProduktpass_Menge_LT3Menge}}'>{{ number_format($qty->PPProduktpass_Menge_LT3Menge, 0, ',', '.') }}</td>
                            <td  class='tgTableTD'  style="text-align:center;color:@if(isset($alt->Abwicklungsart) and $alt->Abwicklungsart != $qty->Abwicklungsart) dodgerblue @else black @endif;" title='{{$import}}   {{$alt->Abwicklungsart}}'>{{ $data['pp']->Abwicklungsart }}</td>
                            <td  class='tgTableTD'  style="text-align:center;color:@if(isset($alt->PPProduktpass_Menge_ArtikelInfo) and $alt->PPProduktpass_Menge_ArtikelInfo != $qty->PPProduktpass_Menge_ArtikelInfo) dodgerblue @else black @endif;" title='{{$import}}   {{$alt->PPProduktpass_Menge_ArtikelInfo}}'>{{ $qty->PPProduktpass_Menge_ArtikelInfo }}</td>
                            <td  class='tgTableTD'  style="text-align:center;color:@if(isset($alt->PPProduktpass_Menge_countryRemarks) and $alt->PPProduktpass_Menge_countryRemarks != $qty->PPProduktpass_Menge_countryRemarks) dodgerblue @else black @endif;" title='{{$import}}   {{$alt->PPProduktpass_Menge_countryRemarks}}'>{{ $qty->PPProduktpass_Menge_countryRemarks }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class='tgTableTDResult'>{{ ServiceProvider::tl($data['lang'], 'Gesamtmenge') }}</td>
                        <td class='tgTableTDResult' style="padding-right:4px;text-align:right">{{ number_format($totalCtn, 0, ',', '.') }}
                        </td>
                        <td class='tgTableTDResult'>&nbsp;</td>
                        <td class='tgTableTDResult' style="padding-right:4px;text-align:right">{{ number_format($total, 0, ',', '.') }}
                        </td>
                        <td class='tgTableTDResult'>&nbsp;</td>
                        <td class='tgTableTDResult'>&nbsp;</td>
                        <td class='tgTableTDResult' style="padding-right:4px;text-align:right">{{ number_format($total1, 0, ',', '.') }}
                        </td>
                        <td class='tgTableTDResult'>&nbsp;</td>
                        <td class='tgTableTDResult' style="padding-right:4px;text-align:right">{{ number_format($total2, 0, ',', '.') }}
                        </td>
                        <td class='tgTableTDResult'>&nbsp;</td>
                        <td class='tgTableTDResult' style="padding-right:4px;text-align:right">{{ number_format($total3, 0, ',', '.') }}
                        </td>
                        <td class='tgTableTDResult'>&nbsp;</td>
                        <td class='tgTableTDResult'>&nbsp;</td>
                        <td class='tgTableTDResult'>&nbsp;</td>
                    </tr>
                </tbody>
            </table>
    <div style='padding:20px;border:none;'></div>
</div>
