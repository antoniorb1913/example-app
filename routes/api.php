<?php

use App\Http\Controllers\PlayerApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/player',[PlayerApiController::class, "list"]);