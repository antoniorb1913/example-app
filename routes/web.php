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
        // Forzamos el cierre de cualquier proceso pendiente
        DB::disconnect();
        
        // Ejecutamos la migración desde cero y el llenado de datos
        Artisan::call('migrate:fresh', ['--force' => true, '--seed' => true]);

        return "¡Práctica completada! Tablas creadas y jugadores cargados en Neon.";
    } catch (\Exception $e) {
        return "Error al configurar: " . $e->getMessage();
    }
});