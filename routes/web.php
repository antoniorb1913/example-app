<?php

use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return redirect()->route('players.index');
});

Route::resource('players', PlayerController::class);

Route::get('/setup-final', function () {
    try {
        // 1. Limpiamos la conexión para olvidar cualquier error previo
        DB::purge();
        
        // 2. Ejecutamos la migración forzando el modo producción
        // Usamos 'migrate:fresh' para que borre lo que haya quedado a medias
        Artisan::call('migrate:fresh', [
            '--force' => true,
            '--seed' => true
        ]);

        return "¡ÉXITO! Tablas creadas y Seeders ejecutados correctamente.";
    } catch (\Exception $e) {
        // Si falla, queremos ver el error real de conexión, no el de la transacción
        return "Error detallado: " . $e->getMessage();
    }
});