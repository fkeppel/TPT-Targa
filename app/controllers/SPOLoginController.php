<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Office365\SharePoint\ClientContext;
use Office365\Runtime\Auth\AuthenticationContext;
class SPOLoginController extends BaseController
{
    protected $AZURE_TENANT_ID;
    protected $AZURE_CLIENT_ID;
    protected $AZURE_CLIENT_SECRET;
    protected $SPO_SITE_URL;
    protected $tokenUrl;
    protected $scope;
    // Pfade zu deinem Key/Zertifikat
    protected $privateKeyPath;
    protected $privateKeyPass;
    protected $publicCertPath;
    public function __construct()
    {
        parent::__construct();
        echo('SPO TEST Certificate II:' . base_path('app/storage/data/Certs').'<br>');
        $this->AZURE_TENANT_ID     = Config::get('office365.tenant_id');
        $this->AZURE_CLIENT_ID     = Config::get('office365.client_id');
        $this->AZURE_CLIENT_SECRET = Config::get('office365.client_secret'); 
        $this->SPO_SITE_URL = Config::get('office365.site_url');
        $this->tokenUrl     = "https://login.microsoftonline.com/".$this->AZURE_TENANT_ID."/oauth2/v2.0/token";
        $this->scope        = 'https://targagmbh.sharepoint.com/.default';
        //$this->scope        = 'https://'.parse_url($this->SPO_SITE_URL, PHP_URL_HOST).'/sites/TPTStorage/.default';
        // Pfade zu deinem Key/Zertifikat
        $this->privateKeyPath = base_path('app/storage/data/Certs/private.key.pem');      // enthält PRIVATE KEY
        $this->privateKeyPass = 'TARGA';                                   // falls dein Key passwortgeschützt ist, hier setzen
        //$this->publicCertPath = base_path('app/storage/data/Certs/public.cert.pem');      // enthält -----BEGIN CERTIFICATE-----
        $this->publicCertPath = base_path('app/storage/data/Certs/TPTUpload.cer'); // oder public.cert.pem
    }
    function b64u($bin){ return rtrim(strtr(base64_encode($bin), '+/', '-_'), '='); }
    function cert_thumbprint_x5t(string $certPem): string {
        // PEM -> DER
        $der = base64_decode(
            preg_replace('/\s+/', '', preg_replace('/-----BEGIN CERTIFICATE-----|-----END CERTIFICATE-----/', '', $certPem))
        );
        // SHA1(der) und base64url
        return $this->b64u(sha1($der, true));
    }
    function make_client_assertion(string $clientId, string $tokenUrl, string $privateKeyPath, ?string $privateKeyPass, string $publicCertPath): string {
        $certPem = file_get_contents($publicCertPath);
        $x5t = $this->cert_thumbprint_x5t($certPem);
        $header = ['alg' => 'RS256', 'typ' => 'JWT', 'x5t' => $x5t, 'kid' => $x5t];
        $now = time();
        $payload = [
            'aud' => $tokenUrl,
            'iss' => $clientId,
            'sub' => $clientId,
            'jti' => bin2hex(random_bytes(16)),
            'nbf' => $now,
            'exp' => $now + 10*60,   // 10 Minuten
        ];
        $segments = [ $this->b64u(json_encode($header, JSON_UNESCAPED_SLASHES)),
                    $this->b64u(json_encode($payload, JSON_UNESCAPED_SLASHES)) ];
        $signingInput = implode('.', $segments);
        $pkey = openssl_pkey_get_private(file_get_contents($privateKeyPath), $privateKeyPass ?? '');
        if (!$pkey) throw new \RuntimeException('Private Key konnte nicht geladen werden (Pfad/Passwort prüfen)');
        $sig = '';
        if (!openssl_sign($signingInput, $sig, $pkey, OPENSSL_ALGO_SHA256)) {
            throw new \RuntimeException('openssl_sign fehlgeschlagen');
        }
        openssl_free_key($pkey);
        $segments[] = $this->b64u($sig);
        return implode('.', $segments);
    }
    function http_post_form(string $url, array $params): array {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($params, '', '&'),
            CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded','Accept: application/json'],
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_PROXY          => 'http://10.254.0.1',
            CURLOPT_PROXYPORT      => '8080',
        ]);
        $res = curl_exec($ch);
        if ($res === false) throw new \RuntimeException('cURL: '.curl_error($ch));
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [$status, $res];
    }
    public function test7(){
        echo "TEST7 XII <br>";
        // --- Pfade & Secrets ---
        $siteUrl        = rtrim($this->SPO_SITE_URL, '/');       // https://targagmbh.sharepoint.com/sites/...
        $tenant         = trim($this->AZURE_TENANT_ID);          // GUID ODER ...onmicrosoft.com (nicht sharepoint.com)
        $clientId       = trim($this->AZURE_CLIENT_ID);
        $privateKeyPath = $this->privateKeyPath;                 // z.B. storage/keys/private.key.pem
        $privateKeyPass = $this->privateKeyPass ?? null;         // falls gesetzt
        $publicCertPath = $this->publicCertPath;                 // z.B. storage/keys/public.cert.pem
        // --- Private Key laden ---
        $pkeyPem = @file_get_contents($privateKeyPath);
        if ($pkeyPem === false) { die("Private Key nicht gefunden: {$privateKeyPath}"); }
        $pkey = openssl_pkey_get_private($pkeyPem, (string)($privateKeyPass ?? ''));
        if ($pkey === false) {
            echo "Fehler beim Laden des Private Keys:\n";
            while (($error = openssl_error_string()) !== false) {
                echo "OpenSSL-Fehler: $error\n";
            }
            exit;
        } else {
           // echo "Private Key erfolgreich geladen!\n";
        }
        if (!$pkey) { die("Private Key konnte nicht geladen werden (Pfad/Passwort prüfen)"); }
        // --- SHA-1 Thumbprint des öffentlichen Zertifikats berechnen (HEX) ---
        $certPem = @file_get_contents($publicCertPath);
        if ($certPem === false) { die("Zertifikat nicht gefunden: {$publicCertPath}"); }
        $der  = base64_decode(preg_replace('/\s+|-----[^-]+-----/', '', $certPem));
        $sha1 = strtoupper(implode('', array_map(fn($b)=>sprintf('%02X', $b), unpack('C*', sha1($der, true)))));
        // Beispiel-Format: DBC5567BAA06AC544D93356609D6EBECABCCB4C6 (40 Zeichen)
        // --- phpSPO Context + Zertifikats-Login ---
        $ctx = new ClientContext($siteUrl);
        // Wichtig: mit SHA-1 Thumbprint arbeiten, nicht mit SHA-256!
        $ctx->withClientCertificate($tenant, $clientId, $pkey, $sha1);
        // --- Test: Web + CurrentUser laden ---
        $web = $ctx->getWeb();
        $me  = $web->getCurrentUser();
        $ctx->load($web);
        $ctx->load($me);
        try {
            $ctx->executeQuery();
            echo('OK4');exit;
            echo "Site Title: ".$web->getTitle()."<br>";
            echo "CurrentUser: ".$me->getLoginName()."<br>"; // App-Only ⇒ i:0i.t|ms.sp.ext|<clientId>@<tenant>
        } catch (\Throwable $e) {
            echo "FAIL ".get_class($e)." (".$e->getCode().") ".($e->getMessage() ?: '(kein Text)');
        }
        $ctx->getAuthenticationContext()->access; // Token löschen
        echo "Token<pre>";
        print_r($token);
        echo "</pre>";
    }
    public function test6()
    {
        // ---------- 1) Client Assertion erzeugen ----------
        $clientAssertion = $this->make_client_assertion(
            $this->AZURE_CLIENT_ID, $this->tokenUrl,
            $this->privateKeyPath, $this->privateKeyPass, $this->publicCertPath
        );
        // (optional) Header/Thumbprint anzeigen
        [$h] = explode('.', $clientAssertion);
        $hdr = json_decode(base64_decode(strtr($h,'-_','+/')), true);
        echo "JWT header 0: ".json_encode($hdr, JSON_PRETTY_PRINT)."<br>";
        $certPem = file_get_contents($this->publicCertPath);
        $der     = base64_decode(preg_replace('/\s+|-----[^-]+-----/','', $certPem));
        $hex     = strtoupper(implode('', array_map(fn($b)=>sprintf('%02X',$b), unpack('C*', sha1($der, true)))));
        $x5t     = rtrim(strtr(base64_encode(sha1($der, true)),'+/','-_'),'=');
        echo "Cert Thumbprint HEX = {$hex}<br>";
        echo "Cert x5t (b64url)   = {$x5t}<br>";
        // ---------- 2) Token via Client Credentials + client_assertion ----------
        list($st, $body) = $this->http_post_form($this->tokenUrl, [
            'client_id'             => $this->AZURE_CLIENT_ID,
            'scope'                 => $this->scope,     // z.B. https://targagmbh.sharepoint.com/.default
            'grant_type'            => 'client_credentials',
            'client_assertion_type' => 'urn:ietf:params:oauth:client-assertion-type:jwt-bearer',
            'client_assertion'      => $clientAssertion,
        ]);
        if ($st !== 200) {
            die("Token-Fehler HTTP {$st}:\n{$body}\n");
        }
        $tok = json_decode($body, true);
        $accessToken = $tok['access_token'] ?? null;
        if (!$accessToken) die("Kein access_token in Antwort\n");
        // Optional: aud prüfen
        [, $p, ] = explode('.', $accessToken);
        $claims = json_decode(base64_decode(strtr($p, '-_', '+/')), true);
        if (strpos($claims['aud'] ?? '', parse_url($this->SPO_SITE_URL, PHP_URL_HOST)) === false) {
            error_log('Warnung: Token aud = '.($claims['aud'] ?? 'n/a'));
        }
        // ---------- 3) Token in phpSPO injizieren ----------
        $ctx  = new ClientContext($this->SPO_SITE_URL);
        try {
            $authCtx = new \Office365\Runtime\Auth\AuthenticationContext($this->SPO_SITE_URL);
        } catch (\Throwable $e) {
            die("Fehler beim Erstellen des AuthenticationContext: ".$e->getMessage()."\n");
        }
        $authCtx->setAccessToken($accessToken);
        if (method_exists($ctx, 'setAuthenticationContext')) {
            $ctx->setAuthenticationContext($authCtx);
        } elseif (method_exists($ctx->getPendingRequest(), 'setAuthenticationContext')) {
            $ctx->getPendingRequest()->setAuthenticationContext($authCtx);
        } elseif (property_exists($ctx->getPendingRequest(), 'AuthenticationContext')) {
            $ctx->getPendingRequest()->AuthenticationContext = $authCtx;
        } else {
        // Notfall-Fallback (seltener nötig)
            $ctx->getPendingRequest()->beforeExecuteRequest(function ($req) use ($accessToken) {
                $req->ensureHeader('Authorization', 'Bearer '.$accessToken);
                $req->ensureHeader('Accept', 'application/json;odata=nometadata');
            });
        }
        $web = $ctx->getWeb();
        $ctx->load($web);
        echo "Site TitleXXXX: <br><pre>";
        try {
            $ctx->executeQuery();
            echo "Query OK<br>";
            echo "Site Title: ".$web->getTitle().PHP_EOL;
        } catch (\Throwable $e) {
            echo "FAIL ".get_class($e)." (".$e->getCode().") ".($e->getMessage() ?: '(kein Text)').PHP_EOL;
        }
    }
    public function test8() {
    echo "TEST8 I<br>";
    // --- Pfade & Secrets ---
    $siteUrl        = rtrim($this->SPO_SITE_URL, '/');
    $tenant         = trim($this->AZURE_TENANT_ID);
    $clientId       = trim($this->AZURE_CLIENT_ID);
    $privateKeyPath = $this->privateKeyPath;
    $privateKeyPass = $this->privateKeyPass ?? null;
    $publicCertPath = $this->publicCertPath;
    // --- Private Key laden ---
    $pkeyPem = @file_get_contents($privateKeyPath);
    if ($pkeyPem === false) { die("Private Key nicht gefunden: {$privateKeyPath}"); }
    $pkey = openssl_pkey_get_private($pkeyPem, (string)($privateKeyPass ?? ''));
    if ($pkey === false) {
        echo "Fehler beim Laden des Private Keys:\n";
        while (($error = openssl_error_string()) !== false) {
            echo "OpenSSL-Fehler: $error\n";
        }
        exit;
    }
    // --- SHA-1 Thumbprint des öffentlichen Zertifikats berechnen ---
    $certPem = @file_get_contents($publicCertPath);
    if ($certPem === false) { die("Zertifikat nicht gefunden: {$publicCertPath}"); }
    $der  = base64_decode(preg_replace('/\s+|-----[^-]+-----/', '', $certPem));
    $sha1 = strtoupper(implode('', array_map(fn($b)=>sprintf('%02X', $b), unpack('C*', sha1($der, true)))));
    // --- ClientContext + Zertifikats-Login ---
    $ctx = new \Office365\SharePoint\ClientContext($siteUrl);
    $ctx->withClientCertificate($tenant, $clientId, $pkey, $sha1);
    $web = $ctx->getWeb();
    $ctx->load($web);
    try {
        $ctx->executeQuery();
        echo "SharePoint-Login erfolgreich!<br>";
        echo "Site Title: ".$web->getTitle()."<br>";
        // === Access Token aus dem authContext ziehen (Reflection) ===
        $ref = new \ReflectionClass($ctx);
        $prop = $ref->getProperty("authContext");
        $prop->setAccessible(true);
        $authCtx = $prop->getValue($ctx);
        $token = property_exists($authCtx, "accessToken") ? $authCtx->accessToken : null;
        if ($token) {
            echo "Access Token (gekürzt): ".substr($token,0,80)."...<br>";
            // JWT Claims decodieren
            list($h, $p, $s) = explode('.', $token);
            $claims = json_decode(base64_decode(strtr($p, '-_', '+/')), true);
            echo "<pre>";
            print_r($claims);
            echo "</pre>";
        } else {
            echo "Kein Token gefunden.<br>";
        }
    } catch (\Throwable $e) {
        echo "FAIL ".get_class($e)." (".$e->getCode().") ".($e->getMessage() ?: '(kein Text)');
    }
    }
    public function test9(){
        $siteUrl = Config::get('app.SPO_siteUrl'); // z.B. https://targagmbh.sharepoint.com/sites/TPTStorage
        $tenant  =  Config::get('SPO_tenant');
        $thumbprint = Config::get('SPO_thumbprint');
        $clientId  = Config::get('SPO_clientId');
        $privateKeyPath =  Config::get('SPO_privateKeyPath'); 
        $privateKeyPwd = Config::get('SPO_privateKeyPwd'); 
        $privateKey = file_get_contents($privateKeyPath);
        $key = openssl_pkey_get_private($privateKey, $privateKeyPwd);
        $ctx = (new ClientContext($siteUrl))->withClientCertificate($tenant, $clientId, $key, $thumbprint);
    }
}
