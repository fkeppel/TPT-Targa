<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SPO-Rev-Prüfung</title>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <style>
        body {
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        #progress-wrapper {
            width: 500px;
            height: 25px;
            border: 1px solid #999;
            margin-top: 20px;
            position: relative;
        }
        #progress-bar {
            width: 0%;
            height: 100%;
            background: #4caf50;
        }
        #progress-text {
            margin-top: 10px;
            font-family: Arial, sans-serif;
        }
        #log {
            margin-top: 20px;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <h2>SPO-Rev-Fehlerprüfung</h2>
<div style="margin-bottom:15px;">
    <label>Status:</label>
    <input type="text" id="status-input" value="PLAN" style="margin-right:10px;"><br>
    <div style="color:rgb(131, 131, 131); font-size:0.8rem;margin-top:5px;margin-bottom:5px;">(z.B. PLAN, GELIEFERT, ABSAGE, MUSTERUNG, FIX oder Kombi wie "PLAN@GELIEFERT")</div><br>
    <label>Ausmusterung:</label>
    <input type="text" id="ausm-input" value="26" style="margin-right:10px;"><br>
    <div style="color:rgb(131, 131, 131); font-size:0.8rem;margin-top:5px;margin-bottom:5px;">(z.B. 2204, 23 oder 2)</div>
</div>
<button id="start-btn">Prüfung starten</button>
<button id="reset-btn" type="button">Reset</button>
    <div id="progress-wrapper">
        <div id="progress-bar"></div>
    </div>
    <div id="progress-text">Noch nicht gestartet</div>
    <div id="log"></div>
<script>
    var pollInterval = null;
    function updateProgress() {
        $.ajax({
            url: '/spo/check/progress',
            type: 'GET',
            success: function(data) {
                console.log('progress response:', data);
                $('#progress-bar').css('width', data.percent + '%');
                $('#progress-text').text(
                    data.current_step + ' / ' + data.total_steps +
                    ' (' + data.percent + '%) - ' + data.message
                );
                if (data.status === 'finished') {
                    clearInterval(pollInterval);
                    $('#log').html('<strong>Fertig</strong>');
                    $('#start-btn').prop('disabled', false);
                }
                if (data.status === 'failed') {
                    clearInterval(pollInterval);
                    $('#log').html('<strong>Fehler:</strong> ' + data.message);
                    $('#start-btn').prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.log('progress error:', xhr.status, error, xhr.responseText);
            }
        });
    }
    $(function () {
        $('#start-btn').on('click', function(e) {
            e.preventDefault();
            console.log('Start-Button geklickt');
            $('#start-btn').prop('disabled', true);
            $('#log').html('');
            $('#progress-bar').css('width', '0%');
            $('#progress-text').text('Starte...');
          $.ajax({
    url: '/spo/check/start',
    type: 'POST',
    data: {
        status: $('#status-input').val(),
        ausm: $('#ausm-input').val()
    },
    success: function(data) {
        console.log('start success:', data);
        pollInterval = setInterval(updateProgress, 1000);
    },
    error: function(xhr, status, error) {
        console.log('start error:', xhr.status, error, xhr.responseText);
        $('#progress-text').text('Start fehlgeschlagen');
        $('#start-btn').prop('disabled', false);
    }
});
        });
    });
     $('#reset-btn').on('click', function () {
        if (!confirm('Fortschritt wirklich zurücksetzen?')) {
            return;
        }
        $.ajax({
            url: '/spo/check/reset',
            type: 'GET',
            success: function (data) {
                $('#progress-bar').css('width', '0%');
                $('#progress-text').text('0 / 0 (0%) - Zurückgesetzt');
                $('#log').html('');
                $('#start-btn').prop('disabled', false);
                console.log(data);
            },
            error: function (xhr, status, error) {
                alert('Reset fehlgeschlagen');
                console.log(xhr.responseText);
            }
        });
    });
</script>
</body>
</html>