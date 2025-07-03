<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OglasiController;

Route::get('/', function () {
    return view('app');
});

Route::post("/updateFile", [OglasiController::class, "updateFile"]);