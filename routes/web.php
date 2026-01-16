<?php

use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return redirect()->route('players.index');
});

Route::resource('players', PlayerController::class);

Route::get('/setup-db', function () {
    try {
        // Forzamos el cierre de cualquier transacción previa y limpiamos todo
        // migrate:fresh borra todas las tablas y las crea desde cero
        Artisan::call('migrate:fresh', [
            '--force' => true,
            '--seed' => true // Esto ejecuta los seeders automáticamente después de migrar
        ]);

        return "¡Éxito! Base de datos limpiada, tablas creadas y datos cargados.";
    } catch (\Exception $e) {
        // Si falla, nos dirá exactamente por qué
        return "Error detallado: " . $e->getMessage();
    }
});