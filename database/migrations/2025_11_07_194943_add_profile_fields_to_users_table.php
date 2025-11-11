<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agregamos campos nuevos a la tabla users.
     * IMPORTANTE: como usamos SQLite, debemos poner valores por defecto
     * para que no falle con columnas NOT NULL.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Nuevo campo username (nombre de usuario)
            $table->string('username')->default('usuario')->after('name');

            // Apellido
            $table->string('lastname')->nullable()->after('username');

            // Teléfono
            $table->string('phone')->nullable()->after('email');

            // Perfil (Administrador, Gestión, Consultas)
            $table->enum('profile', ['Administrador', 'Gestión', 'Consultas'])
                  ->default('Consultas')
                  ->after('phone');

            // Campo para baja lógica
            $table->boolean('active')->default(true)->after('profile');
        });
    }

    /**
     * Revertimos los cambios (rollback)
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'lastname', 'phone', 'profile', 'active']);
        });
    }
};


/** lo hice por consejo de fran */