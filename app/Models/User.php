<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Campos que se pueden llenar de forma masiva
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Campos que no se muestran al serializar
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Tipos de datos de ciertos atributos
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     *  Método auxiliar para identificar al admin.
     * Cambialo si luego agregás roles en la base.
     */
    public function isAdmin(): bool
    {
        return $this->id === 1 || $this->email === 'admin@example.com';
    }
}
