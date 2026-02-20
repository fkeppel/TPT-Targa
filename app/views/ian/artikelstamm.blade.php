<?php
    define ('XXX', 'DEMO-Daten');
?>
<h5 class='header1' style='margin-top:50px;'>{{ ServiceProvider::tl($data['lang'], 'Artikel Stammdaten')}}</h5>
<div id='IANContainer'>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Ausm-Nr.') }}</div>
    <div class='value'>{{ substr($data['pp']->PPProduktpass_Ausmusterungnummer,0,4) }}</div>
    <div></div>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Warengruppe') }}</div>
    <div class='value'>{{ ServiceProvider::tl($data['lang'], $data['pp']->PPProduktpass_Warengruppe) }}</div>
    <div></div>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Einkäufer') }}</div>
    <div class='value'>{{ $data['pp']->PPProduktpass_Einkaeufer }}</div>
    <div></div>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'RF-Sicherung') }}</div>
    <div class='value'>{{ $data['pp']->rfSafety }}</div>
    <div></div>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Vorgänger') }}</div>
    @if (strlen(trim($data['pp']->PPProduktpass_AltIAN)) >  0 )
        <div class='value'><a href="/show/{{ $data['pp']->PPProduktpass_AltIAN }}_{{ $data['pp']->PPProduktpass_AltCharge }}" target="_blank" style="text-decoration: none;color:#003D7C;"><b>{{$data['pp']['PPProduktpass_AltIAN']}} /{{$data['pp']['PPProduktpass_AltCharge']}}</b></a></div>
    @else
        <div class='value'>N.N.</div>
    @endif
    <div></div>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Thema AM') }}</div>
    <div class='value'>{{ ServiceProvider::tl($data['lang'], $data['pp']->PPProduktpass_Thema) }}</div>
    <div></div>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Thema Aktionswoche') }}</div>
    <div class='value'>{{  ServiceProvider::tl($data['lang'], $data['pp']->themeNo ) }}</div>
    <div></div>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Bemerkung Lieferant') }}</div>
    <div class='value'>{{ ServiceProvider::tl($data['lang'], $data['pp']->remarkSupplier) }}</div>
    <div></div>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Versandfähige Umverpackung OS') }} </div>
    <div class='value'>{{ ServiceProvider::tl($data['lang'],  $data['pp']->PPProduktpass_VersandfaehigeUmverpackung ) }}</div>
    <div></div>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'EK Note') }}</div>
    <div class='value'>{{  ServiceProvider::tl($data['lang'], $data['pp']->ekNote ) }}</div>
</div>
<h5 class='header1'>{{ ServiceProvider::tl($data['lang'], 'Zugehörige KL-Informationen')}}</h5>
<div id='IANContainer'>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Itemtyp') }}</div>
    <div class='value'>{{ $data['pp']->itemTypeKL }}</div>
    <div></div>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Dazugehörige Artikel') }}</div>
    <div class='value'  style='grid-column: 5 / 7;'>
        <table class="ianTable">
            <thead>
                <tr>
                    <th class="tgTableHeads" id="relatedItemIan" name="relatedItemIan">{{ ServiceProvider::tl($data['lang'], 'IAN') }}</th>
                    <th class="tgTableHeads" id="lotNo" name="lotNo">{{ ServiceProvider::tl($data['lang'], 'Charge') }}</th>
                    <th class="tgTableHeads" id="lotNo" name="lotNo">{{ ServiceProvider::tl($data['lang'], 'Referenznummer') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['KLLink'] as $item)
                    <?php $ianLink = '/show/' . $item->PPProduktpass_KLLink_IAN . '_' . $item->PPProduktpass_KLLink_lotNo  ; ?>
                    <tr>
                        <td style="padding:6px;"><a href="{{ url($ianLink) }}"
                                target="_blank">{{ $item->PPProduktpass_KLLink_IAN }}</a>
                        </td>
                        <td style="padding:6px;">{{ $item->PPProduktpass_KLLink_lotNo }}
                        </td>
                        <td style="padding:6px;">{{ $item->PPProduktpass_KLLink_refNo }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div></div> 
</div>
<h5 class='header1'>{{ ServiceProvider::tl($data['lang'], 'Artikel Muster')}}</h5>
<div id='IANContainer'>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Anzahl Muster KL') }}</div>
    <div class='value'>{{ $data['pp']->sampleNumberKL }}</div>
    <div></div>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Einkäufer Code KL') }}</div>
    <div class='value'>{{ $data['pp']->buyerShortCodeKL }}</div>
    <div></div>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Einkäufer KL') }}</div>
    <div class='value'>{{ $data['pp']->buyerNameKL }}</div>
    <div></div>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Thema AM KL') }}</div>
    <div class='value'>{{ $data['pp']->themeNoKL }}</div>
    <div></div>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Deadline Mustereingang') }}</div>
    <div class='value'>
            <?php
            $d = ($ts = strtotime($data['pp']->sampleDeadlineKL)) ? date("d.m.Y", $ts) : '';
        ?>
        {{ $d }}
    </div>
    <div></div>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Trackingnummer Muster') }}</div>
    <div class='value'>{{ $data['pp']->sampleTrackingNumber }}</div>
    <div></div>
</div>
<h5 class='header1'>{{ ServiceProvider::tl($data['lang'], 'Kennzeichnung')}}</h5>
<div id='IANContainer'>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], '(Eigen-Marke)') }}</div>
    <div class='value'>{{ $data['pp']->PPProduktpass_Marke }}</div>
    <div></div>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Prüfinstitut') }}</div>
    <div class='value'>{{ $data['pp']->PPProduktpass_Pruefinstitut }}</div>
    <div></div>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Eigen-Marke Kaufland') }}</div>
    <div class='value'>{{ $data['pp']->PPProduktpass_KauflandMarke }}</div>
    <div></div>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Zertifikate') }}</div>
    <div class='value'>
        <?php 
            $zert =  $data['pp']->PPProduktpass_Zertifizierungen .' '.$data['pp']->PPProduktpass_ZertifizierungEigenschaften2.' '.$data['pp']->PPProduktpass_ZertifizierungEigenschaften3.' '.$data['pp']->PPProduktpass_ZertifizierungEigenschaften4.' '.$data['pp']->PPProduktpass_ZertifizierungEigenschaften5;
        ?>
        {{ $zert }}
    </div>
    <div></div>
</div>
<h5 class='header1'>{{ ServiceProvider::tl($data['lang'], 'Restlaufzeit')}}</h5>
<div id='IANContainer'>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Restlaufzeit') }}</div>
    <div class='value'>{{ $data['pp']->PPProduktpass_shelfLife }}</div>
    <div></div>
</div>
<h5 class='header1'>{{ ServiceProvider::tl($data['lang'], 'Garantie')}}</h5>
<div id='IANContainer'>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Garantiezeit (Dauer)') }}</div>
    <div class='value'>{{ ServiceProvider::tl($data['lang'],$data['pp']->Garantie) }}</div>
    <div></div>
    <div class='label'>{{ ServiceProvider::tl($data['lang'], 'Garantieart') }}</div>
    <div class='value' style='grid-column: 5 / 9;'>{{ ServiceProvider::tl($data['lang'],$data['pp']->Garantie_Art) }}</div>
    <div></div>
</div>
<h5 class='header1'>{{ ServiceProvider::tl($data['lang'], 'Verpackung')}}</h5>
<div id='IANContainer'>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Verpackungsagentur') }}</div>
    <div class='value'>{{ $data['pp']->PPProduktpass_Agentur }}</div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Materialstärke der Verkaufsverpackung') }}</div>
    <div class='value' style='grid-column: 5 / 9;'>{{{ ServiceProvider::tl($data['lang'], $data['pp']->PPProduktpass_Materialstaerke_der_Verkaufsverpackung) }}}</div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Verkaufsverpackung') }}</div>
    <div class='value'>{{{ ServiceProvider::tl($data['lang'], $data['pp']->PPProduktpass_Verkaufsverpackung) }}}</div>
    <div></div>
    <div class='label' style='grid-column: 4 / 4;'>{{ ServiceProvider::tl($data['lang'], 'Bemerkung Verpackung') }}</div>
    <div class='value' style='grid-column: 5 / 9;'>{{{ ServiceProvider::tl($data['lang'], $data['pp']->retailPackagingComment) }}}</div>
    <div></div>
</div>
<h5 class='header1'>{{ ServiceProvider::tl($data['lang'], 'Abmessungen')}}</h5>
<div id='IANContainer'>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Maße und Gewichte') }}</div>
    <div class='value' style='grid-column: 2 / 9;'>
    <table class="ianTable">
        <thead>
            <tr>
                <th>{{ ServiceProvider::tl($data['lang'], 'Stylenr') }}.</th>
                <th>{{ ServiceProvider::tl($data['lang'], 'Stylebezeichnung') }}</th>
                <th>{{ ServiceProvider::tl($data['lang'], 'Maße ohne Verpackung') }}</th>
                <th>{{ ServiceProvider::tl($data['lang'], 'Gewicht ohne Verpackung') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['style'] as $style)
            <tr>
                <td>
                    {{ $style->PPProduktpass_Style_Header }}
                </td>
                <td>
                    {{ ServiceProvider::tl($data['lang'], $style->PPProduktpass_Style_Value01) }}
                </td>
                <td>
                    {{ ServiceProvider::tl($data['lang'], $style->sizeWithoutPackaging) }}
                </td>
                <td>
                    {{ ServiceProvider::tl($data['lang'], $style->weightWithoutPackaging) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <div></div>
</div>
<h5 class="header1">{{ ServiceProvider::tl($data['lang'], 'Verpackung Kaufland') }}</h5>
<div id='IANContainer'>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Verkaufsverpackung Kaufland') }}</div>
    <div class='value'>{{ ServiceProvider::tl($data['lang'],  $data['pp']->packagingKL_rt_name ) }}</div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Materialstärke der Verkaufsverpackung Kaufland') }}</div>
    <div class='value' style='grid-column: 5 / 9;'>{{ ServiceProvider::tl($data['lang'], $data['pp']->packagingKL_materialThickness ) }}</div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Bemerkung Verpackung Kaufland') }}</div>
    <div class='value' style='grid-column: 2 / 9;'>{{ ServiceProvider::tl($data['lang'],  $data['pp']->packagingKL_retailPackagingComment ) }}</div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Tray Kaufland') }}</div>
    <div class='value'>{{ ServiceProvider::tl($data['lang'], $data['pp']->packagingKL_tray_name) }}</div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Tray Art') }}</div>
    <div class='value' style='grid-column: 5 / 9;'>{{ ServiceProvider::tl($data['lang'], $data['pp']->packagingKL_trayType ) }}</div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Facing Lagen') }}</div>
    <div class='value'>{{ ServiceProvider::tl($data['lang'],  $data['pp']->packagingKL_trayFacingLayer ) }}</div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Farbiges Tray') }}</div>
    <div class='value'>{{ ServiceProvider::tl($data['lang'],  $data['pp']->packagingKL_trayColor  ) }}</div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Tray Kaufland Höhe (cm)') }}</div>
    <div class='value'>{{ ServiceProvider::tl($data['lang'],  $data['pp']->packagingKL_trayMaxCartonHeight ) }}</div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Tray Kaufland Breite (cm)') }}</div>
    <div class='value'>{{ ServiceProvider::tl($data['lang'],  $data['pp']->packagingKL_trayMaxCartonWidth ) }}</div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Tray Kaufland Länge (cm)') }}</div>
    <div class='value'>{{ ServiceProvider::tl($data['lang'],   $data['pp']->packagingKL_trayMaxCartonWidth ) }}</div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Bemerkung Tray') }}</div>
    <div class='value' style='grid-column: 2 / 9;'>{{ ServiceProvider::tl($data['lang'],  $data['pp']->packagingKL_trayRemarks ) }}</div>
    <div></div>
</div>
<h5 class="header1">{{ ServiceProvider::tl($data['lang'], 'Katalog') }}</h5>
 <?php
    $katalog = false;
    if ($data['pp']->catalogue_isCatalogue == 'true') {
        $katalog = true;
        $katalog_data['catalogue_contractRenewalConfirmation'] = $data['pp']->catalogue_contractRenewalConfirmation;
        $katalog_data['catalogue_initialCharge'] = $data['pp']->catalogue_initialCharge;
        $katalog_data['catalogue_lotNumber'] = $data['pp']->catalogue_lotNumber;
        $katalog_data['catalogue_minOrderQuantity'] = $data['pp']->catalogue_minOrderQuantity;
        $katalog_data['catalogue_initialOrder'] = $data['pp']->catalogue_initialOrder;
        $catalogue_timeOfOrder = '';
        if (!is_null($data['pp']->catalogue_timeOfOrder1)) {
            $catalogue_timeOfOrder .= $data['pp']->catalogue_timeOfOrder1;
        }
        if (!is_null($data['pp']->catalogue_timeOfOrder2)) {
            $catalogue_timeOfOrder .= ' + ' . $data['pp']->catalogue_timeOfOrder2;
        }
        if (!is_null($data['pp']->catalogue_timeOfOrder3)) {
            $catalogue_timeOfOrder .= ' + ' . $data['pp']->catalogue_timeOfOrder3;
        }
        if (!is_null($data['pp']->catalogue_timeOfOrder4)) {
            $catalogue_timeOfOrder .= ' + ' . $data['pp']->catalogue_timeOfOrder4;
        }
        $katalog_data['catalogue_timeOfOrder'] = $catalogue_timeOfOrder;
    } else {
        $katalog_data['catalogue_contractRenewalConfirmation'] = '';
        $katalog_data['catalogue_initialCharge'] = '';
        $katalog_data['catalogue_lotNumber'] = '';
        $katalog_data['catalogue_minOrderQuantity'] = '';
        $katalog_data['catalogue_initialOrder'] = '';
        $katalog_data['catalogue_timeOfOrder'] = '';
    }
?>
<div id='IANContainer'>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Initiale Charge') }}</div>
    <div class='value'>{{ ServiceProvider::tl($data['lang'],  $katalog_data['catalogue_initialCharge'] ) }}</div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Mindestbestellmenge') }}</div>
    <div class='value'>{{ ServiceProvider::tl($data['lang'],  $katalog_data['catalogue_minOrderQuantity'] ) }}</div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Katalogbestellung') }}</div>
    <div class='value'><input class="tgCheckbox" type="checkbox" @if ($katalog) checked @endif  disabled></div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Erstbestellung') }}</div>
    <div class='value'><input class="tgCheckbox" type="checkbox" @if ($data['pp']->initialOrder) checked @endif  disabled ></div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Bestellzeitpunkt') }}</div>
    <div class='value'>{{ ServiceProvider::tl($data['lang'],  $katalog_data['catalogue_timeOfOrder'] ) }}</div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Ablaufdatum Vertrag') }}</div>
    <?php
                            try{
                                if (strlen(trim($katalog_data['catalogue_contractRenewalConfirmation'])) > 3){
                                    $d = new DateTime($katalog_data['catalogue_contractRenewalConfirmation']);
                                    $datum = $d->format('d.m.Y');
                                } else {
                                    $datum = '';
                                }
                            }
                            catch(Exception $e){
                                $datum = '';
                            }
                            ?>
    <div class='value'>{{ $datum }}</div>
    <div></div>
</div>
<h5 class="header1">{{ ServiceProvider::tl($data['lang'], 'Risikiokategorie') }}</h5>
<div id='IANContainer'>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Geeignet für Kinder') }}</div>
    <div class='value'>{{ ServiceProvider::tl($data['lang'],  $data['pp']->childSuitable ) }}</div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'NGO Prüfung Bem.') }}</div>
    <div class='value'>{{ ServiceProvider::tl($data['lang'],  $data['pp']->ngoTestNote ) }}</div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'PSA') }}</div>
    <div class='value'>
        <input class="tgCheckbox" type="checkbox" @if ($data['pp']->PPE == 'true') checked @endif disabled>
    </div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Medizinprodukt') }}</div>
    <div class='value'><input class="tgCheckbox" type="checkbox" @if ($data['pp']->medProduct == 'true') checked @endif disabled></div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'LFGB') }}</div>
    <div class='value'><input class="tgCheckbox" type="checkbox" @if ($data['pp']->LFGB == 'true') checked @endif disabled></div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Referenzerg. vom Vorgänger') }}</div>
    <div class='value'><input class="tgCheckbox" type="checkbox" @if ($data['pp']->resultsFromPredecessor == 'true') checked @endif disabled></div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'NGO Prüfung') }}</div>
    <div class='value'><input class="tgCheckbox" type="checkbox" @if ($data['pp']->ngoTest == 'true') checked @endif disabled></div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Referenztest') }}</div>
    <div class='value'> <input class="tgCheckbox" type="checkbox" @if ($data['pp']->referenceCheck == 'true') checked @endif disabled></div>
    <div></div>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'WEEE Kategorie') }}</div>
    <div class='value'>{{ ServiceProvider::tl($data['lang'],  $data['pp']->PPProduktpass_weeeCategory ) }}</div>
    <div></div>
</div>
<h5 class="header1">{{ ServiceProvider::tl($data['lang'], 'Dateien und Anhänge') }}</h5>
<div id='IANContainer'>
    <div class='label' >{{ ServiceProvider::tl($data['lang'], 'Anhänge') }}</div>
    <div class='label' style='padding:0px;grid-column: 2 /10;' >
        <table style='width:100%;border-collapse:collapse;font-size:1em;'>
            @foreach ($data['Attachments'] as $att)
            <tr>
                <td style='padding:6px;padding-bottom:10px;'><a href="{{ url($att['Link']) }}" style='border-bottom:1px solid  rgb(43, 89, 169,0.9);color:#003D7C;text-decoration:none;font-weight:500;' target="_blank" name=""  class="tgAttachment">{{ $att['FilenameLidl'] }}</a></td>
            </tr>
            @endforeach
        </table>
    </div>
    <div></div>
</div>