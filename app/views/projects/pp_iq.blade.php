<?php $bgcolor1 = "#f6a828"; ?>

<style>
    .poth1, .poth2, .poth3{
        background-color:#d9d9d9;
        border: 1px solid lightgrey;
        padding:4px;
    }
    .poth1 {
        width:100px;
    }
    .poth2 {
        width:150px;
    }
    .poth3{
        width:100px;text-align:right;
    }
    .potdl, .potdr {
        border:1px solid lightgrey;
        padding:4px;
    }
    .potdr {
        text-align:right;
    }
    li{
        margin-bottom:10px;
    }
</style>
<div style="border:none;">
    <div>{{$data['message']}}</div>
    <div style="position:relative;">

        <div style="margin:0 auto;text-align:center;width:130px;border:none;;border-radius: 5px;position:absolute;top:10px;right:5px; z-index: 10;height:200px;background-color: transparent;">

            {{ Form::open( array('url'=>'outPDFP/'.$data['pp']['PPProduktpass_Id'].'/bw', 'class'=>'form-signin')) }}
            {{ Form::submit('PDF BW', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;'))}}
            {{ Form::close() }}
            {{ Form::open( array('url'=>'outPDFP/'.$data['pp']['PPProduktpass_Id'], 'class'=>'form-signin')) }}
            {{ Form::submit('PDF Andere', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;'))}}
            {{ Form::close() }}
            {{ Form::open( array('url'=>'outPDFPFinal/'.$data['pp']['PPProduktpass_Id'].'/bw', 'class'=>'form-signin')) }}
            {{ Form::submit('PDF Uplaod BW', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;'))}}
            {{ Form::close() }}
            {{ Form::open( array('url'=>'outPDFPFinal/'.$data['pp']['PPProduktpass_Id'], 'class'=>'form-signin')) }}
            {{ Form::submit('PDF Upload Andere', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;'))}}
            {{ Form::close() }}

            <!--{{ Form::open( array('url'=>'outPDFPFinal/'.$data['pp']['PPProduktpass_Id'], 'class'=>'form-signin')) }}
                    {{ Form::submit('PDF (Final)', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;'))}}
            {{ Form::close() }} -->


        </div>
    </div>

    <div>

        <div style="position:relative;">
            {{ Form::model($data['purchase'], array('url'=>'updatepo', 'class'=>'form-signin')) }}
            {{Form::hidden('Purchase_Id',$data['purchase']->PPPurchase_Id)}}
            {{Form::hidden('Produktpass_Id',$data['pp']->PPProduktpass_Id)}}
            @if (!$data['pp']['PPProduktpass_IsRevision'])
            <div style="margin:0 auto;text-align:center;width:110px;position:absolute;top:180px;right:20; z-index: 100;padding-top:8px;border-top:none;">
                {{ Form::submit('speichern', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;'))}}
            </div>
            @endif
            <div style="">
                <fieldset style="">
                    <legend>
                        Purchase - Order / Übersetzung
                    </legend>

                    <ul>
                        <li>
                            <div style="width:600px;border:1px solid lightgrey;overflow:auto;height:80px;float:left;padding:11px;">
                                {{ Form::label('PPPurchase_Supplier','Supplier') }}<br>{{ Form::select('PO[PPPurchase_Supplier]',$data['suppliers'],$data['purchase']->PPPurchase_Supplier,array('style'=>'padding:4px;width:400px;')) }}
                            </div>
                            <div style="width:600px;border:1px solid lightgrey;overflow:auto;height:92px;float:left;padding:5px;margin-left:25px;">
                                {{ Form::label('PPPurchase_Status','Status') }}<br>{{ Form::select('PO[PPPurchase_Status]',$data['statipo'],$data['purchase']->PPPurchase_Status,array('style'=>'padding:4px;width:400px;')) }}

                            </div>
                            <div style="clear: both;"></div>
                        </li>

                        <li>
                            {{ Form::label('PPPurchase_BemerkungenAenderungen','Änderungsprotokoll') }}

                            <div>
                                <div style="width:600px;border:1px solid lightgrey;overflow:auto;height:100px;float:left;padding:5px;margin-left:25px;">
                                    {{ Form::textarea("PO[PPPurchase_BemerkungAenderungen]",$data['purchase']->PPPurchase_BemerkungAenderungen,array('style'=>'width:595px;height:90px;border:none;')) }}
                                </div>
                                <div style="clear: both;"></div>
                            </div>


                        </li>
                        <li>
                            {{ Form::label('PPPurchase_Translate_Projectdescription','ProjektDescription') }}

                            <div>
                                <div style="width:600px;border:1px solid lightgrey;overflow:auto;height:80px;float:left;padding:11px;">
                                    {{$data['pp']->PPProduktpass_Artikelbezeichnung}}
                                </div>
                                <div style="width:600px;border:1px solid lightgrey;overflow:auto;height:92px;float:left;padding:5px;margin-left:25px;">
                                    {{ Form::textarea("PO[PPPurchase_Translate_Projectdescription]",$data['purchase']->PPPurchase_Translate_Projectdescription,array('style'=>'width:595px;height:75px;border:none;')) }}
                                </div>
                                <div style="clear: both;"></div>
                            </div>


                        </li>
                        <li>
                            {{ Form::label('PPPurchase_ManufacturingPlant','Manufacturing Plant') }}<br>
                            {{ Form::select('PO[PPPurchase_ManufacturingPlant]',$data['plants'],$data['purchase']->PPPurchase_ManufacturingPlant,array('style'=>'padding:4px;width:400px;')) }}<br>
                            <!--{{ Form::text("PO[PPPurchase_Translate_ManufacturingPlant]",$data['purchase']->PPPurchase_Translate_ManufacturingPlant,array('style'=>'width:400px;')) }}-->


                        </li>

                        <li>
                            {{ Form::label('PPPurchase_Quality','Qualität') }}
                            <div>
                                <div style="width:600px;border:1px solid lightgrey;overflow:auto;height:300px;float:left;padding:11px;">
                                    {{$data['qualitypo']}}
                                </div>
                                <div style="width:600px;border:1px solid lightgrey;overflow:auto;height:312px;float:left;padding:5px;margin-left:25px;">
                                    {{ Form::textarea("PO[PPPurchase_Translate_Quality]",$data['purchase']->PPPurchase_Translate_Quality,array('style'=>'width:595px;height:295px;border:none;')) }}
                                </div>
                                <div style="clear: both;"></div>
                            </div>
                        </li>


                        <!--li>
                                {{ Form::label('PPPurchase_Translate_Assortment','Assortment') }}
                        </li-->
                        <li>
                            {{ Form::label('PPurchase_Translate_Packaging','Packaging') }}
                            <div>
                                <div style="width:600px;border:1px solid lightgrey;overflow:auto;height:200px;float:left;padding:11px;">
                                    {{$data['pp']->PPProduktpass_Verkaufsverpackung}}
                                </div>
                                <div style="width:600px;border:1px solid lightgrey;overflow:auto;height:212px;float:left;padding:5px;margin-left:25px;">
                                    {{ Form::textarea("PO[PPPurchase_Translate_Packaging]",$data['purchase']->PPPurchase_Translate_Packaging,array('style'=>'width:395px;height:195px;border:none;')) }}
                                </div>
                                <div style="clear: both;"></div>
                            </div>
                        </li>


                        <li>
                            {{ Form::label('DesignEAN','Sortierung/EAN:') }}
                            <table style="font-size: 11px;margin-top: 20px;margin-bottom: 20px;">

                                <?php
                                $summeSort = 0;
                                $summeSortOSDE = 0;
                                $summeSortOSBE = 0;
                                $summeSortOSNL = 0;
                                $summeSortOSCZ = 0;
                                $summeSortOSES = 0;
                                $summeSortOSGB = 0;
                                $summeSortOSFR = 0;
                                $summeSortOSPL = 0;
                                $summeSortOSSK = 0;
                                $lb = "Start"
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
                                $summeSort = 0;
                                $summeSortOSDE = 0;
                                $summeSortOSBE = 0;
                                $summeSortOSNL = 0;
                                $summeSortOSCZ = 0;
                                $summeSortOSES = 0;
                                $summeSortOSGB = 0;
                                $summeSortOSPL = 0;
                                $summeSortOSSK = 0;
                                $summeSortOSFR = 0;
                                ?>
                                @endif
                                <tr>
                                    <td colspan="7">Länderblöcke:<br><?php echo(substr(str_replace("CB", "<br>CB", $ds['Laenderblock']), 0, 10000)); ?></td>
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
                                $summeSort += $ds['menge'];
                                $summeSortOSDE += $ds['OSMengeDE'];
                                $summeSortOSGB += $ds['OSMengeGB'];
                                $summeSortOSFR += $ds['OSMengeFR'];
                                $summeSortOSCZ += $ds['OSMengeCZ'];
                                $summeSortOSES += $ds['OSMengeES'];
                                $summeSortOSBE += $ds['OSMengeBE'];
                                $summeSortOSNL += $ds['OSMengeNL'];
                                $summeSortOSPL += $ds['OSMengePL'];
                                $summeSortOSSK += $ds['OSMengeSK'];
//$summeSortOSSK += $ds['OSMengeSK'];

                                $lb = $ds['Laenderblock']
                                ?>
                                <tr>
                                    <td class="abblocktd1">{{$ds['header']}}</td>
                                    <td class="abblocktd1">{{$ds['design']}}</td>
                                    <td class="abblocktd2" style="text-align:left;">{{Form::text('PPM['.$ds['id'].'][PPProduktpass_Sortierung_Translate_Design]',$ds['translate_design'],array('style'=>'width:150px;border:none;'))}}</td>

                                    @if ($ds['max'] < 0)
                                    <td class="abblocktd2" style="text-align:center;">{{$ds['menge']}}</td>
                                    <td class="abblocktd2" style="">{{ Form::text("PPM[".$ds['id']."][EAN]",$ds['EAN'],array('style'=>'text-align:left;width:145px;border:none;padding-right:5px;')) }} </td>
                                    @else
                                    <td colspan="2" class="abblocktd2" style="width: 600px;">
                                        <table style="font-size:10px;">
                                            <?php $summeSort = $ds['menge']; ?>
                                            <tr>
                                               	<td style="width:100px;border:1px solid #0081c2;"><b>Grösse</b></td>
                                                @for ($ik = 1; $ik <= $ds['max']; $ik++)
                                                <td style="text-align:center;width:150px;border:1px solid #0081c2;">{{$ds['SIZE'][$ik]}}</td>
                                                @endfor


                                            </tr>
                                            <tr>
                                                <td style="border:1px solid #0081c2;">Menge</td>
                                                <td style="text-align:center; ">{{$ds['menge']}}</td>
                                                @for ($ik = 0; $ik <= $ds['max']; $ik++)
                                                <td style="text-align:center;border:1px solid #0081c2;">{{$ds['amenge'][$ik]}}</td>
                                                <?php $summeSort += $ds['amenge'][$ik]; ?>
                                                @endfor
                                            </tr>
                                            <tr>
                                                <!--td style="text-align:right;">{{ Form::text("PPM[".$ds['id']."][EAN]",$ds['EAN'],array('style'=>'text-align:left;width:100px;border:1px solid lightgray;padding-right:5px;')) }}</td-->
                                                <td style="border:1px solid #0081c2;">EAN</td>
                                                @for ($ik = 1; $ik <= $ds['max']+2; $ik++)
                                                <td style="text-align:left;border:1px solid #0081c2;">{{ Form::text("PPMA[".$ds['id']."][EAN][$ik]",$ds['AEAN'][$ik],array('style'=>'text-align:left;width:100px;border:1px solid lightgray;padding-right:5px;')) }}</td>
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
                                    @if ($ds['max'] < 0)
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
                            $lc_start = 0;
                            $lc_length = 7;
                            ?>
                            @include ('projects.pp_ab_SizeSort')


                        </li>




                        <li>
                            {{Form::label('FOB Price ['.$data['purchase']->PPPurchase_Currency.']')}} {{ Form::text("PO[PPPurchase_EK]",  number_format($data['purchase']->PPPurchase_EK,3,',','.') ,array('style'=>'padding:4px;width:80px;'))}}
                        </li>
                        <li>
                            {{Form::label('FOB Deliverydate')}} {{ Form::text("PO[PPPurchase_FOBWeek]",  $data['purchase']->PPPurchase_FOBWeek ,array('style'=>'padding:4px;width:60px;'))}} / {{ Form::text("PO[PPPurchase_FOBYear]",  $data['purchase']->PPPurchase_FOBYear ,array('style'=>'padding:4px;width:60px;'))}}
                        </li>
                        <li>
                            {{Form::label('FOB Spicial Deliverydate')}} {{ Form::textarea("PO[PPPurchase_FOBSpecial]",  $data['purchase']->PPPurchase_FOBSpecial ,array('style'=>'padding:4px;width:400px;height:200px;'))}}
                        </li>
                        <li>
                            {{ Form::label('PPPurchase_Currency','Currency') }}{{ Form::select('PO[PPPurchase_Currency]', array(' ' =>'N.N.','EUR'=>'EUR', 'USD'=>'USD'), $data['purchase']->PPPurchase_Currency, array('style'=>'width:80px;')) }}

                        </li>
                        <li>
                            {{ Form::label('PPPurchase_LC_TOP','L/C Zahlungsziel') }}{{ Form::Text('PO[PPPurchase_LC_TOP]',  $data['purchase']->PPPurchase_LC_TOP, array('style'=>'width:80px;')) }} {{ Form::Text('Ax1',  "example: 30 days", array('style'=>'width:120px;')) }}

                        </li>
                        <li>
                            {{Form::label('Terms of Delivery')}} {{ Form::select('PO[PPPurchase_TermsOfDelivery]',$data['tod'],$data['purchase']->PPPurchase_TermsOfDelivery,array('style'=>'padding:4px;width:400px;')) }}
                        </li>
                        <li>
                            {{Form::label('Terms of Payment')}} {{ Form::select('PO[PPPurchase_TermsOfPayment]',$data['top'],$data['purchase']->PPPurchase_TermsOfPayment,array('style'=>'padding:4px;width:400px;')) }}
                        </li>
                        <li>
                            {{Form::label('Transportdokumente (nicht CH)')}} {{ Form::Text('PO[PPPurchase_Transportdokumente]',$data['purchase']->PPPurchase_Transportdokumente,array('style'=>'padding:4px;width:400px;height:25px;')) }}
                        </li>
                        <!--li>
                                {{Form::label('Transportdokumente Liste')}} {{ Form::select('PO[PPPurchase_Transportdokumente2]',$data['transportdok2'],$data['purchase']->PPPurchase_Transportdokumente2,array('style'=>'padding:4px;width:400px;height:25px;')) }}
                        </li-->
                        <li>

                            {{Form::label('Prüfinstitut')}} {{ Form::text('PO[PPPurchase_Pruefinstitut]',$data['purchase']->PPPurchase_Pruefinstitut,array('style'=>'padding:4px;width:400px;')) }}
                        </li>
                        <li>
                            {{Form::label('Ländergrössen BW')}} {{ Form::select('PO[PPPurchase_BWGroesse]',$data['bwg'],$data['purchase']->PPPurchase_BWGroesse,array('style'=>'padding:4px;width:400px;height:25px;', 'id'=>'PO[PPPurchase_BWGroesse]')) }}
                        </li>




                        <li>
                            <!--// Ländermengen / EKs-->

                            GSM: {{$data['pp']->PPProduktpass_Produkt_GSM}}<br><br>

                            <?php
                            $cb = $data['menge']->first()->PPProduktpass_Menge_CountryBlock;
                            $cbek = $data['menge']->first()->PPProduktpass_Menge_CBEK
                            ?>
                            <table style="border:1px solid grey;border-collapse: collapse;font-family: 'Open Sans',Tahoma, Arial, Helvetica, sans-serif;font-size: 10px;" >
                                <tr>
                                    <th style="border:1px solid grey;padding:2px;background-color: lightgray;width:80px;">CB</th>
                                    <th style="border:1px solid grey;padding:2px;background-color: lightgray;width:50px;">Country</th>
                                    <th style="border:1px solid grey;padding:2px;background-color: lightgray;width:60px;text-align: right;">Quantity</th>
                                    <th style="border:1px solid grey;padding:2px;background-color: lightgray;width:60px;text-align: right;">EK {{$data['purchase']->PPPurchase_Currency}}</th>
                                    <th style="border:1px solid grey;padding:2px;background-color: lightgray;width:60px;">EK Total ({{$data['purchase']->PPPurchase_Currency}})</th>
                                    <th style="border:1px solid grey;padding:2px;background-color: lightgray;width:150px;text-align: right">Ländergrössen</th>
                                    <th style="border:1px solid grey;padding:2px;background-color: lightgray;width:150px;text-align: right">Stückgewicht</th>
                                </tr>
                                @foreach ($data['menge'] as $row)
                                @if ($row['PPProduktpass_Menge_CountryBlock'] != $cb)
                                <tr>
                                    <td style="border:1px solid grey;padding:2px;background-color: {{$bgcolor1}}">{{$cb}}</td>
                                    <td style="border:1px solid grey;padding:2px;;text-align: center;background-color: {{$bgcolor1}}"></td>
                                    <td style="border:1px solid grey;padding:2px;text-align: right;background-color: {{$bgcolor1}}"></td>
                                    <td style="border:1px solid grey;padding:2px;text-align: right;background-color: {{$bgcolor1}}">
                                        {{ Form::text("cb_ek_inp[".$cb."]",  number_format($cbek,3,',','.') ,array('class'=>'minp1'))}}
                                    </td>
                                    <td style="border:1px solid grey;padding:2px;text-align: right;background-color: {{$bgcolor1}}">
                                    </td>
                                    <td style="border:1px solid grey;padding:2px;text-align: right;background-color: {{$bgcolor1}}">
                                    </td>
                                    <td style="border:1px solid grey;padding:2px;text-align: right;background-color: {{$bgcolor1}}">
                                    </td>
                                </tr>
                                <?php
                                $cb = $row['PPProduktpass_Menge_CountryBlock'];
                                $cbek = $row['PPProduktpass_Menge_CBEK'];
                                ?>

                                @endif
                                <tr>
                                    <td style="border:1px solid grey;padding:2px;">{{$row['PPProduktpass_Menge_CountryBlock']}}</td>
                                    <td style="border:1px solid grey;padding:2px;;text-align: center;">{{ $row->PPProduktpass_Menge_Country }} </td>
                                    <td style="border:1px solid grey;padding:2px;text-align: right;">{{ number_format($row->PPProduktpass_Menge_Quantity,0,',','.')}}</td>
                                    <td style="border:1px solid grey;padding:2px;text-align: right;">
                                        <?php $ek = ($row->PPProduktpass_Menge_Quantity > 0) ? number_format($row->PPProduktpass_Menge_EKUSD, 3, ',', '.') : ''; ?>
                                        {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_EKUSD]",  $ek ,array('class'=>'minp1'))}}
                                    </td>
                                    <td style="border:1px solid grey;padding:2px;text-align: right;">
                                        @if ($row->PPProduktpass_Menge_Quantity > 0)
                                        {{ number_format($row->PPProduktpass_Menge_EKUSD *$row->PPProduktpass_Menge_Quantity,2,',','.')}}
                                        @endif
                                    </td>
                                    <td style="border:1px solid grey;padding:2px;text-align: left;">
                                        {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_Countrysizes]",  $row->PPProduktpass_Menge_Countrysizes ,array('class'=>'minp1','style' => 'width:200px;text-align:right;vertical-align:top;'))}}
                                    </td>
                                    <td style="border:1px solid grey;padding:2px;text-align: left;">
                                        {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_CountryGSM]",  $row->PPProduktpass_Menge_CountryGSM ,array('class'=>'minp1','style' => 'width:200px;text-align:right;vertical-align:top;'))}}
                                    </td>
                                </tr>

                                @endforeach
                                <tr>
                                    <td style="border:1px solid grey;padding:2px;background-color: {{$bgcolor1}}">{{$cb}}</td>
                                    <td style="border:1px solid grey;padding:2px;;text-align: center;background-color: {{$bgcolor1}}"></td>
                                    <td style="border:1px solid grey;padding:2px;text-align: right;background-color: {{$bgcolor1}}"></td>
                                    <td style="border:1px solid grey;padding:2px;text-align: right;background-color: {{$bgcolor1}}">
                                        {{ Form::text("cb_ek_inp[".$cb."]",  number_format($cbek,3,',','.') ,array('class'=>'minp1'))}}
                                    </td>
                                    <td style="border:1px solid grey;padding:2px;text-align: right;background-color: {{$bgcolor1}}">
                                    </td>
                                    <td style="border:1px solid grey;padding:2px;text-align: right;background-color: {{$bgcolor1}}">
                                    </td>
                                    <td style="border:1px solid grey;padding:2px;text-align: right;background-color: {{$bgcolor1}}">
                                    </td>
                                </tr>

                                <tr>
                                    <td style="border:1px solid grey;padding:2px;background-color: lightgray;">&nbsp;</td>
                                    <td style="border:1px solid grey;padding:2px;background-color: lightgray;">&nbsp;</td>
                                    <td style="border:1px solid grey;padding:2px;background-color: lightgray;text-align: right;">Quantity</td>
                                    <td style="border:1px solid grey;padding:2px;background-color: lightgray;text-align: right;">&nbsp;</td>
                                    <td style="border:1px solid grey;padding:2px;background-color: lightgray;text-align: right;">EK Total ({{$data['purchase']->PPPurchase_Currency}})</td>
                                    <td style="border:1px solid grey;padding:2px;background-color: lightgray;width:150px;text-align: right">&nbsp;</td>
                                    <td style="border:1px solid grey;padding:2px;background-color: lightgray;width:150px;text-align: right">&nbsp;</td>
                                </tr>


                            </table>

                        </li>



                    </ul>


                </fieldset>
            </div>

            {{ Form::close() }}
        </div>
    </div>
</div>