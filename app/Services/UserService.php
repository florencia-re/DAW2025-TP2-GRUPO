<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UserService
{

    public function loguearUsuarioEnApi($username, $password)
    {
        $response = Http::post('http://localhost/daw2025/TP/Public/login', [
            'username' => $username,
            'password' => $password
        ]);

        return $response->json();
    }
}
