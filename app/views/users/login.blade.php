<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Targa - Informationssystem - Login</title>
        <meta name="author" content="fkeppel" />
        <!-- Date: 2015-03-27 -->
        {{ HTML::style('packages/bootstrap/css/bootstrap.min.css') }}
        {{ HTML::style('css/main.css')}}
        <style>
            .bg {
                background: url('/css/images/Logo.jpg') no-repeat center center fixed;
                text-align: center; margin:0 auto; background-color: white;
            }
        </style>
    </head>
    <body class="bg">
        <?php
        $title = "TPT Entwicklungsumgebung";
        $tptMarkerDev = 'color:red;background-color:orange;';  
        if($data['env'] == 'production'){
            $title = "TPT Live";
            $tptMarkerDev = 'color:darkblue;'  ;
        }
        ?>
        <div style="width:600px;border:none; height:300px; margin:0 auto;text-align: center;border:none;margin-top: 6%;margin-left:6%;background-color: transparent;">
            <h2 class="form-signin-heading" style="{{ $tptMarkerDev }}">TARGA Project Tool</h2>
            <div style="margin:0 auto;width:300px;margin-top:50px; ">
                {{ Form::open(array('url'=>'users/signin', 'class'=>'form-signin')) }}
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                {{ Form::text('email', null, array('class'=>'input-block-level', 'placeholder'=>'Benutzername')) }}
                {{ Form::password('password', array('class'=>'input-block-level', 'placeholder'=>'Passwort')) }}
                {{ Form::submit('Login', array('class'=>'btn btn-large btn-primary btn-block'))}}
                {{ Form::close() }}
            </div>
            @if (Session::has('message')) 
            <div class="alert alert-error" style="width:300px; margin:0 auto;text-align: center;">
                {{ Session::get('message') }}
            </div>
            @endif
        </div>
    </body>
</html>
