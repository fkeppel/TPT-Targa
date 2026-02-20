<style>
    label, input, textarea, select {
        display: inline-block;
        vertical-align: top;
        margin: 2px;
    }

    label {
        width: 150px;
        padding:5px;
    }
    input {
        width: 550px;
        border:1px solid lightgray;
        padding:5px;
        border-radius:5px;
    }
    textarea {
        width: 550px;
        border:1px solid lightgray;
        padding:5px;
        border-radius:5px;
        overflow: auto;
        height:40px;
    }
    li {
        list-style-type: none;
    }
    div {
        font-family: Tahoma;
        font-size: 12px;
    }
</style>
<!--div style="border: 1px solid lightgray; height:20px;background-color: lime;@if ($data['pp']->PPProduktpass_IsInquiry == 0)diplay:none;@endif">
    <b>Inquiry</b>
</div-->

<div style="border: none; width:1610px;padding:20px;text-align:left;margin:0 auto;">
    <div id="tabs" >
        <ul>

            <li>
                <a href="#tabs-0">Produktpass ({{$data['pp']->PPProduktpass_IAN}})</a>
            </li>

            <li>
                <a href="#tabs-6">Dateien</a>
            </li>

            @if ($data['pp']->InternerStatus == 'MUSTERUNG' or Auth::User()->username == 'fkeppel')

            <li>
                <a href="#tabs-1">Produktpass </a>
            </li>
            @endif
            
            {{-- 
            <li>
                <a href="#tabs-11">Style</a>
            </li>
            <li>
                <a href="#tabs-2">Qualität</a>
            </li>
           
            @if (Auth::User()->PPMitarbeiter_Gruppe  != 'extern')
            <li>
                <a href="#tabs-4">Sortierung</a>
            </li>
            <li>
                <a href="#tabs-5">Menge</a>
            </li>
            @endif

            --}}

            @if (Auth::User()->PPMitarbeiter_Gruppe  == 'admin')
            <li>
                <a href="#tabs-50">Artikelverwaltung</a>
            </li>
            @endif

          
            @if (Auth::User()->PPMitarbeiter_Gruppe  == 'admin')
            <li>
                <a href="#tabs-7">EK (PP)</a>
            </li>
            <li>
                <a href="#tabs-8">AB</a>
            </li>
          
            <li>
                <a href="#tabs-9">PO</a>
            </li>
            <li>
                <a href="#tabs-70">PO PDF</a>
            </li>
            @endif
            @if (Auth::User()->PPMitarbeiter_Gruppe  == 'admin')
            <li>
                <a href="#tabs-30">LC</a>
            </li>
            {{-- 
            <li>
                <a href="#tabs-40">8WMuster</a>
            </li>
            <li>
                <a href="#tabs-24">GTIN</a>
            </li>
            <li>
                <a href="#tabs-20">ATILA</a>
            </li>
            --}}
            <li>
                <a href="#tabs-60">Shipping Avis</a>
            </li>
            {{-- 
            <li>
                <a href="#tabs-10">Revisionen</a>
            </li>
            --}}
           
            <li>
                <a href="#tabs-200">Eingabe Felder</a>
            </li>
            @endif
        </ul>


        <div id="tabs-0"  style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_targaview')
        </div>  

        
        <div id="tabs-6"  style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_files')
        </div>

        @if ($data['pp']->InternerStatus == 'MUSTERUNG' or Auth::User()->username == 'fkeppel' )
        <div id="tabs-1" style="height:905px;overflow:auto;text-align: left;">
            
            @include('projects.pp_pp')
        </div>
        @endif
        {{-- 
        <div id="tabs-11" style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_style')
        </div>
        <div id="tabs-2" style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_qualitaet')
        </div>
     
        @if (Auth::User()->PPMitarbeiter_Gruppe  == 'admin')
        <div id="tabs-4"  style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_sortierung')
        </div>
        <div id="tabs-5"  style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_menge')
        </div>
        @endif
        --}}
     


        @if (Auth::User()->PPMitarbeiter_Gruppe  == 'admin')

        <div id="tabs-50"  style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_artikelverwaltung')
        </div>
        <div id="tabs-7"  style="height:905px;overflow:auto;text-align: left;">
            @if (substr($data['pp']->PPProduktpass_IAN,0,1) != 'I' )
                @include('projects.pp_purchase')
            @else 
                @include('projects.pp_calc')
            @endif
        </div>

        <div id="tabs-8"  style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_ab')
        </div>
        
        <div id="tabs-9"  style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_po')
        </div>
        <div id="tabs-70"  style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_poPdf')
        </div>
        @endif
        @if (Auth::User()->PPMitarbeiter_Gruppe  == 'admin')
        <div id="tabs-30"  style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_LC')
        </div>
        {{-- 
        <div id="tabs-24"  style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_GTIN')
        </div>

        <div id="tabs-20"  style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_lieferavis')
        </div>
        --}}
        <div id="tabs-60"  style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_Avis')
        </div>
      {{-- 
        <div id="tabs-10"  style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_revision')
        </div>
        --}}
       
        <div id="tabs-200"  style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_input')
        </div>
        @endif
    </div>
</div>
