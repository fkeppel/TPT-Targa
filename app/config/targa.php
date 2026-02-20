<?php
$secrets = file_exists(app_path('secrets.php'))
    ? include app_path('secrets.php')
    : [];
return isset($secrets['targa'])
    ? $secrets['targa']
    : [];
