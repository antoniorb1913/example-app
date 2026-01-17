<?php

use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

// 1. Definimos la ruta de recursos para los jugadores
Route::resource('players', PlayerController::class);

// 2. Definimos una ÚNICA ruta raíz con la lógica de auto-instalación
Route::get('/', function () {
    // Si la tabla 'players' NO existe, ejecutamos la instalación
    if (!Schema::hasTable('players')) {
        try {
            // 'migrate:fresh' limpia la DB y '--seed' inserta los datos de prueba
            Artisan::call('migrate:fresh', [
                '--force' => true,
                '--seed' => true 
            ]);

            return "Base de datos configurada con éxito. <a href='".route('players.index')."'>Ver listado de jugadores</a>";
        } catch (\Exception $e) {
            return "Error en la configuración: " . $e->getMessage();
        }
    }

    // Si la tabla YA EXISTE, redirigimos directamente al listado
    return redirect()->route('players.index');
});