<h5 class='header1'>{{ ServiceProvider::tl($data['lang'], 'Sortierung') }}</h5>
<div id='IANTableContainerSort'>
    <div id="tabAssortment" name="tabAssortment">
        <?php $assortments = $data['tAssortment']['Assortment'];
        $tP = $data['tAssortment']['TotalPack'];
        ?>
        @foreach ($assortments as $article => $assort)
            @foreach ($assort as $country => $styles)
                    <?php
                    $ca = explode(',', $country);
                    $resC = '';
                    $_land = 'X';
                    $lines = 0;
                    foreach ($ca as $c) {
                        if (false and ($c == 'CB5-OSES' or substr($c, 0, 3) == 'CB8' or substr($c, 0, 7) == 'CB10-KO')) {
                            $resC .= $c . PHP_EOL;
                            $lines++;
                        } else {
                            if ($_land != substr($c, 0, 4)) {
                                $_land = substr($c, 0, 4);
                                if ($c != '') {
                                    $resC .= PHP_EOL . str_replace('-', '', substr($c, 0, 4)) . ': ';
                                }
                                $comma = '';
                                $lines++;
                            }
                            $headerLand = preg_replace('/CB.-/', '', $c);
                            $headerLand = preg_replace('/CB10./', '', $headerLand);
                            $resC = $resC . $comma . $headerLand;
                            $comma = ',';
                        }
                    }
                    $lineHeight = 18;
                    $divHeight = $lineHeight * $lines;
                    $cbText = trim($resC);
                    ?>
                    <div id='hlSort'>{{ $cbText }}</div>
                    <?php $ki = 0; ?>
                    <table id='tableSort'>
                        <thead>
                            <tr>
                                <th class="tableSort_th">{{ ServiceProvider::tl($data['lang'], 'Stylenummer') }}</th>
                                <th class="tableSort_th">{{ ServiceProvider::tl($data['lang'], 'Artikelbezeichnung') }}</th>
                                <th class="tableSort_th_small">{{ ServiceProvider::tl($data['lang'], 'Sortierung') }}</th>
                                <th class="tableSort_th_small">{{ ServiceProvider::tl($data['lang'], 'KI:') }}{{ $tP[$country] }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($styles as $style => $prods)
                                @foreach ($prods as $prod => $sizes)
                                    @foreach ($sizes as $sort => $value)
                                        <tr>
                                            <td>{{ $style }}</td>
                                            <td>{{ ServiceProvider::tl($data['lang'],$prod) }}</td>
                                            <td style="text-align:center;">{{ $value }}</td>
                                            <?php $ki += $value; ?>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                            <tr>
                                <td colspan="2"></td>
                                <td style="text-align:center;">{{ $ki }}</td>
                            </tr>
                        </tbody>
                    </table>
            @endforeach
        @endforeach
    </div>
</div>
