<style>
    .abth1, .abth2 {
        width:150px;background-color: #d9d9d9; border:1px solid #a0a0a0;
        padding:5px;
    }
    .abth2{
        width:100px;
        text-align:center;
    }

    .abtd1, .abtd2, .abtd3 {
        border:1px solid #a0a0a0;background-color:#d9d9d9;
        padding:5px;
    }
    .abtd2{
        background-color:#FFF;
        text-align:right;
        padding-right:5px;
    }
    .abtd3 {
        text-align: right;
        padding-right:20px;
    }
    .abs1 {
        width:100px;
        border:1px solid #a0a0a0;
        background-color:#d9d9d9;
    }
    .abblockth1, .abblockth2, 	.abblocktd1 {
        width:60px;background-color: #d9d9d9; border:1px solid #a0a0a0;
        padding:5px;
    }
    .abblockth2 {
        text-align:right;
        padding-right: 6px;
    }
    .abblocktd1 {
        background-color: #d9d9d9; border:1px solid #a0a0a0;
        padding:5px;
    }
    .abblocktd2 {
        text-align:right;padding-right:6px;
        border:1px solid #a0a0a0;
    }

    .Certs td {
        width:100px;
        font-family: tahoma;
        font-size: 11px;
        border: 1px solid darkblue;
        text-align: center;
    }

    .certs table {
        font-family: tahoma;
        font-size: 11px;
        table-layout: fixed;
        border-collapse: collapse;
    }

    .tdh {
        background-color: lightgray;
        width:80px;
    }

    .colTotalHeader {
        background-color: #4169e1;
        text-align: right;
        border:1px solid grey;
        padding:5px;
        color:white;
    }
    .colTotal {

        text-align: right;
        border:1px solid grey;
        padding:5px;

    }
    .colTableTotalHeader {
        background-color:orange;
        text-align: left;
        border:1px solid gray;
        padding:5px;
        width:250px;
    }
    .colTableTotal {
        text-align: right;
        border:1px solid gray;
        padding:5px;
        width:150px;
    }

</style>
<div style="width:100%;border: 1px solid lightgrey; margin: 0 auto;position: relative;height:848px;overflow: auto;padding: 0px;">
    <div style="padding:10px;">
        {{ Form::model($data['ab'], array('url'=>'updateab/'.$data['pp']['PPProduktpass_Id'], 'class'=>'form-signin')) }}
        {{ Form::HIDDEN('qPPAB_Id',$data['ab']->PPAB_Id)}}
        {{ Form::HIDDEN('ppid',$data['pp']['PPProduktpass_Id'])}}
        @if (!$data['pp']['PPProduktpass_IsRevision'])
        <div style="margin:0 auto;text-align:right;height:40px;">
            {{ Form::submit('speichern', array('class'=>'btn','style'=>'width:120px;background-color: #1C73C5;color:white;border-radius:0px;'))}}
        </div>
        @endif

        <div style="width:100%; border: none; height:774px;overflow: auto;" id="accordionAB">


            <li>
                {{ Form::label('PPAB_Lieferbedingung','Lieferbedingung:') }}
                {{ Form::select('PPAB[PPAB_Lieferbedingung]',$data['Lieferbedingungen'],$data['ab']->PPAB_Lieferbedingung,array('style'=>'width:200px;height:25px;') )}}
            </li>
            <li>
                {{ Form::label('PPAB_VKEUR','VK-Preis (EUR)') }}{{ Form::text('PPAB[PPAB_VKEUR]',number_format($data['ab']->PPAB_VKEUR,3,',','.')) }}
            </li>
            <li>
                {{ Form::label('PPAB_VKEUR','VK-DAT-Preis') }}{{ Form::text('PPAB[PPAB_VKDAT]',number_format($data['ab']->PPAB_VKDAT,3,',','.')) }}
            </li>
            <li>
                {{ Form::label('PPAB_VKQMEUR','FOB QM-Preis (EUR)') }}{{ Form::text('PPAB[PPAB_VKQMEUR]',number_format($data['ab']->PPAB_VKQMEUR,3,',','.')) }}
            </li>
            <li>
                <table style="font-size: 11px;margin-top: 20px;margin-bottom: 20px;">
                    <tr>
                        <td class="abth1">Container-Art:</td>
                        <td class="abth2">HC</td>
                        <td class="abth2">40'</td>
                        <td class="abth2">20'</td>
                        <td class="abth2" style="text-align: right;padding-right:20px;">Kartonanzahl</td>
                        <td class="abth1">Palettenfaktor</td>
                        <td class="abth1">Kartonmaße</td>
                        <td class="abth1" style="width: 30px;">% FR</td>
                        <td class="abth1" style="width: 30px;">% IT</td>
                    </tr>
                    <tr>
                        <td class="abtd1">Rotterdam/Antwerpen</td>
                        <td class="abtd2">{{ Form::text('PPAB[PPAB_CD11]',number_format($data['ab']->PPAB_CD11,0),array('style'=>'width:60px;border:none')) }}</td>
                        <td class="abtd2">{{ Form::text('PPAB[PPAB_CD12]',number_format($data['ab']->PPAB_CD12,0),array('style'=>'width:60px;border:none')) }}</td>
                        <td class="abtd2">{{ Form::text('PPAB[PPAB_CD13]',number_format($data['ab']->PPAB_CD13,0),array('style'=>'width:60px;border:none')) }}</td>
                        <td class="abtd3">{{ number_format($data['hm']['Rotterdam']['VE'],0,',','.') }}</td>
                        <td class="abtd1" rowspan="4" style="vertical-align: top;width:150px;">{{ Form::text('PPAB[PPAB_Palettenfaktor]',$data['ab']->PPAB_Palettenfaktor,array('style'=>'width:140px;border:none')) }}</td>
                        <td class="abtd1" rowspan="4" style="vertical-align: top;width:150px;">{{ Form::text('PPAB[PPAB_KatonMasse]',$data['ab']->PPAB_KatonMasse,array('style'=>'width:140px;border:none')) }}</td>
                        <td class="abtd2">{{ Form::text('PPAB[PPAB_Aufteilung_Rotterdam_FR]',number_format($data['ab']->PPAB_Aufteilung_Rotterdam_FR,0),array('style'=>'width:25px;border:none')) }}</td>
                        <td class="abtd3"></td>
                    </tr>
                    <tr>
                        <td class="abtd1">Barcelona</td>
                        <td class="abtd2">{{ Form::text('PPAB[PPAB_CD21]',number_format($data['ab']->PPAB_CD21,0),array('style'=>'width:60px;border:none')) }}</td>
                        <td class="abtd2">{{ Form::text('PPAB[PPAB_CD22]',number_format($data['ab']->PPAB_CD22,0),array('style'=>'width:60px;border:none')) }}</td>
                        <td class="abtd2">{{ Form::text('PPAB[PPAB_CD23]',number_format($data['ab']->PPAB_CD23,0),array('style'=>'width:60px;border:none')) }}</td>
                        <td class="abtd3">{{ number_format($data['hm']['Barcelona']['VE'],0,',','.') }}</td>
                        <td class="abtd3">{{ number_format(100 - $data['ab']->PPAB_Aufteilung_Rotterdam_FR,0)}}</td>
                        <td class="abtd2">{{ Form::text('PPAB[PPAB_Aufteilung_Barcelona_IT]',number_format($data['ab']->PPAB_Aufteilung_Barcelona_IT,0),array('style'=>'width:25px;border:none')) }}</td>

                    </tr>
                    <tr>
                        <td class="abtd1">Koper</td>
                        <td class="abtd2">{{ Form::text('PPAB[PPAB_CD31]',number_format($data['ab']->PPAB_CD31,0),array('style'=>'width:60px;border:none')) }}</td>
                        <td class="abtd2">{{ Form::text('PPAB[PPAB_CD32]',number_format($data['ab']->PPAB_CD32,0),array('style'=>'width:60px;border:none')) }}</td>
                        <td class="abtd2">{{ Form::text('PPAB[PPAB_CD33]',number_format($data['ab']->PPAB_CD33,0),array('style'=>'width:60px;border:none')) }}</td>
                        <td class="abtd3">{{ number_format($data['hm']['Koper']['VE'],0,',','.') }}</td>
                        <td class="abtd3"></td>
                        <td class="abtd3">{{ number_format(100 - $data['ab']->PPAB_Aufteilung_Barcelona_IT,0)}}</td>
                    </tr>
                    <tr>
                        <td class="abtd1">Richmond</td>
                        <td class="abtd2">{{ Form::text('PPAB[PPAB_CD41]',number_format($data['ab']->PPAB_CD41,0),array('style'=>'width:60px;border:none')) }}</td>
                        <td class="abtd2">{{ Form::text('PPAB[PPAB_CD42]',number_format($data['ab']->PPAB_CD42,0),array('style'=>'width:60px;border:none')) }}</td>
                        <td class="abtd2">{{ Form::text('PPAB[PPAB_CD43]',number_format($data['ab']->PPAB_CD43,0),array('style'=>'width:60px;border:none')) }}</td>
                        <td class="abtd3">{{ number_format($data['hm']['Richmond']['VE'],0,',','.') }}</td>
                        <td class="abtd3"></td>
                        <td class="abtd3"></td>
                    </tr>



                </table><br>
                <table style="width:400px;font-family: Tahoma;font-size: 11px;table-layout: fixed;">
                    <tr>
                        <td style="width:80px;"><b>Länder Anlieferung Rotterdam:</b></td>
                        <td>DE OS NL BE FI SE DK GB IE FR LT<br></td>
                    </tr>
                    <tr>
                        <td><b>Länder Anlieferung Barcelona:</b></td>
                        <td>ES PT IT FR</td>
                    </tr>
                    <tr>
                        <td><b>Länder Anlieferung Koper:</b> </td>
                        <td>AT GR PL CZ SK HU SI CY BG RO IT HR CH<br></td>
                    </tr>
                    <tr>
                        <td><b>Länder Anlieferung Richmond:</b> </td>
                        <td>US<br></td>
                    </tr>
                </table>
            </li>
            <li>
                {{ Form::label('PPAB_UZ','UZ CH:') }}
                {{ Form::select('PPAB[PPAB_UZ]',$data['transportdokch'],$data['ab']->PPAB_UZ,array('style'=>'width:200px;height:25px;') )}}
            </li>
            <li>
                {{ Form::label('PPAB_UZRS','UZ RS:') }}
                {{ Form::select('PPAB[PPAB_UZRS]',$data['transportdokrs'],$data['ab']->PPAB_UZRS,array('style'=>'width:200px;height:25px;') )}}
            </li>
            <li>
                {{ Form::label('PPAB_Produktionsstaette_Id','Produktionsstätte:') }}{{ Form::select('PPAB[PPAB_Produktionsstaette_Id]',$data['plants'],$data['ab']->PPAB_Produktionsstaette_Id,array('style'=>'width:200px;height:25px;') )}}					</li>
            <li>
                {{ Form::label('PPAB_Produktionsstaetteid','Produktionsstätte-Id:') }}{{ Form::text('xPSID',$data['ab']->PPAB_Produktionsstaette_LidlId,array('style'=>'width:200px;height:25px;','disabled'=>'True') )}}
            </li>
            <li>
                <div class="certs" ><table style="" >
                        <tr>
                            <td  class="tdh">Zertifikat</td>

                            <td  class="tdh">Gültig</td>
                        </tr>
                        <tr>
                            <td class="tdh">BSCI:</td>

                            <!--td >{{$data['CertsOfProducer']['BSCI']}}</td-->
                            <td style="background-color: {{$data['CertsOfProducer']['BSCIColor']}}">{{$data['CertsOfProducer']['BSCIValid']}}</td>
                        </tr>

                    </table></div>
            </li>

            <li>
                {{ Form::label('PPAB_herkunftsland','Herkunftsland:') }}{{ Form::select('PPAB[PPAB_Herkunftsland]',$data['herkunftslaender'],$data['ab']->PPAB_Herkunftsland,array('style'=>'width:200px;height:25px;') )}}
            </li>
            <li>
                {{ Form::label('PPAB_Masse','Maße:') }}{{ Form::text('PPAB[PPAB_Masse]',$data['ab']->PPAB_Masse,array('style'=>'width:200px;height:25px;') )}}
            </li>

            <li>
                {{ Form::label('PPAB_Abgangshafen','Abgangshafen:') }}{{ Form::select('PPAB[PPAB_Abgangshafen]',$data['haefen'],$data['ab']->PPAB_Abgangshafen,array('style'=>'width:200px;height:25px;') )}}
            </li>
            <li>
                {{ Form::label('LT','Liefertermin:') }}{{ Form::text('xLT',$data['pp']->PPProduktpass_Liefertermin,array('style'=>'width:200px;height:25px;','disabled'=>'True') )}}
            </li>
            <li>
                {{ Form::label('PPAB_Anmerkung','Anmerkungen:') }}{{ Form::textarea('PPAB[PPAB_Anmerkung]',$data['ab']->PPAB_Anmerkung,array('style'=>'width:200px;height:60px;') )}}
            </li>

            <li>
                {{Form::label('Ländergrössen BW')}} {{ Form::select('PO[PPPurchase_BWGroesse]',$data['bwg'],$data['purchase']->PPPurchase_BWGroesse,array('style'=>'padding:4px;width:400px;height:25px;')) }}
            </li>


            <li>
                <div style="width:calc(100%-20px); overflow: auto;border:1px solid lightgray;">
                    <table style="font-size: 11px;margin-top: 20px;margin-bottom: 20px;width:98%;border-collapse: collapse;">
                        <tr>
                            <td class="abs1">Land</td>
                            @foreach ($data['lieferlaender'] as $land)
                            <td style="width:110px;background-color: #d4d4d4;text-align: center;border:1px solid grey;padding:5px;">{{ $land['Country'] }}</td>
                            @endforeach
                            <td class="colTotalHeader"><b>TOTAL</b></td>
                        </tr>
                        <tr>
                            <td class="abs1">Kollie</td>

                            @foreach ($data['lieferlaender'] as $land)
                            <td style="width:110px;background-color: #d4d4d4;text-align: right;border:1px solid grey;padding:5px;">
                                @if ($land['sumCountry'] > 0)

                                {{ number_format($land['Kolli'],0,',','.') }}
                                @endif
                            </td>
                            @endforeach
                            <td class="colTotal">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="abs1">Kartons</td>
                            <?php $totalMenge    = 0; ?>
                            <?php $totalCts      = 0; ?>
                            <?php $totalVK       = 0; ?>
                            @foreach ($data['lieferlaender'] as $land)
                            <td style="width:110px;background-color: #d4d4d4;text-align: right;border:1px solid grey;padding:5px;">
                                @if ($land['sumCountry'] > 0 and $land['Kolli'] != 0)
                                <?php
                                $totalMenge    += $land['sumCountry'];
                                $totalCts      += $land['sumCountry'] / $land['Kolli'];
                                $totalVK       += $land['VK'] * $land['sumCountry'];
                                ?>
                                {{ number_format($land['sumCountry']/$land['Kolli'],0,',','.') }}
                                @endif
                            </td>
                            @endforeach
                            <td class="colTotal">{{number_format($totalCts,0,',','.')}}</td>
                        </tr>
                        <tr   style="background-color:#ffb04a;">
                            <td class="abs1" rowspan="2" style="background-color:#ffb04a;">LT</td>
                            @foreach ($data['lieferlaender'] as $land)
                            <td style="border:1px solid grey;text-align:right;padding:5px;">
                                @if ($land['sumCountry'] > 0)
                                {{ number_format($land['sumCountry'],0,',','.') }}
                                @endif
                            </td>
                            @endforeach
                            <td class="colTotal">{{number_format($totalMenge,0,',','.')}}</td>
                        </tr>
                        <tr  style="background-color:#ffb04a;">
                            <!--td class="abs1">LT</td-->
                            @foreach ($data['lieferlaender'] as $land)
                            <td style="border:1px solid grey;text-align:right;padding:0px;padding:5px;">
                                @if ($land['sumCountry'] > 0)
                                {{ $land['Lt'] }}
                                @endif
                            </td>

                            @endforeach
                            <td class="colTotal">&nbsp;</td>

                        </tr>
                        <tr>
                            <td class="abs1"  rowspan="2">LT1</td>
                            @foreach ($data['lieferlaender'] as $land)
                            <td style="border:1px solid grey;text-align:right;padding:5px;">
                                @if ($land['sumCountry'] > 0)
                                {{ number_format($land['LT1Menge'],0,',','.')}}
                                @else
                                &nbsp;
                                @endif
                            </td>

                            @endforeach
                            <td class="colTotal">&nbsp;</td>

                        </tr>
                        <tr>
                            <!--td class="abs1">LT1</td-->
                            @foreach ($data['lieferlaender'] as $land)
                            <td style="border:1px solid grey;text-align:right;padding:5px;">
                                @if ($land['sumCountry'] > 0)
                                {{ $land['LT1']}}
                                @else
                                &nbsp;
                                @endif
                            </td>

                            @endforeach
                            <td class="colTotal">&nbsp;</td>

                        </tr>
                        <tr  style="background-color:#ffb04a;">
                            <td class="abs1" rowspan="2"  style="background-color:#ffb04a;">LT2</td>
                            @foreach ($data['lieferlaender'] as $land)
                            <td style="border:1px solid grey;text-align:right;padding:5px;">
                                @if ($land['sumCountry'] > 0)
                                {{ number_format($land['LT2Menge'],0,',','.')}}
                                @else
                                &nbsp;
                                @endif
                            </td>

                            @endforeach
                            <td class="colTotal">&nbsp;</td>

                        </tr>
                        <tr  style="background-color:#ffb04a;">
                            <!--td class="abs1">LT2</td-->
                            @foreach ($data['lieferlaender'] as $land)
                            <td style="border:1px solid grey;text-align:right;padding:5px;">
                                @if ($land['sumCountry'] > 0)
                                {{ $land['LT2']}}
                                @else
                                &nbsp;
                                @endif
                            </td>

                            @endforeach
                            <td class="colTotal">&nbsp;</td>
                        </tr>

                        <tr>
                            <td class="abs1" rowspan="2">LT3</td>
                            @foreach ($data['lieferlaender'] as $land)
                            <td style="border:1px solid grey;text-align:right;padding:5px;">
                                @if ($land['sumCountry'] > 0)
                                {{ number_format($land['LT3Menge'],0,',','.')}}
                                @else
                                &nbsp;
                                @endif
                            </td>

                            @endforeach
                            <td class="colTotal">&nbsp;</td>
                        </tr>
                        <tr>
                            <!--td class="abs1">LT3</td-->
                            @foreach ($data['lieferlaender'] as $land)
                            <td style="border:1px solid grey;text-align:right;padding:5px;">
                                @if ($land['sumCountry'] > 0)
                                {{ $land['LT3']}}
                                @else
                                &nbsp;
                                @endif
                            </td>

                            @endforeach
                            <td class="colTotal">&nbsp;</td>
                        </tr>

                        <tr>
                            <td class="abs1">Preis/Land</td>
                            @foreach ($data['lieferlaender'] as $land)
                            <td style="border:1px solid grey;text-align:right;padding:0px;">
                                @if ($land['sumCountry'] > 0)
                                {{ Form::text("VK[".$land['id']."]",number_format($land['VK'],2,',','.'),array('style'=>'text-align:right;width:45px;border:none;padding-right:5px;')) }}
                                @endif
                            </td>

                            @endforeach
                            <td class="colTotalHeader">{{number_format($totalVK,2,',','.')}}</td>

                        </tr>
                    </table>
                </div>
                <div style="padding:20 0 40 60;">
                    <h1><b>Zusammenfassung</b></h1>
                    <table style="border-collapse:collapse;">
                        <tr>
                            <td class="colTableTotalHeader">Menge</td>
                            <td class="colTableTotal">{{number_format($totalMenge,0,',','.')}}</td>
                        </tr>
                        <tr>
                            <td class="colTableTotalHeader">Menge Kartons</td>
                            <td class="colTableTotal">{{number_format($totalCts,0,',','.')}}</td>
                        </tr>
                        <tr>
                            <td class="colTableTotalHeader">Gesamt VK</td>
                            <td class="colTableTotal">{{number_format($totalVK,2,',','.')}}</td>
                        </tr>
                    </table>
                </div>

            </li>

            <li>
                @foreach ($data['laenderBloecke'] as $block)
                {{ $block['CountryBlock'] }}/
                @endforeach
            </li>
            <li>
                <table style="font-size: 11px;margin-top: 20px;margin-bottom: 20px;">
                    <tr>
                        <td class="abblockth1">Block</td>
                        @foreach ($data['laenderBloecke'] as $block)
                        <td class="abblockth2">{{ $block['CountryBlock'] }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="abblockth1">Menge</td>
                        @foreach ($data['laenderBloecke'] as $block)
                        <td class="abblocktd2">{{ number_format($block['sumCountryBlock'],0,',','.') }}</td>
                        @endforeach

                    </tr>
                    <tr>
                        <td class="abblocktd1">in Kartons</td>
                        @foreach ($data['laenderBloecke'] as $block)
                        <td class="abblocktd2">
                            @if ($data['pp']->PPProduktpass_Verpackungseinheit != 0 )
                            {{ number_format($block['sumCountryBlock']/$data['pp']->PPProduktpass_Verpackungseinheit,0,',','.') }}
                            @else
                            0
                            @endif
                        </td>
                        @endforeach
                    </tr>
                </table>
            </li>

            <li>
                {{ Form::label('DesignEAN','Sortierung/EAN:') }}
                <table style="font-size: 11px;margin-top: 20px;margin-bottom: 20px;">

                    <?php
                    $summeSort     = 0;
                    $summeSortOSDE = 0;
                    $summeSortOSBE = 0;
                    $summeSortOSNL = 0;
                    $summeSortOSCZ = 0;
                    $summeSortOSES = 0;
                    $summeSortOSGB = 0;
                    $summeSortOSFR = 0;
                    $summeSortOSPL = 0;
                    $summeSortOSSK = 0;
                    $lb            = "Start"
                    ?>
                    @foreach ($data['designSort'] as $ds)
                    @if ($lb != $ds['Laenderblock'])
                    @if ($lb != "Start")

                    <tr>
                        <td class="abth1">&nbsp;</td>
                        <td class="abth1">&nbsp;</td>
                        <td class="abth2">&nbsp;</td>
                        <td class="abth2" style="text-align:center;"></td>
                        <td class="abth2" style="">&nbsp;</td>

                        <!--td class="abth2" style=""></td-->
                    </tr>
                    <?php
                    $summeSort     = 0;
                    $summeSortOSDE = 0;
                    $summeSortOSBE = 0;
                    $summeSortOSNL = 0;
                    $summeSortOSCZ = 0;
                    $summeSortOSES = 0;
                    $summeSortOSGB = 0;
                    $summeSortOSFR = 0;
                    $summeSortOSPL = 0;
                    $summeSortOSSK = 0;
                    ?>
                    @endif
                    <tr>
                        <td colspan="7">Länderblöcke: <br><?php echo(substr(str_replace("CB", "<br>CB", $ds['Laenderblock']), 0, 10000)); ?></td>
                    </tr>
                    <tr>
                        <td class="abth1">Design</td>
                        <td class="abth1">Farbe / Style</td>
                        <td class="abth2" style="width:160px;">Design (EN)</td>
                        @if ($ds['max'] < 0)
                        <td class="abth2" style="width:50px;">Menge im Karton</td>
                        <td class="abth2" style="width:150px;">EAN</td>
                        @else
                        <td class="abth2" style="width:200px;" colspan="2">Sortierung</td>

                        @endif

                        <!--td class="abth2" style="width:150px;">EAN (OS)</td-->
                    </tr>
                    @endif
                    <?php
                    $summeSort     += $ds['menge'];
                    $summeSortOSDE += $ds['OSMengeDE'];
                    $summeSortOSGB += $ds['OSMengeGB'];
                    $summeSortOSFR += $ds['OSMengeFR'];
                    $summeSortOSCZ += $ds['OSMengeCZ'];
                    $summeSortOSES += $ds['OSMengeES'];
                    $summeSortOSBE += $ds['OSMengeBE'];
                    $summeSortOSNL += $ds['OSMengeNL'];
                    $summeSortOSPL += $ds['OSMengePL'];
                    $summeSortOSSK += $ds['OSMengeSK'];
                    $lb            = $ds['Laenderblock']
                    ?>
                    <tr>
                        <td class="abblocktd1">{{$ds['header']}}</td>
                        <td class="abblocktd1">{{$ds['design']}}</td>
                        <td class="abblocktd2" style="text-align:left;">{{Form::text('PPM['.$ds['id'].'][PPProduktpass_Sortierung_Translate_Design]',$ds['translate_design'],array('style'=>'width:150px;border:none;'))}}</td>

                        @if ($ds['max'] < 0)
                        <td class="abblocktd2" style="text-align:center;">{{$ds['menge']}}</td>
                        <td class="abblocktd2"  @if (substr($ds['EAN'],0,1) == '#') style="background-color:red;" @endif>{{ Form::text("PPM[".$ds['id']."][EAN]",$ds['EAN'],array('style'=>'text-align:left;width:145px;border:none;padding-right:5px;')) }} </td>
                        @else
                        <td colspan="2" class="abblocktd2" style="width: 600px;">
                            <table style="font-size:10px;">
                                <?php $summeSort     = $ds['menge']; ?>
                                <tr>
                                    <td style="width:100px;"><b>Grösse</b></td>
                                    @for ($ik = 0; $ik <= $ds['max']+1; $ik++)
                                    <td style="text-align:center;width:150px;">{{$ds['SIZE'][$ik+1]}}</td>
                                    @endfor


                                </tr>
                                <tr>
                                    <td>Menge</td>
                                    <td style="text-align:center; ">{{$ds['menge']}}</td>
                                    @for ($ik = 0; $ik <= $ds['max']; $ik++)
                                    <td style="text-align:center;">{{$ds['amenge'][$ik]}}</td>
                                    <?php
                                    try {
                                        $summeSort += $ds['amenge'][$ik];
                                    }
                                    catch (Exception $ex) {
                                        $summeSort += 0;
                                    }
                                    ?>
                                    @endfor
                                </tr>
                                <tr>
                                    <!--td style="text-align:right;">{{ Form::text("PPM[".$ds['id']."][EAN]",$ds['EAN'],array('style'=>'text-align:left;width:100px;border:1px solid lightgray;padding-right:5px;')) }}</td-->
                                    <td>EAN</td>
                                    @for ($ik = 1; $ik <= $ds['max']+2; $ik++)
                                    <td style="text-align:right;">{{ Form::text("PPMA[".$ds['id']."][EAN][$ik]",$ds['AEAN'][$ik],array('style'=>'text-align:left;width:100px;border:1px solid lightgray;padding-right:5px;')) }}</td>
                                    @endfor
                                </tr>
                            </table>
                        </td>
                        @endif

                        <!--td class="abblocktd2">{{ Form::text("PPM[".$ds['id']."][EANOS]",$ds['EANOS'],array('style'=>'text-align:left;width:145px;border:none;padding-right:5px;')) }} </td-->

                    </tr>
                    @endforeach
                    <tr>
                        <td class="abth1">&nbsp;</td>
                        <td class="abth1">&nbsp;</td>
                        <td class="abth2">&nbsp;</td>
                        @if (isset($ds['max']) and $ds['max'] < 0)
                        <td class="abth2" style="text-align:center;">{{$summeSort}}</td>
                        <td class="abth2" style="">&nbsp;</td>
                        @else
                        <td class="abth2"  colspan= "2" style="text-align:center;">&nbsp;</td>
                        @endif

                        <!--td class="abth2" style=""></td-->

                    </tr>


                </table>
            </li>

            <li>
                {{ Form::label('DesignEAN','Sortierung OS:') }}

                <?php
                $lc_start  = 0;
                $lc_length = 7;
                ?>
                @include ('projects.pp_ab_SizeSort')


            </li>




        </div>
        {{Form::close()}}
    </div>
</div>

