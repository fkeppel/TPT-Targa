<?php $bgcolor1 = "#f6a828"; ?>

<style>
    #AvisImport table{
        border-collapse: collapse;
        font-family: Arial;
        font-size: 11px;
        width:100%;
    }
    #AvisImport th {
        background-color: orange;
        border:1px solid darkblue;
        padding:4px;
        text-align: left;

    }
    #AvisImport .right{
        text-align: right;
        width:80px;
    }
    #AvisImport td{
        background-color: white;
        border:1px solid darkblue;
        padding:4px;

    }
</style>
<div>{{$data['message']}}</div>
<div id="AvisImport" style="border:none; border-radius: 0px; height:830px;overflow: hidden;padding:10px;overflow: auto;">
    @if($data['AvisImport'])
    @foreach ($data['AvisImport'] as $index => $avis)
    <p><b>Lieferavis No.: {{$avis['Kopf']->AvisKopf_Id}}</b></p>

    <table>

        <tr>
            <th>Date</th>
            <th>Voyage</th>
            <th>Country of Origin</th>
            <th>OceanVessel</th>
            <th>POL</th>
            <th>ATD</th>
            <th>POD</th>
            <th>ETA</th>
            <th>ShippingWeek</th>
        </tr>
        <tr>
            <td>{{$avis['Kopf']->AvisKopf_Date}}</td>
            <td>{{$avis['Kopf']->AvisKopf_Voyage}}</td>
            <td>{{$avis['Kopf']->AvisKopf_CountryOfOrigin}}</td>
            <td>{{$avis['Kopf']->AvisPositionen_OceanVessel}}</td>
            <td>{{$avis['Kopf']->AvisKopf_POL}}</td>
            <td>{{$avis['Kopf']->AvisKopf_ATD}}</td>
            <td>{{$avis['Kopf']->AvisKopf_POD}}</td>
            <td>{{$avis['Kopf']->AvisKopf_ETA}}</td>
            <td>{{$avis['Kopf']->AvisKopf_ShippingWeek}}</td>
        </tr>
        <tr>
            <th colspan="4">TarifCode</th>
            <th></th>
            <th colspan="4">Remarks</th>
        </tr>
        <tr>
            <td colspan="4">{{str_replace( array("\r\n", "\n", "\r"), '<br />', $avis['Kopf']->AvisKopf_TarifCode)}}</td>
            <td></td>
            <td colspan="4">{{$avis['Kopf']->AvisKopf_Remarks}}</td>
        </tr>
    </table>

    <table style="margin-top: 10px;">
        <tr>
            <th>ContainerSize</th>
            <th>ContainerNo</th>
            <th>ContainerSealNo</th>
            <th>CB</th>
            <th>SubInfo</th>
            <th  class="right">ParcelCount</th>
            <th class="right">VE</th>
            <th class="right">Total Pcs</th>
            <th class="right">ParcelGross</th>
            <th class="right">ParcelNet</th>
            <th class="right">ParcelDepth</th>
            <th class="right">ParcelWidth</th>
            <th class="right">ParcelHeight</th>

        </tr>

        @foreach($avis['Position'] as $key => $pos)
        <tr>
            <td>{{$pos->AvisPositionen_ContainerSize}}</td>
            <td>{{$pos->AvisPositionen_ContainerNo}}</td>
            <td>{{$pos->AvisPositionen_ContainerSealNo}}</td>
            <td>{{$pos->AvisPositionen_CB}}</td>
            <td>{{$pos->AvisPositionen_SubInfo}}</td>
            <td class="right">{{$pos->AvisPositionen_ParcelCount}}</td>
            <td class="right">{{$pos->AvisPositionen_VE}}</td>
            <td class="right">{{$pos->AvisPositionen_ParcelCount * $pos->AvisPositionen_VE}}</td>
            <td class="right">{{$pos->AvisPositionen_ParcelGross}}</td>
            <td  class="right">{{$pos->AvisPositionen_ParcelNet}}</td>
            <td class="right">{{$pos->AvisPositionen_ParcelDepth}}</td>
            <td  class="right">{{$pos->AvisPositionen_ParcelWidth}}</td>
            <td  class="right">{{$pos->AvisPositionen_ParcelHeight}}</td>
        </tr>
        @endforeach

    </table>

    @endforeach
    @endif
</div>

