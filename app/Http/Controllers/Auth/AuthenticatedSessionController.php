<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use GuzzleHttp\Cookie\CookieJar;

class AuthenticatedSessionController extends Controller
{


    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        $request->authenticate();

        $request->session()->regenerate();
        $user = Auth::user();
        // Autenticarse en la API externa
        $this->authenticateWithExternalApi($user->name, $request->input('password'));
        Log::info('Resultado de autenticación con API externa', [
            'cookies_en_sesion' => session('external_api_cookies'),
            'authenticated_flag' => session('external_api_authenticated')
        ]);
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Autenticarse en la API externa y guardar el token
     */
    protected function authenticateWithExternalApi($userName, $password)
    {
        try {
            Log::info('Intentando autenticar con API externa', ['nombre_usuario' => $userName]);
            $cookies = new CookieJar();
            $response = Http::withOptions(['cookies' => $cookies])
                ->asJson()
                ->post('http://localhost/daw2025/TP/Public/login', [
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
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
