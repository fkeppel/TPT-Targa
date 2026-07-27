<div style="background-color:#FFF; border:1px solid gray; border-radius:5px; width:1638px;
            text-align:left; padding:30px; font-family:Tahoma; font-size:14px; overflow:auto;">
    <h1>Produktpass Massen Import (Zip-File aus Lidl Portal)</h1>
    <div style="float:left; width:600px; border:4px solid lightgray; margin-left:20px; padding:20px;">
        <h2 style="color:red;">Zip-Archiv</h2>
        <div>
            <form id="massImportForm" method="POST" action="{{ URL::route('uploadMassenImport') }}"
                  accept-charset="UTF-8" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="import_token" value="{{ md5(uniqid(mt_rand(), true)) }}">
                <div style="width:500px; vertical-align:text-top; font-size:15px;
                            border:1px solid lightgray; padding:20px;">
                    <h3>Schritt 1: ZIP-Archive aus Lidl Portal auswählen</h3>
                    <div style="width:400px; float:left; vertical-align:text-top; font-size:15px; padding:0px;">
                        <div style="margin-top:20px;">
                            <input accept=".xml,.zip" type="file" name="MultiZip"
                                   style="font-size:20px; margin-top:15px; width:400px; height:30px;" />
                        </div>
                        <div style="margin-top:20px; padding-bottom:20px;">
                            <h3>Status</h3>
                            <input type="radio" name="InternerStatus" value="PLAN" checked="checked" />
                            <b>PLAN</b><br>
                            <input type="radio" name="InternerStatus" value="FIX" />
                            <b>FIX</b>
                        </div>
                    </div>
                    <div style="clear:both;"></div>
                </div>
                <div style="width:500px; border:1px solid lightgray; padding:0 0 0 20px; margin-top:15px;">
                    <h3>Schritt 2: Importieren</h3>
                    <div style="margin-top:20px;">
                        Infomail an:<br>
                        <input name="mailto" style="font-size:20px; width:400px; height:30px;"
                               value="{{ Auth::user()->PPMitarbeiter_email }}" />
                    </div>
                    <div style="margin-top:20px;">
                        <label style="display:inline-block; vertical-align:middle;">
                            Mailversand unterdrücken:
                        </label>
                        <input type="checkbox" name="mailSuppress" value="1"
                               style="margin-left:10px; vertical-align:middle;" />
                    </div>
                    <div style="margin-top:20px;">
                        Generelles Lieferdatum für IANs OHNE Liefertermin<br>
                        Woche:
                        <input name="LTWoche"
                               style="font-size:20px; width:100px; height:30px; margin-right:30px; text-align:right;"
                               value="99" />
                        Jahr:
                        <input name="LTJahr"
                               style="font-size:20px; width:100px; height:30px; text-align:right;"
                               value="9999" />
                    </div>
                    <input id="importBtn" type="submit" value="IMPORTIEREN"
                           style="width:400px; margin-top:20px; font-size:20px; height:40px;" />
                </div>
            </form>
        </div>
        <div id="uploadStatus" style="margin-top:20px; font-weight:bold;"></div>
        <div id="progressBox" style="margin-top:20px; display:none;">
            <div style="margin-bottom:10px;">
                Fortschritt: <span id="progressText">0 / 0</span>
            </div>
            <div style="width:500px; height:24px; border:1px solid #999; background:#eee;">
                <div id="progressBar" style="width:0%; height:24px; background:#4caf50;"></div>
            </div>
            <div id="currentFile" style="margin-top:10px;"></div>
            <div id="resultList"
                 style="margin-top:15px; max-height:300px; overflow:auto; border:1px solid #ccc; padding:10px;">
            </div>
        </div>
    </div>
    <div style="clear:both;"></div>
</div>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script>
$(function() {
    $('#massImportForm').on('submit', function(e) {
        e.preventDefault();
        var $btn = $('#importBtn');
        if ($btn.data('submitted') == 1) {
            return false;
        }
        $btn.data('submitted', 1);
        $btn.prop('disabled', true).val('Import läuft...');
        $('#uploadStatus').html('ZIP wird hochgeladen...');
        $('#progressBox').show();
        $('#progressText').html('0 / 0');
        $('#progressBar').css('width', '0%');
        $('#currentFile').html('');
        $('#resultList').html('');
        var formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(resp) {
                if (!resp.success) {
                    $('#uploadStatus').html(resp.message ? resp.message : 'Import konnte nicht gestartet werden.');
                    $btn.data('submitted', 0);
                    $btn.prop('disabled', false).val('IMPORTIEREN');
                    return;
                }
                $('#uploadStatus').html('Import gestartet.');
                pollImportStatus(resp.job_id);
            },
            error: function() {
                $('#uploadStatus').html('Fehler beim Starten des Imports.');
                $btn.data('submitted', 0);
                $btn.prop('disabled', false).val('IMPORTIEREN');
            }
        });
        return false;
    });
    function pollImportStatus(jobId) {
        var timer = setInterval(function() {
            $.ajax({
                url: '/uploadMassenImportStatus/' + jobId,
                type: 'GET',
                success: function(resp) {
                    $('#progressText').html(resp.processed_files + ' / ' + resp.total_files);
                    $('#progressBar').css('width', resp.percent + '%');
                    if (resp.current_file) {
                        $('#currentFile').html('Aktuell: ' + resp.current_file);
                    } else {
                        $('#currentFile').html('');
                    }
                    $('#resultList').html('');
                    if (resp.messages && resp.messages.length) {
                        for (var i = 0; i < resp.messages.length; i++) {
                            $('#resultList').append('<div style="padding:3px 0;">' + resp.messages[i] + '</div>');
                        }
                    }
                    if (resp.status == 'done') {
                        clearInterval(timer);
                        $('#uploadStatus').html('Import abgeschlossen.');
                        $('#importBtn').data('submitted', 0).prop('disabled', false).val('IMPORTIEREN');
                    }
                    if (resp.status == 'error') {
                        clearInterval(timer);
                        $('#uploadStatus').html('Fehler: ' + (resp.error_message ? resp.error_message : 'Unbekannter Fehler'));
                        $('#importBtn').data('submitted', 0).prop('disabled', false).val('IMPORTIEREN');
                    }
                },
                error: function() {
                    clearInterval(timer);
                    $('#uploadStatus').html('Fehler beim Abfragen des Fortschritts.');
                    $('#importBtn').data('submitted', 0).prop('disabled', false).val('IMPORTIEREN');
                }
            });
        }, 1000);
    }
});
</script>