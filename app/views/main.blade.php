<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
    <head>
        <title>@if(isset($title)){{$title}} @else Targa Project Tool (TPT) - LIVE - @endif</title>
        {{ HTML::style('css/bisstyle.css'); }}
        {{ HTML::style('css/menu.css'); }}
        {{ HTML::script('js/menu.js'); }}
        {{-- HTML::style('js/calendar/calendar-win2k-cold-1.css'); --}}
        {{ HTML::style('js/calendar/calendar-blue.css');}}
        {{-- HTML::style('//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css'); --}}
        {{ HTML::style('jquery/jquery-ui.css'); }}
        {{ HTML::style('js/jquery-ui/jquery-ui.theme.css'); }}
        {{-- HTML::script('//code.jquery.com/jquery-1.10.2.js'); --}}
        {{ HTML::script('jquery/jquery-1.10.2.js'); }}
        {{-- HTML::script('//code.jquery.com/ui/1.11.3/jquery-ui.js'); --}}
        {{ HTML::script('jquery/jquery-ui.js'); }}
        {{HTML::style('jquery/dropzone.css');}}
        {{HTML::script('jquery/dropzone.js');}}
        {{ HTML::style('css/bisstyle.css'); }}
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>    
        {{-- HTML::style('css/magicsuggest.css'); --}}
        {{-- HTML::script('js/magicsuggest-min.js'); --}}
        {{--HTML::script('jquery/FileUpload/js/vendor/jquery.ui.widget.js')--}}
        {{--HTML::script('jquery/FileUpload/js/jquery.iframe-transport.js')--}}
        {{--HTML::script('jquery/FileUpload/js/jquery.fileupload.js')--}}
        <script>
            $(function () {
                $("#tabs").tabs();
            });
            $(function () {
                $("#tabs2345").tabs();
            });
            $(function () {
                for (i = 0; i < 110; i++) {
                    $("#tabs" + i).tabs();
                }
            }); 
        </script>
        <script type="text/javascript">
            function stopRKey(evt) {
                var evt = (evt) ? evt : ((event) ? event : null);
                var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
                if ((evt.keyCode == 13) && (node.type == "text")) {
                    return false;
                }
            }
            document.onkeypress = stopRKey;
        </script>
        <script>
            function showHist(str) {
                alert(str);
            }
        </script>
        <!--script>
            function preventUnload( state )
            {
                unloadMessage = "Es wurden Daten geändert\nSind Sie sicher?";
                window.onbeforeunload = state ? function() { return unloadMessage; } : null;
            }
            preventUnload( true );
        </script-->
        <script>
            function resetFormTerminliste() {
                document.getElementById('qiIAN').setAttribute('value', '');
                document.getElementById('qiVerantwortlicher').setAttribute('value', '');
                document.getElementById('qiTerminart').setAttribute('value', '');
                document.getElementById('qiSollTermin').setAttribute('value', '');
                document.getElementById('qiStatus').setAttribute('value', '');
                document.getElementById('Terminliste').submit();
            }
        </script>
        <script>
            function cpc_save_termin(id) {
                $.ajax({
                    url: 'termineupdate/"+id+"/true',
                    type: 'POST',
                    data: $('#cpcfrmTerminEdit').serialize(),
                    success: function (responseText) {
                        $('#cpcdivTerminEdit').html(responseText);
                    },
                    error: function (responseText) {
                        $('#cpcdivTerminEdit').html(responseText);
                    }
                });
            }
        </script>
        <script type="text/javascript">
            function cpc_popupTerminEdit(id) {
                //alert(id); exit;
                document.getElementById('terminEdit1').style.visibility = 'visible';
                $("#terminEdit1").load("" + id,
                        function (response, status, xhr) {
                            if (status == "error") {
                                var msg = "Fehler im Termin: " + id;
                                $("#terminEdit1").html(msg + " " + xhr.status + " " + xhr.statusText);
                            } else {
                                //document.getElementById('terminEdit1').style.visibility = 'hidden';
                            }
                        });
            }
            function cpc_popupTerminEditSave() {
                alert('speichern');
                $("#frmTerminEdit").submit(function () {
                    $.post($(this).attr("action"),
                            $(this).serialize(),
                            function (jsonData) {
                                $("#terminEdit1").html("Termin gespeichert!");
                            },
                            "json"
                            );
                });
            }
            function cpc_popupTerminEditClose() {
                //alert('angekommen!' + id);
                //$( "#terminEdit" ).load( "/terminEdit/"+id );
                document.getElementById("terminEdit1").style.visibility = 'hidden';
                //fenster = window.open("/terminEdit/"+id, "width=600,height=400,status=yes,scrollbars=no,resizable=no");
                //fenster.focus();
            }
        </script>
        <script>
            $(function () {
                $("#dialog").dialog({
                    autoOpen: false,
                    show: {
                        effect: "blind",
                        duration: 1000
                    },
                    hide: {
                        effect: "explode",
                        duration: 1000
                    }
                });
                $("#opener").click(function () {
                    $("#dialog").dialog("open");
                });
            });
        </script>
        {{HTML::script('js/tsave.js');}}
        {{HTML::style('js/jquery-filestyle/jquery-filestyle.min.css');}}
        {{HTML::script('js/jquery-filestyle/jquery-filestyle.min.js');}}
        <link rel="icon" type="image/vnd.microsoft.icon" href="{{url('/images/Targa_FavIcon.ico')}}">
        <style>
              .ui-widget-header {
                   border: 1px solid #c5c5c5;
                    background: #c5c5c5;
                    color: #333333;
                    font-weight: bold;
                }
                .ui-widget.ui-widget-content {
                    border: 1px solid #c5c5c5;
                }
                .ui-widget-content {
                    border: 1px solid #dddddd;
                    background: #ffffff;
                    color: #333333;
                }
                body {
                    font-family:'Open Sans', Tahoma,  Arial,  sans-serif;
                }
        </style>
    </head>
    <html>
        <body style="margin: 0 auto;background:#afafaf;text-align:center;border-collapse: collapse;width:99.8%;height:94%;">
            <div style="position:relative;width:100%;margin: 0 auto;border:1px solid lightgray;">
                <div style="position:relative;text-align: center; margin:0 auto;z-index: 10000;">
                    <div>
                        @include('jqmenu')
                    </div>
                </div>
                <div style="position:relative;text-align: center; margin:0 auto;margin-top:0px;height:calc(100% - 25px); overflow: auto;z-index: 10;border-radius: 0px;margin-top:30px;">
                    {{$content}}
                </div>
                <div style="background-color:#d0d0d0;text-align: center; margin:0 auto;height:30px;border:1px solid lightgray;position:relative;padding-left:10px;">
                    <div style="width:500px;background-color:#d0d0d0;position:absolute; left:0;height:25px;text-align: left;padding-left:10px;">
                        <p style="color:#0D0D0D;font-size:10px;">Status: {{$footer['Status'] or ''}} {{ isset($_SESSION['TPT_Message']) ? $_SESSION['TPT_Message'] : '';   }}  @if(isset($DAUER)) {{ date('s') - $DAUER  }}s @endif</p>
                    </div>
                    <div style="width:100px;background-color:#d0d0d0;position:absolute; right:0;height:25px;text-align: right;padding-right:10px;">
                        <p style="color:#0D0D0D;font-size:10px;">Kalenderwoche: {{date('W')}}</p>
                    </div>
                </div>
            </div>
        </body>
    </html>