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
        // 1. Forzamos una limpieza de la conexión actual
        DB::purge();
        
        // 2. Limpieza manual por si el DROP de la web de Neon no fue suficiente
        // Borra el esquema público y lo recrea para asegurar 0 bloqueos
        DB::statement('DROP SCHEMA public CASCADE');
        DB::statement('CREATE SCHEMA public');
        
        // 3. Ahora que está vacío y sin bloqueos, migramos
        Artisan::call('migrate', ['--force' => true]);
        
        // 4. Llenamos los datos de los jugadores
        Artisan::call('db:seed', ['--force' => true]);

        return "¡CONSEGUIDO! Base de datos reseteada y sincronizada correctamente.";
    } catch (\Exception $e) {
        return "Error crítico: " . $e->getMessage();
    }
});