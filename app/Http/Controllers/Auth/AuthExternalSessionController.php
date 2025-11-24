<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Facades\Log;

class AuthExternalSessionController extends Controller
{

    protected $baseUrl = 'http://localhost/daw2025/TP/Public';
     /**
     * Autenticarse en la API externa y guardar el token
     */
    public function authenticateWithExternalApi($userName, $password)
    {
        try {
            Log::info('Intentando autenticar con API externa', ['nombre_usuario' => $userName]);
            $cookies = new CookieJar();
            $response = Http::withOptions(['cookies' => $cookies])
                ->asJson()
                ->post("{$this->baseUrl}/login", [
                    'nombre_usuario' => $userName,
                    'contrasena' => $password
                ]);

            Log::info('Respuesta de API externa', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            if ($response->successful()) {
                $cookiesArray = [];
                Log::info('Cookies recibidas del CookieJar', [
                    'total_cookies' => count($cookies->toArray()),
                    'cookies_raw' => $cookies->toArray()
                ]);
                foreach ($cookies->toArray() as $cookie) {
                    $cookiesArray[$cookie['Name']] = $cookie['Value'];
                }
                session(['external_api_cookies' => $cookiesArray, 'external_api_authenticated' => true]);
                Log::info('Cookies guardadas en sesión', [
                    'cookies_guardadas' => array_keys($cookiesArray),
                    'total' => count($cookiesArray)
                ]);

                return true;
            } else {
                Log::warning('API externa respondió con error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Excepción al autenticar con API externa: ' . $e->getMessage());
            return false;
        }
    }

}
