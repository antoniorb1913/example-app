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
        // 1. Crea las tablas en la base de datos de Neon
        Artisan::call('migrate:fresh', ['--force' => true]);
        
        // 2. Ejecuta los Seeders para llenar los datos de jugadores
        Artisan::call('db:seed', ['--force' => true]);

        return "Base de datos sincronizada y Seeders ejecutados con éxito.";
    } catch (\Exception $e) {
        return "Error al sincronizar: " . $e->getMessage();
    }
});