<?php
error_reporting(E_ALL ^ E_DEPRECATED);
return array(
    /*******
     * Parametr für die Verbindung mit SPO Targagmbh
     * 
     * 
     * 
     * 
     * 
     * 
     */
    'SPOTEST'             => 124,
    'SPO_siteUrl'         => "https://targagmbh.sharepoint.com/sites/TPTStorage",
    'SPO_siteUrlChina'         => "https://targagmbh.sharepoint.com/sites/TPTStorageChina",
    'SPO_tenant'          => "targagmbh.onmicrosoft.com", 
    'SPO_thumbprint'      => "0AE89B709806C518D50E1651C2B047A21C582A1A",
    'SPO_clientId'        => "bf7658a4-b690-4934-bd74-9b4da3c60ae9",
    'SPO_privateKeyPath'  => '/var/www/targa/app/storage/data/Certs/private.key.pem', 
    'SPO_privateKeyPwd'   => 'TARGA',
    /*
      |--------------------------------------------------------------------------
      | Application Debug Mode
      |--------------------------------------------------------------------------
      |
      | When your application is in debug mode, detailed error messages with
      | stack traces will be shown on every error that occurs within your
      | application. If disabled, a simple generic error page is shown.
      |
     */
     'cEnv' => 'production',
     'debug' => true,
    /*
      |--------------------------------------------------------------------------
      | Application URL
      |--------------------------------------------------------------------------
      |
      | This URL is used by the console to properly generate URLs when using
      | the Artisan command line tool. You should set this to the root of
      | your application so that it is used when running Artisan tasks.
      |
     */
    'url' => 'https://tpt-dev.ad.targa.de/',
    /*
      |--------------------------------------------------------------------------
      | Application Timezone
      |--------------------------------------------------------------------------
      |
      | Here you may specify the default timezone for your application, which
      | will be used by the PHP date and date-time functions. We have gone
      | ahead and set this to a sensible default for you out of the box.
      |
     */
    'timezone' => 'Europe/Berlin',
    /*
      |--------------------------------------------------------------------------
      | Application Locale Configuration
      |--------------------------------------------------------------------------
      |
      | The application locale determines the default locale that will be used
      | by the translation service provider. You are free to set this value
      | to any of the locales which will be supported by the application.
      |
     */
    'locale' => 'de',
    /*
      |--------------------------------------------------------------------------
      | Application Fallback Locale
      |--------------------------------------------------------------------------
      |
      | The fallback locale determines the locale to use when the current one
      | is not available. You may change the value to correspond to any of
      | the language folders that are provided through your application.
      |
     */
    'fallback_locale' => 'en',
    /*
      |--------------------------------------------------------------------------
      | Encryption Key
      |--------------------------------------------------------------------------
      |
      | This key is used by the Illuminate encrypter service and should be set
      | to a random, 32 character string, otherwise these encrypted strings
      | will not be safe. Please do this before deploying an application!
      |
     */
    'key' => 'Abz6&&5$hhsgt%$A',
    'cipher' => MCRYPT_RIJNDAEL_128,
    //
    /*
      |--------------------------------------------------------------------------
      | Autoloaded Service Providers
      |--------------------------------------------------------------------------
      |
      | The service providers listed here will be automatically loaded on the
      | request to your application. Feel free to add your own services to
      | this array to grant expanded functionality to your applications.
      |
     */
    'providers' => array(
        'Illuminate\Foundation\Providers\ArtisanServiceProvider',
        'Illuminate\Auth\AuthServiceProvider',
        'Illuminate\Cache\CacheServiceProvider',
        'Illuminate\Session\CommandsServiceProvider',
        'Illuminate\Foundation\Providers\ConsoleSupportServiceProvider',
        'Illuminate\Routing\ControllerServiceProvider',
        'Illuminate\Cookie\CookieServiceProvider',
        'Illuminate\Database\DatabaseServiceProvider',
        'Illuminate\Encryption\EncryptionServiceProvider',
        'Illuminate\Filesystem\FilesystemServiceProvider',
        'Illuminate\Hashing\HashServiceProvider',
        'Illuminate\Html\HtmlServiceProvider',
        'Illuminate\Log\LogServiceProvider',
        'Illuminate\Mail\MailServiceProvider',
        'Illuminate\Database\MigrationServiceProvider',
        'Illuminate\Pagination\PaginationServiceProvider',
        'Illuminate\Queue\QueueServiceProvider',
        'Illuminate\Redis\RedisServiceProvider',
        'Illuminate\Remote\RemoteServiceProvider',
        'Illuminate\Auth\Reminders\ReminderServiceProvider',
        'Illuminate\Database\SeedServiceProvider',
        'Illuminate\Session\SessionServiceProvider',
        'Illuminate\Translation\TranslationServiceProvider',
        'Illuminate\Validation\ValidationServiceProvider',
        'Illuminate\View\ViewServiceProvider',
        'Illuminate\Workbench\WorkbenchServiceProvider',
        'Way\Generators\GeneratorsServiceProvider',
        'Anouar\Fpdf\FpdfServiceProvider',
    ),
    /*
      |--------------------------------------------------------------------------
      | Service Provider Manifest
      |--------------------------------------------------------------------------
      |
      | The service provider manifest is used by Laravel to lazy load service
      | providers which are not needed for each request, as well to keep a
      | list of all of the services. Here, you may set its storage spot.
      |
     */
    'manifest' => storage_path() . '/meta',
    /*
      |--------------------------------------------------------------------------
      | Class Aliases
      |--------------------------------------------------------------------------
      |
      | This array of class aliases will be registered when this application
      | is started. However, feel free to register as many as you wish as
      | the aliases are "lazy" loaded so they don't hinder performance.
      |
     */
    'aliases' => array(
        'App' => 'Illuminate\Support\Facades\App',
        'Artisan' => 'Illuminate\Support\Facades\Artisan',
        'Auth' => 'Illuminate\Support\Facades\Auth',
        'Blade' => 'Illuminate\Support\Facades\Blade',
        'Cache' => 'Illuminate\Support\Facades\Cache',
        'ClassLoader' => 'Illuminate\Support\ClassLoader',
        'Config' => 'Illuminate\Support\Facades\Config',
        'Controller' => 'Illuminate\Routing\Controller',
        'Cookie' => 'Illuminate\Support\Facades\Cookie',
        'Crypt' => 'Illuminate\Support\Facades\Crypt',
        'DB' => 'Illuminate\Support\Facades\DB',
        'Eloquent' => 'Illuminate\Database\Eloquent\Model',
        'Event' => 'Illuminate\Support\Facades\Event',
        'File' => 'Illuminate\Support\Facades\File',
        'Form' => 'Illuminate\Support\Facades\Form',
        'Hash' => 'Illuminate\Support\Facades\Hash',
        'HTML' => 'Illuminate\Support\Facades\HTML',
        'Input' => 'Illuminate\Support\Facades\Input',
        'Lang' => 'Illuminate\Support\Facades\Lang',
        'Log' => 'Illuminate\Support\Facades\Log',
        'Mail' => 'Illuminate\Support\Facades\Mail',
        'Paginator' => 'Illuminate\Support\Facades\Paginator',
        'Password' => 'Illuminate\Support\Facades\Password',
        'Queue' => 'Illuminate\Support\Facades\Queue',
        'Redirect' => 'Illuminate\Support\Facades\Redirect',
        'Redis' => 'Illuminate\Support\Facades\Redis',
        'Request' => 'Illuminate\Support\Facades\Request',
        'Response' => 'Illuminate\Support\Facades\Response',
        'Route' => 'Illuminate\Support\Facades\Route',
        'Schema' => 'Illuminate\Support\Facades\Schema',
        'Seeder' => 'Illuminate\Database\Seeder',
        'Session' => 'Illuminate\Support\Facades\Session',
        'SoftDeletingTrait' => 'Illuminate\Database\Eloquent\SoftDeletingTrait',
        'SSH' => 'Illuminate\Support\Facades\SSH',
        'Str' => 'Illuminate\Support\Str',
        'URL' => 'Illuminate\Support\Facades\URL',
        'Validator' => 'Illuminate\Support\Facades\Validator',
        'View' => 'Illuminate\Support\Facades\View',
        'Fpdf' => 'Anouar\Fpdf\Facades\Fpdf',
    ),
    'mailer_OLD' => array (
      'mailer_Host'          => 'vex2016.ad.targa.de',               
      'mailer_SMTPAuth'      => false,                  
      'mailer_Username'      => 'tpt-admin@targa.de',     
      'mailer_Password'      => '',         
      'mailer_SMTPSecure'    => 'tsl',               
      'mailer_Port'          => 465,                       
      'mailer_FromName'  => 'Targa Projekt Tool',
      'mailer_FromEMail'  => 'tpt-admin@targa.de', 
    ),
    'mailer' => array (
      'mailer_Host'          => 'targagmbh.mail.protection.outlook.com',               
      'mailer_SMTPAuth'      => false,                  
      'mailer_Username'      => 'tpt-admin@targa.de',     
      'mailer_Password'      => '',         
      'mailer_SMTPSecure'    => '',               
      'mailer_Port'          => 25,                       
      'mailer_FromName'  => 'Targa Projekt Tool',
      'mailer_FromEMail'  => 'tpt-admin@targa.de', 
      'mailer_SMTPDebug' => 0,
      'mailer_Debugoutput' => 'html',
      'mailer_SMTPAutoTLS' => false
    ),
);