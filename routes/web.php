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
        // Ejecuta las migraciones (crea la tabla players)
        Artisan::call('migrate:fresh', ['--force' => true]);
        
        // Ejecuta los seeders (llena la tabla con tus datos)
        Artisan::call('db:seed', ['--force' => true]);

        return "Base de datos sincronizada y Seeders ejecutados con éxito.";
    } catch (\Exception $e) {
        return "Error al sincronizar: " . $e->getMessage();
    }
});