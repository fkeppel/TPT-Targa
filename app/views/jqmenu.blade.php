<?php 
    $style = '';
    $config = Config::get('app.cEnv');
    if (Config::get('app.cEnv') != 'production'){
        $style='Border:4px  solid red;background-color:#12abef;';
    }
    if (isset ($_COOKIE['TPTLanguage'])){
        $lang = $_COOKIE['TPTLanguage'];
    } else {
        $lang = Auth::User()->PPMitarbeiter_Language;
    }  
?>
<style>
#dirac {
    vertical-align: middle;
}
#dirAc input:focus {
    background-color: lightskyblue;
    color:darkblue;
    border-radius:0px;
    font-weight: bold;
    outline:none;
}
#dirAc input {
    padding:5px;
    border:1px solid darkblue;
    border-radius:0px;
    font-size:0.7rem;
}
#dirAc button {
    padding:5px;
    border:1px solid darkblue;
    background-color: lightgray;
    border-radius:0px;
    font-size:0.7rem;
    color:darkblue;
}
#dirAc button:focus {
    border:2px solid darkgreen;
    font-weight:bold;
    color:white;
    background-color: green;
}
</style>
<div id='cssmenu' style="border-radius:0px;position:absolute;width:100%;{{$style}}">
    <ul>
        <li  style="text-align: left;">
            <a href='/home'>Home</a>
        </li>
        @if (ServiceProvider::AuthUserHasRole('SYSADMIN'))
        <li  class='has-sub' style="text-align: left;">
            <a href='#'>Sysadmin</a>
            <ul>
                <li  style="text-align: left;">
                    <a href='/frmSystem'>{{ ServiceProvider::tl($lang, 'System') }}</a>
                </li>
            </ul>
        </li>
        @endif
        @if (Auth::user()->PPMitarbeiter_Gruppe == 'XXXadmin')
         <li  style="text-align: left;">
            <a href='#'><span style='font-size:1.2em;color: red;'><b>SPO Upload</b></span></a>
            <ul>
                <li><a href='/l2spo_start'>Simulation Hintergrund-Prozess SPO Upload</a></li>
            </ul>
        </li>
		@endif        
        @if (Auth::User()->PPMitarbeiter_Gruppe  == 'admin' )
        <li class='has-sub'>
            <a href='#'>{{ ServiceProvider::tl($lang, 'Stammdaten') }}</a>
            <ul>
                @if (Auth::user()->PPMitarbeiter_Gruppe == 'admin')
                <li  style="text-align: left;">
                    <a href='/adressen/liste/4'>{{ ServiceProvider::tl($lang, 'Lieferanten') }}</a>
                </li>
                <li  style="text-align: left;">
                    <a href='/adressen/liste/7'>{{ ServiceProvider::tl($lang, 'Produzenten') }}</a>
                </li>
                <li  style="text-align: left;">
                    <a href='/adressen/liste/8'>{{ ServiceProvider::tl($lang, 'Agenten') }}</a>
                </li>
                <li  style="text-align: left;">
                    <a href='/adressen/liste/3'>{{ ServiceProvider::tl($lang, 'Spediteure') }}</a>
                </li>
                <li  style="text-align: left;">
                    <a href='/adressen/liste/9'>{{ ServiceProvider::tl($lang, 'Frachtführer') }}</a>
                </li>
                <li  style="text-align: left;">
                    <a href='/adressen/liste/2'>{{ ServiceProvider::tl($lang, 'Kunden') }}</a>
                </li>
                <li  style="text-align: left;">
                    <a href='/adressen/liste/0'>{{ ServiceProvider::tl($lang, 'Alle') }}</a>
                </li>
                <li  style="text-align: left;">
                    <a href='/stammdaten/ausmusterung'>{{ ServiceProvider::tl($lang, 'Logistikpauschale') }}</a>
                </li>
                <li  style="text-align: left;">
                    <a href='/mitarbeiter'>{{ ServiceProvider::tl($lang, 'Mitarbeitende') }}</a>
                </li>
                @endif
                @if (Auth::user()->PPMitarbeiter_Gruppe == 'Xadmin')
                <li  style="text-align: left;">
                    <a href='/textbausteine'>{{ ServiceProvider::tl($lang, 'Textbausteine') }}</a>
                </li>
                <li  style="text-align: left;">
                    <a href='/warengruppen'>{{ ServiceProvider::tl($lang, 'Warengruppen') }}</a>
                </li>
                <li  style="text-align: left;">
                    <a href='/stammdaten/cs'>{{ ServiceProvider::tl($lang, 'Ländergrössen') }}</a>
                </li>
                @endif
                @if (strpos(Auth::user()->PPMitarbeiter_Role,'ZOLL') !== false or Auth::user()->PPMitarbeiter_Gruppe == 'admin')
                <li  style="text-align: left;">
                    <a href='/Zoll'>{{ ServiceProvider::tl($lang, 'Zoll Restriktionen') }}</a>
                </li>
                @endif
                @if (Auth::user()->PPMitarbeiter_Gruppe == 'admin')
                <li  style="text-align: left;">
                    <a href='/formDeleteIAN'>PP {{ ServiceProvider::tl($lang, 'löschen') }}</a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        @if (Auth::User()->PPMitarbeiter_Gruppe  == 'admin' )
        <li class='has-sub'>
            <a href='#'>{{ ServiceProvider::tl($lang, 'Produktpass') }}</a>
            <ul>
                @if (Auth::User()->PPMitarbeiter_Gruppe  == 'admin' )
                    <li  style="text-align: left;">
                        <a href='/uploadForm/0'>{{ ServiceProvider::tl($lang, 'Import XML-Datei o. Zip-Archiv') }}</a>
                    </li>
                    @if (strtoupper(Auth::User()->PPMitarbeiter_Kuerzel)  == 'MM_ADMIN' or strtoupper(Auth::User()->PPMitarbeiter_Kuerzel)  == 'CSP_ADMIN' or strtoupper(Auth::User()->PPMitarbeiter_Kuerzel)  == 'FKE'  or strtoupper(Auth::User()->PPMitarbeiter_Kuerzel)  == 'JA_ADMIN' )
                    <li  style="text-align: left;">
                        <a href='/uploadMultiZipForm'>{{ ServiceProvider::tl($lang, 'Massen-Import über Lidl Zip-Archiv') }}</a>
                    </li>
                    @endif
                    @if(false)
                    <li  style="text-align: left;">
                            <a href='/upl2spo'>{{ ServiceProvider::tl($lang, 'Dateitransfer nach Sharepoint') }}</a>
                    </li>
                    @endif
                @endif
                <!--
                <li  style="text-align: left;">
                    <a href='/uploadAvisForm'>Import Avis</a>
                </li>
                -->
                <li  style="text-align: left;">
                    <a href='/showImportThemenplanung'>{{ ServiceProvider::tl($lang, 'Import Themenplanung') }}</a>
                </li>
                @if (strpos(Auth::User()->PPMitarbeiter_Role,'PPIMP')  !== false) 
                <li  style="text-align: left;">
                    <a href='/getFormUploadPruefplaene'>{{ ServiceProvider::tl($lang, 'Massen-Import Prüfpläne') }}</a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        <li class='has-sub'>
            @if (false )
            <a href='#'>{{ ServiceProvider::tl($lang, 'Übersicht Produktpässe') }}</a>
            <ul>
                <li  style="text-align: left;">
                    <a href='/termine/projekt/U/5/0'>{{ ServiceProvider::tl($lang, 'Terminübersicht') }}</a>
                </li>
            </ul>
            @else
            <a href='#'>{{ ServiceProvider::tl($lang, 'Übersichten') }}</a>
            <ul>
                @foreach ($SALs as $sal)
                    @if (strpos($sal->PPBoard_Bezeichnung, '(P)') !== false )
                        @if (Auth::User()->PPMitarbeiter_Kuerzel  == 'FKE' )
                        <li style="text-align: left;">
                            <a href='/termine/projekt/U/{{ $sal->PPBoard_Id }}/1'>{{ ServiceProvider::tl($lang,$sal->PPBoard_Bezeichnung) }}</a>
                        </li>
                        @endif
                    @else 
                        <li style="text-align: left;">
                            <a href='/termine/projekt/U/{{ $sal->PPBoard_Id }}/1'>{{ ServiceProvider::tl($lang,$sal->PPBoard_Bezeichnung) }}</a>
                        </li>
                    @endif
                @endforeach
                @if (ServiceProvider::AuthUserHasRole('INTERN') or ServiceProvider::AuthUserHasRole('EXTERN') )
                <li style="text-align: left;">
                    <a href='/termine/projekt/U/2000/1'>Dashboard {{ ServiceProvider::tl($lang, 'Archiv (GELIEFERT)') }}</a>
                </li>
                @endif
                @if (ServiceProvider::AuthUserHasRole('INTERN') or ServiceProvider::AuthUserHasRole('EXTERN') )
                <li style="text-align: left;">
                    <a href='/termine/projekt/U/2002/1'>Dashboard {{ ServiceProvider::tl($lang, 'Archiv (ABSAGE)') }}</a>
                </li>
                @endif
                <li  style="text-align: left;">
                    <a href='/terminliste/X'>{{ ServiceProvider::tl($lang, 'Termine Projekte') }}</a>
                </li>
                <li  style="text-align: left;">
                    <a href='/terminlisteM/X'>{{ ServiceProvider::tl($lang, 'Termine  Musterung') }}</a>
                </li>
                <!--li  style="text-align: left;">
                    <a href='/terminlisteI/X'>Terminliste Auschreibungen</a>
                </li -->
                @if(false)
                <li style="text-align: left;">
                    <a href='/ppOverviewStart'>{{ ServiceProvider::tl($lang, 'Produktpass Übersicht') }}</a>
                </li>
                @endif
                <li  style="text-align: left;">
                    <a href='/showOrderAll'>IAN-{{ ServiceProvider::tl($lang, 'Suche') }}</a>
                </li>
                <li  style="text-align: left;">
                    <a href='/showFilesAll'>{{ ServiceProvider::tl($lang, 'Datei-Suche') }}</a>
                </li>
                @if (Auth::User()->PPMitarbeiter_Gruppe  == 'admin')
                <li  style="text-align: left;">
                    <a href='/showOrderAll'>{{ ServiceProvider::tl($lang, 'Auftragsübersicht') }}</a>
                </li>
                <li  style="text-align: left;">
                    <!-- a href='/ExcelForm'>Excel-Auswertung</a -->
                    <a href='#'>{{ ServiceProvider::tl($lang, 'Excel-Auswertung')}}</a>
                </li>
                @endif
            </ul>
            @endif
        </li>
        @if ( false )
        <li class='has-sub' style="width:150px;">
            <a href='#'>Finanzen</a>
            <ul>
                <li  style="text-align: left;">
                    <a href='/finance'>Devisenterminkäufe</a>
                </li>
                <li  style="text-align: left;">
                    <a href='/showUngedeckt'>FW-Aufträge Übersicht</a>
                </li>
                <li>
                    <a href='/showLC'>L/C-Übersicht</a>
                </li>
                <li  style="text-align: left;">
                    <a href='/showLiq'>Übersicht LIQ-Liste</a>
                </li>
                <li  style="text-align: left;">
                    <a href='/showOrderAll'>Auftragsübersicht</a>
                </li>
                <!-- li  style="text-align: left;">
                    <a href='/showLiqAll'>Liquiditätsübersicht</a>
                </li-->
            </ul>
        </li>
        <li class='has-sub'>
            <a href='#'>Reports</a>
            <ul>
                @foreach(Reports::getreports('Lisi') as $rep)
                <li  style="text-align: left;">
                    <a href='{{$rep->Reports_Link}}' target="_blank">{{$rep->Reports_Name}}</a>
                </li>
                @endforeach
            </ul>
        </li>
        @endif
        <li style='margin-left:200px;'>
            <div style="padding-left:20px;padding-top:19px;background-color:transparent;font-weight:normal;font-family: 'Tahoma', sans-serif;border-radius:0px;">{{ ServiceProvider::tl($lang, 'Sprache') }} 
            <select style='border-radius:0px;margin-left:10px;margin-top:-3px;margin-left:5px;width:100px;padding:6px;outline:none;' onChange="chngLang(this.options[this.selectedIndex].value)">
                <option @if ($lang == 'DE') selected @endif  value='DE'>{{ ServiceProvider::tl($lang, 'Deutsch') }}</option>
                <option @if ($lang == 'EN') selected @endif  value='EN'>{{ ServiceProvider::tl($lang, 'Englisch') }}</option>
            </select></div>
        </li>
        <li style="position:absolute; right:220px;">
            <a href="/frmChangePassword"><span style='margin-left:30px;'>{{ ServiceProvider::tl($lang, 'Passwort ändern') }}</span></a>
        </li>
        <li style="position:absolute; right:0px;">
            <a href="/users/logout">LOGOUT [{{Auth::User()->username}}] </a>
        </li>
    </ul>
    </div>
</div>
<script>
    function chngLang(lang){
        var frmData = new FormData();
        frmData.append('lang', lang);
        if (lang == 'DE'){
            alert('Sprache auf Deutsch geändert!');
        }
        if (lang == 'EN'){
            alert('Set Language to English!');
        }
        $.ajax({
            type: "POST",
            url: "/setLanguage",
            data: frmData,
            processData: false,
            contentType: false,
            success: onSuccessLangSet,
            error: function(xhr, ajaxOptions, thrownError) {
                alert ('Fehler');
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function onSuccessLangSet (json){
        location.reload();
    }
</script>