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
        // PASO A: Desconectar para resetear el error 25P02
        DB::disconnect();

        // PASO B: Borrado manual desde PHP por si Neon no se limpió bien
        // Esto vacía la base de datos completamente
        DB::statement('DROP SCHEMA public CASCADE; CREATE SCHEMA public;');

        // PASO C: Ejecutar migraciones y seeders
        Artisan::call('migrate', ['--force' => true]);
        Artisan::call('db:seed', ['--force' => true]);

        return "¡POR FIN! Base de datos configurada y limpia.";
    } catch (\Exception $e) {
        // Esto nos dirá si el problema es la CONTRASEÑA o el HOST
        return "Error real de conexión: " . $e->getMessage();
    }
});