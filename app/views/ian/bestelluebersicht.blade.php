<h5 class='header1'>{{ ServiceProvider::tl($data['lang'], 'Bestellübersicht')}}</h5>
<div id='IANTableContainerBestellOV'>
    <div id="tabOverview" name="tabOverview" class="tgTabContent" style='padding-left:30px;'>
            <h3 class="tgCategoryHeadline" id="h3Overview" name="h3Overview">{{ ServiceProvider::tl($data['lang'], 'Sortierung Stationär') }}</h3>
            <div class="tgFullTextContainer" style="overflow:auto;padding-left:30px;">
                <table style='border-collapse:collapse; font-size:0.8em;'>
                    <thead>
                    <tr>
                        <th class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'GTIN') }}</th>
                        <th class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'GTIN KL') }}</th>
                        <th class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'Stylenummer') }}</th>
                        <th class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'Stylebezeichnung') }}</th>
                        <th class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'Größe') }}</th>
                        <!-- th class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'LSV Code') }}</th -->
                        <th class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'LSV') }}</th>
                        @foreach ($data['tAssortment']['Local']['countries'] as $country => $val)
                            <th class='tgTableHeads'>{{ $country }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    @foreach ($data['tAssortment']['Local']['values'] as $gtin => $gtins)
                            @foreach ($gtins as $gtinKL => $KLs)
                                @foreach ($KLs as $styleNo => $styles1)
                                 <tr>
                                    <td class='tgTableTD'>{{ $gtin }}</td>
                                    <td class='tgTableTD'>{{ $gtinKL }}</td>
                                    <td class='tgTableTD'>{{ $styleNo }}</td>
                                    @foreach ($styles1 as $stylebez => $styles)
                                        <td class='tgTableTD'>{{ ServiceProvider::tl($data['lang'],$stylebez) }}</td>
                                        @foreach ($styles as $size => $sizes)
                                            <td class='tgTableTD'>{{ ServiceProvider::tl($data['lang'], $size) }}</td>
                                            @foreach ($sizes as $lsv => $countries)
                                                <!-- td class='tgTableTD'>{{ $data['tLsv']['codes'][$lsv]['code']??'N.N.' }}</td -->
                                                <td class='tgTableTD'>{{ ServiceProvider::tl($data['lang'], $lsv) }}</td>
                                                @foreach ($countries as $country => $menge)
                                                    <td class='tgTableTD' style="text-align:center;">{{ $menge }}</td>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5">&nbsp;</td>
                        <td class='tgTableTD'><b>KI</b></td>
                        @foreach ($data['tAssortment']['Local']['countries'] as $country => $val)
                            <td class='tgTableTD' style="text-align:center;">{{ $val }}</td>
                        @endforeach
                    </tr>
                </table>
            </div>
            <hr>
            <div class="tgFullTextContainer" style="overflow:auto;margin-bottom:30px;">
                @foreach ($data['tAssortment']['Online']['values'] as $delno =>  $delivery)
                <h3>{{ ServiceProvider::tl($data['lang'], 'Variantenbestellmengen Onlineshops: frühester Liefertermin') }}</h3>
                <table  style='border-collapse:collapse; font-size:0.8em;margin-left:30px;'>
                    <tr>
                        <th  class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'GTIN') }}</th>
                        <th  class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'GTIN KL') }}</th>
                        <th  class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'Stylenummer') }}</th>
                        <th  class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'Stylebezeichnung') }}</th>
                        <th  class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'Größe') }}</th>
                        <!-- th  class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'LSV Code') }}</th -->
                        <th  class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'LSV') }}</th>
                        @foreach ($data['tAssortment']['Online']['countries'][$delno] as $country => $val)
                        <th  class="tgTableHeads">{{ $country }}</th>
                        @endforeach
                        <th  class="tgTableHeads">{{ ServiceProvider::tl($data['lang'], 'Summe OS')}}</th>
                    </tr>
                    @foreach ($delivery as $gtin => $gtins)
                        <?php $summe = 0; ?>
                            @foreach ($gtins as $gtinKL => $KLs)
                                @foreach ($KLs as $styleNo => $styles1)
                                <tr>
                                    <td  class='tgTableTD' >{{ $gtin }}</td>
                                    <td  class='tgTableTD' >{{ $gtinKL }}</td>
                                    <td  class='tgTableTD' >{{ $styleNo }}</td>
                                    @foreach ($styles1 as $stylebez => $styles)
                                        <td  class='tgTableTD' >{{ ServiceProvider::tl($data['lang'], $stylebez) }}</td>
                                        @foreach ($styles as $size => $sizes)
                                            <td  class='tgTableTD' >{{ ServiceProvider::tl($data['lang'], $size) }}</td>
                                            @foreach ($sizes as $lsv => $countries)
                                                <!-- td  class='tgTableTD' >{{ ServiceProvider::tl($data['lang'],$data['tLsv']['codes'][$lsv]['code']??'N.N.') }}</td -->
                                                <td  class='tgTableTD' >{{ ServiceProvider::tl($data['lang'], $lsv)}}</td>
                                                @foreach ($countries as $country => $menge)
                                                <td  class='tgTableTD'  style="text-align:right;padding-right:4px;">{{ number_format($menge,0,',','.') }}</td>
                                                <?php $summe += $menge ?>
                                                @endforeach
                                                <td  class='tgTableTD'  style="text-align:right;padding-right:4px;">{{ number_format($summe,0,',','.') }}</td>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tr>
                    @endforeach
                    <!-- tr>
                        <td colspan="5">&nbsp;</td>
                        <td>KI {{ $delno }}</td>
                        @foreach ($data['tAssortment']['Online']['countries'][$delno] as $country => $val)
                            <td style="text-align:right;padding-right:4px;">{{ number_format($val, 0, ',', '.') }}</td>
                        @endforeach
                    </tr -->
                </table>
                @endforeach
            </div>
    </div>    
</div>
