<?php

use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return redirect()->route('players.index');
});

Route::resource('players', PlayerController::class);

Route::get('/setup-db', function () {
    // 1. Ejecutar migraciones (Crea las tablas)
    Artisan::call('migrate', ['--force' => true]);
    
    // 2. Ejecutar Seeders (Llena los datos de jugadores)
    Artisan::call('db:seed', ['--force' => true]);

    return "Base de datos actualizada y Seeders ejecutados con éxito.";
});