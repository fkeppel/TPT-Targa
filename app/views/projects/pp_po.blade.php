<?PHP 
    $bgcolor1 = "#f6a828"; 
?>

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
    #cmds #frm_button{
        width:135px;
        margin:0px;
        height: 28px;
        float: left;
        border:none;
        padding:0px;
    }


    .cpcLocalQuant div {
        width:100%;
        border:1px solid orange;
        padding:15px;
    }
    .cpcLocalQuant table{
        padding: 0px;
        border-collapse: collapse;
        font-family: tahoma;
        font-size: 11px;

        table-layout: fixed;

    }

    .cpcLocalQuant tr:hover{
        background-color: lightskyblue;
    }
    .cpcLocalQuant td{
        padding: 6px;
        border:1px solid lightgray;
        text-align: left;
    }
    .cpcLocalQuant th{
        padding: 6px;
        border:1px solid darkgray;
        font-weight: bold;
        background-color: lightgray;
        text-align: left;
        width:120px;
    }
</style>


<div style="border:none; border-radius: 0px; height:840px;overflow: hidden;">
    <div id="cmds" style=" border:none;height:30px; margin-top: 0px;width:985px;">
        <div id="frm_button">
            {{ Form::open( array('url'=>'outPDFP/'.$data['pp']['PPProduktpass_Id'].'/bw', 'class'=>'form-signin')) }}
            {{ Form::submit('PDF BW', array('class'=>'btn','style'=>'width:120px;background-color: #1C73C5;color:white;border-radius:0px;'))}}
            {{ Form::close() }}
        </div>
        <div id="frm_button">
            {{ Form::open( array('url'=>'outPDFP/'.$data['pp']['PPProduktpass_Id'], 'class'=>'form-signin')) }}
            {{ Form::submit('PDF Andere', array('class'=>'btn','style'=>'width:120px;background-color: #1C73C5;color:white;border-radius:0px;'))}}
            {{ Form::close() }}
        </div>

        @if (Auth::User()->PPMitarbeiter_Gruppe  != 'extern')
        <div id="frm_button">
            {{ Form::open( array('url'=>'outPDFPFinal/'.$data['pp']['PPProduktpass_Id'].'/bw', 'class'=>'form-signin')) }}
            {{ Form::submit('PDF Uplaod BW', array('class'=>'btn','style'=>'width:120px;background-color: #1C73C5;color:white;border-radius:0px;'))}}
            {{ Form::close() }}
        </div>
        <div id="frm_button">
            {{ Form::open( array('url'=>'outPDFPFinal/'.$data['pp']['PPProduktpass_Id'], 'class'=>'form-signin')) }}
            {{ Form::submit('PDF Upload Andere', array('class'=>'btn','style'=>'width:120px; background-color: #1C73C5;color:white;border-radius:0px;'))}}
            {{ Form::close() }}
        </div>

        <div id="frm_button">
            <button onclick="submit_po();" class="btn" style="width:120px;background-color: #1C73C5;color:white;border-radius:0px; border-radius:0px; border:1px solid lightgray; height:25px; padding:5px;margin:3px; border-radius: 5px;">speichern</button>
        </div>
        @endif
    </div>


    <br>

    <div  style="border:1px solid lightgray;padding:5px;height:770px; overflow:auto;">

        <div style="">
            {{ Form::model($data['purchase'], array('url'=>'updatepo', 'class'=>'form-signin', 'id' => 'frm_po')) }}
            {{Form::hidden('Purchase_Id',$data['purchase']->PPPurchase_Id)}}
            {{Form::hidden('Produktpass_Id',$data['pp']->PPProduktpass_Id)}}
            @if (!$data['pp']['PPProduktpass_IsRevision'])
            <!--div style="margin:0 auto;text-align:center;width:110px;position:absolute;top:180px;right:20; z-index: 100;padding-top:8px;border-top:none;">
                {{ Form::submit('speichern', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;'))}}
            </div-->
            @endif
            <div id="POMain" style="">
                <fieldset style="">
                    <legend>
                        Purchase - Order / Übersetzung
                    </legend>


                    <li>
                        <?php
                        try {
                            $orderdate = date_format(date_create_from_format('Y-m-d H:i:s', $data['purchase']->PPPurchase_OrderDate), 'd.m.Y');
                        }
                        catch (Exception $ex) {
                            $orderdate = "N.N.";
                        }
                        ?>
                        <div style="width:600px;border:1px solid lightgrey;overflow:auto;height:80px;float:left;padding:11px;">
                            {{ Form::label('PPPurchase_Supplier','Supplier') }}<br>{{ Form::select('PO[PPPurchase_Supplier]',$data['suppliers'],$data['purchase']->PPPurchase_Supplier,array('style'=>'padding:4px;width:400px;')) }}

                        </div>
                        <div style="width:700px;border:1px solid lightgrey;overflow:auto;height:92px;float:left;padding:5px;margin-left:25px;">
                            {{ Form::label('PPPurchase_Status',"Status",array('style' => 'width:120px;')) }} {{ Form::label('PPPurchase_Status',"Letzter Upload: $orderdate",array('style' => 'width:280px;font-weight:bold;')) }}<br>
                            {{ Form::label('PPPurchase_ManCheckOK','Manuell Geprüft',array('style' => 'width:120px;')) }} <input type="hidden" value="0" name="PO[PPPurchase_ManCheckOK]" /><input name='PO[PPPurchase_ManCheckOK]' type="checkbox" @if($data['purchase']->PPPurchase_ManCheckOK == 1)checked @endif  value="1" style="margin-left:-162px;margin-top:5px;height:20px;"/> <br>
                            {{ Form::select('PO[PPPurchase_Status]',$data['statipo'],$data['purchase']->PPPurchase_Status,array('style'=>'padding:4px;width:400px;')) }} <br>

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
                            <div style="width:700px;border:1px solid lightgrey;overflow:auto;height:92px;float:left;padding:5px;margin-left:25px;">
                                {{ Form::textarea("PO[PPPurchase_Translate_Projectdescription]",$data['purchase']->PPPurchase_Translate_Projectdescription,array('style'=>'width:695px;height:75px;border:none;')) }}
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
                            <div style="width:700px;border:1px solid lightgrey;overflow:auto;height:312px;float:left;padding:5px;margin-left:25px;">
                                {{ Form::textarea("PO[PPPurchase_Translate_Quality]",$data['purchase']->PPPurchase_Translate_Quality,array('style'=>'width:695px;height:295px;border:none;')) }}
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
                                {{$data['pp']->PPProduktpass_Materialstaerke_der_Verkaufsverpackung}}
                            </div>
                            <div style="width:700px;border:1px solid lightgrey;overflow:auto;height:312px;float:left;padding:5px;margin-left:25px;">
                                {{ Form::textarea("PO[PPPurchase_Translate_Packaging]",$data['purchase']->PPPurchase_Translate_Packaging,array('style'=>'width:695px;height:295px;border:none;')) }}
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                    </li>


                    <li>
                        {{ Form::label('DesignEAN','Sortierung/EAN:') }}
                        <div>
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
                                $lb            = "Start";
                                ?>
                                @foreach ($data['designSort'] as $ds)
                                @if (strpos($ds['Laenderblock'],"CB8") === False)


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
                                $summeSortOSPL = 0;
                                $summeSortOSSK = 0;
                                $summeSortOSFR = 0;
                                ?>
                                @endif
                                <?php
                                $oscolor       = (strpos($ds['Laenderblock'], 'OS') !== false)
                                            ? "orange" : "lightblue";
                                ?>
                                <tr  style="background-color:{{$oscolor}}">
                                    <td colspan="7">Länderblöcke:<br><?php echo(substr(str_replace("CB", "<br>CB", $ds['Laenderblock']), 0, 10000)); ?></td>
                                </tr>
                                <tr>
                                    <td class="abth1">Design</td>
                                    <td class="abth1">Farbe / Style</td>
                                    <td class="abth2" style="width:160px;">Design (EN)</td>
                                    @if (isset($ds['max']) and $ds['max'] <= 1)
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
//$summeSortOSSK += $ds['OSMengeSK'];

                                $lb        = $ds['Laenderblock']
                                ?>
                                <tr>
                                    <td class="abblocktd1">{{$ds['header']}}</td>
                                    <td class="abblocktd1">{{$ds['design']}}</td>
                                    <!--td class="abblocktd2" style="text-align:left;">{{Form::text('PPM['.$ds['id'].'][PPProduktpass_Sortierung_Translate_Design]',$ds['translate_design'],array('style'=>'width:150px;border:none;'))}}</td -->
                                    <td class="abblocktd2" style="text-align:left;background-color:lightgray;">
                                        {{
                                        (isset($data['StyleTranslation'][$ds['header']]['Value01']) and strlen($data['StyleTranslation'][$ds['header']]['Value01']) > 0)
                                                            ? $data['StyleTranslation'][$ds['header']]['Value01']
                                                            : $ds['translate_design'];
                                        }}</td>

                                    @if (isset($ds['max']) and $ds['max'] <= 1)
                                    <td class="abblocktd2" style="text-align:center;">{{$ds['menge']}}</td>
                                    <td class="abblocktd2"  @if (substr($ds['EAN'],0,1) == '#')style="background-color:red;"@endif>{{ Form::text("PPM[".$ds['id']."][EAN]",$ds['EAN'],array('style'=>'text-align:left;width:145px;border:none;padding-right:5px;')) }} </td>
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
                                                @if (isset($ds['max']) and $ds['max'] <= 1)
                                                <td style="text-align:center;border:1px solid #0081c2;">{{$ds['menge']}}</td>
                                                @endif
                                                @for ($ik = 0; $ik <$ds['max']; $ik++)
                                                <td style="text-align:center;border:1px solid #0081c2;">{{$ds['amenge'][$ik]}}</td>
                                                <?php $summeSort += $ds['amenge'][$ik]; ?>
                                                @endfor
                                            </tr>
                                            <tr>
                                                <!--td style="text-align:right;">{{ Form::text("PPM[".$ds['id']."][EAN]",$ds['EAN'],array('style'=>'text-align:left;width:100px;border:1px solid lightgray;padding-right:5px;')) }}</td-->
                                                <td style="border:1px solid #0081c2;">EAN</td>
                                                @for ($ik = 1; $ik <= $ds['max']; $ik++)
                                                <?php
                                                $bg        = "";
                                                if (substr($ds['AEAN'][$ik], 0, 1) == '#') {
                                                    $bg = "background-color: red;";
                                                }
                                                ?>
                                                <td style="text-align:left;border:1px solid #0081c2;{{$bg}}">{{ Form::text("PPMA[".$ds['id']."][EAN][$ik]",$ds['AEAN'][$ik],array('style'=>'text-align:left;width:100px;border:1px solid lightgray;padding-right:5px;')) }}</td>
                                                @endfor
                                            </tr>
                                        </table>
                                    </td>
                                    @endif

                                    <!--td class="abblocktd2">{{ Form::text("PPM[".$ds['id']."][EANOS]",$ds['EANOS'],array('style'=>'text-align:left;width:145px;border:none;padding-right:5px;')) }} </td-->

                                </tr>
                                @endif
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
                        </div>
                        <br><!-- comment -->
                    </li>
                    <li>
                        {{ Form::label('DesignEAN','Sortierung OS:') }}

                        <?php
                        $lc_start  = 0;
                        $lc_length = 7;
                        ?>
                        <div>
                            @include ('projects.pp_ab_SizeSort')
                        </div>

                    </li>



                    <li>
                        <table style="border-collapse:collapse;font-size: 12px;margin:20px;">
                            <tr style="background-color:orange;">
                                <td colspan="3" style="border:1px solid gray;"><b>Special Distribution (Kollies per Warehouse)</b></td>
                            </tr>
                            <tr style="background-color:orange;">
                                <td style="border:1px solid gray;"><b>Land</b></td>
                                <td style="border:1px solid gray;"><b>Warehouse</b></td>
                                <td style="border:1px solid gray;"><b>Quantity</b></td>
                            </tr>
                            <?php $cwhd      = 0; ?>

                            @foreach ($data['LWHD'] as $lwhd)
                            <tr>
                                <td  style="border:1px solid gray;">
                                    {{ Form::hidden("LWHD[$cwhd][Id]",  $lwhd['PPLaenderaufteilung_Id'] )}}
                                    {{ Form::text("LWHD[$cwhd][Land]",  $lwhd->PPLaenderaufteilung_Land ,array('style'=>'border:none;padding:4px;width:60px;'))}}</td>
                                <td  style="border:1px solid gray;">{{ Form::text("LWHD[$cwhd][Warehouse]", $lwhd->PPLaenderaufteilung_Warehouse  ,array('style'=>'border:none;padding:4px;width:100px;'))}}</td>
                                <td  style="border:1px solid gray;">{{ Form::text("LWHD[$cwhd][Qty]", $lwhd->PPLaenderaufteilung_Menge_Kollies  ,array('style'=>'text-align:right;border:none;padding:4px;width:80px;'))}}</td>
                            </tr>
                            <?php $cwhd++; ?>
                            @endforeach
                        </table>
                    </li>



                    <li>
                        {{Form::label('FOB Price ['.$data['purchase']->PPPurchase_Currency.']')}} {{ Form::text("PO[PPPurchase_EK]",  number_format($data['purchase']->PPPurchase_EK,3,',','.') ,array('style'=>'padding:4px;width:80px;text-align:right;'))}}<br>
                        {{Form::label('FOB QM  ['.$data['purchase']->PPPurchase_Currency.']')}} {{ Form::text("PO[PPPurchase_FOBQm]",  number_format($data['purchase']->PPPurchase_FOBQm,3,',','.') ,array('style'=>'padding:4px;width:80px;text-align:right;'))}}
                    </li>
                    <li>
                        {{Form::label('Commission')}} {{ Form::select("PO[PPPurchase_IsCommission]",  array(0 =>'Nein',1=>'Ja'), $data['purchase']->PPPurchase_IsCommission, array('style'=>'padding:4px;width:80px;text-align:right;'))}}
                    </li>
                    <li>
                        {{Form::label('FOB Deliverydate')}} {{ Form::text('PO[PPPurchase_DeliveryDate]',$data['purchase']->PPPurchase_DeliveryDate,array('style'=>'padding:4px;width:400px;','id'=>'dtpDeliveryDate', 'autocomplete'=>"off")) }}<br>
                        <div style="padding-left: 145px;padding-top:5px;"> <b>Kalenderwoche: {{$data['purchase']->PPPurchase_FOBWeek}}/{{$data['purchase']->PPPurchase_FOBYear}}</b></div>
                    </li>

                    <!--li>
                        {{Form::label('FOB Deliverydate')}} {{ Form::text("PO[PPPurchase_FOBWeek]",  $data['purchase']->PPPurchase_FOBWeek ,array('style'=>'padding:4px;width:60px;'))}} / {{ Form::text("PO[PPPurchase_FOBYear]",  $data['purchase']->PPPurchase_FOBYear ,array('style'=>'padding:4px;width:60px;'))}}
                    </li -->
                    <li>
                        {{Form::label('FOB Special Deliverydate')}} {{ Form::textarea("PO[PPPurchase_FOBSpecial]",  $data['purchase']->PPPurchase_FOBSpecial ,array('style'=>'padding:4px;width:400px;height:200px;'))}}
                    </li>
                    <li>
                        {{ Form::label('PPPurchase_Currency','Currency') }}{{ Form::select('PO[PPPurchase_Currency]', array(' ' =>'N.N.','EUR'=>'EUR', 'USD'=>'USD'), $data['purchase']->PPPurchase_Currency, array('style'=>'padding:4px;width:80px;')) }}

                    </li>
                    <li>
                        {{ Form::label('PPPurchase_LC_TOP','L/C Zahlungsziel') }}{{ Form::Text('PO[PPPurchase_LC_TOP]',  $data['purchase']->PPPurchase_LC_TOP, array('style'=>'width:80px;')) }} {{ Form::Text('Ax1',  "example: 30 days", array('style'=>'width:120px;')) }}

                    </li>
                    <li>
                        {{Form::label('Terms of Delivery')}} {{ Form::select('PO[PPPurchase_TermsOfDelivery]',$data['tod'],$data['purchase']->PPPurchase_TermsOfDelivery,array('style'=>'padding:4px;width:400px;')) }}
                    </li>
                    <li>
                        {{Form::label('Delivery From')}} {{ Form::select('PO[PPPurchase_DeliveryFrom]',array('N.N.' => 'N.N.', 'Asia' => 'Asia', 'Mediteranean' => 'Mediteranean'), $data['purchase']->PPPurchase_DeliveryFrom,array('style'=>'padding:4px;width:400px;')) }}
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
                        {{Form::label('InspectionCenter')}} {{ Form::select('PO[PPPurchase_InspectionCenter]',array(""=>'N.N.', "Shanghai" => "Shanghai", "Qingdao" => "Qingdao" , "Shenzen" => "Shenzen",  "Xiamen" => "Xiamen"),$data['purchase']->PPPurchase_InspectionCenter,array('style'=>'padding:4px;width:400px;')) }}
                    </li>
                    <li>
                        {{Form::label('Ländergrössen BW')}} {{ Form::select('PO[PPPurchase_BWGroesse]',$data['bwg'],$data['purchase']->PPPurchase_BWGroesse,array('style'=>'padding:4px;width:400px;height:25px;', 'id'=>'PO[PPPurchase_BWGroesse]')) }}
                    </li>


                    <li>
                        {{Form::label('First Sampling')}} {{ Form::text('PO[PPPurchase_FirstSampling]',$data['purchase']->PPPurchase_FirstSampling,array('style'=>'padding:4px;width:400px;','id'=>'dtpFirstSampling', 'autocomplete'=>"off")) }}
                    </li>


                    <li>
                        {{Form::label('Second Sampling')}} {{ Form::text('PO[PPPurchase_SecondSampling]',$data['purchase']->PPPurchase_SecondSampling,array('style'=>'padding:4px;width:400px;','id'=>'dtpSecondSampling', 'autocomplete'=>"off")) }}
                    </li>


                    <li>
                        <!-- GSM: {{$data['pp']->PPProduktpass_Produkt_GSM}}<br><br> -->
                        {{Form::label('GSM')}} {{ Form::text('GSM',number_format($data['pp']->PPProduktpass_Produkt_GSM,0,",","."),array('style'=>'padding:4px;width:400px;height:25px;', 'id'=>'GSM')) }}
                    </li>

                    <?php
                    $cb        = $data['menge']->first()->PPProduktpass_Menge_CountryBlock;
                    $cbek      = $data['menge']->first()->PPProduktpass_Menge_CBEK
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
                        $cb        = $row['PPProduktpass_Menge_CountryBlock'];
                        $cbek      = $row['PPProduktpass_Menge_CBEK'];
                        ?>

                        @endif
                        <tr>
                            <td style="border:1px solid grey;padding:2px;">{{$row['PPProduktpass_Menge_CountryBlock']}}</td>
                            <td style="border:1px solid grey;padding:2px;;text-align: center;">{{ $row->PPProduktpass_Menge_Country }} </td>
                            <td style="border:1px solid grey;padding:2px;text-align: right;">{{ number_format($row->PPProduktpass_Menge_Quantity,0,',','.')}}</td>
                            <td style="border:1px solid grey;padding:2px;text-align: right;">
                                <?php
                                $ek        = ($row->PPProduktpass_Menge_Quantity > 0)
                                            ? number_format($row->PPProduktpass_Menge_EKUSD, 3, ',', '.')
                                            : '';
                                ?>
                                {{ Form::text("inp[".$row['PPProduktpass_Menge_Id']."][PPProduktpass_Menge_EKUSD]",  $ek ,array('class'=>'minp1'))}}
                            </td>
                            <td style="border:1px solid grey;padding:2px;text-align: right;">
                                @if ($row->PPProduktpass_Menge_Quantity > 0)
                                {{ number_format($row->PPProduktpass_Menge_EKUSD * $row->PPProduktpass_Menge_Quantity,2,',','.')}}
                                @endif
                            </td>
                            <td style="border:1px solid grey;text-align: right; padding-right: 5px;">{{ $row->PPProduktpass_Menge_Countrysizes}}</td>
                            <td style="border:1px solid grey;text-align: right; padding-right: 5px;">{{ $row->PPProduktpass_Menge_CountryGSM}}</td>
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





                </fieldset>
            </div>

            {{ Form::close() }}
        </div>
    </div>

</div>

<script>


    $(function () {
        $("#dtpFirstSampling").datepicker({
            firstDay: 1,
            showWeek: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '2015:2050',
            dateFormat: 'yy-mm-dd'

        });
    });
    $(function () {
        $("#dtpSecondSampling").datepicker({
            firstDay: 1,
            showWeek: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '2015:2050',
            dateFormat: 'yy-mm-dd'

        });
    });
    $(function () {
        $("#dtpDeliveryDate").datepicker({
            firstDay: 1,
            showWeek: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '2015:2050',
            dateFormat: 'yy-mm-dd'

        });
    });


    function submit_po() {

        frm = document.getElementById("frm_po");
        console.log(frm);
        frm.submit();// Form submission
    }

</script>
