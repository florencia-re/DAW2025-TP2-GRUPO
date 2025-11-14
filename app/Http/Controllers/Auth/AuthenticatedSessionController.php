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

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
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

        // Autenticarse en la API externa
        $this->authenticateWithExternalApi($request->input('email'), $request->input('password'));

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Autenticarse en la API externa y guardar el token
     */
    protected function authenticateWithExternalApi($email, $password)
    {
        try {
            Log::info('Intentando autenticar con API externa', ['email' => $email]);

            $response = Http::post('http://localhost/daw2025/TP/Public/login', [
                'nombre_usuario' => $email,
                'contrasena' => $password
            ]);

            Log::info('Respuesta de API externa', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $token = $response->json()['token'] ?? null;

                if ($token) {
                    // Guardar el token en sesión
                    session(['external_api_token' => $token]);
                    Log::info('Token guardado en sesión', ['token_length' => strlen($token)]);
                } else {
                    Log::warning('No se encontró token en la respuesta de la API externa');
                }
            } else {
                Log::warning('API externa respondió con error', ['status' => $response->status()]);
            }
        } catch (\Exception $e) {
            // Si falla la API externa, continuar con el login normal
            Log::error('Excepción al autenticar con API externa: ' . $e->getMessage());
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
