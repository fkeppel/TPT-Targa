<style>
    label,
    input,
    textarea,
    select {
        display: inline-block;
        vertical-align: top;
        margin: 2px;
    }
    label {
        width: 150px;
        padding: 5px;
    }
    input {
        width: 550px;
        border: 1px solid lightgray;
        padding: 5px;
        border-radius: 5px;
    }
    textarea {
        width: 550px;
        border: 1px solid lightgray;
        padding: 5px;
        border-radius: 5px;
        overflow: auto;
        height: 40px;
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
<div style="border: none; padding:20px;text-align:left;margin:0 auto;">
    <div id="tabs">
        <ul>
            <li>
                <a href="#tabs-0">Produktpass ({{$data['pp']->PPProduktpass_IAN}})</a>
            </li>
            <li>
                <a href="#tabs-6">Dateien</a>
            </li>
            @if(false)
            <li>
                <a href="#tabs-45">Meeting-Protokoll</a>
            </li>
            @endif
            @if ($data['pp']->InternerStatus == 'MUSTERUNG' or Auth::User()->PPMitarbeiter_Gruppe == 'admin' )
            <li>
                <a href="#tabs-1">Produktpass </a>
            </li>
            @endif
            @if (Auth::User()->PPMitarbeiter_Gruppe == 'admin' )
            <li>
                <a href="#tabs-89">Notizen</a>
            </li>
            @endif
            @if (Auth::User()->PPMitarbeiter_Gruppe == 'admin')
            <li>
                <a href="#tabs-50">Artikelverwaltung</a>
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
            @if (Auth::User()->PPMitarbeiter_Gruppe == 'admin')
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
            @if (Auth::User()->PPMitarbeiter_Gruppe == 'admin')
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
            <li>
                <a href="#tabs-98">Thema</a>
            </li>
            --}}
            @endif
            <li>
                <a href="#tabs-99">Service Anfrage</a>
            </li>
            <li>
                <a href="#tabs-100">RFQ</a>
            </li>
        </ul>
        <div id="tabs-0" style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_targaview')
        </div>
        <div id="tabs-6" style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_files')
        </div>
        @if (false)
        <div id="tabs-45" style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_meetingprotokoll')
        </div>
        @endif
        @if ($data['pp']->InternerStatus == 'MUSTERUNG' or Auth::User()->PPMitarbeiter_Gruppe == 'admin' )
            <div id="tabs-1" style="height:905px;overflow:auto;text-align: left;">
                @include('projects.pp_pp')
            </div>
        @endif
        @if (Auth::User()->PPMitarbeiter_Gruppe == 'admin' )
            <div id="tabs-89" style="height:905px;overflow:auto;text-align: left;">
                @include('projects.pp_adminremark')
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
        @if (Auth::User()->PPMitarbeiter_Gruppe == 'admin')
            <div id="tabs-50" style="height:905px;overflow:auto;text-align: left;">
                @include('projects.pp_artikelverwaltung')
            </div>
            <div id="tabs-7" style="height:905px;overflow:auto;text-align: left;">
                @if (substr($data['pp']->PPProduktpass_IAN,0,1) != 'I' )
                @include('projects.pp_purchase')
                @else
                @include('projects.pp_calc')
                @endif
            </div>
            <div id="tabs-8" style="height:905px;overflow:auto;text-align: left;">
                @include('projects.pp_ab')
            </div>
            <div id="tabs-9" style="height:905px;overflow:auto;text-align: left;">
                @include('projects.pp_po')
            </div>
            <div id="tabs-70" style="height:905px;overflow:auto;text-align: left;">
                @include('projects.pp_poPdf')
            </div>
        @endif
        {{--
        <div id="tabs-24"  style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_GTIN')
        </div>
        <div id="tabs-20"  style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_lieferavis')
        </div>
        --}}
        {{--
        <div id="tabs-10"  style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_revision')
        </div>
        <div id="tabs-98"  style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_thema')
        </div>
        --}}
        @if (Auth::User()->PPMitarbeiter_Gruppe == 'admin')
            <div id="tabs-30" style="height:905px;overflow:auto;text-align: left;">
                @include('projects.pp_LC')
            </div>
           <div id="tabs-60" style="height:905px;overflow:auto;text-align: left;">
                @include('projects.pp_Avis')
            </div>
        @endif
        <div id="tabs-99" style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_input')
        </div>
        <div id="tabs-100" style="height:905px;overflow:auto;text-align: left;">
            @include('projects.pp_RFQ')
         </div>
    </div>
</div>
<script>
    function activateTabsAfterUpload() {
        var maintab = document.getElementById('hiddenActivmainTab1').value;
        var maintabIndex = document.getElementById('hiddenActivmainTabIndex').value;
        var subtabIndex = document.getElementById('hiddenActivsubTabIndex').value;
        var subtabName = document.getElementById('hiddenActivsubTabName').value;
        var subsubtabIndex = document.getElementById('hiddenActivsubsubTabIndex').value;
        if (maintab == 0) {
            return;
        }
        console.log("main:" + maintab + " mainindex:" + maintabIndex + " SubIndex:" + subtabIndex + " Subname:" + subtabName + " SubSubIndex:" + subsubtabIndex);
        $("#tabs").tabs({
            disabled: 0
        });
        $("#tabs").tabs({
            active: maintabIndex
        });
        var mainTabName = "#tabs-" + maintab;
        console.log("maintab:" + mainTabName);
        $(mainTabName).tabs({
            disabled: 0
        }); //subtract one because zero-based
        $(mainTabName).tabs({
            active: subtabIndex
        }); //subtabIndex  subtract one because zero-based
        var sT = "#" + subtabName;
        console.log("sT:" + sT);
        $(sT).tabs({
            disabled: 0
        }); //subtract one because zero-based
        console.log(subsubtabIndex);
        $(sT).tabs({
            active: subsubtabIndex
        }); // subsubtabIndex subtract one because zero-based
    }
    $(function() {
        //alert("Ready");
        //activateTabsAfterUpload();
    });
</script>