<?php

use App\Http\Controllers\OmdbController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('movie/detail', [OmdbController::class, 'detailMovie']);
Route::get('movie/search', [OmdbController::class, 'getMovies']);
