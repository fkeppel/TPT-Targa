
<style>

    .cpc_avis {
        font-family:'Open Sans';
        font-size: 12px;
    }
    .cpc_avis table {
        border-collapse:collapse;
        margin:10px;
        font-family:'Open Sans';
        font-size: 12px;

    }

    .table_ohne_rand {

    }
    .cpc_avis th, td {
        width:100px;
        border: none;
        vertical-align:top;
        min-height:20px;
        padding:4px;
    }
    .cpc_avis th{
        background-color:#E1E1E1;
    }
    .cpc_avis	p{
        padding:5px;
        width:300px;
        height:20px;
        border:1px solid gray;
        background-color:#EDEDED;
        font-family:'Open Sans';
        margin-left:10px;

    }
    .cpc_avis button{
        width:80px;
        margin:5px;
    }
    .cpc_avis select{
        width:200px;
    }
    .cpc_avis input{
        width:100px;
        border-radius:0;

    }
    .avis_lb {
        text-align:right;
        color:red;
    }
    .cpc_avis label{
        width:220px;
    }
</style>


<div class="cpc_avis" style="border:1px solid gray;padding:20px;">
    <form method="POST" action="/updateLieferavis">
        <input name="ppid" type="hidden" value="{{$data['pp']->PPProduktpass_Id}}">


        <div style="position:relative;">
            <div style="Position:absolute;right:0;top:0;width:220px;height:70px;text-align: right;">
                <button type="submit" value="save">Speichern</button>
                @if ($data['lieferavis_has_data'])
                <a href="/Lieferavis2XML/{{$data['lieferavis']['AVIS']->PPLieferavis_Id}}" target="_blank">XML</a>
                @endif

            </div>


            <table>
                <tr>
                    <td >Lieferavis</td>
                    <td> <select type="text" name="SELECT" style="width:200px;">
                            <option>Bitte wählen...</option>
                            <option>NEU</option>
                            @foreach ($data['Lieferavise'] as $key => $las )
                            <option value="{{$las}}">{{$key}}</option>
                            @endforeach

                    </td>
                    <td>Avis-Nummer</td>
                    <td><input name="AVISNR_NEU"></td>
                </tr>
            </table>
            <button type="submit" name="submit" value="Go"> Go </button>



            @if ($data['lieferavis_has_data'])
            <p>Lieferavis <b>{{$data['lieferavis']['AVIS']->PPLieferavis_AvisNr}}</b> zu IAN {{$data['pp']->PPProduktpass_IAN}}</p>


            <p>Kopfdaten</p>
            {{ Form::hidden('LierferavisID', $data['lieferavis']['AVIS']->PPLieferavis_Id ) }}
            <table>
                <tr>
                    <td>{{ Form::label('Lieferavis-Nummer',NULL,array('style'=>'float:left;')) }}</td>
                    <td>{{ Form::text('H[AvisNr]', $data['lieferavis']['AVIS']->PPLieferavis_AvisNr) }}</td>
                    <td>{{ Form::label('Lieferanten-Nummer',"Lieferanten-Nr",array('style'=>'float:left;')) }}</td>
                    <td> {{ Form::text('H[SupplierId]', "4942") }} </td>
                </tr>
                <tr>
                    <td >{{ Form::label('ETD',NULL,array('style'=>'float:left;')) }}</td>
                    <td>{{ Form::text('H[ETD]', $data['lieferavis']['AVIS']->PPLieferavis_ETD,array('id'=>'avis_ETA','class'=>'datepicker_avis')) }} </td>

                    <td>{{ Form::label('ETA',NULL,array('style'=>'float:left;')) }}</td>
                    <td> {{ Form::text('H[ETA]', $data['lieferavis']['AVIS']->PPLieferavis_ETA,array('id'=>'avis_ETD','class'=>'datepicker_avis')) }}</td>
                </tr>
                <tr>
                    <td>{{ Form::label('Port of Loading',NULL,array('style'=>'float:left;')) }}</td>
                    <td>
                        {{ Form::select('H[POL]',$data['lidlhaefen'],$data['lieferavis']['AVIS']->PPLieferavis_POL) }}
                    </td>

                    <td>{{ Form::label('Port of Discharge',NULL,array('style'=>'float:left;')) }}</td>
                    <td> {{ Form::select('H[POD]',$data['lidlhaefen'],$data['lieferavis']['AVIS']->PPLieferavis_POD) }}</td>
                </tr>
                <tr>
                    <td>{{ Form::label('Spediteur',NULL,array('style'=>'float:left;')) }}</td>
                    <td>
                        {{ Form::select('H[SpediteurId]',$data['spediteure'],$data['lieferavis']['AVIS']->PPLieferavis_SpediteurId,array('style'=>'')) }}
                    </td>

                    <td>{{ Form::label('Frachtführer',NULL,array('style'=>'float:left;')) }}</td>
                    <td>
                        {{ Form::select('H[FrachtfuehrerId]',$data['frachtfuehrer'],$data['lieferavis']['AVIS']->PPLieferavis_FrachtfuehrerId,array('style'=>'')) }}
                    </td>
                </tr>
                <tr>
                    <td>{{ Form::label('Sea/Air',NULL,array('style'=>'float:left;')) }}</td>
                    <td>{{ Form::select('H[SeaAir]',array(" "=>" ","Y030"=>"Seefracht","Y060"=>"Luftfracht", ),$data['lieferavis']['AVIS']->PPLieferavis_SeaAir,array('style'=>'')) }}</td>
                    <td>{{ Form::label('IMO (Schiffsnummer)',NULL,array('style'=>'float:left;')) }}</td>
                    <td> {{ Form::text('H[IMO]', $data['lieferavis']['AVIS']->PPLieferavis_IMO) }}</td>
                </tr>
                <tr>
                    <td>{{ Form::label('Incoterm',NULL,array('style'=>'float:left;')) }}</td>
                    <td>
                        {{ Form::select('H[Incoterm]',array("   ","FOB","FCA", "DDP","DAP", "DAT" ),$data['lieferavis']['AVIS']->PPLieferavis_Incoterm,array('style'=>'')) }}
                    </td>

                    <td>{{ Form::label('Incoterm II (Hafen)',NULL,array('style'=>'float:left;')) }}</td>
                    <td>{{ Form::text('H[Incoterm2]', $data['lieferavis']['AVIS']->PPLieferavis_Incoterm2) }}</td>
                </tr>
                <tr>
                    <td>{{ Form::label('Abgangsland (Start des Transports)',NULL,array('style'=>'float:left;')) }}</td>
                    <td>
                        {{ Form::select('H[Abgangsland]',array(
							"  ",
							"BE",
							"BE",
							"CN",
							"DE",
							"DJ",
							"EG",
							"ES",
							"HK",
							"ID",
							"IN",
							"KH",
							"KR",
							"LK",
							"MM",
							"MO",
							"NL",
							"PK",
							"PK",
							"PY",
							"SG",
							"SI",
							"TH",
							"TR",
							"TW",
							"VN"), $data['lieferavis']['AVIS']->PPLieferavis_Abgangsland,array('style'=>'')) }}
                    </td>


                    <td>{{ Form::label('Bemerkung',NULL,array('style'=>'float:left;')) }}</td>
                    <td>{{ Form::textarea('H[Remark]', $data['lieferavis']['AVIS']->PPLieferavis_Remark, array('style'=>'width:600px;height:80px;'))}}</td>
                </tr>


            </table>

            <p>Materialdaten</p>
            <table style="table-layout: fixed;">
                <tr>
                    <th style="width:100px;">Pos-Nr</th>
                    <th style="width:100px;">Order-Nr</th>
                    <th style="width:100px;">Order-PosNr</th>
                    <th style="width:125px;">Artikelnummer</th>
                    <th style="width:100px;">Menge (CTS)</th>
                    <th style="width:100px;">Order-GTIN</th>
                    <th style="width:100px;">&nbsp;</th>
                </tr>

                @if (isset($data['lieferavis']['MATERIAL']) >0)
                <?php $i = 0; ?>
                @foreach($data['lieferavis']['MATERIAL'] as $material)
                <tr>
                    <td><input type="text" name="MD[{{$i}}][AvisPosNr]" value="{{$material->PPLieferavis_Material_AvisPosNr}}" style="text-align: center;"/></td>
                    <td><input type="text" name="MD[{{$i}}][OrderNr]" value="{{$material->PPLieferavis_Material_OrderNr}}"/>{{ Form::hidden("MD_NDX[$i]", $material->PPLieferavis_Material_Id) }}</td>
                    <td><input type="text" name="MD[{{$i}}][OrderPosNr]" value="{{$material->PPLieferavis_Material_OrderPosNr}}"/></td>
                    <td><input type="text" name="MD[{{$i}}][Materialnr]" value="{{$material->PPLieferavis_Material_Materialnr}}" style="width:120px;"/></td>
                    <td><input type="text" name="MD[{{$i}}][Menge]" value="{{number_format($material->PPLieferavis_Material_Menge,0,',','.')}}"  class="avis_lb"/></td>
                    <td><input type="text" name="MD[{{$i}}][OrderGTIN]" value="{{$material->PPLieferavis_Material_OrderGTIN}}"/></td>
                    <td style="padding:8px;"> <input style="width:10px;" type="checkbox" name="MDDEL[{{$i}}]" />Löschen </td>
                </tr>

                <?php $i++; ?>
                @endforeach
                @endif
                <tr>
                    {{ Form::hidden("MD_NDX[$i]", 0) }}
                    <td><input type="text" name="MD[{{$i}}][AvisPosNr]" value="{{$i+1}}" style="text-align: center;"/></td>
                    <td><input type="text" name="MD[{{$i}}][OrderNr]" value=""/></td>
                    <td><input type="text" name="MD[{{$i}}][OrderPosNr]" value=""/></td>
                    <td><input type="text" name="MD[{{$i}}][Materialnr]" value="" style="width:120px;"/></td>
                    <td><input type="text" name="MD[{{$i}}][Menge]" value=""  class="avis_lb"/></td>
                    <td><input type="text" name="MD[{{$i}}][OrderGTIN]" value=""/></td>
                    <td ><button type="submit" name="submit" value="NewMaterial">speichern</button></td>
                </tr>
            </table>

            <p>Verpackungsdaten</p>
            <table>
                <tr>
                    <th style="width:125px;">Artikelnummer (9-stellig)</th>
                    <th>Länge (cm)</th>
                    <th>Breite (cm)</th>
                    <th>Höhe (cm)</th>
                    <th>Brutto-Gew (kg)</th>
                    <th>Netto-Gew (kg)</th>
                    <th style="width:50px;">&nbsp;</th>
                </tr>
                <?php $i = 0; ?>
                @foreach($data['lieferavis']['MARM'] as $marm)
                <tr>
                    <td>{{ Form::hidden("MARM_NDX[$i]", $marm->PPLieferavis_MARM_Id) }}
                        <input type="text" name="MARM[{{$i}}][SATNR]" value="{{$marm->PPLieferavis_MARM_SATNR}}"  style="width:120px;"/></td>
                    <td><input type="text" name="MARM[{{$i}}][Laenge]" value="{{$marm->PPLieferavis_MARM_Laenge}}"  class="avis_lb"/></td>
                    <td><input type="text" name="MARM[{{$i}}][Breite]" value="{{$marm->PPLieferavis_MARM_Breite}}" class="avis_lb"/></td>
                    <td><input type="text" name="MARM[{{$i}}][Hoehe]" value="{{$marm->PPLieferavis_MARM_Hoehe}}" class="avis_lb"/></td>
                    <td><input type="text" name="MARM[{{$i}}][Brutto]" value="{{number_format($marm->PPLieferavis_MARM_Brutto,0,',','.')}}" class="avis_lb"/></td>
                    <td><input type="text" name="MARM[{{$i}}][Netto]" value="{{number_format($marm->PPLieferavis_MARM_Netto,0,',','.')}}" class="avis_lb"/></td>
                    <td style="padding:8px;"><input type="checkbox" name="MARMDEL[{{$i}}]" style="width:10px;" />Löschen</td>
                </tr>
                <?php $i++; ?>
                @endforeach
                <tr>
                    <td>{{ Form::hidden("MARM_NDX[$i]",0) }}
                        <input type="text" name="MARM[{{$i}}][SATNR]"  style="width:120px;"/></td>
                    <td><input type="text" name="MARM[{{$i}}][Laenge]"  class="avis_lb"/></td>
                    <td><input type="text" name="MARM[{{$i}}][Breite]"  class="avis_lb"/></td>
                    <td><input type="text" name="MARM[{{$i}}][Hoehe]"  class="avis_lb"/></td>
                    <td><input type="text" name="MARM[{{$i}}][Brutto]"  class="avis_lb"/></td>
                    <td><input type="text" name="MARM[{{$i}}][Netto]"  class="avis_lb"/></td>
                    <td><button type="submit" name="submit" value="NewMARM">speichern</button></td>
                </tr>
            </table>


            <style>
                .bldaten td {
                    border:1px solid lightgray;
                }
                .bldaten table {
                    table-layout:fixed;
                    border-collapse: collapse;

                }
                .bldaten .tdheader {
                    background-color: #dedede;
                }
                .bldaten .tdinput{
                    background-color: #FFF;
                    padding:0px;
                }
                .bldaten th {
                    height:1px;
                    background-color:white;
                    border:none;
                }
                .bldaten table, td ,th {
                    font-familiy:'Open Sans';
                }
            </style>


            <div class="bldaten">
                <p>Bill of Lading</p>
                <table style="table-layout: fixed;">
                    <tr>
                        <th style="width:80px;">&nbsp;</th>
                        <th style="width:80px;">&nbsp;</th>
                        <th style="width:80px;">&nbsp;</th>
                        <th style="width:80px;">&nbsp;</th>
                        <th style="width:80px;">&nbsp;</th>
                        <th style="width:80px;">&nbsp;</th>
                        <th style="width:80px;">&nbsp;</th>
                    </tr>
                    <!--tr>
                            <td colspan="7" class="tdheader">BOL Daten </td>
                    </tr-->

                    <!-- BOL daten -->
                    <?php $bi = 0; ?>
                    @if (!isset($data['lieferavis']['BOL']) or count($data['lieferavis']['BOL']) == 0 and false )
                    <tr>
                        <td class="tdheader">BOL-Nummer</td>
                        <td class="tdheader">Bruttogewicht</td>
                        <td class="tdheader"colspan="5"></td>
                    </tr>

                    <tr>
                        <td class="tdinput">{{ Form::hidden("BOL_NDX[$bi]", 0) }}<input type="text" name="BOL[{{$bi}}][BOLNr]" value=""/></td>
                        <td class="tdinput"><input type="text" name="BOL[{{$bi}}][Brutto]" value="" class="avis_lb"/></td>
                        <td class="tdinput"colspan="5"> <button type="submit" name="submit" value="NewBOL">speichern</button> </td>
                    </tr>
                    @endif



                    <? $bi=1; ?>
                    @foreach($data['lieferavis']['BOL'] as $bolj)
                    <tr>
                        <td class="tdheader">BOL-Nummer</td>
                        <td class="tdheader">Bruttogewicht</td>

                        <td class="tdheader"colspan="5"></td>
                    </tr>
                    <?php $bol = $bolj['BOL'] ?>
                    <tr>
                        <td class="tdinput">{{ Form::hidden("BOL_NDX[$bi]", $bol->PPLieferavis_BOL_Id) }}<input type="text" name="BOL[{{$bi}}][BOLNr]" value="{{$bol->PPLieferavis_BOL_BOLNr}}"/></td>
                        <td class="tdinput"><input type="text" name="BOL[{{$bi}}][Brutto]" value="{{number_format($bol->PPLieferavis_BOL_Brutto,0,',','.')}}" class="avis_lb"/></td>
                        <td class="tdinput"colspan="5">
                            <div  class="right" style="padding:8px;width:200px;float:left;">
                                <input style="width:10px;margin-right:2px;color: red;" type="checkbox" name="BOLDEL[{{$bol->PPLieferavis_BOL_Id}}]" />
                                Löschen
                            </div>
                            <div style="width:450px;float:left;text-align: right;"><button>speichern</button></div>
                        </td>
                    </tr>
                    <?php $bi++; ?>
                    <!--if (!isset($bolj['Container']) or count($bolj['Container']) ==0)-->
                    @if (false)
                    <?php $ci = 0; ?>
                    <tr>
                        <td></td>
                        <td class="tdheader">Container-ID</td>
                        <td class="tdheader">Container-Art</td>
                        <td class="tdheader">Container/Palette</td>
                        <td class="tdheader" colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="tdinput">{{ Form::hidden("CON_NDX[$bol->PPLieferavis_BOL_Id][$ci]", 0) }}
                            {{ Form::text("CON[$bol->PPLieferavis_BOL_Id][$ci][ContainerId]", "") }}</td>
                        <td class="tdinput">{{ Form::select("CON[$bol->PPLieferavis_BOL_Id][$ci][Art]",array(
									""=>"Bitte wählen...",
									"10010"=>'20" Container',
									"10011"=>'40" Container',
									"10012"=>'40" HC Container',
									"10013"=>'20" Container Reefer',
									"10014"=>'40" Container Reefer',
									"10015"=>'40" HC Container Reefer',
									"10016"=>'45" Container',
									"10018"=>'40" HC Container (substitute)',
									"10019"=>'40" Container (substitute)',
									"10020"=>'45" HC Container'
								), "",array('style'=>'width:150px;')) }}</td>
                        <td class="tdinput">	{{ Form::select("CON[$bol->PPLieferavis_BOL_Id][$ci][PalCon]",array("Y020"=>"Container","Y010"=>"Palette"), "",array('style'=>'')) }}</td>
                        <td class="tdinput" colspan="4"><button type="submit" name="submit" value="NewContainer">speichern</button></td>
                    </tr>
                    @endif
                    <?php $ci = 1; ?>
                    @foreach($bolj['Container'] as $index => $container)
                    <tr>
                        <td></td>
                        <td class="tdheader">Container-ID</td>
                        <td class="tdheader">Container-Art</td>
                        <td class="tdheader">Container/Palette</td>
                        <td class="tdheader" colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="tdinput">{{ Form::hidden("CON_NDX[$bol->PPLieferavis_BOL_Id][$ci]", $container->PPLieferavis_Container_Id) }}
                            {{ Form::text("CON[$bol->PPLieferavis_BOL_Id][$container->PPLieferavis_Container_Id][ContainerId]", $container->PPLieferavis_Container_ContainerId) }}</td>
                        <td class="tdinput" style="padding-top:4px;">

                            {{ Form::select("CON[$bol->PPLieferavis_BOL_Id][$container->PPLieferavis_Container_Id][Art]",array(
									""=>"Bitte wählen...",
									"10010"=>'20" Container',
									"10011"=>'40" Container',
									"10012"=>'40" HC Container',
									"10013"=>'20" Container Reefer',
									"10014"=>'40" Container Reefer',
									"10015"=>'40" HC Container Reefer',
									"10016"=>'45" Container',
									"10018"=>'40" HC Container (substitute)',
									"10019"=>'40" Container (substitute)',
									"10020"=>'45" HC Container'
								), $container->PPLieferavis_Container_Art,array('style'=>'width:150px;')) }}</td>
                        <td class="tdinput" style="padding-top:4px;">	{{ Form::select("CON[$bol->PPLieferavis_BOL_Id][$container->PPLieferavis_Container_Id][PalCon]",array("Y020"=>"Container","Y010"=>"Palette"), $container->PPLieferavis_Container_PalCon,array('style'=>'')) }}</td>
                        <td class="tdinput" colspan="4">
                            <div  class="right" style="padding:8px;width:200px;float:left;">
                                <input style="width:10px;margin-right:2px;color: red;" type="checkbox" name="CONDEL[{{$container->PPLieferavis_Container_Id}}]" />
                                Löschen
                            </div>
                            <div style="width:100px;float:left;"><button>speichern</button></div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="tdheader">Lfd-Nr.</td>
                        <td class="tdheader">Pos-Nr.</td>
                        <td class="tdheader">Artikel (13stellig)</td>
                        <td class="tdheader">Menge (CTS)</td>
                        <td class="tdheader">&nbsp;</td>
                    </tr>
                    <!--  Containerdaten Inhalt -->
                    @if (!isset($container['CONTENT']) or count($container['CONTENT']) == 0  and false)
                    <?php $cii = 0; ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="tdinput">{{ Form::hidden("CONT_NDX[$ci][$cii]", 0) }}
                            {{ Form::hidden("CONT_NDX[$container->PPLieferavis_Container_Id][PPLieferavis_Container_Id]", $container->PPLieferavis_Container_Id) }}
                            <input type="text" name="CON[{{$bol->PPLieferavis_BOL_Id}}][{{$container->PPLieferavis_Container_Id}}][Content][{{$cii}}][VEPos]" value="1"</td>
                        <td class="tdinput"><input type="text" name="CON[{{$bol->PPLieferavis_BOL_Id}}][{{$container->PPLieferavis_Container_Id}}][Content][{{$cii}}][POSNr]"  value=""/></td>
                        <td class="tdinput"><input type="text" name="CON[{{$bol->PPLieferavis_BOL_Id}}][{{$container->PPLieferavis_Container_Id}}][Content][{{$cii}}][MaterialNr]"  value=""/></td>
                        <td class="tdinput"><input type="text" name="CON[{{$bol->PPLieferavis_BOL_Id}}][{{$container->PPLieferavis_Container_Id}}][Content][{{$cii}}][Menge]"  value=""  class="avis_lb"/></td>
                        <td class="tdinput"><button type="submit" name="submit" value="NewContent">speichern</button></td>
                    </tr>

                    @endif

                    <?php $cii = 1; ?>
                    @foreach ($container['CONTENT'] as $content)
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="tdinput">{{ Form::hidden("CONT_NDX[$ci][$cii]", $content->PPLieferavis_Container_Content_Id) }}
                            <input type="text" name="CON[{{$bol->PPLieferavis_BOL_Id}}][{{$container->PPLieferavis_Container_Id}}][Content][{{$content->PPLieferavis_Container_Content_Id}}][VEPos]" value="{{$content->PPLieferavis_Container_Content_VEPos}}"</td>
                        <td class="tdinput"><input type="text" name="CON[{{$bol->PPLieferavis_BOL_Id}}][{{$container->PPLieferavis_Container_Id}}][Content][{{$content->PPLieferavis_Container_Content_Id}}][POSNr]"  value="{{$content->PPLieferavis_Container_Content_POSNr}}"/></td>
                        <td class="tdinput"><input type="text" name="CON[{{$bol->PPLieferavis_BOL_Id}}][{{$container->PPLieferavis_Container_Id}}][Content][{{$content->PPLieferavis_Container_Content_Id}}][MaterialNr]"  value="{{$content->PPLieferavis_Container_Content_MaterialNr}}"/></td>
                        <td class="tdinput"><input type="text" name="CON[{{$bol->PPLieferavis_BOL_Id}}][{{$container->PPLieferavis_Container_Id}}][Content][{{$content->PPLieferavis_Container_Content_Id}}][Menge]"  value="{{number_format($content->PPLieferavis_Container_Content_Menge,0,',','.')}}"  class="avis_lb"/></td>
                        <td class="tdinput">
                            <div style="padding-left:10px;padding-top: 8px;">
                                <input style="width:10px;" type="checkbox" name="CONTDEL[{{$content->PPLieferavis_Container_Content_Id}}]" /> Löschen
                            </div>
                        </td>
                    </tr>
                    <?php $cii++ ?>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>

                        <td colspan="5">
                            Neue Position     Pos-Nr: <input type="text" name="POSNEW[{{$bol->PPLieferavis_BOL_PPLieferavis_Id}}][{{$container->PPLieferavis_Container_Id}}]" value="" />
                            <button type="submit" name="submit" value="NewContainerPos">Neu</button>
                        </td>
                    </tr>

                    <?php $ci++ ?>
                    @endforeach
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="6">
                            Neuer Container zu BOL {{$bol->PPLieferavis_BOL_BOLNr}}  Container-ID
                            <input type="text" name="CONTAINERIDNEW[{{$bol->PPLieferavis_BOL_Id}}]" value="" />
                            <button type="submit" name="submit" value="NewContainer">Neu</button>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="7">
                            Neues BOL anlegen. BOL-Nummer:
                            <input type="text" name="BOLNRNEW" value="" class="avis_lb"/>
                            <button type="submit" name="submit" value="NewBOL">Neu</button>
                        </td>
                    </tr>

                </table>



            </div>



            @endif
        </div>
    </form>
</div>

<script>

    $(function () {
        $(function () {
            $(".datepicker_avis").datepicker(
                    {
                        numberOfMonths: 1,
                        showButtonPanel: true,
                        showWeek: true,
                        firstDay: 1,
                        dateFormat: "dd.mm.yy",
                        monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
                        monthNamesShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
                        dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
                        dayNamesShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
                        dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
                    });
        });
    });
</script>