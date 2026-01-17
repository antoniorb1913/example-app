<?php

use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

//Route::get('/', function () {
    //return redirect()->route('players.index');
//})

Route::resource('players', PlayerController::class);

Route::get('/', function () {
    // Si no existe la tabla de jugadores, configuramos todo automáticamente
    if (!Schema::hasTable('players')) {
        try {
            Artisan::call('migrate', ['--force' => true]);
            Artisan::call('db:seed', ['--force' => true]);
            
            return "Base de datos instalada automáticamente. Refresca la página.";
        } catch (\Exception $e) {
            return "Error en auto-instalación: " . $e->getMessage();
        }
    }
    return view('welcome'); // O tu vista principal
});