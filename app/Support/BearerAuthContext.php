<?php
namespace App\Support;
class BearerAuthContext
{
    private string $accessToken;
    public function __construct($accessToken) {
        $this->accessToken = $accessToken;
    }
    // phpSPO ruft das zur Authentifizierung jedes Requests auf
    public function authenticateRequest($request): void
    {
        if (method_exists($request, 'ensureHeader')) {
            $request->ensureHeader('Authorization', 'Bearer '.$this->accessToken);
            $request->ensureHeader('Accept', 'application/json;odata=nometadata');
        } else {
            // Fallback für Forks ohne ensureHeader()
            $request->Headers['Authorization'] = 'Bearer '.$this->accessToken;
            $request->Headers['Accept']        = 'application/json;odata=nometadata';
        }
    }
}