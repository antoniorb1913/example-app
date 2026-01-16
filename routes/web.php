<?php

use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return redirect()->route('players.index');
});

Route::resource('players', PlayerController::class);
