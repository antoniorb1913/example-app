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
        // Cerramos conexiones previas bloqueadas
        DB::disconnect(); 
        
        // migrate:fresh borra las tablas con error y las crea de nuevo
        Artisan::call('migrate:fresh', ['--force' => true, '--seed' => true]);
        
        return "¡Práctica completada con éxito! Tablas creadas y datos cargados en Neon.";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});