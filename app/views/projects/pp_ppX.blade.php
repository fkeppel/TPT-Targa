
<style>
   #idProduktpass label{
        color:#eb8f00;
        width:120px;
        border: 1px solid lightgray;
        border-radius: 5px;
        background-color:#F0F0F0;
    }
    #idProduktpass input {
        width:350px;
    }
    #idProduktpass textarea{
        width:350px;
        height:60px;
    }

    .cpcCerts div {
        background-color: red;
    }
    .cpcCerts input [type="checkbox"]{
        width:55px; height:55px;
    }
    .info{

        color:#FFF;
    }
</style>


<div id="idProduktpass" style="border:1px solid lightgray;padding-top:0px;" >

    <div style="position:relative; display:none;">
        @if (!$data['pp']['PPProduktpass_IsRevision'])
        <div style="margin:0 auto;text-align:center;width:130px;border:0px solid lightgray;border-radius: 5px;position:absolute;top:0px;right:0; z-index: 10;height:280px;background-color: transparent;">
            <!--{{Form::open( array('url'=>'exportPP/'.$data['pp']['PPProduktpass_Id'], 'class'=>'form-signin')) }}
                    {{ Form::submit('Ausgabe PP', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;'))}}
            {{ Form::close() }}
            {{ Form::open( array('url'=>'exportPPFinal/'.$data['pp']['PPProduktpass_Id'], 'class'=>'form-signin')) }}
                    {{ Form::submit('Ausgabe PP (Final)', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;'))}}
            {{ Form::close() }}

            {{ Form::open( array('url'=>'writeAB/'.$data['pp']['PPProduktpass_Id'], 'class'=>'form-signin')) }}
                    {{ Form::submit('Ausgabe AB', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;'))}}
            {{ Form::close() }}
            {{ Form::open( array('url'=>'writeAnlage/'.$data['pp']['PPProduktpass_Id'], 'class'=>'form-signin')) }}
                    {{ Form::submit('Ausgabe Anlage', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;'))}}
            {{ Form::close() }}

            {{ Form::open( array('method'=>'get','url'=>'originalExcel/'.$data['pp']['PPProduktpass_Id'], 'class'=>'form-signin')) }}
                    {{ Form::submit('Ausgabe Org. Excel', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;'))}}
            {{ Form::close()}}-->
            @if (Auth::User()->PPMitarbeiter_Gruppe  != 'extern')
            {{ Form::open( array('method'=>'get','url'=>'show/'.$data['pp']['PPProduktpass_Id']."/0/1", 'class'=>'form-signin')) }}
            {{ Form::submit('Diff', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;'))}}
            {{ Form::close() }}


            {{ Form::button('Löschen', array('onclick'=>'xconfirmDelete('.$data['pp']['PPProduktpass_Id'].','.$data['pp']['PPProduktpass_IAN'].');','class'=>'btn','style'=>'width:120px;background-color:red;'))}}


            @endif
        </div>
        @else
        <div style="color:red;margin:0 auto;text-align:center;width:130px;border:1px solid lightgray;border-radius: 5px;position:absolute;top:0px;right:0; z-index: 10;height:80px;background-color: transparent;">
            REVISIONS Anzeige<br>Änderungen nicht möglich!
        </div>
        @endif

    </div>



    {{ Form::model($data['pp'], array('url'=>'update/'.$data['pp']['PPProduktpass_Id'], 'class'=>'form-signin')) }}
    @if (Auth::User()->PPMitarbeiter_Gruppe  == 'admin')
    <div style="margin:0 auto;text-align:left;width:110px; z-index: 100;padding-top:8px;border:none;height:40px;margin-left:0px;">
       
        {{ Form::submit('speichern', array('class'=>'btn','style'=>'width:120px;background-color: #e78f08;'))}}
        @endif
    </div>
    @endif

    <div style="position:relative;height:786px;overflow: auto;">

        <div style="width:600px;float:left;">
            <fieldset>
                <legend>
                    Produktpass
                </legend>

                <ul>
                    <li>
                        {{ Form::label('IAN') }}{{ Form::text('PPProduktpass_IAN') }}
                    </li>
                    <li>
                        {{ Form::label('Artikelbezeichnung') }}{{ Form::textarea('PPProduktpass_Artikelbezeichnung') }}
                        @if ($data["ShowDiff"] and ($data['pprev']->PPProduktpass_Artikelbezeichnung != $data['pp']->PPProduktpass_Artikelbezeichnung))
                        {{ Form::label('Artikelbezeichnung Rev') }}{{ Form::textarea('D',$data['pprev']->PPProduktpass_Artikelbezeichnung,array('style'=>'color:red;')) }}
                        @endif
                    </li>
                    <!--li>
                            {{ Form::label('Ausmusterung') }}{{ Form::text('PPProduktpass_Ausmusterung') }}
                    </li-->
                    <li>
                        {{ Form::label('Ausmusterungnummer')}}{{ Form::text('PPProduktpass_Ausmusterungnummer')}}
                        @if ($data["ShowDiff"] and ($data['pprev']->PPProduktpass_Ausmusterungnummer != $data['pp']->PPProduktpass_Ausmusterungnummer))
                        {{ Form::label('Ausmusterungnummer Rev') }}{{ Form::text('D',$data['pprev']->PPProduktpass_Ausmusterungnummer,array('style'=>'color:red;')) }}
                        @endif
                    </li>
                    <li>
                        {{ Form::label('AltIAN') }}{{ Form::text('PPProduktpass_AltIAN')}}
                        @if ($data["ShowDiff"] and ($data['pprev']->PPProduktpass_AltIAN != $data['pp']->PPProduktpass_AltIAN))
                        {{ Form::label('AltIAN Rev') }}{{ Form::text('D',$data['pprev']->PPProduktpass_AltIAN,array('style'=>'color:red;')) }}
                        @endif
                    </li>
                    <li>
                        {{ Form::label('Charge') }}{{ Form::text('PPProduktpass_Charge')}}
                        @if ($data["ShowDiff"] and ($data['pprev']->PPProduktpass_AltIAN != $data['pp']->PPProduktpass_Charge))
                        {{ Form::label('Charge Rev') }}{{ Form::text('D',$data['pprev']->PPProduktpass_Charge,array('style'=>'color:red;')) }}
                        @endif
                    </li>
                    <li>
                        {{ Form::label('Vorgänger Charge') }}{{ Form::text('PPProduktpass_AltCharge')}}
                        @if ($data["ShowDiff"] and ($data['pprev']->PPProduktpass_AltIAN != $data['pp']->PPProduktpass_AltCharge))
                        {{ Form::label('AltCharge Rev') }}{{ Form::text('D',$data['pprev']->PPProduktpass_AltCharge,array('style'=>'color:red;')) }}
                        @endif
                    </li>
                    <li>
                        {{ Form::label('AltArtikelbezeichnung') }}{{ Form::textarea('PPProduktpass_AltArtikelbezeichnung') }}
                        @if ($data["ShowDiff"] and ($data['pprev']->PPProduktpass_AltArtikelbezeichnung != $data['pp']->PPProduktpass_AltArtikelbezeichnung))
                        {{ Form::label('AltArtikelbezeichnung') }}{{ Form::text('D',$data['pprev']->PPProduktpass_AltArtikelbezeichnung,array('style'=>'color:red;')) }}
                        @endif
                    </li>
                    <li>
                        {{ Form::label('Warengruppe') }}{{ Form::text('PPProduktpass_Warengruppe') }}
                        @if ($data["ShowDiff"] and ($data['pprev']->PPProduktpass_Warengruppe != $data['pp']->PPProduktpass_Warengruppe))
                        {{ Form::label('Warengruppe') }}{{ Form::text('D',$data['pprev']->PPProduktpass_Warengruppe,array('style'=>'color:red;')) }}
                        @endif
                    </li>
                    <li>
                        {{ Form::label('Neue Warengruppe') }}{{ Form::text('PPProduktpass_Neu_Warengruppe') }}
                        <?php
                        $attr = "PPProduktpass_Neu_Warengruppe";
                        $lbl  = "Neue Warengruppe";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>
                    <li>
                        {{ Form::label('Verpackungseinheit') }}{{ Form::text('Verpackungseinheit',number_format($data['pp']->PPProduktpass_Verpackungseinheit,0,',','.'),array('disabled'=>'disabled')) }}
                        <?php
                        $lbl  = "Verpackungseinheit";
                        $attr = "Verpackungseinheit";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label('$lbl') }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>
                    <li>
                        {{ Form::label('Thema') }}{{ Form::text('PPProduktpass_Thema') }}
                        <?php
                        $lbl  = "Thema";
                        $attr = "PPProduktpass_Thema";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>
                    <li>
                        {{ Form::label('Liefertermin (KW/Jahr)') }}{{ Form::text('PPProduktpass_Liefertermin',NULL,array('style'=>'width:60px;')) }}{{ Form::text('PPProduktpass_LieferterminJahr',NULL,array('style'=>'width:60px;')) }}<br>
                        <?php
                        $lbl   = "Liefertermin (KW/Jahr)";
                        $attr  = "PPProduktpass_Liefertermin";
                        $attr1 = "PPProduktpass_LieferterminJahr";
                        $lbl   = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;width:60px;')) }}{{ Form::text('D',$data['pprev']->{$attr1},array('style'=>'color:red;width:60px;')) }}
                        <?php } ?>
                    </li>
                    <li>
                        {{ Form::label('Einkäufer') }}{{ Form::text('PPProduktpass_Einkaeufer') }}
                        <?php
                        $lbl  = "Einkäufer";
                        $attr = "PPProduktpass_Einkaeufer";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>
                    <li>
                        {{ Form::label('Marke') }}{{ Form::text('PPProduktpass_Marke') }}
                        <?php
                        $lbl  = "Marke";
                        $attr = "PPProduktpass_Marke";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>
                    <li>
                        {{ Form::label('Kaufland-Marke') }}{{ Form::text('PPProduktpass_KauflandMarke') }}
                        <?php
                        $lbl  = "Kaufland-Marke";
                        $attr = "PPProduktpass_KauflandMarke";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>
                    <li>
                        {{ Form::label('Gesamtmenge') }}{{ Form::text('PPProduktpass_Gesamtmenge',number_format($data['pp']->PPProduktpass_Gesamtmenge,0,',','.') ) }}
                        <?php
                        $lbl  = "Gesamtmenge";
                        $attr = "PPProduktpass_Gesamtmenge";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',number_format($data['pprev']->{$attr},0,',','.'),array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>
                    <li>
                        {{ Form::label('Prüfinstitut') }}{{ Form::text('PPProduktpass_Pruefinstitut') }}
                        <?php
                        $lbl  = "Prüfinstitut";
                        $attr = "PPProduktpass_Pruefinstitut";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>
                    <li>
                        {{ Form::label('Andere_Kriterien') }}{{ Form::text('PPProduktpass_Andere_Kriterien') }}
                        <?php
                        $lbl  = "Andere_Kriterien";
                        $attr = "PPProduktpass_Andere_Kriterien";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>
                    <li>
                        <div class="cpcCerts">
                            {{ Form::hidden('PPProduktpass_BSCINeeded',0) }}
                            {{ Form::hidden('PPProduktpass_StepNeeded',0) }}
                            {{ Form::label('BSCI benötigt') }}{{ Form::checkbox('PPProduktpass_BSCINeeded') }} {{ Form::label('Step benötigt') }}{{ Form::checkbox('PPProduktpass_StepNeeded') }}</div>
                    </li>

                    <li>
                        {{ Form::label('Zertifizierungen') }}{{ Form::text('PPProduktpass_Zertifizierungen') }}
                        <?php
                        $lbl  = "Zertifizierungen";
                        $attr = "PPProduktpass_Zertifizierungen";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>

                    <li>
                        {{ Form::label('Zertifizierungen2') }}{{ Form::text('PPProduktpass_ZertifizierungEigenschaften2') }}
                        <?php
                        $lbl  = "Zertifizierungen2";
                        $attr = "PPProduktpass_ZertifizierungEigenschaften2";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>
                    <li>
                        {{ Form::label('Zertifizierungen3') }}{{ Form::text('PPProduktpass_ZertifizierungEigenschaften3') }}
                        <?php
                        $lbl  = "Zertifizierungen3";
                        $attr = "PPProduktpass_ZertifizierungEigenschaften3";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>
                    <li>
                        {{ Form::label('Zertifizierungen4') }}{{ Form::text('PPProduktpass_ZertifizierungEigenschaften4') }}
                        <?php
                        $lbl  = "Zertifizierungen4";
                        $attr = "PPProduktpass_ZertifizierungEigenschaften4";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>
                    <li>
                        {{ Form::label('Zertifizierungen5') }}{{ Form::text('PPProduktpass_ZertifizierungEigenschaften5') }}
                        <?php
                        $lbl  = "Zertifizierungen5";
                        $attr = "PPProduktpass_ZertifizierungEigenschaften5";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>


                    <li>
                        {{ Form::label('Logo-1') }}{{ Form::text('PPProduktpass_Logos') }}
                        <?php
                        $lbl  = "Logo-1";
                        $attr = "PPProduktpass_Logos";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>

                    <li>
                        {{ Form::label('Logo-2') }}{{ Form::text('PPProduktpass_Logos2') }}
                        <?php
                        $lbl  = "Logo-2";
                        $attr = "PPProduktpass_Logos2";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>

                    <li>
                        {{ Form::label('Logo-3') }}{{ Form::text('PPProduktpass_Logos3') }}
                        <?php
                        $lbl  = "Logo-3";
                        $attr = "PPProduktpass_Logos3";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>

                    <li>
                        {{ Form::label('Logo-4') }}{{ Form::text('PPProduktpass_Logos4') }}
                        <?php
                        $lbl  = "Logo-4";
                        $attr = "PPProduktpass_Logos4";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>

                    <li>
                        {{ Form::label('Logo-5') }}{{ Form::text('PPProduktpass_Logos5') }}
                        <?php
                        $lbl  = "Logo-5";
                        $attr = "PPProduktpass_Logos5";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>

                    <li>
                        {{ Form::label('Verpackung') }}{{ Form::text('PPProduktpass_Verkaufsverpackung',$data['pp']->PPProduktpass_Verkaufsverpackung ,array('style'=>''))}}
                        @if (isset($data['Retail'][$data['pp']->PPProduktpass_Verkaufsverpackung]))
                        {{ Form::label('Reatil PACK') }}{{ Form::textarea('X',$data['Retail'][$data['pp']->PPProduktpass_Verkaufsverpackung] ,array('style'=>'height:100px;'))}}

                        @endif
                        <?php
                        $lbl  = "Umverpackung";
                        $attr = "PPProduktpass_VersandfaehigeUmverpackung";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::select('PPProduktpass_Verkaufsverpackung',$data['umverpackung'],$data['pp']->PPProduktpass_Verkaufsverpackung) }}
                        <?php } ?>
                    </li>

                    <!--li>
                            {{ Form::label('Verkaufsverpackung') }}{{ Form::text('PPProduktpass_Verkaufsverpackung') }}
                    <?php
                    $lbl  = "Verkaufsverpackung";
                    $attr = "PPProduktpass_Verkaufsverpackung";
                    $lbl  = $lbl . " Rev";
                    if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                        ?>
                                                                                                                                                                                                                                                                                                                    {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                    <?php } ?>
                    </li-->

                    <li>
                        {{ Form::label('Materialstärke') }}{{ Form::textarea('PPProduktpass_Materialstaerke_der_Verkaufsverpackung',Null,array('style'=>'height:150px')) }}
                        <?php
                        $lbl  = "Materialstärke";
                        $attr = "PPProduktpass_Materialstaerke_der_Verkaufsverpackung";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>
                    <li>
                        {{ Form::label('Agentur') }}{{ Form::text('PPProduktpass_Agentur') }}
                        <?php
                        $lbl  = "Agentur";
                        $attr = "PPProduktpass_Agentur";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>
                    <li>
                        {{ Form::label('Katalog') }}{{ Form::text('PPProduktpass_KAT') }}
                        <?php
                        $lbl  = "Katalog";
                        $attr = "PPProduktpass_KAT";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>
                    <li>
                        {{ Form::label('BZP') }}{{ Form::text('PPProduktpass_BZP') }}
                        <?php
                        $lbl  = "BZP";
                        $attr = "PPProduktpass_BZP";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>
                    <li>
                        {{ Form::label('MOQ') }}{{ Form::text('PPProduktpass_MOQ') }}
                        <?php
                        $lbl  = "MOQ";
                        $attr = "PPProduktpass_MOQ";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>
                    <li>
                        {{ Form::label('Initiale Charge') }}{{ Form::text('PPProduktpass_InitialeCharge') }}
                        <?php
                        $lbl  = "Initiale Charge";
                        $attr = "PPProduktpass_InitialeCharge";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>
                    <li>
                        {{ Form::label('Erstbestellung') }}{{ Form::text('PPProduktpass_Erstbestellung') }}
                        <?php
                        $lbl  = "Erstbestellung";
                        $attr = "PPProduktpass_Erstbestellung";
                        $lbl  = $lbl . " Rev";
                        if ($data["ShowDiff"] and ( $data['pprev']->{$attr} != $data['pp']->{$attr})) {
                            ?>
                            {{ Form::label($lbl) }}{{ Form::text('D',$data['pprev']->{$attr},array('style'=>'color:red;')) }}
                        <?php } ?>
                    </li>
                </ul>


            </fieldset>
        </div>
        <div style="float:left;width:750px; margin-left:10px;">
            <fieldset>
                <legend>
                    Interne Daten
                </legend>
                <ul>
                    <li>
                        {{ Form::label('Revision',NULL,array('style'=>'float:left;')) }}{{ Form::text('PPProduktpass_Revisionsnummer') }}
                        <div style="clear: both"></div>
                    </li>
                    <li>
                        {{ Form::label('Projekt',NULL,array('style'=>'float:left;')) }}{{ Form::text('PPProduktpass_PPProjekte_Projekt') }}
                        <div style="clear: both"></div>
                    </li>
                    @if (strlen($data['pp']['PPProduktpass_PPProjekte_Projekt']) > 2)
                    <li>
                        {{ Form::label('Zugehörige IANs',NULL,array('style'=>'float:left;')) }}

                        <div style='padding-left:142px;'>
                            <div style='padding:0px; vertical-align: top;'>

                                <?php $i = 0; ?>
                                @foreach ($data['ProjektIANs'] as $prjId => $prjIAN)
                                <?php $i++; ?>
                                <div style="display:inline-block; padding:8px;"><a href="/show/{{$prjId}}" style="text-decoration:none;color:darkblue;" target="_blank"><b>{{$prjIAN}}</b></a></div>
                                @if (!($i%8))
                                <br>
                                @endif
                                @endforeach
                            </div>
                        </div>

                        <div style="clear: both"></div>
                    </li>
                    @endif

                    <li><div style=" width:128px;height:80px;float:left;">{{ Form::label('Parent/Child',NULL,array('style'=>'float:left;')) }}</div>
                    <input name='PPProduktpass_IsParent' type="hidden" value='0' />
                    <input name='PPProduktpass_IsChild' type="hidden" value='0' />
                    <input name='PPProduktpass_IsKaufland' type="hidden" value='0' />
                    <div style="width:400px;height:80px;float:left;text-align:left;padding:6px;">
                        <div style='text-align:left;'><input name='PPProduktpass_IsParent'   type="checkbox" value="1" @if( $data['pp']->PPProduktpass_IsParent ) checked=checked @endif   style='width:30px; height:20px;'/> <div style='display:inline-block;width:60px;font-weight:bold;padding-top:4px;'>Parent</div></div>
                        <div style='text-align:left;'><input name='PPProduktpass_IsChild'    type="checkbox" value="1" @if( $data['pp']->PPProduktpass_IsChild ) checked=checked @endif    style='width:30px; height:20px;'/> <div style='display:inline-block;width:60px;font-weight:bold;padding-top:4px;'>Child</div></div>
                        <div style='text-align:left;'><input name='PPProduktpass_IsKaufland' type="checkbox" value="1" @if( $data['pp']->PPProduktpass_IsKaufland ) checked=checked @endif style='width:30px; height:20px;'/> <div style='display:inline-block;width:60px;font-weight:bold;padding-top:4px;'>Nachbestellung</div></div>
                    </div>
                    <div style="clear: both;">&nbsp;</div>
                    </li>



                    <li>
                        {{ Form::label('Status',NULL,array('style'=>'float:left;')) }}{{ Form::select('PPProduktpass_Status',array('Neu'=>'Neu', 'In Arbeit'=>'In Arbeit', 'Vorversion'=>'Vorversion', 'Final'=>'Final','Abgerechnet'=>'Abgerechnet', 'Canceld'=>'Canceld'),$data['pp']->PPProduktpass_Status, array('style' => 'width:120px;font-weight:bold;height:28px;')) }}
                        <div style="clear: both"></div>
                    </li>
                    <li style="margin-top:20px;">

                        {{ Form::label('Lizenz',NULL,array('style'=>'float:left;')) }}{{ Form::text('PPProduktpass_Lizenz',NULL,array('id'=>'Lizenz','style'=>'width:350px;float:left;')) }}
                        <div style="clear: both"></div>

                    </li>
                    <li>
                        {{ Form::label('WAWI-Artikel') }}{{ Form::text('PPProduktpass_WAWIArtikelnummer',NULL,array('id'=>'WAWI-Artikel','style'=>'width:350px;')) }}
                    </li>
                    <li>
                        {{ Form::label('Material') }}{{ Form::text('PPProduktpass_Material',NULL,array('id'=>'Material','style'=>'width:350px;')) }}
                    </li>
                    <li>
                        {{ Form::label('Konstruktion') }}{{ Form::text('PPProduktpass_Konstruktion',NULL,array('id'=>'Konstruktion','style'=>'width:350px;')) }}
                    </li>
                </ul>



                {{ Form::label('Projekt Bild') }}

                <ul>
                    <li>
                        <div style="border:none;text-align: center;">
                            <a href="/data/uploads/{{$data['pp']['PPProduktpass_ProjektBild']}}" target="_blank"><img src="/data/uploads/{{$data['pp']['PPProduktpass_ProjektBild']}}" style="margin:5px;border: 1px solid gray;width:200px;"/></a>

                        </div>
                    </li>
                </ul>

                {{ Form::label('Freie Felder') }}

                <ul>
                    <li>
                        {{ Form::text('PPProduktpass_ZBV1_Name',NULL,array('id'=>'PPProduktpass_ZBB1_Name','style'=>'width:80px;float:left;')) }}{{ Form::text('PPProduktpass_ZBV1_Wert',NULL,array('id'=>'PPProduktpass_ZBB1_Wert','style'=>'width:350px;float:left;')) }}
                        <div style="clear: both;"></div>
                    </li>
                    <li>
                        {{ Form::text('PPProduktpass_ZBV2_Name',NULL,array('id'=>'PPProduktpass_ZBB2_Name','style'=>'width:80px;float:left;')) }}{{ Form::text('PPProduktpass_ZBV2_Wert',NULL,array('id'=>'PPProduktpass_ZBB2_Wert','style'=>'width:350px;float:left;')) }}
                        <div style="clear: both;"></div>
                    </li>
                    <li>
                        {{ Form::text('PPProduktpass_ZBV3_Name',NULL,array('id'=>'PPProduktpass_ZBB3_Name','style'=>'width:80px;float:left;')) }}{{ Form::text('PPProduktpass_ZBV3_Wert',NULL,array('id'=>'PPProduktpass_ZBB3_Wert','style'=>'width:350px;float:left;')) }}
                        <div style="clear: both;"></div>
                    </li>
                    <li>
                        {{ Form::text('PPProduktpass_ZBV4_Name',NULL,array('id'=>'PPProduktpass_ZBB4_Name','style'=>'width:80px;float:left;')) }}{{ Form::text('PPProduktpass_ZBV4_Wert',NULL,array('id'=>'PPProduktpass_ZBB4_Wert','style'=>'width:350px;float:left;')) }}
                        <div style="clear: both;"></div>
                    </li>
                    <li>
                        {{ Form::text('PPProduktpass_ZBV5_Name',NULL,array('id'=>'PPProduktpass_ZBB5_Name','style'=>'width:80px;float:left;')) }}{{ Form::text('PPProduktpass_ZBV5_Wert',NULL,array('id'=>'PPProduktpass_ZBB5_Wert','style'=>'width:350px;float:left;')) }}
                        <div style="clear: both;"></div>
                    </li>

                </ul>

                {{ Form::label('Maße und Gewichte') }}
                <ul>
                    <li>
                        {{ Form::label('Länge [cm]') }}{{ Form::text('PPProduktpass_Produkt_Laenge',number_format($data['pp']->PPProduktpass_Produkt_Laenge,0,',','.')) }}
                    </li>
                    <li>
                        {{ Form::label('Breite [cm]') }}{{ Form::text('PPProduktpass_Produkt_Breite',number_format($data['pp']->PPProduktpass_Produkt_Breite,0,',','.')) }}
                    </li>
                    <li>
                        {{ Form::label('Höhe [cm]') }}{{ Form::text('PPProduktpass_Produkt_Hoehe',number_format($data['pp']->PPProduktpass_Produkt_Hoehe,0,',','.')) }}
                    </li>
                    <li>Bitte nur bei Bettwäsche Aufträgen ausfüllen!<br><br>
                        {{ Form::label('GSM [g]') }}{{ Form::text('PPProduktpass_Produkt_GSM',number_format($data['pp']->PPProduktpass_Produkt_GSM,2,',','.')) }}
                    </li>
                    <li>
                        {{ Form::label('Zusätzliches Gewicht/St. [g]') }}{{ Form::text('PPProduktpass_Produkt_ZusatzGSM',number_format($data['pp']->PPProduktpass_Produkt_ZusatzGSM,2,',','.')) }}
                    </li>
                </ul>
                {{ Form::label('Green-Level') }}
                <ul>
                    <li>
                        <!<!-- :                - no Green
                                               -low Green
                                               -med Green
                                               -high Green
                        -->
                        <fieldset>

                            @foreach ($data['greenlevel'] as $glId =>  $greenlevel)
                            <input style="width:30px;" type="radio" id="{{$greenlevel}}" name="PPProduktpass_GreenLevel" value="{{$glId}}" @if ($data['pp']->PPProduktpass_GreenLevel == $glId) checked="checked" @endif >
                            <span>{{$greenlevel}}</span><br>
                            @endforeach
                        </fieldset>
                    </li>
                </ul>

        </div>
        <div style="clear: both;"></div>

    </div>
    {{ Form::close() }}
</div>

<script>

    function  xconfirmDelete(id, ian) {
        var confirm = window.confirm('IAN:' + ian + ' Wiklich löschen?');
        if (confirm) {
            $.ajax({
                type: "POST",
                url: "/postdeletep",
                data: {'id': id},
                cache: false,
                success: function () {
                    alert("Daten gelöscht!");
                    window.close();
                },
                error: function (jqXHR, textStatus, ex) {
                    alert(textStatus + "," + ex + "," + jqXHR.responseText);
                }
            });

        } else {
            alert('Produktpass wurde nicht gelöscht!');
        }
    }

</script>





